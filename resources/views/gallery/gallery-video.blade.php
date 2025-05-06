@extends('layouts.main-navigation')

@section('title', 'Gallery Videos')

@section('head')
    <style>
        /* Custom CSS for video gallery layout */
        .video-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1rem;
        }

        @media (min-width: 640px) {
            .video-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 768px) {
            .video-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .video-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Animation for lazy loading */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Video player modal */
        .video-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .video-modal.active {
            display: flex;
        }

        .video-modal-content {
            max-width: 90%;
            max-height: 90%;
            position: relative;
        }

        .video-modal-content video {
            max-width: 100%;
            max-height: 90vh;
        }
    </style>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-4 md:mb-0">Video Gallery</h1>

            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                <div class="relative flex-grow sm:max-w-xs">
                    <input type="text" id="search" placeholder="Search by title..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <button id="searchBtn" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>

                <select id="sortOption"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="latest">Latest</option>
                    <option value="oldest">Oldest</option>
                    <option value="title_asc">Title (A-Z)</option>
                    <option value="title_desc">Title (Z-A)</option>
                </select>
            </div>
        </div>

        <!-- Loading indicator -->
        <div id="loading" class="flex justify-center items-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
        </div>

        <!-- Video gallery container -->
        <div id="gallery" class="video-grid hidden">
            @forelse ($galleries as $gallery)
                <div class="video-item fade-in" data-title="{{ strtolower($gallery->title) }}">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <div class="relative cursor-pointer gallery-item" data-id="{{ $gallery->id }}"
                            data-path="{{ asset('storage/' . $gallery->path) }}">
                            <div class="relative">
                                <img src="{{ asset('storage/thumbnails/' . pathinfo($gallery->path, PATHINFO_FILENAME) . '.jpg') }}"
                                    alt="{{ $gallery->title }}" class="w-full h-48 object-cover" loading="lazy">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="bg-black bg-opacity-50 rounded-full p-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Hover overlay -->
                            <div
                                class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 transition-opacity duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
                                <div class="text-white text-center p-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="mt-2 font-medium">Play Video</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white truncate">{{ $gallery->title }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $gallery->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-4 text-xl font-medium text-gray-700 dark:text-gray-300">No videos found</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">There are no videos in the gallery yet.</p>
                </div>
            @endforelse
        </div>

        <!-- No results message -->
        <div id="noResults" class="hidden text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <h3 class="mt-4 text-xl font-medium text-gray-700 dark:text-gray-300">No matching results</h3>
            <p class="mt-2 text-gray-500 dark:text-gray-400">Try adjusting your search criteria.</p>
        </div>

        <!-- Video Modal -->
        <div id="videoModal" class="video-modal">
            <button id="closeVideoModal" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="video-modal-content">
                <div id="videoModalContent"></div>
                <div class="text-white text-center mt-4">
                    <h3 id="videoModalTitle" class="text-xl font-semibold"></h3>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Show gallery after images have loaded
            setTimeout(() => {
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('gallery').classList.remove('hidden');
            }, 500);

            // Search functionality
            const searchInput = document.getElementById('search');
            const searchBtn = document.getElementById('searchBtn');
            const galleryItems = document.querySelectorAll('.video-item');
            const noResults = document.getElementById('noResults');

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
                    document.getElementById('gallery').classList.remove('hidden');
                } else {
                    noResults.classList.remove('hidden');
                    document.getElementById('gallery').classList.add('hidden');
                }
            }

            searchBtn.addEventListener('click', performSearch);
            searchInput.addEventListener('keyup', function (e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });

            // Sorting functionality
            const sortSelect = document.getElementById('sortOption');

            sortSelect.addEventListener('change', function () {
                const sortOption = this.value;
                const gallery = document.getElementById('gallery');
                const items = Array.from(document.querySelectorAll('.video-item'));

                items.sort((a, b) => {
                    const titleA = a.querySelector('h3').textContent.toLowerCase();
                    const titleB = b.querySelector('h3').textContent.toLowerCase();
                    const dateA = new Date(a.querySelector('p').textContent);
                    const dateB = new Date(b.querySelector('p').textContent);

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

            // Video modal functionality
            const videoModal = document.getElementById('videoModal');
            const videoModalContent = document.getElementById('videoModalContent');
            const videoModalTitle = document.getElementById('videoModalTitle');
            const closeVideoModal = document.getElementById('closeVideoModal');
            const galleryItemElements = document.querySelectorAll('.gallery-item');

            function openVideoModal(item) {
                const path = item.dataset.path;
                const title = item.closest('.video-item').querySelector('h3').textContent;

                videoModalContent.innerHTML = '';

                const video = document.createElement('video');
                video.src = path;
                video.controls = true;
                video.autoplay = true;
                videoModalContent.appendChild(video);

                videoModalTitle.textContent = title;
                videoModal.classList.add('active');

                // Disable scrolling on body
                document.body.style.overflow = 'hidden';
            }

            function closeVideoModalHandler() {
                videoModal.classList.remove('active');
                videoModalContent.innerHTML = '';

                // Re-enable scrolling
                document.body.style.overflow = '';
            }

            galleryItemElements.forEach(item => {
                item.addEventListener('click', () => openVideoModal(item));
            });

            closeVideoModal.addEventListener('click', closeVideoModalHandler);

            // Close video modal with escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && videoModal.classList.contains('active')) {
                    closeVideoModalHandler();
                }
            });

            // Close video modal when clicking outside the content
            videoModal.addEventListener('click', function (e) {
                if (e.target === videoModal) {
                    closeVideoModalHandler();
                }
            });

            // Lazy loading for images
            if ('IntersectionObserver' in window) {
                const lazyImages = document.querySelectorAll('img[loading="lazy"]');

                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src || img.src;
                            img.classList.add('fade-in');
                            observer.unobserve(img);
                        }
                    });
                });

                lazyImages.forEach(img => {
                    imageObserver.observe(img);
                });
            }
        });
    </script>
@endsection
