<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('articles.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }

    public function show(Request $request, Category $category)
    {
        // Start building the query
        $query = $category->articles()
            ->with(['author', 'tags'])
            ->where('status', 'published');

        // Apply search filter if provided
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest('published_at');
                break;
            case 'popular':
                $query->withCount('comments')
                    ->orderByDesc('comments_count')
                    ->orderByDesc('published_at');
                break;
            case 'latest':
            default:
                $query->latest('published_at');
                break;
        }

        // Get paginated results
        $articles = $query->paginate(12);

        // Get other categories for the "Explore Other Categories" section
        $otherCategories = Category::withCount('articles')
            ->where('id', '!=', $category->id)
            ->whereHas('articles', function ($query) {
                $query->where('status', 'published');
            })
            ->orderByDesc('articles_count')
            ->limit(8)
            ->get();

        return view('category.show', compact('category', 'articles', 'otherCategories'));
    }
}
