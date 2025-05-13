@extends('layouts.dashboard-layout')

@section('head')
    <style>
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.3);
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

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
    </style>
@endsection

@section('content')
    <div
        class="py-8 min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-blue-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 transition-colors duration-300">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Decorative elements -->
            <div
                class="absolute top-10 right-10 w-64 h-64 bg-purple-500/10 dark:bg-purple-500/20 rounded-full blur-3xl -z-10 animate-float">
            </div>
            <div class="absolute bottom-10 left-10 w-72 h-72 bg-blue-500/10 dark:bg-blue-500/20 rounded-full blur-3xl -z-10 animate-float"
                style="animation-delay: 2s;"></div>

            <!-- Breadcrumb -->
            <nav class="flex mb-6 text-sm text-slate-600 dark:text-slate-400">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="hover:text-purple-600 dark:hover:text-purple-400 transition duration-200">Dashboard</a>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="{{ route('categories.index') }}"
                            class="hover:text-purple-600 dark:hover:text-purple-400 transition duration-200">Categories</a>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-slate-800 dark:text-slate-200">Create New Category</span>
                    </li>
                </ol>
            </nav>

            <!-- Page header -->
            <div class="mb-8">
                <h1
                    class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 via-violet-600 to-blue-600 dark:from-purple-400 dark:via-violet-400 dark:to-blue-400 inline-block">
                    Create New Category
                </h1>
                <p class="mt-2 text-slate-600 dark:text-slate-400">
                    Create a new category to organize your articles and improve content discovery.
                </p>
            </div>

            <!-- Form Card -->
            <div
                class="bg-white/70 dark:bg-slate-800/50 rounded-xl shadow-lg border border-slate-200/50 dark:border-slate-700/30 overflow-hidden glass-effect">
                <div class="p-6">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="form-input w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white/70 dark:bg-slate-700/70 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-purple-500 dark:focus:border-purple-500 transition duration-200"
                                placeholder="Enter category name">

                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror

                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                                The slug will be automatically generated from the name.
                            </p>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('categories.index') }}"
                                class="px-5 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition duration-200">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-medium shadow-lg shadow-purple-500/20 hover:shadow-purple-500/40 transition duration-300">
                                Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
