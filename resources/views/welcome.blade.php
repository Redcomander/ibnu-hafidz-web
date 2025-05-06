@extends('layouts.main-navigation')

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
            --bg-darker: #e2e8f0;
        }

        .hero-pattern {
            background-color: #4CAF50;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3Cpath d='M6 5V0H5v5H0v1h5v94h1V6h94V5H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .slide-in-bottom {
            animation: slide-in-bottom 1s ease-out both;
        }

        @keyframes slide-in-bottom {
            0% {
                transform: translateY(50px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .gradient-text {
            background: linear-gradient(90deg, #2e7d32, #4CAF50);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .program-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 1rem;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .program-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #2e7d32, #4CAF50);
            opacity: 0;
            z-index: -1;
            transition: opacity 0.4s ease;
        }

        .program-card:hover {
            transform: translateY(-15px) scale(1.02);
        }

        .program-card:hover::before {
            opacity: 0.05;
        }

        .program-icon {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 1.5rem auto;
            overflow: hidden;
            position: relative;
            transition: all 0.4s ease;
        }

        .program-card:hover .program-icon {
            transform: scale(1.1);
        }

        .program-card:hover h3 {
            color: #2e7d32;
        }

        /* Decorative background elements */
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%234CAF50' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .testimonial-card {
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: scale(1.03);
        }

        .cta-button {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.1));
            transition: all 0.5s ease;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 Aspect Ratio */
            height: 0;
            overflow: hidden;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            /* Add these properties to fix the overflow issue */
            width: 100%;
            max-width: 100%;
        }

        .video-container:hover {
            transform: scale(1.03);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 0.75rem;
            border: none;
        }

        /* Hero video container specific styles */
        .hero-video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin: 0 auto;
            max-width: 100%;
            background-color: rgba(0, 0, 0, 0.1);
        }

        .hero-video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 1rem;
        }

        .hero-video-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 30px -5px rgba(0, 0, 0, 0.2), 0 15px 15px -5px rgba(0, 0, 0, 0.1);
        }

        /* Maps section styles */
        .maps-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .maps-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 1rem;
        }

        .maps-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 30px -5px rgba(0, 0, 0, 0.2), 0 15px 15px -5px rgba(0, 0, 0, 0.1);
        }

        .rating-card {
            background-color: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .rating-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .star-rating {
            color: #FBBF24;
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        /* Daily Activities section styles */
        .daily-activities-container {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .daily-activities-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 30px -5px rgba(0, 0, 0, 0.2), 0 15px 15px -5px rgba(0, 0, 0, 0.1);
        }

        .daily-activities-container img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* News/Article Card Styles */
        .article-card {
            transition: all 0.3s ease;
            border-radius: 1rem;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .article-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .article-image {
            height: 200px;
            overflow: hidden;
        }

        .article-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .article-card:hover .article-image img {
            transform: scale(1.1);
        }

        .article-content {
            padding: 1.5rem;
            background-color: white;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .article-date {
            font-size: 0.875rem;
            color: #6B7280;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .article-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .article-excerpt {
            color: #6B7280;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .article-link {
            display: inline-flex;
            align-items: center;
            color: #4CAF50;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .article-link:hover {
            color: #2E7D32;
        }

        .article-link svg {
            margin-left: 0.5rem;
            transition: transform 0.3s ease;
        }

        .article-link:hover svg {
            transform: translateX(4px);
        }

        /* Add this to ensure the entire page doesn't overflow */
        body {
            overflow-x: hidden;
        }

        /* Ensure sections with videos don't overflow */
        .py-16,
        .py-24 {
            overflow-x: hidden;
        }

        /* Ensure the hero section doesn't cause overflow */
        .hero-pattern {
            overflow-x: hidden;
            width: 100%;
        }

        /* Ensure grid containers don't overflow */
        .grid {
            width: 100%;
            max-width: 100%;
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero-pattern relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 md:pb-40">
            <div class="grid md:grid-cols-2 gap-8 items-center relative" style="z-index: 2;">
                <!-- Left column: Text content -->
                <div class="text-white slide-in-bottom">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                        Selamat Datang di<br>
                        <span class="text-white">Pondok Pesantren<br>Ibnu Hafidz</span>
                    </h1>
                    <p class="text-lg md:text-xl mb-8 text-white/90">
                        Membentuk generasi Qur'ani yang berakhlak mulia, berwawasan luas, dan siap menghadapi tantangan
                        global.
                    </p>
                    <div>
                        <a href="{{ url('/pendaftaran') }}"
                            class="cta-button inline-block bg-amber-400 text-green-800 font-semibold px-8 py-4 rounded-lg shadow-lg hover:shadow-xl hover:bg-amber-300 transition duration-300 text-lg">
                            Daftar Sekarang
                        </a>
                    </div>

                    <!-- Show video on mobile only -->
                    <div class="mt-8 block md:hidden w-full">
                        <div class="hero-video-container">
                            <iframe src="https://www.youtube.com/embed/CtrcqPfah-E?rel=0"
                                title="Pondok Pesantren Ibnu Hafidz"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>

                <!-- Right column: Video (desktop only) -->
                <div class="hidden md:block w-full">
                    <div class="hero-video-container">
                        <iframe src="https://www.youtube.com/embed/CtrcqPfah-E?rel=0" title="Pondok Pesantren Ibnu Hafidz"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 w-full overflow-hidden" style="z-index: 1;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full h-auto">
                <path fill="#ffffff" fill-opacity="1"
                    d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,149.3C960,160,1056,160,1152,138.7C1248,117,1344,75,1392,53.3L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>
    </section>

    <!-- News/Articles Section (Replacing About Section) -->
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text" data-aos="fade-up">Berita & Artikel Terbaru
                </h2>
                <div class="w-24 h-1 bg-green-500 mx-auto mb-8" data-aos="fade-up" data-aos-delay="100"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    Ikuti perkembangan terbaru dan kegiatan-kegiatan yang berlangsung di Pondok Pesantren Ibnu Hafidz
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @forelse($articles as $index => $article)
                    <!-- Article {{ $index + 1 }} -->
                    <div class="article-card shadow-md" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                        <div class="article-image">
                            @if($article->thumbnail)
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}">
                            @else
                                <img src="/placeholder.svg?height=200&width=400" alt="{{ $article->title }}">
                            @endif
                        </div>
                        <div class="article-content">
                            <div class="article-date">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $article->published_at->format('d F Y') }}
                            </div>
                            <h3 class="article-title">{{ $article->title }}</h3>
                            <p class="article-excerpt">
                                {{ $article->excerpt ?? Str::limit(strip_tags($article->body), 150) }}
                            </p>
                            <a href="{{ route('articles.show', ['category' => $article->category->slug, 'article' => $article->slug]) }}"
                                class="article-link">
                                Baca selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <!-- Fallback content if no articles are available -->
                    <div class="col-span-3 text-center py-8">
                        <p class="text-gray-500">Belum ada artikel yang tersedia.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('all-articles') }}"
                    class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-300">
                    Lihat Semua Berita
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>


    <!-- Programs Section (Redesigned) -->
    <section class="py-16 md:py-24 bg-gray-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-green-100 rounded-full opacity-30 -mr-32 -mt-16"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-green-100 rounded-full opacity-30 -ml-40 -mb-20"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1 bg-green-100 text-green-700 rounded-full mb-4 text-sm font-semibold"
                    data-aos="fade-up">Program Unggulan</span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text" data-aos="fade-up">Kenapa Mondok di Pesantren
                    Tahfidz Ibnu Hafidz?</h2>
                <div class="w-24 h-1 bg-green-500 mx-auto mb-8" data-aos="fade-up" data-aos-delay="100"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    Berikut ini kelebihan Pesantren Tahfidz Ibnu Hafidz yang membedakan kami dari pesantren lainnya
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Program 1: Tahfidz Sangat Intensif -->
                <div class="program-card bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transform transition-all duration-300"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="program-icon relative mx-auto mb-6 group">
                        <div
                            class="absolute inset-0 bg-green-500 rounded-full opacity-10 group-hover:opacity-20 transform scale-110 transition-all duration-300">
                        </div>
                        <img src="{{ asset('tahfidz.webp') }}" alt="Program Tahfidz"
                            class="rounded-full w-full h-full object-cover border-4 border-green-100 group-hover:border-green-200 transition-all duration-300">
                    </div>
                    <h3 class="text-xl font-bold text-center mb-4 text-gray-800">Program Tahfidz Sangat Intensif</h3>
                    <p class="text-gray-600 text-center mb-4">
                        1 Guru tahfidz untuk 12 santri. Kegiatan menghafal Al Quran 3 kali sehari, ba'da subuh, ba'da ashar
                        dan ba'da isya.
                    </p>
                    <div class="w-12 h-1 bg-green-500 mx-auto"></div>
                </div>

                <!-- Program 2: Kajian Kitab Kuning -->
                <div class="program-card bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transform transition-all duration-300"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="program-icon relative mx-auto mb-6 group">
                        <div
                            class="absolute inset-0 bg-green-500 rounded-full opacity-10 group-hover:opacity-20 transform scale-110 transition-all duration-300">
                        </div>
                        <img src="{{ asset('kajian_kitab.webp') }}" alt="Kajian Kitab Kuning"
                            class="rounded-full w-full h-full object-cover border-4 border-green-100 group-hover:border-green-200 transition-all duration-300">
                    </div>
                    <h3 class="text-xl font-bold text-center mb-4 text-gray-800">Kajian Kitab Kuning</h3>
                    <p class="text-gray-600 text-center mb-4">
                        Seluruh santri wajib bisa membaca dan belajar kitab kuning. Metode yang di gunakan adalah metode
                        Amsilati, yang praktis dan sudah teruji.
                    </p>
                    <div class="w-12 h-1 bg-green-500 mx-auto"></div>
                </div>

                <!-- Program 3: Lancar Bahasa Arab dan Inggris -->
                <div class="program-card bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transform transition-all duration-300"
                    data-aos="fade-up" data-aos-delay="300">
                    <div class="program-icon relative mx-auto mb-6 group">
                        <div
                            class="absolute inset-0 bg-green-500 rounded-full opacity-10 group-hover:opacity-20 transform scale-110 transition-all duration-300">
                        </div>
                        <img src="{{ asset('arab.webp') }}" alt="Bahasa Arab dan Inggris"
                            class="rounded-full w-full h-full object-cover border-4 border-green-100 group-hover:border-green-200 transition-all duration-300">
                    </div>
                    <h3 class="text-xl font-bold text-center mb-4 text-gray-800">Lancar Bahasa Arab dan Inggris</h3>
                    <p class="text-gray-600 text-center mb-4">
                        Santri di biasakan untuk pede dan lancar bahasa Arab dan Inggris, baik berbicara maupun untuk
                        pidato/ceramah.
                    </p>
                    <div class="w-12 h-1 bg-green-500 mx-auto"></div>
                </div>

                <!-- Program 4: Bimbingan Kuliah ke Luar Negeri -->
                <div class="program-card bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transform transition-all duration-300"
                    data-aos="fade-up" data-aos-delay="400">
                    <div class="program-icon relative mx-auto mb-6 group">
                        <div
                            class="absolute inset-0 bg-green-500 rounded-full opacity-10 group-hover:opacity-20 transform scale-110 transition-all duration-300">
                        </div>
                        <img src="{{ asset('luar_negri.webp') }}" alt="Bimbingan Kuliah Luar Negeri"
                            class="rounded-full w-full h-full object-cover border-4 border-green-100 group-hover:border-green-200 transition-all duration-300">
                    </div>
                    <h3 class="text-xl font-bold text-center mb-4 text-gray-800">Bimbingan Kuliah ke Luar Negeri</h3>
                    <p class="text-gray-600 text-center mb-4">
                        Bagi santri yang berminat kuliah ke luar negeri ada bimbingan khusus kuliah ke luar negeri oleh
                        alumni luar negeri.
                    </p>
                    <div class="w-12 h-1 bg-green-500 mx-auto"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Daily Activities Section -->
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text" data-aos="fade-up">Aktivitas Santri Pondok
                    Tahfidz</h2>
                <div class="w-24 h-1 bg-green-500 mx-auto mb-8" data-aos="fade-up" data-aos-delay="100"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    Jadwal kegiatan harian santri yang terstruktur untuk membentuk disiplin dan kebiasaan positif
                </p>
            </div>

            <div class="flex justify-center" data-aos="zoom-in" data-aos-delay="300">
                <div class="daily-activities-container">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/WhatsApp%20Image%202025-04-09%20at%208.35.14%20PM-61Hb8DVJfwe61wCPr6jIfjRMjxhUPl.jpeg"
                        alt="Jadwal Kegiatan Harian Santri Pondok Pesantren Ibnu Hafidz" class="w-full h-auto">
                </div>
            </div>
        </div>
    </section>

    <!-- Facilities Section -->
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text" data-aos="fade-up">Fasilitas</h2>
                <div class="w-24 h-1 bg-green-500 mx-auto mb-8" data-aos="fade-up" data-aos-delay="100"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    Kami menyediakan fasilitas modern dan nyaman untuk mendukung proses belajar mengajar.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div class="grid grid-cols-2 gap-4" data-aos="fade-right">
                    <div class="bg-gray-200 rounded-lg h-48 pulse"></div>
                    <div class="bg-gray-200 rounded-lg h-64 mt-8"></div>
                    <div class="bg-gray-200 rounded-lg h-64"></div>
                    <div class="bg-gray-200 rounded-lg h-48 mt-8 pulse"></div>
                </div>

                <div data-aos="fade-left">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Lingkungan Belajar yang Nyaman</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-3 mt-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">Asrama putra dan putri yang terpisah dengan fasilitas lengkap</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-3 mt-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">Masjid sebagai pusat kegiatan ibadah dan pembelajaran</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-3 mt-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">Ruang kelas yang nyaman dan dilengkapi dengan fasilitas
                                modern</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-3 mt-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">Perpustakaan dengan koleksi buku yang lengkap</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-3 mt-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">Laboratorium komputer dan bahasa</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-3 mt-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">Fasilitas olahraga dan area rekreasi</span>
                        </li>
                    </ul>
                    <a href="{{ url('/gallery/foto') }}"
                        class="inline-flex items-center mt-6 text-green-600 font-medium hover:text-green-700">
                        Lihat Galeri Fasilitas
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 md:py-24 bg-gray-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text" data-aos="fade-up">Apa kata mereka tentang
                    Ibnu Hafidz?</h2>
                <div class="w-24 h-1 bg-green-500 mx-auto mb-8" data-aos="fade-up" data-aos-delay="100"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    Dengarkan langsung pengalaman dan kesaksian dari para santri, alumni, dan orang tua tentang Pondok
                    Pesantren Ibnu Hafidz.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div data-aos="fade-up" data-aos-delay="100">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/UOIDZDhCvxg?rel=0"
                            title="Testimoni Pondok Pesantren Ibnu Hafidz"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="200">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/bhWKv7EzYDE?rel=0"
                            title="Testimoni Pondok Pesantren Ibnu Hafidz"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="300">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/FLeUvzKRUvo?rel=0"
                            title="Testimoni Pondok Pesantren Ibnu Hafidz"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 md:py-24 bg-green-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                <defs>
                    <pattern id="pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 20 L40 20" stroke="white" stroke-width="1" fill="none" />
                        <path d="M20 0 L20 40" stroke="white" stroke-width="1" fill="none" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#pattern)" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 text-white">Bergabunglah dengan Kami</h2>
                <p class="text-lg text-white/90 max-w-3xl mx-auto mb-8">
                    Jadilah bagian dari keluarga besar Pondok Pesantren Ibnu Hafidz dan raih masa depan cerah dengan
                    pendidikan berkualitas.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ url('/pendaftaran') }}"
                        class="cta-button inline-block bg-amber-400 text-green-800 font-semibold px-8 py-4 rounded-lg shadow-lg hover:shadow-xl hover:bg-amber-300 transition duration-300 text-lg">
                        Daftar Sekarang
                    </a>
                    <a href="{{ url('/contact') }}"
                        class="inline-block bg-transparent border-2 border-white text-white font-semibold px-8 py-4 rounded-lg hover:bg-white/10 transition duration-300 text-lg">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Maps and Rating Section -->
    <section class="py-16 md:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text" data-aos="fade-up">Lokasi Kami</h2>
                <div class="w-24 h-1 bg-green-500 mx-auto mb-8" data-aos="fade-up" data-aos-delay="100"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    Kunjungi Pondok Pesantren Ibnu Hafidz di lokasi yang strategis dan mudah dijangkau.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Google Maps -->
                <div data-aos="fade-up" data-aos-delay="100">
                    <div class="maps-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15864.451167314095!2d107.83863946304244!3d-6.248865199999991!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e695aa14cc467fd%3A0xd72c4a6817372450!2sPesantren%20Tahfidz%20Ibnu%20Hafidz!5e0!3m2!1sid!2sid!4v1744362523706!5m2!1sid!2sid"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <!-- Rating Card -->
                <div data-aos="fade-up" data-aos-delay="200">
                    <div class="rating-card">
                        <h3 class="text-2xl font-bold mb-4 text-gray-800">Pondok Pesantren Tahfidz Ibnu Hafidz</h3>

                        <div class="mt-4 space-y-3">
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2 mt-0.5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016   stroke-width=" 2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-gray-600">Sukamulya, RT.25/RW.06, Rancadaka, Kec. Pusakanagara, Kabupaten
                                    Subang, Jawa Barat 41255</span>
                            </div>
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2 mt-0.5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                <span class="text-gray-600">Plus Code: QV25+3C Rancadaka, Kabupaten Subang, Jawa
                                    Barat</span>
                            </div>
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2 mt-0.5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-gray-600">Buka: Senin - Minggu (24 Jam)</span>
                            </div>
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2 mt-0.5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span class="text-gray-600">Telepon: (021) 12345678</span>
                            </div>
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2 mt-0.5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-600">Email: info@ibnuhafidz.ac.id</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="https://maps.app.goo.gl/vR8W4XVRbKBhb5oE9" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                Lihat di Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            });
        });
    </script>
@endsection
