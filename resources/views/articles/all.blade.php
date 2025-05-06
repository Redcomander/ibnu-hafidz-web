@extends('layouts.main-navigation')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-green-500 to-green-600 text-white">
        <div class="container mx-auto px-4 py-16 md:py-24">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-3xl md:text-5xl font-bold mb-6">All Articles</h1>
                <p class="text-lg md:text-xl text-white mb-8">Discover our collection of insightful articles and stay
                    updated with the latest trends.</p>

                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto">
                    <form action="{{ route('all-articles') }}" method="GET" class="relative">
                        <input type="text" name="search" placeholder="Search articles..."
                            class="w-full px-5 py-3 rounded-full bg-white/20 backdrop-blur-sm border border-white/20 focus:outline-none focus:ring-2 focus:ring-white/50 text-white placeholder-white/75"
                            value="{{ request('search') }}">
                        <button type="submit"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white hover:text-white/75">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
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
            <!-- Category Filter -->
            <div class="mb-10 flex flex-wrap gap-3 justify-center">
                <a href="{{ route('all-articles') }}"
                    class="category-filter-btn {{ !request('category') ? 'active' : '' }}">
                    All
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('all-articles', ['category' => $category->slug]) }}"
                        class="category-filter-btn {{ request('category') == $category->slug ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <!-- Articles -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($articles as $article)
                    <!-- Update the article card to use the correct fields -->
                    <div class="article-card group">
                        <a href="{{ route('articles.show', ['category' => $article->category->slug, 'article' => $article->slug]) }}"
                            class="block">
                            <div class="article-image-container">
                                <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : asset('images/default-article-bg.jpg') }}"
                                    alt="{{ $article->title }}" class="article-image">
                                @if($article->category)
                                    <span class="article-category">{{ $article->category->name }}</span>
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
                                    <span class="text-sm text-gray-500">
                                        {{ $article->published_at ? $article->published_at->format('M d, Y') : 'Draft' }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="text-5xl text-gray-300 mb-4">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">No articles found</h3>
                        <p class="text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $articles->links() }}
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-green-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-green-700 mb-4">Subscribe to Our Newsletter</h2>
                <p class="text-lg text-gray-600 mb-8">Get the latest articles and resources sent straight to your inbox.</p>
                <form id="newsletter-form" class="flex flex-col md:flex-row gap-4 max-w-xl mx-auto">
                    @csrf
                    <input type="email" name="email" id="newsletter-email" placeholder="Your email address" required
                        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 focus:border-transparent">
                    <button type="submit"
                        class="bg-green-500 text-white py-3 px-6 rounded-lg hover:bg-green-600 transition">
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
        }

        /* Category Filter Buttons */
        .category-filter-btn {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #4b5563;
            background: #f3f4f6;
            transition: all 0.2s ease;
        }

        .category-filter-btn:hover {
            background: #e5e7eb;
            color: #1f2937;
        }

        .category-filter-btn.active {
            background: var(--color-primary-500);
            color: white;
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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Newsletter form handling
            const newsletterForm = document.getElementById('newsletter-form');
            const newsletterMessage = document.getElementById('newsletter-message');

            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
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
