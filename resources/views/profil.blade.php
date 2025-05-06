@extends('layouts.main-navigation')

@section('title', 'Profil Kami')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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
            background-color: var(--primary);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3Cpath d='M6 5V0H5v5H0v1h5v94h1V6h94V5H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            position: relative;
            z-index: 0;
        }

        .hero-pattern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(27, 94, 32, 0.8), rgba(46, 125, 50, 0.7));
            z-index: 1;
        }

        .gradient-text {
            background: linear-gradient(90deg, var(--primary-dark), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-light));
        }

        .card {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: var(--bg-light);
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.2), 0 15px 20px -10px rgba(0, 0, 0, 0.1);
        }

        .program-card {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: var(--bg-light);
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
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-light));
            opacity: 0;
            z-index: -1;
            transition: opacity 0.4s ease;
        }

        .program-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.2), 0 15px 20px -10px rgba(0, 0, 0, 0.1);
        }

        .program-card:hover::before {
            opacity: 0.05;
        }

        .program-card:hover .program-icon {
            transform: scale(1.1) rotate(10deg);
            background-color: var(--primary-light);
            color: var(--text-light);
        }

        .program-card:hover h3 {
            color: var(--primary);
        }

        .program-icon {
            width: 80px;
            height: 80px;
            background-color: rgba(46, 125, 50, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: all 0.4s ease;
            color: var(--primary);
        }

        .program-detail {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px dashed rgba(46, 125, 50, 0.3);
        }

        .program-feature {
            display: flex;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .program-feature i {
            color: var(--primary);
            margin-right: 0.75rem;
            margin-top: 0.25rem;
        }

        .team-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            position: relative;
        }

        .team-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 30px 40px -15px rgba(0, 0, 0, 0.2), 0 20px 25px -10px rgba(0, 0, 0, 0.1);
        }

        .team-image-container {
            position: relative;
            overflow: hidden;
            height: 300px;
        }

        .team-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.7s ease;
        }

        .team-card:hover .team-image {
            transform: scale(1.1);
        }

        .team-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            overflow: hidden;
            width: 100%;
            height: 0;
            transition: .5s ease;
        }

        .team-card:hover .team-overlay {
            height: 50%;
        }

        .team-social {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
        }

        .team-social a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            margin: 0 5px;
            color: var(--primary);
            line-height: 40px;
            transition: all 0.3s ease;
            transform: translateY(50px);
            opacity: 0;
        }

        .team-card:hover .team-social a {
            transform: translateY(0);
            opacity: 1;
        }

        .team-card:hover .team-social a:nth-child(1) {
            transition-delay: 0.1s;
        }

        .team-card:hover .team-social a:nth-child(2) {
            transition-delay: 0.2s;
        }

        .team-card:hover .team-social a:nth-child(3) {
            transition-delay: 0.3s;
        }

        .team-social a:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        .stat-card {
            background-color: var(--bg-light);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-light));
            top: -25%;
            left: -25%;
            z-index: -1;
            transform: rotate(-10deg) translateY(100%);
            transition: transform 0.6s ease;
            opacity: 0.1;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.2), 0 15px 20px -10px rgba(0, 0, 0, 0.1);
        }

        .stat-card:hover::before {
            transform: rotate(-10deg) translateY(0);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            background-color: rgba(46, 125, 50, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: all 0.4s ease;
        }

        .stat-card:hover .stat-icon {
            background-color: var(--primary-light);
            transform: scale(1.1) rotate(10deg);
        }

        .stat-card:hover .stat-icon i {
            color: white;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
            transition: all 0.4s ease;
        }

        .stat-card:hover .stat-number {
            transform: scale(1.1);
        }

        .stat-label {
            color: var(--text-dark);
            font-size: 1.1rem;
            font-weight: 500;
        }

        .facility-card {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }

        .facility-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.2), 0 15px 20px -10px rgba(0, 0, 0, 0.1);
        }

        .facility-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
            transition: all 0.7s ease;
        }

        .facility-card:hover .facility-image {
            transform: scale(1.1);
        }

        .facility-image-container {
            overflow: hidden;
            position: relative;
        }

        .facility-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(46, 125, 50, 0.2), rgba(46, 125, 50, 0.5));
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .facility-card:hover .facility-overlay {
            opacity: 1;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .btn-secondary {
            background-color: var(--secondary);
            color: var(--text-dark);
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .btn-secondary:hover {
            background-color: var(--secondary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .btn-outline {
            background-color: transparent;
            color: white;
            border: 2px solid white;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-outline:hover {
            background-color: white;
            color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            position: relative;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--primary);
            transition: width 0.4s ease;
        }

        .section-title-center {
            position: relative;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .section-title-center::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: var(--primary);
            transition: width 0.4s ease;
        }

        .section-container:hover .section-title::after,
        .section-container:hover .section-title-center::after {
            width: 100px;
        }

        .section-bg-light {
            background-color: var(--bg-light);
        }

        .section-bg-dark {
            background-color: var(--bg-dark);
        }

        .section-wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .section-wave svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 70px;
        }

        .section-wave .shape-fill {
            fill: var(--bg-light);
        }

        .section-wave-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            transform: rotate(180deg);
        }

        .section-wave-top svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 70px;
        }

        .section-wave-top .shape-fill {
            fill: var(--bg-dark);
        }

        .cta-section {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.1;
        }

        @media (max-width: 768px) {
            .hero-pattern {
                padding: 6rem 0;
            }

            .section-title::after,
            .section-title-center::after {
                width: 30px;
            }

            .section-container:hover .section-title::after,
            .section-container:hover .section-title-center::after {
                width: 60px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero-pattern relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-28 md:py-40">
            <div class="text-center relative" style="z-index: 2;" data-aos="fade-up">
                <span
                    class="inline-block px-4 py-1 bg-white/20 backdrop-blur-sm text-white rounded-full mb-4 text-sm font-semibold">Pondok
                    Pesantren Tahfidz</span>
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6">Tentang <span
                        class="text-yellow-300">Ibnu Hafidz</span></h1>
                <p class="text-lg md:text-xl text-white/90 max-w-3xl mx-auto mb-10">
                    Mengenal lebih dekat Pondok Pesantren Tahfidz Ibnu Hafidz, sejarah, visi misi, dan perkembangannya.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#program" class="btn-primary">
                        <i class="fas fa-book-open mr-2"></i> Program Kami
                    </a>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 w-full overflow-hidden" style="z-index: 1; transform: translateY(1px);">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#ffffff" fill-opacity="1"
                    d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,149.3C960,160,1056,160,1152,138.7C1248,117,1344,75,1392,53.3L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 section-container">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div data-aos="fade-right" data-aos-duration="1000">
                    <div class="relative">
                        <div class="absolute -top-4 -left-4 w-24 h-24 bg-green-100 rounded-tl-3xl z-0"></div>
                        <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-green-100 rounded-br-3xl z-0"></div>
                        <img src="/placeholder.svg?height=500&width=600" alt="Tentang Ibnu Hafidz"
                            class="rounded-xl shadow-xl w-full bg-gray-200 relative z-10">
                    </div>
                </div>
                <div data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <h2 class="section-title text-3xl md:text-4xl font-bold mb-8 gradient-text">Sejarah Singkat</h2>
                    <p class="text-gray-600 mb-6 text-lg">
                        Pesantren Tahfidz Ibnu Hafidz didirikan oleh <span class="font-semibold text-green-700">Ust. Taslim
                            Hafidz, Lc.</span> (Alumni Universitas Al-Azhar
                        Cairo Mesir) pada tahun 2018 dengan luas tanah 46.000 m². Diresmikan pada tanggal 10 Juli 2019 oleh
                        Gubernur TGB H. Dr. Zainul Majdi, Lc. MA.
                    </p>
                    <p class="text-gray-600 mb-6 text-lg">
                        Santri perdana tahun ajaran 2019 - 2020 berjumlah 40 santri, dan saat ini sudah mencapai <span
                            class="font-semibold text-green-700">660 santri</span>
                        dari berbagai daerah seperti Papua, Sulawesi, Aceh, dan juga dari Malaysia, dan didominasi dari Jawa
                        Barat.
                    </p>
                    <p class="text-gray-600 text-lg">
                        Tenaga pengajar terdiri dari lulusan Universitas Al-Azhar Cairo Mesir, Pesantren Gontor, Pesantren
                        Almawaddah, Pesantren Sidogiri, Alfalah Ploso, Dalwa, Pesantren Nurul Iman, UI, UGM, UNDIP, UNM, dan
                        Pesantren Daarul Qur'an milik Ust. Yusuf Mansur.
                    </p>
                    <div class="mt-8 flex space-x-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-alt text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <span class="block text-sm text-gray-500">Didirikan Tahun</span>
                                <span class="block text-lg font-bold text-green-700">2018</span>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                <i class="fas fa-users text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <span class="block text-sm text-gray-500">Jumlah Santri</span>
                                <span class="block text-lg font-bold text-green-700">660+</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section class="py-20 md:py-28 bg-gray-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 section-container">
            <div class="text-center mb-16">
                <h2 class="section-title-center text-3xl md:text-4xl font-bold mb-8 gradient-text" data-aos="fade-up">Visi &
                    Misi</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    Komitmen kami untuk memberikan pendidikan berkualitas dan membentuk generasi Qur'ani
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-10">
                <div class="card p-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <i class="fas fa-eye text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-center mb-6 text-green-700">Visi</h3>
                    <p class="text-gray-600 text-center text-lg italic mb-8">
                        "Menjadi lembaga pendidikan Islam terkemuka yang melahirkan generasi Qur'ani, berakhlak mulia, dan
                        berprestasi global."
                    </p>
                    <div class="mt-8 bg-green-50 p-6 rounded-xl">
                        <h4 class="text-lg font-semibold mb-4 text-green-700">Tujuan Utama:</h4>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Mencetak generasi penghafal Al-Qur'an yang memahami dan
                                    mengamalkan isinya</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Membentuk karakter Islami yang kuat berdasarkan nilai-nilai
                                    Al-Qur'an dan Sunnah</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Mengembangkan potensi akademik dan non-akademik untuk menghadapi
                                    tantangan global</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card p-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <i class="fas fa-bullseye text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-center mb-6 text-green-700">Misi</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <span
                                class="flex-shrink-0 flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-full mr-3 font-bold">1</span>
                            <span class="text-gray-700">Menyelenggarakan pendidikan berbasis Al-Qur'an dan Sunnah dengan
                                metode pembelajaran modern yang efektif</span>
                        </li>
                        <li class="flex items-start">
                            <span
                                class="flex-shrink-0 flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-full mr-3 font-bold">2</span>
                            <span class="text-gray-700">Mengembangkan potensi santri secara komprehensif melalui program
                                tahfidz intensif dan pendampingan personal</span>
                        </li>
                        <li class="flex items-start">
                            <span
                                class="flex-shrink-0 flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-full mr-3 font-bold">3</span>
                            <span class="text-gray-700">Membangun karakter Islami melalui pembiasaan akhlak mulia dalam
                                kehidupan sehari-hari dan keteladanan</span>
                        </li>
                        <li class="flex items-start">
                            <span
                                class="flex-shrink-0 flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-full mr-3 font-bold">4</span>
                            <span class="text-gray-700">Mengembangkan kemampuan bahasa Arab dan Inggris untuk menghadapi
                                tantangan global dan dakwah internasional</span>
                        </li>
                        <li class="flex items-start">
                            <span
                                class="flex-shrink-0 flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-full mr-3 font-bold">5</span>
                            <span class="text-gray-700">Mempersiapkan santri untuk melanjutkan pendidikan ke jenjang yang
                                lebih tinggi baik di dalam maupun luar negeri</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-20 md:py-28 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 section-container">
            <div class="text-center mb-16">
                <h2 class="section-title-center text-3xl md:text-4xl font-bold mb-8 gradient-text" data-aos="fade-up">Fakta
                    & Angka</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    Perkembangan Pondok Pesantren Ibnu Hafidz dalam angka yang menunjukkan pertumbuhan kami
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-icon">
                        <i class="fas fa-user-graduate text-green-600 text-3xl"></i>
                    </div>
                    <div class="stat-number">660+</div>
                    <div class="stat-label">Santri Aktif</div>
                </div>

                <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-icon">
                        <i class="fas fa-map-marked-alt text-green-600 text-3xl"></i>
                    </div>
                    <div class="stat-number">46.000</div>
                    <div class="stat-label">Luas Area (m²)</div>
                </div>

                <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-icon">
                        <i class="fas fa-chalkboard-teacher text-green-600 text-3xl"></i>
                    </div>
                    <div class="stat-number">30+</div>
                    <div class="stat-label">Tenaga Pengajar</div>
                </div>

                <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-icon">
                        <i class="fas fa-history text-green-600 text-3xl"></i>
                    </div>
                    <div class="stat-number">5+</div>
                    <div class="stat-label">Tahun Berdiri</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Section (Expanded) -->
    <section id="program" class="py-20 md:py-28 bg-gray-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 section-container">
            <div class="text-center mb-16">
                <h2 class="section-title-center text-3xl md:text-4xl font-bold mb-8 gradient-text" data-aos="fade-up">
                    Program Kami di Ibnu Hafidz</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    Program unggulan yang kami tawarkan untuk pengembangan santri secara komprehensif, mencakup aspek
                    spiritual, intelektual, dan keterampilan
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 mb-16">
                <div class="program-card p-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="program-icon mx-auto">
                        <i class="fas fa-book-quran text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-center mb-4 text-green-700">Tahfidz Halaqoh</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Program intensif menghafal Al-Qur'an dengan metode halaqoh yang dibimbing langsung oleh para hafidz
                        dan hafidzah berpengalaman.
                    </p>
                    <div class="program-detail">
                        <h4 class="font-semibold text-green-600 mb-3">Keunggulan Program:</h4>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Metode menghafal yang disesuaikan dengan kemampuan santri</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Bimbingan intensif dengan rasio pengajar dan santri yang ideal</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Evaluasi hafalan berkala untuk memastikan kualitas hafalan</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Pembelajaran tajwid dan tahsin untuk memperbaiki bacaan</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Program muroja'ah (pengulangan) terjadwal untuk menjaga hafalan</span>
                        </div>
                    </div>
                </div>

                <div class="program-card p-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="program-icon mx-auto">
                        <i class="fas fa-book-open text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-center mb-4 text-green-700">Kajian Kitab</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Pembelajaran kitab-kitab klasik dan kontemporer untuk memperdalam pemahaman agama Islam dari
                        berbagai aspek keilmuan.
                    </p>
                    <div class="program-detail">
                        <h4 class="font-semibold text-green-600 mb-3">Kitab yang Dipelajari:</h4>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Kitab Tafsir (Tafsir Ibnu Katsir, Tafsir Al-Qurthubi)</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Kitab Hadits (Riyadhus Shalihin, Bulughul Maram)</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Kitab Fiqih (Fathul Qarib, Fiqhus Sunnah)</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Kitab Akhlak (Ta'limul Muta'allim, Akhlaq lil Banin/Banat)</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Kitab Bahasa Arab (Nahwu, Sharaf, Balaghah)</span>
                        </div>
                    </div>
                </div>

                <div class="program-card p-8" data-aos="fade-up" data-aos-delay="300">
                    <div class="program-icon mx-auto">
                        <i class="fas fa-school text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-center mb-4 text-green-700">Sekolah Formal SMP IT</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Pendidikan formal tingkat menengah pertama dengan kurikulum nasional yang diintegrasikan dengan
                        nilai-nilai Islam.
                    </p>
                    <div class="program-detail">
                        <h4 class="font-semibold text-green-600 mb-3">Kurikulum Unggulan:</h4>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Kurikulum Nasional (Kemendikbud) dengan pengayaan materi keislaman</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Program penguatan karakter berbasis nilai-nilai Islam</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Pembelajaran bahasa Arab dan Inggris intensif</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Integrasi tahfidz dalam jadwal akademik</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Pengembangan life skill dan leadership</span>
                        </div>
                    </div>
                </div>

                <div class="program-card p-8" data-aos="fade-up" data-aos-delay="400">
                    <div class="program-icon mx-auto">
                        <i class="fas fa-graduation-cap text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-center mb-4 text-green-700">Sekolah Formal SMA IT</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Pendidikan formal tingkat menengah atas dengan kurikulum nasional yang diintegrasikan dengan
                        nilai-nilai Islam dan persiapan perguruan tinggi.
                    </p>
                    <div class="program-detail">
                        <h4 class="font-semibold text-green-600 mb-3">Program Unggulan:</h4>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Penjurusan IPA dan IPS dengan pendekatan islami</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Persiapan UTBK dan seleksi perguruan tinggi dalam dan luar negeri</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Program beasiswa ke universitas terkemuka</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Pengembangan riset dan karya ilmiah</span>
                        </div>
                        <div class="program-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Bimbingan karir dan pengembangan bakat</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-lg" data-aos="fade-up">
                <h3 class="text-2xl font-bold mb-6 text-center text-green-700">Jadwal Program Harian</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-3 px-4 bg-green-50 text-left text-green-700 font-semibold">Waktu</th>
                                <th class="py-3 px-4 bg-green-50 text-left text-green-700 font-semibold">Kegiatan</th>
                                <th class="py-3 px-4 bg-green-50 text-left text-green-700 font-semibold">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="py-3 px-4 text-gray-700">04:00 - 04:30</td>
                                <td class="py-3 px-4 text-gray-700">Tahajud</td>
                                <td class="py-3 px-4 text-gray-700">Shalat malam dan muroja'ah hafalan</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">04:30 - 05:00</td>
                                <td class="py-3 px-4 text-gray-700">Sholat Subuh Berjama'ah</td>
                                <td class="py-3 px-4 text-gray-700">Berjamaah di masjid</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">05:00 - 06:15</td>
                                <td class="py-3 px-4 text-gray-700 font-semibold text-green-600">Tahfidz Pertama</td>
                                <td class="py-3 px-4 text-gray-700">Setoran hafalan baru</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">06:15 - 06:30</td>
                                <td class="py-3 px-4 text-gray-700">Sholat Dhuha</td>
                                <td class="py-3 px-4 text-gray-700">Shalat sunnah pagi</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">06:30 - 07:30</td>
                                <td class="py-3 px-4 text-gray-700">Istirahat & Makan Pagi</td>
                                <td class="py-3 px-4 text-gray-700">Sarapan dan persiapan sekolah</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">07:30 - 08:00</td>
                                <td class="py-3 px-4 text-gray-700">Giving Vocabulary (Arab/Inggris)</td>
                                <td class="py-3 px-4 text-gray-700">Penguatan bahasa</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">08:00 - 11:45</td>
                                <td class="py-3 px-4 text-gray-700">Sekolah Formal SMPIT & SMAIT</td>
                                <td class="py-3 px-4 text-gray-700">Pembelajaran akademik</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">12:00 - 12:30</td>
                                <td class="py-3 px-4 text-gray-700">Sholat Dhuhur Berjama'ah</td>
                                <td class="py-3 px-4 text-gray-700">Berjamaah di masjid</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">12:30 - 13:00</td>
                                <td class="py-3 px-4 text-gray-700">Makan Siang</td>
                                <td class="py-3 px-4 text-gray-700">Istirahat</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">13:00 - 14:00</td>
                                <td class="py-3 px-4 text-gray-700">Tidur Siang</td>
                                <td class="py-3 px-4 text-gray-700">Istirahat</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">14:00 - 15:15</td>
                                <td class="py-3 px-4 text-gray-700">Belajar Kitab Kuning</td>
                                <td class="py-3 px-4 text-gray-700">Pembelajaran kitab klasik</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">15:15 - 15:45</td>
                                <td class="py-3 px-4 text-gray-700">Sholat Ashar Berjama'ah & Baca Surat Al-Waqi'ah</td>
                                <td class="py-3 px-4 text-gray-700">Berjamaah di masjid</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">15:45 - 16:45</td>
                                <td class="py-3 px-4 text-gray-700 font-semibold text-green-600">Tahfidz Kedua</td>
                                <td class="py-3 px-4 text-gray-700">Muroja'ah hafalan</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">16:45 - 17:30</td>
                                <td class="py-3 px-4 text-gray-700">Olahraga, Ekskul, Siap ke Masjid</td>
                                <td class="py-3 px-4 text-gray-700">Kegiatan ekstrakurikuler</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">17:30 - 18:00</td>
                                <td class="py-3 px-4 text-gray-700">Pembacaan Arhamarrohimin dan Kultum</td>
                                <td class="py-3 px-4 text-gray-700">Kegiatan spiritual</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">18:00 - 18:20</td>
                                <td class="py-3 px-4 text-gray-700">Sholat Maghrib Berjama'ah</td>
                                <td class="py-3 px-4 text-gray-700">Berjamaah di masjid</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">18:20 - 18:45</td>
                                <td class="py-3 px-4 text-gray-700">Tahsin</td>
                                <td class="py-3 px-4 text-gray-700">Perbaikan bacaan Al-Qur'an</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">18:45 - 19:15</td>
                                <td class="py-3 px-4 text-gray-700">Makan Malam</td>
                                <td class="py-3 px-4 text-gray-700">Istirahat</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">19:15 - 19:45</td>
                                <td class="py-3 px-4 text-gray-700">Sholat Isya' Berjama'ah</td>
                                <td class="py-3 px-4 text-gray-700">Berjamaah di masjid</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">19:45 - 21:00</td>
                                <td class="py-3 px-4 text-gray-700 font-semibold text-green-600">Tahfidz Ketiga</td>
                                <td class="py-3 px-4 text-gray-700">Persiapan hafalan</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">21:00 - 21:30</td>
                                <td class="py-3 px-4 text-gray-700">Pembacaan Al-Mulk & Tikror Mufrodat</td>
                                <td class="py-3 px-4 text-gray-700">Kegiatan spiritual dan bahasa</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">21:30 - 04:00</td>
                                <td class="py-3 px-4 text-gray-700">Istirahat Malam</td>
                                <td class="py-3 px-4 text-gray-700">Tidur malam</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Extracurricular Section -->
    <section class="py-20 md:py-28 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 section-container">
            <div class="text-center mb-16">
                <h2 class="section-title-center text-3xl md:text-4xl font-bold mb-8 gradient-text" data-aos="fade-up">
                    Kegiatan Ekstrakurikuler</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    Berbagai kegiatan untuk mengembangkan bakat dan minat santri di luar kegiatan akademik
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="facility-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="facility-image-container">
                        <img src="/placeholder.svg?height=250&width=400" alt="Olahraga" class="facility-image bg-gray-200">
                        <div class="facility-overlay"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-green-700">Olahraga</h3>
                        <p class="text-gray-600 mb-4">
                            Berbagai kegiatan olahraga seperti sepak bola, bulu tangkis, tenis meja, dan panahan untuk
                            menjaga kesehatan fisik santri.
                        </p>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-circle text-green-500 text-xs mr-2"></i>
                                <span>Sepak Bola & Futsal</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-circle text-green-500 text-xs mr-2"></i>
                                <span>Bulu Tangkis</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-circle text-green-500 text-xs mr-2"></i>
                                <span>Panahan (Memanah Sunnah)</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-circle text-green-500 text-xs mr-2"></i>
                                <span>Berenang</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="facility-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="facility-image-container">
                        <img src="/placeholder.svg?height=250&width=400" alt="Seni dan Budaya"
                            class="facility-image bg-gray-200">
                        <div class="facility-overlay"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-green-700">Seni dan Budaya</h3>
                        <p class="text-gray-600 mb-4">
                            Kegiatan seni seperti kaligrafi, nasyid, dan hadrah untuk mengembangkan kreativitas dan
                            apresiasi seni Islami.
                        </p>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-circle text-green-500 text-xs mr-2"></i>
                                <span>Kaligrafi Islam</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-circle text-green-500 text-xs mr-2"></i>
                                <span>Nasyid & Vocal Group</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-circle text-green-500 text-xs mr-2"></i>
                                <span>Hadrah & Marawis</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-circle text-green-500 text-xs mr-2"></i>
                                <span>Tilawah Al-Qur'an</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="facility-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="facility-image-container">
                        <img src="/placeholder.svg?height=250&width=400" alt="Keterampilan"
                            class="facility-image bg-gray-200">
                        <div class="facility-overlay"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-green-700">Keterampilan</h3>
                        <p class="text-gray-600 mb-4">
                            Pelatihan keterampilan seperti public speaking, jurnalistik, dan entrepreneurship untuk
                            mempersiapkan santri di masa depan.
                        </p>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-circle text-green-500 text-xs mr-2"></i>
                                <span>Public Speaking & Khitobah</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-circle text-green-500 text-xs mr-2"></i>
                                <span>Jurnalistik & Penulisan</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-circle text-green-500 text-xs mr-2"></i>
                                <span>Entrepreneurship</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-circle text-green-500 text-xs mr-2"></i>
                                <span>Teknologi Informasi</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Team Section (Modified) -->
    <section class="py-20 md:py-28 bg-gray-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 section-container">
            <div class="text-center mb-16">
                <h2 class="section-title-center text-3xl md:text-4xl font-bold mb-8 gradient-text" data-aos="fade-up">
                    Pimpinan</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    Mengenal sosok di balik kesuksesan Pondok Pesantren Ibnu Hafidz
                </p>
            </div>

            <div class="flex justify-center">
                <div class="team-card max-w-md" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-image-container">
                        <img src="/placeholder.svg?height=300&width=400" alt="Al-Ustadz Taslim Hafidz, Lc."
                            class="team-image bg-gray-200">
                        <div class="team-overlay">
                            <div class="team-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-2">Al-Ustadz Taslim Hafidz, Lc.</h3>
                        <p class="text-green-600 mb-4 font-medium">Pendiri & Pimpinan Pesantren</p>
                        <p class="text-gray-600">
                            Alumni Universitas Al-Azhar Cairo Mesir dengan pengalaman mengajar dan mengelola pendidikan
                            Islam selama lebih dari 15 tahun. Beliau memiliki dedikasi tinggi dalam pengembangan pendidikan
                            Islam
                            yang berkualitas dan pembentukan generasi Qur'ani.
                        </p>
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-graduation-cap text-green-600 mr-3"></i>
                                <span class="text-gray-700">Lulusan Universitas Al-Azhar Cairo, Mesir</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-book text-green-600 mr-3"></i>
                                <span class="text-gray-700">Hafidz Al-Qur'an 30 Juz</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Facilities Section -->
    <section class="py-20 md:py-28 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 section-container">
            <div class="text-center mb-16">
                <h2 class="section-title-center text-3xl md:text-4xl font-bold mb-8 gradient-text" data-aos="fade-up">
                    Fasilitas Kami</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    Fasilitas modern dan nyaman untuk mendukung kegiatan belajar mengajar dan pengembangan santri
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="facility-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="facility-image-container">
                        <img src="/placeholder.svg?height=200&width=400" alt="Masjid" class="facility-image bg-gray-200">
                        <div class="facility-overlay"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-green-700">Masjid</h3>
                        <p class="text-gray-600">
                            Masjid sebagai pusat kegiatan ibadah dan pembelajaran Al-Qur'an dengan kapasitas 1000 jamaah,
                            dilengkapi dengan sound system dan pendingin ruangan.
                        </p>
                    </div>
                </div>

                <div class="facility-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="facility-image-container">
                        <img src="/placeholder.svg?height=200&width=400" alt="Asrama" class="facility-image bg-gray-200">
                        <div class="facility-overlay"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-green-700">Asrama</h3>
                        <p class="text-gray-600">
                            Asrama putra dan putri yang terpisah dengan fasilitas lengkap untuk kenyamanan santri, termasuk
                            kamar mandi dalam, lemari, dan meja belajar.
                        </p>
                    </div>
                </div>

                <div class="facility-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="facility-image-container">
                        <img src="/placeholder.svg?height=200&width=400" alt="Ruang Kelas"
                            class="facility-image bg-gray-200">
                        <div class="facility-overlay"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-green-700">Ruang Kelas</h3>
                        <p class="text-gray-600">
                            Ruang kelas yang nyaman dan dilengkapi dengan fasilitas modern seperti proyektor, AC, dan papan
                            tulis interaktif untuk mendukung proses belajar mengajar.
                        </p>
                    </div>
                </div>

                <div class="facility-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="facility-image-container">
                        <img src="/placeholder.svg?height=200&width=400" alt="Perpustakaan"
                            class="facility-image bg-gray-200">
                        <div class="facility-overlay"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-green-700">Perpustakaan</h3>
                        <p class="text-gray-600">
                            Perpustakaan dengan koleksi buku yang lengkap, termasuk kitab-kitab klasik, buku referensi
                            modern, dan akses digital untuk mendukung kegiatan belajar santri.
                        </p>
                    </div>
                </div>

                <div class="facility-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="facility-image-container">
                        <img src="/placeholder.svg?height=200&width=400" alt="Laboratorium"
                            class="facility-image bg-gray-200">
                        <div class="facility-overlay"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-green-700">Laboratorium</h3>
                        <p class="text-gray-600">
                            Laboratorium komputer, bahasa, dan sains yang lengkap untuk mengembangkan keterampilan santri
                            dalam teknologi, bahasa, dan ilmu pengetahuan.
                        </p>
                    </div>
                </div>

                <div class="facility-card" data-aos="fade-up" data-aos-delay="600">
                    <div class="facility-image-container">
                        <img src="/placeholder.svg?height=200&width=400" alt="Fasilitas Olahraga"
                            class="facility-image bg-gray-200">
                        <div class="facility-overlay"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-green-700">Fasilitas Olahraga</h3>
                        <p class="text-gray-600">
                            Lapangan olahraga multifungsi, lapangan futsal, lapangan basket, dan area rekreasi untuk
                            kegiatan ekstrakurikuler dan pengembangan fisik santri.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="contact" class="py-20 md:py-28 cta-section relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 text-white">Bergabunglah dengan Kami</h2>
                <p class="text-lg text-white/90 max-w-3xl mx-auto mb-10">
                    Jadilah bagian dari keluarga besar Pondok Pesantren Ibnu Hafidz dan raih masa depan cerah dengan
                    pendidikan berkualitas yang mengintegrasikan nilai-nilai Islam.
                </p>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="{{ url('/pendaftaran') }}" class="btn-secondary">
                        <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                    </a>
                    <a href="{{ url('/contact') }}" class="btn-outline">
                        <i class="fas fa-phone-alt mr-2"></i> Hubungi Kami
                    </a>
                </div>

                <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white/10 backdrop-blur-sm p-6 rounded-xl">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Lokasi</h3>
                        <p class="text-white/80">
                            Sukamulya, RT.25/RW.06, Rancadaka, Kec. Pusakanagara, Kabupaten
                            Subang, Jawa Barat 41255
                        </p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm p-6 rounded-xl">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-phone-alt text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Kontak</h3>
                        <p class="text-white/80">
                            Telepon: +62 812-3456-7890<br>
                            Email: info@ibnuhafidz.sch.id
                        </p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm p-6 rounded-xl">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-clock text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Jam Kunjungan Santri</h3>
                        <p class="text-white/80">
                            Ahad: 08:00 - 16:00
                        </p>
                        <h3 class="text-xl font-bold text-white mb-3">Jam Kunjungan Survey</h3>
                        <p class="text-white/80">
                            Setiap Hari
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
                mirror: false,
                offset: 100
            });
        });
    </script>
@endsection
