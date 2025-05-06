@extends('layouts.main-navigation')

@section('title', 'Gallery Photo')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <style>
        :root {
            --primary: #2e7d32;
            --primary-light: #4CAF50;
            --primary-dark: #1b5e20;
            --secondary: #FFC107;
            --secondary-dark: #FFA000;
            --text-light: #f8fafc;
            --text-dark: #1a202c;
            --bg-light: #ffffff;
            --bg-dark: #f1f5f9;
        }

        /* Custom CSS for masonry layout */
        .masonry-container {
            column-count: 1;
            column-gap: 1.5rem;
        }

        @media (min-width: 640px) {
            .masonry-container {
                column-count: 2;
            }
        }

        @media (min-width: 768px) {
            .masonry-container {
                column-count: 3;
            }
        }

        @media (min-width: 1024px) {
            .masonry-container {
                column-count: 4;
            }
        }

        @media (min-width: 1280px) {
            .masonry-container {
                column-count: 5;
            }
        }

        .masonry-item {
            display: inline-block;
            width: 100%;
            margin-bottom: 1.5rem;
            break-inside: avoid;
        }

        /* Animation for lazy loading */
        .fade-in {
            animation: fadeIn 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Gallery item styles */
        .gallery-card {
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transform: translateY(0);
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .gallery-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.2);
        }

        .gallery-card img {
            transition: transform 0.7s cubic-bezier(0.22, 1, 0.36, 1);
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-card:hover img {
            transform: scale(1.05);
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 60%);
            opacity: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.5rem;
            transition: all 0.4s ease;
            color: white;
        }

        .gallery-card:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-date {
            font-size: 0.875rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1) 0.1s;
        }

        .gallery-card:hover .gallery-date {
            transform: translateY(0);
            opacity: 1;
        }

        .gallery-view {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.8);
            background-color: rgba(255, 255, 255, 0.9);
            color: var(--primary);
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .gallery-card:hover .gallery-view {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }

        .gallery-view:hover {
            background-color: white;
            transform: translate(-50%, -50%) scale(1.1) !important;
        }

        /* Search and filter styles */
        .search-input {
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            padding-left: 3rem;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
            outline: none;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }

        .select-container {
            position: relative;
        }

        .select-input {
            appearance: none;
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            padding-right: 2.5rem;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .select-input:focus {
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
            outline: none;
        }

        .select-arrow {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            pointer-events: none;
        }

        /* Lightbox styles */
        .lightbox {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.95);
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .lightbox.active {
            display: flex;
        }

        .lightbox-content {
            max-width: 90%;
            max-height: 90%;
            position: relative;
        }

        .lightbox-content img {
            max-width: 100%;
            max-height: 90vh;
            object-fit: contain;
            border-radius: 0.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .lightbox-title {
            position: absolute;
            bottom: -3rem;
            left: 0;
            width: 100%;
            text-align: center;
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .lightbox-date {
            position: absolute;
            bottom: -5rem;
            left: 0;
            width: 100%;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.875rem;
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .lightbox-nav:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .lightbox-prev {
            left: 1rem;
        }

        .lightbox-next {
            right: 1rem;
        }

        .lightbox-close {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1010;
        }

        .lightbox-close:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Loading animation */
        .loader {
            width: 48px;
            height: 48px;
            border: 5px solid #e5e7eb;
            border-bottom-color: var(--primary);
            border-radius: 50%;
            display: inline-block;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            width: 5rem;
            height: 5rem;
            margin: 0 auto 1.5rem;
            color: #9ca3af;
        }

        /* Page header */
        .page-header {
            position: relative;
            padding: 3rem 0;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-light));
            border-radius: 0 0 2rem 2rem;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3Cpath d='M6 5V0H5v5H0v1h5v94h1V6h94V5H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .page-title {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            position: relative;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.8);
            text-align: center;
            max-width: 36rem;
            margin: 0 auto;
            position: relative;
        }

        /* Filter tags */
        .filter-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .filter-tag {
            background-color: #f3f4f6;
            color: #4b5563;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-tag:hover,
        .filter-tag.active {
            background-color: var(--primary);
            color: white;
        }

        /* Floating decoration */
        .floating-decoration {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            z-index: 0;
        }

        .floating-decoration-1 {
            width: 150px;
            height: 150px;
            top: -50px;
            right: 10%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-decoration-2 {
            width: 100px;
            height: 100px;
            bottom: -30px;
            left: 15%;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="floating-decoration floating-decoration-1"></div>
        <div class="floating-decoration floating-decoration-2"></div>
        <div class="container mx-auto px-4">
            <h1 class="page-title" data-aos="fade-up">Photo Gallery</h1>
            <p class="page-subtitle" data-aos="fade-up" data-aos-delay="100">
                Explore our collection of memorable moments and beautiful captures
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 pb-16">
        <!-- Search and Filter Section -->
        <div class="max-w-4xl mx-auto mb-12" data-aos="fade-up" data-aos-delay="200">
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="relative flex-grow">
                        <div class="search-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" id="search" placeholder="Search photos..." class="search-input">
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="select-container w-full md:w-48">
                        <select id="sortOption" class="select-input">
                            <option value="latest">Latest</option>
                            <option value="oldest">Oldest</option>
                            <option value="title_asc">Title (A-Z)</option>
                            <option value="title_desc">Title (Z-A)</option>
                        </select>
                        <div class="select-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Filter Tags -->
                <div class="filter-tags mt-4">
                    <span class="filter-tag active" data-filter="all">All</span>
                    <span class="filter-tag" data-filter="events">Events</span>
                    <span class="filter-tag" data-filter="campus">Campus</span>
                    <span class="filter-tag" data-filter="activities">Activities</span>
                    <span class="filter-tag" data-filter="students">Students</span>
                </div>
            </div>
        </div>

        <!-- Loading indicator -->
        <div id="loading" class="flex justify-center items-center py-16">
            <span class="loader"></span>
        </div>

        <!-- Gallery container -->
        <div id="gallery" class="masonry-container hidden">
            @forelse ($galleries as $gallery)
                <div class="masonry-item fade-in" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}"
                    data-title="{{ strtolower($gallery->title) }}">
                    <div class="gallery-card">
                        <div class="gallery-item" data-id="{{ $gallery->id }}"
                            data-path="{{ asset('storage/' . $gallery->path) }}" data-title="{{ $gallery->title }}"
                            data-date="{{ $gallery->created_at->format('d M Y') }}">
                            <img src="{{ asset('storage/' . $gallery->path) }}" alt="{{ $gallery->title }}" loading="lazy">

                            <!-- Overlay with date on hover -->
                            <div class="gallery-overlay">
                                <div class="gallery-date">{{ $gallery->created_at->format('d M Y') }}</div>
                            </div>

                            <!-- View button -->
                            <div class="gallery-view">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state" data-aos="fade-up">
                    <svg class="empty-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">No photos found</h3>
                    <p class="text-gray-500">There are no photos in the gallery yet.</p>
                </div>
            @endforelse
        </div>

        <!-- No results message -->
        <div id="noResults" class="empty-state hidden" data-aos="fade-up">
            <svg class="empty-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">No matching results</h3>
            <p class="text-gray-500">Try adjusting your search criteria.</p>
        </div>

        <!-- Lightbox -->
        <div id="lightbox" class="lightbox">
            <button id="closeLightbox" class="lightbox-close">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <button id="prevItem" class="lightbox-nav lightbox-prev">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <div class="lightbox-content">
                <div id="lightboxContent"></div>
                <div class="lightbox-title" id="lightboxTitle"></div>
                <div class="lightbox-date" id="lightboxDate"></div>
            </div>

            <button id="nextItem" class="lightbox-nav lightbox-next">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease-out-cubic',
                once: true
            });

            // Show gallery after images have loaded
            setTimeout(() => {
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('gallery').classList.remove('hidden');
            }, 800);

            // Search functionality
            const searchInput = document.getElementById('search');
            const galleryItems = document.querySelectorAll('.masonry-item');
            const noResults = document.getElementById('noResults');
            const gallery = document.getElementById('gallery');

            function performSearch() {
                const searchTerm = searchInput.value.toLowerCase();
                let resultsFound = false;

                galleryItems.forEach(item => {
                    const title = item.dataset.title;
                    if (title.includes(searchTerm)) {
                        item.classList.remove('hidden');
                        resultsFound = true;
                    } else {
                        item.classList.add('hidden');
                    }
                });

                if (resultsFound) {
                    noResults.classList.add('hidden');
                    gallery.classList.remove('hidden');
                } else {
                    noResults.classList.remove('hidden');
                    gallery.classList.add('hidden');
                }
            }

            searchInput.addEventListener('input', performSearch);

            // Filter tags
            const filterTags = document.querySelectorAll('.filter-tag');

            filterTags.forEach(tag => {
                tag.addEventListener('click', function () {
                    // Remove active class from all tags
                    filterTags.forEach(t => t.classList.remove('active'));

                    // Add active class to clicked tag
                    this.classList.add('active');

                    // Get filter value
                    const filter = this.dataset.filter;

                    // For demo purposes, just show all items
                    // In a real implementation, you would filter based on categories
                    if (filter === 'all') {
                        galleryItems.forEach(item => item.classList.remove('hidden'));
                    } else {
                        // This is just a placeholder - in a real app you'd check if items have this category
                        // For now, let's just show some random items for each filter
                        galleryItems.forEach((item, index) => {
                            if (filter === 'events' && index % 4 === 0) {
                                item.classList.remove('hidden');
                            } else if (filter === 'campus' && index % 4 === 1) {
                                item.classList.remove('hidden');
                            } else if (filter === 'activities' && index % 4 === 2) {
                                item.classList.remove('hidden');
                            } else if (filter === 'students' && index % 4 === 3) {
                                item.classList.remove('hidden');
                            } else {
                                item.classList.add('hidden');
                            }
                        });
                    }
                });
            });

            // Sorting functionality
            const sortSelect = document.getElementById('sortOption');

            sortSelect.addEventListener('change', function () {
                const sortOption = this.value;
                const items = Array.from(document.querySelectorAll('.masonry-item'));

                items.sort((a, b) => {
                    const titleA = a.querySelector('.gallery-item').dataset.title.toLowerCase();
                    const titleB = b.querySelector('.gallery-item').dataset.title.toLowerCase();
                    const dateA = new Date(a.querySelector('.gallery-item').dataset.date);
                    const dateB = new Date(b.querySelector('.gallery-item').dataset.date);

                    switch (sortOption) {
                        case 'latest':
                            return dateB - dateA;
                        case 'oldest':
                            return dateA - dateB;
                        case 'title_asc':
                            return titleA.localeCompare(titleB);
                        case 'title_desc':
                            return titleB.localeCompare(titleA);
                        default:
                            return 0;
                    }
                });

                // Remove all items
                items.forEach(item => item.remove());

                // Add sorted items back
                items.forEach(item => gallery.appendChild(item));
            });

            // Lightbox functionality
            const lightbox = document.getElementById('lightbox');
            const lightboxContent = document.getElementById('lightboxContent');
            const lightboxTitle = document.getElementById('lightboxTitle');
            const lightboxDate = document.getElementById('lightboxDate');
            const closeLightbox = document.getElementById('closeLightbox');
            const prevItem = document.getElementById('prevItem');
            const nextItem = document.getElementById('nextItem');
            const galleryItemElements = document.querySelectorAll('.gallery-item');

            let currentIndex = 0;
            const galleryArray = Array.from(galleryItemElements);

            function openLightbox(index) {
                currentIndex = index;
                const item = galleryArray[currentIndex];
                const path = item.dataset.path;
                const title = item.dataset.title;
                const date = item.dataset.date;

                lightboxContent.innerHTML = '';

                const img = document.createElement('img');
                img.src = path;
                img.alt = title;
                lightboxContent.appendChild(img);

                lightboxTitle.textContent = title;
                lightboxDate.textContent = date;
                lightbox.classList.add('active');

                // Disable scrolling on body
                document.body.style.overflow = 'hidden';
            }

            function closeLightboxHandler() {
                lightbox.classList.remove('active');
                lightboxContent.innerHTML = '';

                // Re-enable scrolling
                document.body.style.overflow = '';
            }

            function navigateLightbox(direction) {
                let newIndex = currentIndex + direction;

                if (newIndex < 0) {
                    newIndex = galleryArray.length - 1;
                } else if (newIndex >= galleryArray.length) {
                    newIndex = 0;
                }

                openLightbox(newIndex);
            }

            galleryItemElements.forEach((item, index) => {
                item.addEventListener('click', () => openLightbox(index));
            });

            closeLightbox.addEventListener('click', closeLightboxHandler);
            prevItem.addEventListener('click', () => navigateLightbox(-1));
            nextItem.addEventListener('click', () => navigateLightbox(1));

            // Close lightbox with escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && lightbox.classList.contains('active')) {
                    closeLightboxHandler();
                } else if (e.key === 'ArrowLeft' && lightbox.classList.contains('active')) {
                    navigateLightbox(-1);
                } else if (e.key === 'ArrowRight' && lightbox.classList.contains('active')) {
                    navigateLightbox(1);
                }
            });

            // Close lightbox when clicking outside the content
            lightbox.addEventListener('click', function (e) {
                if (e.target === lightbox) {
                    closeLightboxHandler();
                }
            });
        });
    </script>
@endsection
