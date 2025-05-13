@extends('layouts.dashboard-layout')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        /* Advanced animations */
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

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(124, 58, 237, 0.2);
            }

            50% {
                box-shadow: 0 0 20px 5px rgba(124, 58, 237, 0.4);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-slow {
            animation: float 8s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }

        .article-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .article-card:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.15), 0 18px 36px -18px rgba(0, 0, 0, 0.1);
        }

        .card-shimmer {
            background: linear-gradient(90deg,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 0.2) 50%,
                    rgba(255, 255, 255, 0) 100%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }

        .status-badge {
            transition: all 0.3s ease;
        }

        .status-badge:hover {
            transform: scale(1.1);
        }

        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.3);
        }

        .truncate-2-lines {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .article-actions button,
        .article-actions a {
            transition: all 0.2s ease;
            opacity: 0.8;
        }

        .article-actions button:hover,
        .article-actions a:hover {
            opacity: 1;
            transform: scale(1.15);
        }

        .article-card:hover .article-actions {
            opacity: 1;
        }

        .article-actions {
            opacity: 0.4;
            transition: opacity 0.3s ease;
        }

        .category-pill {
            transition: all 0.3s ease;
        }

        .category-pill:hover {
            transform: translateY(-2px);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dark .glass-effect {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .filter-active {
            @apply bg-gradient-to-r from-purple-500 to-blue-500 text-white;
        }

        .filter-button {
            transition: all 0.3s ease;
        }

        .filter-button:hover {
            transform: translateY(-2px);
        }

        .pagination-item {
            transition: all 0.3s ease;
        }

        .pagination-item:hover:not(.pagination-active):not(.pagination-disabled) {
            transform: translateY(-2px);
        }

        .pagination-active {
            @apply bg-gradient-to-r from-purple-500 to-blue-500 text-white border-transparent;
            box-shadow: 0 10px 15px -3px rgba(124, 58, 237, 0.3);
        }

        .article-thumbnail {
            transition: all 0.5s ease;
        }

        .article-card:hover .article-thumbnail {
            transform: scale(1.05);
        }

        .stats-card {
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-icon {
            transition: all 0.3s ease;
        }

        .stats-card:hover .stats-icon {
            transform: scale(1.1);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(124, 58, 237, 0.5);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(124, 58, 237, 0.7);
        }

        /* Tooltip */
        .tooltip {
            position: relative;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            width: auto;
            min-width: 120px;
            background: rgba(15, 23, 42, 0.9);
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 10px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            white-space: nowrap;
            font-size: 0.75rem;
            pointer-events: none;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        /* Delete Modal Styles */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(4px);
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        .delete-modal {
            background: white;
            border-radius: 1rem;
            width: 90%;
            max-width: 500px;
            transform: translateY(20px) scale(0.95);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .dark .delete-modal {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-backdrop.active .delete-modal {
            transform: translateY(0) scale(1);
        }

        .delete-modal-header {
            position: relative;
            padding: 1.5rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
        }

        .dark .delete-modal-header {
            border-bottom: 1px solid rgba(51, 65, 85, 0.5);
        }

        .delete-modal-body {
            padding: 1.5rem;
        }

        .delete-modal-footer {
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            border-top: 1px solid rgba(226, 232, 240, 0.5);
        }

        .dark .delete-modal-footer {
            border-top: 1px solid rgba(51, 65, 85, 0.5);
        }

        .delete-modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.5rem;
            border-radius: 9999px;
            transition: background-color 0.2s;
        }

        .delete-modal-close:hover {
            background-color: rgba(226, 232, 240, 0.5);
        }

        .dark .delete-modal-close:hover {
            background-color: rgba(51, 65, 85, 0.5);
        }

        .delete-btn-cancel {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s;
            background-color: #e2e8f0;
            color: #475569;
        }

        .dark .delete-btn-cancel {
            background-color: #334155;
            color: #e2e8f0;
        }

        .delete-btn-cancel:hover {
            background-color: #cbd5e1;
        }

        .dark .delete-btn-cancel:hover {
            background-color: #475569;
        }

        .delete-btn-confirm {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s;
            background: linear-gradient(to right, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2), 0 2px 4px -1px rgba(239, 68, 68, 0.1);
        }

        .delete-btn-confirm:hover {
            box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.3), 0 4px 6px -2px rgba(239, 68, 68, 0.1);
            transform: translateY(-2px);
        }

        .delete-btn-confirm:active {
            transform: translateY(0);
        }

        .delete-icon-container {
            width: 4rem;
            height: 4rem;
            border-radius: 9999px;
            background-color: #fee2e2;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
        }

        .dark .delete-icon-container {
            background-color: rgba(239, 68, 68, 0.2);
        }

        .delete-icon {
            width: 2rem;
            height: 2rem;
            color: #ef4444;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        .shake {
            animation: shake 0.6s cubic-bezier(.36, .07, .19, .97) both;
        }
    </style>
@endsection

@section('content')
    <div
        class="py-8 min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-blue-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Decorative elements -->
            <div
                class="absolute top-10 right-10 w-64 h-64 bg-purple-500/10 dark:bg-purple-500/20 rounded-full blur-3xl -z-10 animate-float">
            </div>
            <div
                class="absolute bottom-10 left-10 w-72 h-72 bg-blue-500/10 dark:bg-blue-500/20 rounded-full blur-3xl -z-10 animate-float-slow">
            </div>
            <div
                class="absolute top-1/2 left-1/4 w-48 h-48 bg-pink-500/10 dark:bg-pink-500/20 rounded-full blur-3xl -z-10 animate-float-slow">
            </div>

            <!-- Page header with animated gradient -->
            <div class="mb-8 animate__animated animate__fadeIn">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1
                            class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 via-violet-600 to-blue-600 dark:from-purple-400 dark:via-violet-400 dark:to-blue-400 inline-block animate__animated animate__fadeInUp">
                            Articles
                        </h1>
                        <p
                            class="mt-2 text-slate-600 dark:text-slate-400 max-w-2xl animate__animated animate__fadeInUp animate__delay-1s">
                            Manage your content library. Create, edit, and organize your articles to engage your audience.
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 animate__animated animate__fadeInRight">
                        <a href="{{ route('categories.index') }}"
                            class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition duration-300 flex items-center whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Manage Categories
                        </a>
                        <a href="{{ route('categories.create') }}"
                            class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition duration-300 flex items-center whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            New Category
                        </a>
                        <a href="{{ route('articles.create') }}"
                            class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-medium shadow-lg shadow-purple-500/20 hover:shadow-purple-500/40 transition duration-300 flex items-center whitespace-nowrap animate-pulse-glow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            New Article
                        </a>
                    </div>
                </div>

                <!-- Stats cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
                    <div
                        class="stats-card bg-white/70 dark:bg-slate-800/50 rounded-xl shadow-md border border-slate-200/50 dark:border-slate-700/30 p-4 glass-effect">
                        <div class="flex items-center">
                            <div
                                class="stats-icon p-3 rounded-lg bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-lg shadow-purple-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Articles</p>
                                <p class="text-2xl font-bold text-slate-800 dark:text-white">{{ $articles->total() }}</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="stats-card bg-white/70 dark:bg-slate-800/50 rounded-xl shadow-md border border-slate-200/50 dark:border-slate-700/30 p-4 glass-effect">
                        <div class="flex items-center">
                            <div
                                class="stats-icon p-3 rounded-lg bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow-lg shadow-green-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Published</p>
                                <p class="text-2xl font-bold text-slate-800 dark:text-white">
                                    {{ $articles->where('status', 'published')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="stats-card bg-white/70 dark:bg-slate-800/50 rounded-xl shadow-md border border-slate-200/50 dark:border-slate-700/30 p-4 glass-effect">
                        <div class="flex items-center">
                            <div
                                class="stats-icon p-3 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 text-white shadow-lg shadow-amber-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Drafts</p>
                                <p class="text-2xl font-bold text-slate-800 dark:text-white">
                                    {{ $articles->where('status', 'draft')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="stats-card bg-white/70 dark:bg-slate-800/50 rounded-xl shadow-md border border-slate-200/50 dark:border-slate-700/30 p-4 glass-effect">
                        <div class="flex items-center">
                            <div
                                class="stats-icon p-3 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-lg shadow-blue-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Views</p>
                                <p class="text-2xl font-bold text-slate-800 dark:text-white">
                                    {{ number_format($totalViews) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and filters -->
                <div
                    class="mt-8 glass-effect bg-white/40 dark:bg-slate-800/40 rounded-xl p-4 shadow-lg border border-slate-200/50 dark:border-slate-700/30 animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="flex flex-col lg:flex-row gap-4">
                        <div class="relative flex-grow">
                            <input type="text" id="searchInput" placeholder="Search articles by title, content or author..."
                                class="search-input w-full px-4 py-3 pl-12 rounded-xl border border-slate-300 dark:border-slate-600 bg-white/70 dark:bg-slate-700/70 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-purple-500 dark:focus:border-blue-500 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-slate-400 absolute left-4 top-1/2 transform -translate-y-1/2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <div
                                class="filter-button px-3 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white/70 dark:bg-slate-700/70 text-slate-700 dark:text-slate-300 hover:shadow-md transition duration-200 cursor-pointer flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                <span class="text-sm font-medium">Filters</span>
                            </div>

                            <select id="categoryFilter"
                                class="filter-button px-3 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white/70 dark:bg-slate-700/70 text-slate-700 dark:text-slate-300 hover:shadow-md transition duration-200 text-sm">
                                <option value="">All Categories</option>
                                @foreach(App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            <select id="statusFilter"
                                class="filter-button px-3 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white/70 dark:bg-slate-700/70 text-slate-700 dark:text-slate-300 hover:shadow-md transition duration-200 text-sm">
                                <option value="">All Status</option>
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>

                            <select id="sortFilter"
                                class="filter-button px-3 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white/70 dark:bg-slate-700/70 text-slate-700 dark:text-slate-300 hover:shadow-md transition duration-200 text-sm">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="a-z">A-Z</option>
                                <option value="z-a">Z-A</option>
                                <option value="popular">Most Popular</option>
                            </select>
                        </div>
                    </div>

                    <!-- Category pills -->
                    <div class="flex flex-wrap gap-2 mt-4">
                        <div class="category-pill px-3 py-1.5 rounded-full bg-gradient-to-r from-purple-500 to-blue-500 text-white text-xs font-medium shadow-sm shadow-purple-500/20 cursor-pointer"
                            data-category-id="">
                            All Categories
                        </div>
                        @foreach(App\Models\Category::all() as $category)
                            <div class="category-pill px-3 py-1.5 rounded-full bg-white/70 dark:bg-slate-700/70 text-slate-700 dark:text-slate-300 text-xs font-medium shadow-sm border border-slate-200 dark:border-slate-600 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-600"
                                data-category-id="{{ $category->id }}">
                                {{ $category->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Flash messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 rounded-lg shadow-sm animate__animated animate__fadeIn"
                    role="alert">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Articles grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($articles as $article)
                    <div class="article-card bg-white/70 dark:bg-slate-800/50 rounded-xl shadow-lg border border-slate-200/50 dark:border-slate-700/30 overflow-hidden glass-effect animate__animated animate__fadeInUp"
                        data-category-id="{{ $article->category_id ?? '' }}" data-status="{{ $article->status }}"
                        data-title="{{ $article->title }}" data-content="{{ strip_tags($article->body) }}">
                        <!-- Article thumbnail -->
                        <div class="relative h-48 overflow-hidden">
                            @if($article->thumbnail)
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}"
                                    class="w-full h-full object-cover article-thumbnail">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-purple-500/20 via-violet-500/20 to-blue-500/20 dark:from-purple-500/30 dark:via-violet-500/30 dark:to-blue-500/30 flex items-center justify-center article-thumbnail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-300 dark:text-slate-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            <!-- Status badge -->
                            <div class="absolute top-3 right-3">
                                @if($article->status === 'published')
                                    <span
                                        class="status-badge px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-md shadow-green-500/30 flex items-center">
                                        <span class="w-2 h-2 rounded-full bg-white mr-1.5 animate-pulse"></span>
                                        Published
                                    </span>
                                @else
                                    <span
                                        class="status-badge px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-md shadow-amber-500/30 flex items-center">
                                        <span class="w-2 h-2 rounded-full bg-white mr-1.5"></span>
                                        Draft
                                    </span>
                                @endif
                            </div>

                            <!-- Category badge -->
                            <div class="absolute bottom-3 left-3">
                                @if($article->category)
                                    <span
                                        class="px-3 py-1.5 rounded-full text-xs font-medium bg-white/80 dark:bg-slate-800/80 text-slate-800 dark:text-slate-200 shadow-md backdrop-blur-sm border border-slate-200/50 dark:border-slate-700/50">
                                        {{ $article->category->name }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Article content -->
                        <div class="p-5">
                            <div class="flex items-center text-xs text-slate-500 dark:text-slate-400 mb-2 space-x-3">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $article->published_at ? $article->published_at->format('M d, Y') : 'Not published' }}
                                </span>

                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-purple-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span class="article-views-count">{{ number_format($article->views_count) }}</span>
                                </span>
                            </div>

                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2 truncate">
                                {{ $article->title }}
                            </h3>

                            <div class="text-sm text-slate-600 dark:text-slate-300 mb-4 truncate-2-lines">
                                {!! Str::limit(strip_tags($article->body), 120) !!}
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white font-medium text-sm shadow-md shadow-purple-500/20">
                                        {{ substr($article->author->name ?? 'User', 0, 1) }}
                                    </div>
                                    <span class="ml-2 text-sm text-slate-700 dark:text-slate-300">
                                        {{ $article->author->name ?? 'Unknown' }}
                                    </span>
                                </div>


                                <div class="article-actions flex space-x-1">
                                    <a href="{{ route('articles.show', ['category' => $article->category->slug, 'article' => $article->slug]) }}"
                                        class="tooltip p-2 rounded-lg text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 bg-blue-100 dark:bg-blue-900/30 hover:bg-blue-200 dark:hover:bg-blue-900/50">
                                        <span class="tooltip-text">View Article</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('articles.edit', $article->id) }}"
                                        class="tooltip p-2 rounded-lg text-amber-600 hover:text-amber-800 dark:text-amber-400 dark:hover:text-amber-300 bg-amber-100 dark:bg-amber-900/30 hover:bg-amber-200 dark:hover:bg-amber-900/50">
                                        <span class="tooltip-text">Edit Article</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('articles.analytics', ['id' => $article->id]) }}"
                                        class="tooltip p-2 rounded-lg text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 bg-indigo-100 dark:bg-indigo-900/30 hover:bg-indigo-200 dark:hover:bg-indigo-900/50">
                                        <span class="tooltip-text">View Analytics</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </a>
                                    <button type="button"
                                        class="tooltip p-2 rounded-lg text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 delete-article-btn"
                                        data-article-id="{{ $article->id }}" data-article-title="{{ $article->title }}">
                                        <span class="tooltip-text">Delete Article</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-1 md:col-span-2 lg:col-span-3 bg-white/70 dark:bg-slate-800/50 rounded-xl shadow-lg border border-slate-200/50 dark:border-slate-700/30 p-8 text-center glass-effect animate__animated animate__fadeIn">
                        <div class="py-8">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-20 w-20 mx-auto text-slate-300 dark:text-slate-600 mb-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <h3
                                class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600 dark:from-purple-400 dark:to-blue-400 mb-3">
                                No Articles Found</h3>
                            <p class="text-slate-600 dark:text-slate-400 mb-8 max-w-md mx-auto">You haven't created any articles
                                yet. Start creating your first article to share your knowledge with the world.</p>
                            <a href="{{ route('articles.create') }}"
                                class="px-6 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-medium shadow-lg shadow-purple-500/20 hover:shadow-purple-500/40 transition duration-300 inline-flex items-center animate-pulse-glow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Create Your First Article
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($articles->hasPages())
                <div class="mt-10 flex justify-center">
                    <nav class="relative z-0 inline-flex rounded-xl shadow-lg overflow-hidden glass-effect"
                        aria-label="Pagination">
                        <!-- Previous Page Link -->
                        @if($articles->onFirstPage())
                            <span
                                class="pagination-item pagination-disabled relative inline-flex items-center px-4 py-3 border-r border-slate-200 dark:border-slate-700 bg-white/70 dark:bg-slate-800/50 text-sm font-medium text-slate-400 dark:text-slate-500 cursor-not-allowed">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $articles->previousPageUrl() }}"
                                class="pagination-item relative inline-flex items-center px-4 py-3 border-r border-slate-200 dark:border-slate-700 bg-white/70 dark:bg-slate-800/50 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/70 transition duration-200">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif

                        <!-- Pagination Elements -->
                        @foreach ($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                            @if ($page == $articles->currentPage())
                                <span
                                    class="pagination-item pagination-active relative inline-flex items-center px-5 py-3 border-r border-slate-200 dark:border-slate-700 text-sm font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="pagination-item relative inline-flex items-center px-5 py-3 border-r border-slate-200 dark:border-slate-700 bg-white/70 dark:bg-slate-800/50 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/70 transition duration-200">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        <!-- Next Page Link -->
                        @if($articles->hasMorePages())
                            <a href="{{ $articles->nextPageUrl() }}"
                                class="pagination-item relative inline-flex items-center px-4 py-3 bg-white/70 dark:bg-slate-800/50 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/70 transition duration-200">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @else
                            <span
                                class="pagination-item pagination-disabled relative inline-flex items-center px-4 py-3 bg-white/70 dark:bg-slate-800/50 text-sm font-medium text-slate-400 dark:text-slate-500 cursor-not-allowed">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        @endif
                    </nav>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-backdrop" id="deleteModal">
        <div class="delete-modal">
            <div class="delete-modal-header">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Delete Article</h3>
                <button type="button" class="delete-modal-close" id="closeModal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500 dark:text-slate-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="delete-modal-body">
                <div class="delete-icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" class="delete-icon" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <p class="text-center text-slate-700 dark:text-slate-300 mb-2">Are you sure you want to delete this article?
                </p>
                <p class="text-center font-medium text-slate-900 dark:text-white mb-4" id="articleTitle"></p>
                <p class="text-center text-sm text-slate-500 dark:text-slate-400">This action cannot be undone. This will
                    permanently delete the article and all associated data.</p>
            </div>
            <div class="delete-modal-footer">
                <button type="button" class="delete-btn-cancel" id="cancelDelete">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn-confirm">Delete Article</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add animation classes to elements as they scroll into view
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize tooltips if needed

            // Add animation to article cards on scroll
            const cards = document.querySelectorAll('.article-card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__fadeInUp');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            cards.forEach(card => {
                observer.observe(card);
            });

            // Category pill selection
            const categoryPills = document.querySelectorAll('.category-pill');
            categoryPills.forEach(pill => {
                pill.addEventListener('click', function () {
                    const categoryId = this.getAttribute('data-category-id');

                    // Update UI
                    categoryPills.forEach(p => {
                        p.classList.remove('bg-gradient-to-r', 'from-purple-500', 'to-blue-500', 'text-white');
                        p.classList.add('bg-white/70', 'dark:bg-slate-700/70', 'text-slate-700', 'dark:text-slate-300');
                    });
                    this.classList.remove('bg-white/70', 'dark:bg-slate-700/70', 'text-slate-700', 'dark:text-slate-300');
                    this.classList.add('bg-gradient-to-r', 'from-purple-500', 'to-blue-500', 'text-white');

                    // Filter articles
                    filterArticles();
                });
            });

            // Delete confirmation modal
            const modal = document.getElementById('deleteModal');
            const deleteButtons = document.querySelectorAll('.delete-article-btn');
            const closeModal = document.getElementById('closeModal');
            const cancelDelete = document.getElementById('cancelDelete');
            const deleteForm = document.getElementById('deleteForm');
            const articleTitle = document.getElementById('articleTitle');
            const deleteModal = document.querySelector('.delete-modal');

            // Open modal when delete button is clicked
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const articleId = this.getAttribute('data-article-id');
                    const title = this.getAttribute('data-article-title');

                    deleteForm.action = `/articles/${articleId}`;
                    articleTitle.textContent = title;

                    modal.classList.add('active');
                    setTimeout(() => {
                        deleteModal.classList.add('shake');
                    }, 100);

                    setTimeout(() => {
                        deleteModal.classList.remove('shake');
                    }, 700);
                });
            });

            // Close modal
            function closeDeleteModal() {
                modal.classList.remove('active');
            }

            closeModal.addEventListener('click', closeDeleteModal);
            cancelDelete.addEventListener('click', closeDeleteModal);

            // Close modal when clicking outside
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeDeleteModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && modal.classList.contains('active')) {
                    closeDeleteModal();
                }
            });

            // Search and filter functionality
            const searchInput = document.getElementById('searchInput');
            const categoryFilter = document.getElementById('categoryFilter');
            const statusFilter = document.getElementById('statusFilter');
            const sortFilter = document.getElementById('sortFilter');

            searchInput.addEventListener('input', filterArticles);
            categoryFilter.addEventListener('change', function () {
                // Update category pills to match dropdown selection
                const selectedCategoryId = this.value;
                categoryPills.forEach(pill => {
                    const pillCategoryId = pill.getAttribute('data-category-id');

                    if ((pillCategoryId === selectedCategoryId) || (pillCategoryId === '' && selectedCategoryId === '')) {
                        pill.classList.remove('bg-white/70', 'dark:bg-slate-700/70', 'text-slate-700', 'dark:text-slate-300');
                        pill.classList.add('bg-gradient-to-r', 'from-purple-500', 'to-blue-500', 'text-white');
                    } else {
                        pill.classList.remove('bg-gradient-to-r', 'from-purple-500', 'to-blue-500', 'text-white');
                        pill.classList.add('bg-white/70', 'dark:bg-slate-700/70', 'text-slate-700', 'dark:text-slate-300');
                    }
                });

                filterArticles();
            });
            statusFilter.addEventListener('change', filterArticles);
            sortFilter.addEventListener('change', sortArticles);

            function filterArticles() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedCategory = categoryFilter.value;
                const selectedStatus = statusFilter.value;

                // Get active category pill
                const activeCategoryPill = document.querySelector('.category-pill.bg-gradient-to-r');
                const activeCategoryId = activeCategoryPill ? activeCategoryPill.getAttribute('data-category-id') : '';

                // Use either dropdown or pill selection (pill takes precedence)
                const categoryToFilter = activeCategoryId !== '' ? activeCategoryId : selectedCategory;

                cards.forEach(card => {
                    const cardCategoryId = card.getAttribute('data-category-id');
                    const cardStatus = card.getAttribute('data-status');
                    const cardTitle = card.getAttribute('data-title').toLowerCase();
                    const cardContent = card.getAttribute('data-content').toLowerCase();

                    const matchesCategory = categoryToFilter === '' || cardCategoryId === categoryToFilter;
                    const matchesStatus = selectedStatus === '' || cardStatus === selectedStatus;
                    const matchesSearch = searchTerm === '' ||
                        cardTitle.includes(searchTerm) ||
                        cardContent.includes(searchTerm);

                    if (matchesCategory && matchesStatus && matchesSearch) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            function sortArticles() {
                const sortOption = sortFilter.value;
                const cardsContainer = document.querySelector('.grid');
                const cardsArray = Array.from(cards).filter(card => card.style.display !== 'none');

                cardsArray.sort((a, b) => {
                    const titleA = a.getAttribute('data-title').toLowerCase();
                    const titleB = b.getAttribute('data-title').toLowerCase();

                    switch (sortOption) {
                        case 'a-z':
                            return titleA.localeCompare(titleB);
                        case 'z-a':
                            return titleB.localeCompare(titleA);
                        case 'popular':
                            const viewsA = parseInt(a.querySelector('.article-views-count').textContent.replace(/,/g, ''));
                            const viewsB = parseInt(b.querySelector('.article-views-count').textContent.replace(/,/g, ''));
                            return viewsB - viewsA;
                        default:
                            return 0;
                    }
                });

                // Reappend cards in the new order
                cardsArray.forEach(card => {
                    cardsContainer.appendChild(card);
                });
            }
        });
    </script>
@endsection
