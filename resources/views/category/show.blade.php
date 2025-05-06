@extends('layouts.main-navigation')

@section('content')
    <!-- Category Hero Section -->
    <section class="bg-gradient-to-br from-green-500 to-green-600 text-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;">
            </div>
        </div>

        <div class="container mx-auto px-4 py-16 md:py-24 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <span
                    class="inline-block px-4 py-1 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium mb-4">Category</span>
                <h1 class="text-3xl md:text-5xl font-bold mb-6">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="text-lg md:text-xl text-white mb-8">{{ $category->description }}</p>
                @endif

                <div class="flex items-center justify-center text-white text-sm">
                    <span class="flex items-center">
                        <i class="far fa-newspaper mr-2"></i>
                        {{ $articles->total() }} {{ Str::plural('Article', $articles->total()) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Wave Divider -->
        <div class="wave-divider">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" class="text-white fill-current">
                <path
                    d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z">
                </path>
            </svg>
        </div>
    </section>

    <!-- Articles Grid -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <!-- Breadcrumbs -->
            <nav class="breadcrumbs text-sm mb-10" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center space-x-1">
                    <li><a href="{{ route('home') }}" class="hover:text-green-500 transition">Home</a></li>
                    <li><span class="text-gray-400 mx-1">/</span></li>
                    <li><a href="{{ route('all-articles') }}" class="hover:text-green-500 transition">Articles</a></li>
                    <li><span class="text-gray-400 mx-1">/</span></li>
                    <li aria-current="page" class="text-gray-600">{{ $category->name }}</li>
                </ol>
            </nav>

            <!-- Filter Options -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center">
                    <span class="text-lg font-semibold text-gray-700 mr-3">Sort by:</span>
                    <div class="flex gap-2">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}"
                            class="px-3 py-1 rounded-md {{ request('sort', 'latest') == 'latest' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Latest
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}"
                            class="px-3 py-1 rounded-md {{ request('sort') == 'oldest' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Oldest
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}"
                            class="px-3 py-1 rounded-md {{ request('sort') == 'popular' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Popular
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <form action="{{ route('categories.show', $category->slug) }}" method="GET" class="flex">
                        <input type="text" name="search" placeholder="Search in this category..."
                            class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                            value="{{ request('search') }}">
                        <button type="submit"
                            class="bg-green-500 text-white px-4 py-2 rounded-r-md hover:bg-green-600 transition">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Articles -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($articles as $article)
                    <div class="article-card group">
                        <a href="{{ route('articles.show', ['category' => $category->slug, 'article' => $article->slug]) }}"
                            class="block">
                            <div class="article-image-container">
                                <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : asset('images/default-article-bg.jpg') }}"
                                    alt="{{ $article->title }}" class="article-image">
                                <span class="article-category">{{ $category->name }}</span>

                                @if($article->tags->count() > 0)
                                    <div class="article-tags">
                                        @foreach($article->tags->take(2) as $tag)
                                            <span class="article-tag">#{{ $tag->name }}</span>
                                        @endforeach
                                        @if($article->tags->count() > 2)
                                            <span class="article-tag">+{{ $article->tags->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="article-content">
                                <h3 class="article-title">{{ $article->title }}</h3>
                                <p class="article-excerpt">
                                    {{ $article->excerpt ?? Str::limit(strip_tags($article->body), 120) }}</p>
                                <div class="article-meta">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-300 mr-2">
                                            <img src="{{ $article->author->profile_photo_url ?? asset('images/default-avatar.jpg') }}"
                                                alt="{{ $article->author->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <span class="text-sm">{{ $article->author->name }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <span class="mr-3">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            {{ $article->published_at->format('M d, Y') }}
                                        </span>
                                        <span>
                                            <i class="far fa-comment mr-1"></i>
                                            {{ $article->commentsCount }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="text-6xl text-gray-300 mb-4">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">No articles found in this category</h3>
                        <p class="text-gray-500 mb-6">We couldn't find any articles matching your criteria.</p>
                        @if(request('search'))
                            <a href="{{ route('categories.show', $category->slug) }}"
                                class="inline-block bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition">
                                Clear search
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $articles->withQueryString()->links() }}
            </div>
        </div>
    </section>

    <!-- Related Categories -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold text-center mb-10">Explore Other Categories</h2>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($otherCategories as $otherCategory)
                    <a href="{{ route('categories.show', $otherCategory->slug) }}" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-folder"></i>
                        </div>
                        <h3 class="category-name">{{ $otherCategory->name }}</h3>
                        <span class="category-count">{{ $otherCategory->articles_count }}
                            {{ Str::plural('Article', $otherCategory->articles_count) }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-green-50 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%2322c55e\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;">
            </div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-4 text-green-700">Stay Updated with {{ $category->name }}</h2>
                <p class="text-lg text-gray-600 mb-8">Subscribe to our newsletter and never miss new articles in this
                    category.</p>
                <form id="newsletter-form" class="flex flex-col md:flex-row gap-4 max-w-xl mx-auto">
                    @csrf
                    <input type="email" name="email" id="newsletter-email" placeholder="Your email address" required
                        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 focus:border-transparent">
                    <button type="submit"
                        class="bg-green-500 text-white py-3 px-6 rounded-lg hover:bg-green-600 transition font-medium">
                        Subscribe
                    </button>
                </form>
                <div id="newsletter-message" class="mt-4 text-sm hidden"></div>
            </div>
        </div>
    </section>

    <style>
        /* Primary Colors - Lighter Green Theme */
        :root {
            --color-primary-50: #f0fdf4;
            --color-primary-100: #dcfce7;
            --color-primary-200: #bbf7d0;
            --color-primary-300: #86efac;
            --color-primary-400: #4ade80;
            --color-primary-500: #22c55e;
            --color-primary-600: #16a34a;
            --color-primary-700: #15803d;
            --color-primary-800: #166534;
            --color-primary-900: #14532d;
        }

        /* Article Cards */
        .article-card {
            background-color: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .article-image-container {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .article-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .article-card:hover .article-image {
            transform: scale(1.05);
        }

        .article-category {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(34, 197, 94, 0.8);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 500;
            backdrop-filter: blur(4px);
        }

        .article-tags {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            display: flex;
            gap: 0.5rem;
        }

        .article-tag {
            background: rgba(255, 255, 255, 0.8);
            color: var(--color-primary-600);
            padding: 0.15rem 0.5rem;
            border-radius: 2rem;
            font-size: 0.7rem;
            font-weight: 500;
            backdrop-filter: blur(4px);
        }

        .article-content {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .article-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.75rem;
            line-height: 1.4;
            transition: color 0.2s ease;
        }

        .article-card:hover .article-title {
            color: var(--color-primary-500);
        }

        .article-excerpt {
            color: #6b7280;
            margin-bottom: 1.25rem;
            line-height: 1.6;
            font-size: 0.95rem;
            flex-grow: 1;
        }

        .article-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #f3f4f6;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        /* Category Cards */
        .category-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            text-align: center;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            background-color: var(--color-primary-500);
            color: white;
        }

        .category-icon {
            font-size: 2rem;
            color: var(--color-primary-500);
            margin-bottom: 1rem;
            transition: color 0.3s ease;
        }

        .category-card:hover .category-icon {
            color: white;
        }

        .category-name {
            font-weight: 600;
            font-size: 1.125rem;
            margin-bottom: 0.5rem;
        }

        .category-count {
            font-size: 0.875rem;
            color: #6b7280;
            transition: color 0.3s ease;
        }

        .category-card:hover .category-count {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Wave Divider */
        .wave-divider {
            line-height: 0;
            margin-top: -1px;
        }

        /* Pagination Styling */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .pagination .page-item {
            display: inline-block;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f3f4f6;
            color: #4b5563;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .pagination .page-item.active .page-link {
            background: var(--color-primary-500);
            color: white;
        }

        .pagination .page-link:hover:not(.active) {
            background: #e5e7eb;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .article-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Newsletter form handling
            const newsletterForm = document.getElementById('newsletter-form');
            const newsletterMessage = document.getElementById('newsletter-message');

            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const email = document.getElementById('newsletter-email').value;

                    // Simple validation
                    if (!email || !email.includes('@')) {
                        showNewsletterMessage('Please enter a valid email address.', 'error');
                        return;
                    }

                    // Simulate form submission (replace with actual API call)
                    showNewsletterMessage('Processing your subscription...', 'info');

                    // Simulate success after 1 second
                    setTimeout(() => {
                        showNewsletterMessage('Thank you for subscribing to our newsletter!', 'success');
                        newsletterForm.reset();
                    }, 1000);
                });
            }

            function showNewsletterMessage(message, type) {
                if (!newsletterMessage) return;

                newsletterMessage.textContent = message;
                newsletterMessage.classList.remove('hidden', 'text-green-600', 'text-red-500', 'text-blue-500');

                switch (type) {
                    case 'success':
                        newsletterMessage.classList.add('text-green-600');
                        break;
                    case 'error':
                        newsletterMessage.classList.add('text-red-500');
                        break;
                    case 'info':
                        newsletterMessage.classList.add('text-blue-500');
                        break;
                }
            }
        });
    </script>
@endsection
