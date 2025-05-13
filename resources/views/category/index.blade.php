@extends('layouts.dashboard-layout')

@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<style>
    /* Advanced animations */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }

    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(124, 58, 237, 0.2); }
        50% { box-shadow: 0 0 20px 5px rgba(124, 58, 237, 0.4); }
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

    .category-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .category-card:hover {
        transform: translateY(-8px) scale(1.01);
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.15), 0 18px 36px -18px rgba(0, 0, 0, 0.1);
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
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }

    .shake {
        animation: shake 0.6s cubic-bezier(.36,.07,.19,.97) both;
    }

    /* Action buttons */
    .action-btn {
        transition: all 0.2s ease;
        opacity: 0.9;
    }

    .action-btn:hover {
        opacity: 1;
        transform: scale(1.1);
    }

    /* Stats badge */
    .stats-badge {
        transition: all 0.3s ease;
    }

    .stats-badge:hover {
        transform: scale(1.05);
    }

    /* Search input */
    .search-input:focus {
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.3);
    }
</style>
@endsection

@section('content')
<div class="py-8 min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-blue-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <!-- Decorative elements -->
        <div class="absolute top-10 right-10 w-64 h-64 bg-purple-500/10 dark:bg-purple-500/20 rounded-full blur-3xl -z-10 animate-float"></div>
        <div class="absolute bottom-10 left-10 w-72 h-72 bg-blue-500/10 dark:bg-blue-500/20 rounded-full blur-3xl -z-10 animate-float-slow"></div>
        <div class="absolute top-1/2 left-1/4 w-48 h-48 bg-pink-500/10 dark:bg-pink-500/20 rounded-full blur-3xl -z-10 animate-float-slow"></div>

        <!-- Page header with animated gradient -->
        <div class="mb-8 animate__animated animate__fadeIn">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 via-violet-600 to-blue-600 dark:from-purple-400 dark:via-violet-400 dark:to-blue-400 inline-block animate__animated animate__fadeInUp">
                        Categories
                    </h1>
                    <p class="mt-2 text-slate-600 dark:text-slate-400 max-w-2xl animate__animated animate__fadeInUp animate__delay-1s">
                        Manage your content categories. Create, edit, and organize your categories to better structure your articles.
                    </p>
                </div>
                <div class="flex items-center space-x-3 animate__animated animate__fadeInRight">
                    <a href="{{ route('articles.index') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition duration-300 flex items-center whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        Manage Articles
                    </a>
                    <a href="{{ route('categories.create') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-medium shadow-lg shadow-purple-500/20 hover:shadow-purple-500/40 transition duration-300 flex items-center whitespace-nowrap animate-pulse-glow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        New Category
                    </a>
                </div>
            </div>
        </div>

        <!-- Search and stats -->
        <div class="mb-8 glass-effect bg-white/40 dark:bg-slate-800/40 rounded-xl p-4 shadow-lg border border-slate-200/50 dark:border-slate-700/30 animate__animated animate__fadeInUp animate__delay-1s">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="relative w-full md:w-auto md:flex-grow">
                    <input type="text" placeholder="Search categories..." class="search-input w-full px-4 py-3 pl-12 rounded-xl border border-slate-300 dark:border-slate-600 bg-white/70 dark:bg-slate-700/70 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-purple-500 dark:focus:border-blue-500 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center px-4 py-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600 dark:text-purple-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span class="text-sm font-medium text-purple-700 dark:text-purple-300">Total Categories: {{ $categories->count() }}</span>
                    </div>
                    <div class="flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Total Articles: {{ $categories->sum(function($category) { return $category->articles->count(); }) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash messages -->
        @if(session('success'))
        <div class="mb-6 bg-green-100 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 rounded-lg shadow-sm animate__animated animate__fadeIn" role="alert">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Categories grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($categories as $category)
            <div class="category-card bg-white/70 dark:bg-slate-800/50 rounded-xl shadow-lg border border-slate-200/50 dark:border-slate-700/30 overflow-hidden glass-effect animate__animated animate__fadeInUp">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold text-slate-900 dark:text-white">
                            {{ $category->name }}
                        </h3>
                        <span class="stats-badge px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-sm font-medium">
                            {{ $category->articles->count() }} {{ Str::plural('Article', $category->articles->count()) }}
                        </span>
                    </div>

                    <div class="text-sm text-slate-600 dark:text-slate-300 mb-6">
                        <p class="mb-2">
                            <span class="font-medium">Slug:</span> {{ $category->slug }}
                        </p>
                        <p>
                            <span class="font-medium">Created:</span> {{ $category->created_at->format('M d, Y') }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('categories.show', $category->slug) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium flex items-center action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View Articles
                        </a>

                        <div class="flex space-x-2">
                            <a href="{{ route('categories.edit', $category->id) }}" class="tooltip p-2 rounded-lg text-amber-600 hover:text-amber-800 dark:text-amber-400 dark:hover:text-amber-300 bg-amber-100 dark:bg-amber-900/30 hover:bg-amber-200 dark:hover:bg-amber-900/50 transition duration-200 action-btn">
                                <span class="tooltip-text">Edit Category</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>

                            <button type="button" class="tooltip p-2 rounded-lg text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 transition duration-200 action-btn delete-category-btn"
                                data-category-id="{{ $category->id }}"
                                data-category-name="{{ $category->name }}"
                                data-article-count="{{ $category->articles->count() }}">
                                <span class="tooltip-text">Delete Category</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white/70 dark:bg-slate-800/50 rounded-xl shadow-lg border border-slate-200/50 dark:border-slate-700/30 p-8 text-center glass-effect animate__animated animate__fadeIn">
                <div class="py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-slate-300 dark:text-slate-600 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <h3 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600 dark:from-purple-400 dark:to-blue-400 mb-3">
                        No Categories Found</h3>
                    <p class="text-slate-600 dark:text-slate-400 mb-8 max-w-md mx-auto">You haven't created any categories yet. Start creating your first category to better organize your articles.</p>
                    <a href="{{ route('categories.create') }}" class="px-6 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-medium shadow-lg shadow-purple-500/20 hover:shadow-purple-500/40 transition duration-300 inline-flex items-center animate-pulse-glow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Create Your First Category
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal-backdrop" id="deleteModal">
    <div class="delete-modal">
        <div class="delete-modal-header">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Delete Category</h3>
            <button type="button" class="delete-modal-close" id="closeModal">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="delete-modal-body">
            <div class="delete-icon-container">
                <svg xmlns="http://www.w3.org/2000/svg" class="delete-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <p class="text-center text-slate-700 dark:text-slate-300 mb-2">Are you sure you want to delete this category?</p>
            <p class="text-center font-medium text-slate-900 dark:text-white mb-4" id="categoryName"></p>
            <div class="bg-amber-100 dark:bg-amber-900/30 border-l-4 border-amber-500 text-amber-700 dark:text-amber-300 p-4 rounded-lg mb-4">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <p class="text-sm" id="articleWarning">This category has <span id="articleCount">0</span> articles. Deleting it will NOT delete these articles, but they will no longer be categorized.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="delete-modal-footer">
            <button type="button" class="delete-btn-cancel" id="cancelDelete">Cancel</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn-confirm">Delete Category</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add animation to category cards on scroll
        const cards = document.querySelectorAll('.category-card');
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

        // Delete confirmation modal
        const modal = document.getElementById('deleteModal');
        const deleteButtons = document.querySelectorAll('.delete-category-btn');
        const closeModal = document.getElementById('closeModal');
        const cancelDelete = document.getElementById('cancelDelete');
        const deleteForm = document.getElementById('deleteForm');
        const categoryName = document.getElementById('categoryName');
        const articleCount = document.getElementById('articleCount');
        const articleWarning = document.getElementById('articleWarning');
        const deleteModal = document.querySelector('.delete-modal');

        // Open modal when delete button is clicked
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-category-id');
                const name = this.getAttribute('data-category-name');
                const count = this.getAttribute('data-article-count');

                deleteForm.action = `/admin/categories/${categoryId}`;
                categoryName.textContent = name;
                articleCount.textContent = count;

                // Update warning message based on article count
                if (count == 0) {
                    articleWarning.textContent = "This category has no articles.";
                } else if (count == 1) {
                    articleWarning.textContent = "This category has 1 article. Deleting it will NOT delete this article, but it will no longer be categorized.";
                } else {
                    articleWarning.textContent = `This category has ${count} articles. Deleting it will NOT delete these articles, but they will no longer be categorized.`;
                }

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
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeDeleteModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeDeleteModal();
            }
        });

        // Search functionality
        const searchInput = document.querySelector('.search-input');
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();

            cards.forEach(card => {
                const categoryName = card.querySelector('h3').textContent.toLowerCase();
                const categorySlug = card.querySelector('.text-sm p:first-child').textContent.toLowerCase();

                if (categoryName.includes(searchTerm) || categorySlug.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
