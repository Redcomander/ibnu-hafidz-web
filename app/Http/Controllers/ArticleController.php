<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\ArticleView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['category', 'author', 'views'])
            ->withCount('views')
            ->latest()
            ->paginate(10);

        // Get total view count for stats card
        $totalViews = ArticleView::count();

        return view('articles.index', compact('articles', 'totalViews'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $validated['author_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']);
        $validated['published_at'] = $validated['status'] === 'published' ? now() : null;

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Handle duplicate slugs (optional)
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Article::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        Article::create($validated);

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    /**
     * Display a listing of the articles.
     */
    public function allArticles(Request $request)
    {
        $query = Article::with(['author', 'category'])
            ->where('status', 'published')
            ->latest('published_at');

        // Apply search filter if provided
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Apply category filter if provided
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $articles = $query->paginate(12);
        $categories = Category::withCount('articles')->get();

        return view('articles.all', compact('articles', 'categories'));
    }

    /**
     * Display the specified article.
     */
    public function show(Category $category, Article $article)
    {
        // Record the view
        $this->recordArticleView($article);

        // Get view count
        $viewsCount = $this->getArticleViewsCount($article);
        $uniqueViewsCount = $this->getArticleUniqueViewsCount($article);

        // Calculate reading time
        $article->reading_time = $this->calculateReadingTime($article->body);

        // Load the article with its relationships
        $article->load(['author', 'category', 'comments.replies', 'tags']);

        // Get previous and next articles
        $previousArticle = Article::where('status', 'published')
            ->where('published_at', '<', $article->published_at)
            ->latest('published_at')
            ->first();

        $nextArticle = Article::where('status', 'published')
            ->where('published_at', '>', $article->published_at)
            ->oldest('published_at')
            ->first();

        // Get related articles
        $relatedArticles = Article::where('status', 'published')
            ->where('id', '!=', $article->id)
            ->where(function ($query) use ($article) {
                // Related by category
                if ($article->category_id) {
                    $query->where('category_id', $article->category_id);
                }
                // Could also relate by tags if you have them
                if ($article->tags->count() > 0) {
                    $tagIds = $article->tags->pluck('id');
                    $query->orWhereHas('tags', function ($q) use ($tagIds) {
                        $q->whereIn('tags.id', $tagIds);
                    });
                }
            })
            ->latest('published_at')
            ->limit(3)
            ->get();

        // Get popular categories for sidebar
        $popularCategories = Category::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->limit(5)
            ->get();

        return view('articles.show', compact(
            'article',
            'previousArticle',
            'nextArticle',
            'relatedArticles',
            'popularCategories',
            'viewsCount',
            'uniqueViewsCount'
        ));
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['published_at'] = $validated['status'] === 'published' ? now() : null;

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
                Storage::disk('public')->delete($article->thumbnail);
            }

            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        } else {
            // Don't override existing thumbnail if not uploaded
            unset($validated['thumbnail']);
        }

        $article->update($validated);

        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        // Delete thumbnail if exists
        if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }

    public function catagoryShowAll(Category $category)
    {
        $category = Category::all();
        return view('category.show', compact('category'));
    }

    /**
     * Record a view for the article
     */
    private function recordArticleView(Article $article)
    {
        // Get current user or IP address for guest
        $userId = Auth::id() ?: null;
        $userIp = request()->ip();
        $userAgent = request()->header('User-Agent');

        // Create a new article view record
        ArticleView::create([
            'article_id' => $article->id,
            'user_id' => $userId,
            'ip_address' => $userIp,
            'user_agent' => $userAgent
        ]);
    }

    /**
     * Get total view count for an article
     */
    private function getArticleViewsCount(Article $article)
    {
        return ArticleView::where('article_id', $article->id)->count();
    }

    /**
     * Get unique view count (by IP) for an article
     */
    private function getArticleUniqueViewsCount(Article $article)
    {
        return ArticleView::where('article_id', $article->id)
            ->distinct('ip_address')
            ->count('ip_address');
    }

    /**
     * Calculate estimated reading time for an article
     */
    private function calculateReadingTime($content)
    {
        // Strip HTML tags and count words
        $wordCount = str_word_count(strip_tags($content));

        // Average reading speed: 200 words per minute
        $minutes = ceil($wordCount / 200);

        return $minutes . ' min read';
    }

    /**
     * Get article analytics
     */
    public function analytics(Request $request, $id)
    {
        // Find the article by ID
        $article = Article::findOrFail($id);

        // Get view counts
        $totalViews = ArticleView::where('article_id', $article->id)->count();
        $uniqueViews = ArticleView::where('article_id', $article->id)
            ->distinct('ip_address')
            ->count('ip_address');

        // Get views by day for the last 30 days
        $viewsByDay = ArticleView::where('article_id', $article->id)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('articles.analytics', compact(
            'article',
            'totalViews',
            'uniqueViews',
            'viewsByDay'
        ));
    }
}
