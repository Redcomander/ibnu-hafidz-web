@extends('layouts.dashboard-layout')

@section('head')
    <style>
        /* Fade in up animation */
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animation delay utility classes */
        .animation-delay-100 {
            animation-delay: 100ms;
        }

        .animation-delay-200 {
            animation-delay: 200ms;
        }

        .animation-delay-300 {
            animation-delay: 300ms;
        }

        .animation-delay-400 {
            animation-delay: 400ms;
        }

        /* Pulse animation for online status */
        .pulse-animation {
            position: relative;
        }

        .pulse-animation::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: inherit;
            opacity: 0.7;
            z-index: -1;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.7;
            }

            70% {
                transform: scale(1.5);
                opacity: 0;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        /* Custom pagination styling */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .pagination>* {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.75rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination .page-link {
            background-color: white;
            color: #4b5563;
            border: 1px solid #e5e7eb;
        }

        .pagination .page-link:hover {
            background-color: #f3f4f6;
            border-color: #d1d5db;
            z-index: 1;
        }

        .pagination .active {
            background-color: #0ea5e9;
            color: white;
            border: 1px solid #0ea5e9;
        }

        .pagination .disabled {
            color: #9ca3af;
            pointer-events: none;
        }

        /* Dark mode pagination */
        .dark .pagination .page-link {
            background-color: #1f2937;
            color: #e5e7eb;
            border-color: #374151;
        }

        .dark .pagination .page-link:hover {
            background-color: #374151;
            border-color: #4b5563;
        }

        .dark .pagination .disabled {
            color: #6b7280;
        }

        /* Custom color classes for avatars */
        .bg-avatar-pink {
            background-color: #ec4899;
        }

        .bg-avatar-purple {
            background-color: #8b5cf6;
        }

        .bg-avatar-indigo {
            background-color: #6366f1;
        }

        .bg-avatar-blue {
            background-color: #3b82f6;
        }

        .bg-avatar-teal {
            background-color: #14b8a6;
        }

        .bg-avatar-green {
            background-color: #22c55e;
        }

        .bg-avatar-yellow {
            background-color: #eab308;
        }

        .bg-avatar-orange {
            background-color: #f97316;
        }

        .bg-avatar-red {
            background-color: #ef4444;
        }

        .bg-avatar-rose {
            background-color: #f43f5e;
        }

        /* Gradient background for current user */
        .bg-gradient-primary {
            background: linear-gradient(to right, #0ea5e9, #0369a1);
        }

        /* Avatar image styling */
        .avatar-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
@endsection

@section('content')
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md animate-fade-in-up"
                role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button"
                                class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-100"
                                onclick="this.parentElement.parentElement.parentElement.remove()">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md animate-fade-in-up"
                role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button"
                                class="inline-flex rounded-md p-1.5 text-red-500 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 focus:ring-offset-red-100"
                                onclick="this.parentElement.parentElement.parentElement.remove()">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                <span class="inline-block animate-fade-in-up">User Management</span>
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400 animate-fade-in-up animation-delay-100">
                Manage and view all users in the system
            </p>
        </div>

        <!-- Search Bar -->
        <div class="mb-8 animate-fade-in-up animation-delay-200">
            <form action="{{ route('teachers.index') }}" method="GET" class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="search" name="search" value="{{ $search ?? '' }}"
                    class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-300 shadow-sm hover:shadow-md focus:shadow-lg"
                    placeholder="Search users by name, email or username...">
                <button type="submit"
                    class="absolute right-2.5 bottom-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-all duration-300 text-white">
                    Search
                </button>
            </form>
        </div>

        <!-- Current User Card -->
        @if($currentUser)
            <div class="mb-8 animate-fade-in-up animation-delay-300">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    <span class="inline-block">Your Profile</span>
                </h2>
                <div
                    class="bg-gradient-primary rounded-xl shadow-xl overflow-hidden transform transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl">
                    <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6">
                        <div class="flex-shrink-0">
                            <div class="relative">
                                <div
                                    class="w-24 h-24 rounded-full flex items-center justify-center text-white text-2xl font-bold overflow-hidden">
                                    @if($currentUser->foto_guru)
                                        <img src="{{ asset('storage/' . $currentUser->foto_guru) }}" alt="{{ $currentUser->name }}"
                                            class="avatar-image">
                                    @else
                                                            <div class="w-full h-full flex items-center justify-center
                                                                                                                                    @php
                                                                                                                                        $colors = [
                                                                                                                                            'bg-avatar-pink',
                                                                                                                                            'bg-avatar-purple',
                                                                                                                                            'bg-avatar-indigo',
                                                                                                                                            'bg-avatar-blue',
                                                                                                                                            'bg-avatar-teal',
                                                                                                                                            'bg-avatar-green',
                                                                                                                                            'bg-avatar-yellow',
                                                                                                                                            'bg-avatar-orange',
                                                                                                                                            'bg-avatar-red',
                                                                                                                                            'bg-avatar-rose'
                                                                                                                                        ];
                                                                                                                                        echo $colors[$currentUser->id % count($colors)];
                                                                                                                                    @endphp
                                                                                                                                ">
                                                                @php
                                                                    $nameParts = explode(' ', $currentUser->name);
                                                                    $initials = '';

                                                                    if (count($nameParts) >= 2) {
                                                                        $initials = strtoupper(substr($nameParts[0], 0, 1) . substr(end($nameParts), 0, 1));
                                                                    } else {
                                                                        $initials = strtoupper(substr($currentUser->name, 0, 2));
                                                                    }

                                                                    echo $initials;
                                                                @endphp
                                                            </div>
                                    @endif
                                </div>
                                <div
                                    class="absolute bottom-0 right-0 w-6 h-6 rounded-full bg-green-500 border-4 border-white dark:border-gray-800 pulse-animation">
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 text-center sm:text-left">
                            <h3 class="text-2xl font-bold text-white">
                                {{ $currentUser->name }}
                            </h3>
                            <div class="mt-1 text-blue-100">
                                <span class="inline-flex items-center">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                        </path>
                                    </svg>
                                    {{ $currentUser->email }}
                                </span>
                            </div>
                            <div class="mt-1 text-blue-100">
                                <span class="inline-flex items-center">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $currentUser->username }}
                                </span>
                            </div>
                            <div class="mt-4">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
                                    Online
                                </span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 self-center sm:self-start mt-4 sm:mt-0">
                            <a href="{{ url('/profile') }}"
                                class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg text-white transition-all duration-300 backdrop-blur-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                    </path>
                                </svg>
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- All Users -->
        <div class="animate-fade-in-up animation-delay-400">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    <span class="inline-block">All Users</span>
                </h2>
                <div class="flex items-center gap-3">
                    <a href="{{ route('teachers.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add New Teacher
                    </a>
                    <span
                        class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                        {{ $users->total() }} Users
                    </span>
                </div>
            </div>

            @if($users->isEmpty())
                <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No users found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        @if($search)
                            No users match your search criteria.
                        @else
                            There are no other users in the system yet.
                        @endif
                    </p>
                </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="users-grid">
                @foreach($users as $index => $user)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-500 hover:shadow-xl hover:-translate-y-1 animate-fade-in-up user-card"
                            style="animation-delay: {{ 400 + ($index * 100) }}ms" data-user-id="{{ $user->id }}">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 relative">
                                        <div
                                            class="w-16 h-16 rounded-full flex items-center justify-center text-white text-xl font-bold overflow-hidden">
                                            @if($user->foto_guru)
                                                <img src="{{ asset('storage/' . $user->foto_guru) }}" alt="{{ $user->name }}"
                                                    class="avatar-image">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center {{ $colors[$user->id % count($colors)] }}">
                                                    {{ $user->getInitials() }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="user-status-indicator absolute bottom-0 right-0 w-4 h-4 rounded-full border-2 border-white dark:border-gray-800
                                            {{ $user->isOnline() ? 'bg-green-500 pulse-animation' : 'bg-gray-400' }}">
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white truncate"
                                            title="{{ $user->name }}">
                                            {{ $user->name }}
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate" title="{{ $user->username }}">
                                            {{ $user->username }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-4 text-sm text-gray-600 dark:text-gray-300 truncate" title="{{ $user->email }}">
                                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                        </path>
                                    </svg>
                                    {{ $user->email }}
                                </div>
                                <div class="mt-4 flex justify-between items-center">
                                    <span class="user-status-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $user->isOnline() ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        <span class="w-1.5 h-1.5 mr-1.5 {{ $user->isOnline() ? 'bg-green-500' : 'bg-gray-500' }} rounded-full"></span>
                                        <span class="user-status-text">{{ $user->isOnline() ? 'Online' : 'Offline' }}</span>
                                    </span>
                                    <div class="flex space-x-2">
                                        <button type="button"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button type="button"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $users->withQueryString()->links('vendor.pagination') }}
                </div>
            @endif
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update user statuses every 2 minutes (120000 ms)
            const updateInterval = 120000;

            // Function to update user statuses
            function updateUserStatuses() {
                fetch('{{ route("teachers.check-status") }}', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update each user's status
                    Object.keys(data).forEach(userId => {
                        const isOnline = data[userId];
                        const userCard = document.querySelector(`.user-card[data-user-id="${userId}"]`);

                        if (userCard) {
                            // Update status indicator
                            const statusIndicator = userCard.querySelector('.user-status-indicator');
                            if (isOnline) {
                                statusIndicator.classList.remove('bg-gray-400');
                                statusIndicator.classList.add('bg-green-500', 'pulse-animation');
                            } else {
                                statusIndicator.classList.remove('bg-green-500', 'pulse-animation');
                                statusIndicator.classList.add('bg-gray-400');
                            }

                            // Update status badge
                            const statusBadge = userCard.querySelector('.user-status-badge');
                            const statusText = userCard.querySelector('.user-status-text');
                            const statusDot = statusBadge.querySelector('span:first-child');

                            if (isOnline) {
                                statusBadge.classList.remove('bg-gray-100', 'text-gray-800', 'dark:bg-gray-700', 'dark:text-gray-300');
                                statusBadge.classList.add('bg-green-100', 'text-green-800', 'dark:bg-green-900', 'dark:text-green-300');
                                statusDot.classList.remove('bg-gray-500');
                                statusDot.classList.add('bg-green-500');
                                statusText.textContent = 'Online';
                            } else {
                                statusBadge.classList.remove('bg-green-100', 'text-green-800', 'dark:bg-green-900', 'dark:text-green-300');
                                statusBadge.classList.add('bg-gray-100', 'text-gray-800', 'dark:bg-gray-700', 'dark:text-gray-300');
                                statusDot.classList.remove('bg-green-500');
                                statusDot.classList.add('bg-gray-500');
                                statusText.textContent = 'Offline';
                            }
                        }
                    });
                })
                .catch(error => console.error('Error updating user statuses:', error));
            }

            // Update user statuses immediately and then at regular intervals
            updateUserStatuses();
            setInterval(updateUserStatuses, updateInterval);

            // Update current user's last activity timestamp periodically
            function updateCurrentUserActivity() {
                fetch('{{ route("teachers.update-activity") }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .catch(error => console.error('Error updating activity:', error));
            }

            // Update current user's activity every minute
            setInterval(updateCurrentUserActivity, 60000);

            // Also update when user interacts with the page
            ['click', 'keypress', 'scroll', 'mousemove'].forEach(event => {
                document.addEventListener(event, debounce(updateCurrentUserActivity, 5000));
            });

            // Debounce function to limit API calls
            function debounce(func, wait) {
                let timeout;
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }
        });
    </script>
@endsection
