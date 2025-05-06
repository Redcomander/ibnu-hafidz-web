@extends('layouts.dashboard-layout')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Profile Information -->
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl transition-all duration-300 hover:shadow-md">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col md:flex-row md:items-start gap-8">
                        <!-- Profile Avatar Section -->
                        <div class="flex flex-col items-center space-y-4 md:w-1/3">
                            <div class="relative group">
                                <div
                                    class="w-32 h-32 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white text-3xl font-bold overflow-hidden border-4 border-white dark:border-gray-700 shadow-lg">
                                    @if(isset($user->foto_guru))
                                        <img src="{{ asset('storage/' . $user->foto_guru) }}" alt="{{ $user->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    @endif
                                </div>
                                <label for="avatar-upload"
                                    class="absolute inset-0 rounded-full bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all duration-300 cursor-pointer">
                                    <span class="text-white text-sm">Change Photo</span>
                                </label>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                            <div class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Member since {{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>

                        <!-- Profile Form Section -->
                        <div class="md:w-2/3">
                            <section>
                                <header class="mb-6">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-6 w-6 text-purple-500 dark:text-purple-400 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                            {{ __('Profile Information') }}
                                        </h2>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ __("Update your account's profile information and email address.") }}
                                    </p>
                                    <div class="h-1 w-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mt-2">
                                    </div>
                                </header>

                                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                    @csrf
                                </form>

                                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')

                                    <!-- Hidden file input for avatar upload -->
                                    <div class="mt-2 w-full">
                                        <label for="avatar-upload"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-center">
                                            {{ __('Upload Profile Photo') }}
                                        </label>
                                        <div class="flex items-center justify-center">
                                            <label for="avatar-upload"
                                                class="cursor-pointer bg-white dark:bg-gray-700 py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ __('Choose File') }}
                                            </label>
                                            <input id="avatar-upload" name="foto_guru" type="file" accept="image/*"
                                                class="hidden" onchange="updateFileName(this)" />
                                        </div>
                                        <p id="selected-file"
                                            class="mt-2 text-xs text-gray-500 dark:text-gray-400 text-center">
                                            {{ __('No file selected') }}</p>
                                        @error('foto_guru')
                                            <div
                                                class="flex items-center mt-2 text-sm text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-md border-l-4 border-red-500 dark:border-red-500/70 animate-fadeIn">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 flex-shrink-0"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <span>{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <label for="name"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                <span class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 mr-1 text-purple-500 dark:text-purple-400"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    {{ __('Name') }}
                                                </span>
                                            </label>
                                        </div>
                                        <div class="relative group input-wrapper">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 text-gray-400 group-focus-within:text-purple-500 transition-colors duration-200"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                                                required autofocus autocomplete="name" class="custom-input pl-10 mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/60 text-gray-900 dark:text-gray-100
                                                    focus:border-purple-500 focus:ring focus:ring-purple-500/30 focus:ring-opacity-50
                                                    hover:border-gray-400 dark:hover:border-gray-500
                                                    transition-all duration-200 shadow-sm backdrop-blur-sm
                                                    py-3 text-base" />
                                            <div
                                                class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-blue-500 to-purple-600 group-focus-within:w-full transition-all duration-300">
                                            </div>
                                        </div>
                                        @error('name')
                                            <div
                                                class="flex items-center mt-2 text-sm text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-md border-l-4 border-red-500 dark:border-red-500/70 animate-fadeIn">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 flex-shrink-0"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <span>{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <label for="username"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                <span class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 mr-1 text-purple-500 dark:text-purple-400"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ __('Username') }}
                                                </span>
                                            </label>
                                        </div>
                                        <div class="relative group input-wrapper">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 text-gray-400 group-focus-within:text-purple-500 transition-colors duration-200"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <input id="username" name="username" type="text"
                                                value="{{ old('username', $user->username) }}" autocomplete="username"
                                                class="custom-input pl-10 mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/60 text-gray-900 dark:text-gray-100
                                                    focus:border-purple-500 focus:ring focus:ring-purple-500/30 focus:ring-opacity-50
                                                    hover:border-gray-400 dark:hover:border-gray-500
                                                    transition-all duration-200 shadow-sm backdrop-blur-sm
                                                    py-3 text-base" />
                                            <div
                                                class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-blue-500 to-purple-600 group-focus-within:w-full transition-all duration-300">
                                            </div>
                                        </div>
                                        @error('username')
                                            <div
                                                class="flex items-center mt-2 text-sm text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-md border-l-4 border-red-500 dark:border-red-500/70 animate-fadeIn">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 flex-shrink-0"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <span>{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <label for="email"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                <span class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 mr-1 text-purple-500 dark:text-purple-400"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ __('Email') }}
                                                </span>
                                            </label>
                                        </div>
                                        <div class="relative group input-wrapper">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 text-gray-400 group-focus-within:text-purple-500 transition-colors duration-200"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <input id="email" name="email" type="email"
                                                value="{{ old('email', $user->email) }}" required autocomplete="username"
                                                class="custom-input pl-10 mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/60 text-gray-900 dark:text-gray-100
                                                    focus:border-purple-500 focus:ring focus:ring-purple-500/30 focus:ring-opacity-50
                                                    hover:border-gray-400 dark:hover:border-gray-500
                                                    transition-all duration-200 shadow-sm backdrop-blur-sm
                                                    py-3 text-base" />
                                            <div
                                                class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-blue-500 to-purple-600 group-focus-within:w-full transition-all duration-300">
                                            </div>
                                        </div>
                                        @error('email')
                                            <div
                                                class="flex items-center mt-2 text-sm text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-md border-l-4 border-red-500 dark:border-red-500/70 animate-fadeIn">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 flex-shrink-0"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <span>{{ $message }}</span>
                                            </div>
                                        @enderror

                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                            <div
                                                class="mt-2 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                    <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                                        {{ __('Your email address is unverified.') }}
                                                    </p>
                                                </div>

                                                <div class="mt-2 ml-7">
                                                    <button form="send-verification"
                                                        class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline transition-colors">
                                                        {{ __('Click here to re-send the verification email.') }}
                                                    </button>
                                                </div>

                                                @if (session('status') === 'verification-link-sent')
                                                    <div class="mt-2 ml-7 flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500 mr-1"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        <p class="text-sm text-green-600 dark:text-green-400">
                                                            {{ __('A new verification link has been sent to your email address.') }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-4 pt-2">
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-blue-600 hover:to-purple-700 focus:outline-none focus:border-purple-700 focus:ring focus:ring-purple-200 active:from-blue-700 active:to-purple-800 disabled:opacity-25 transition-all duration-300 ease-in-out">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            {{ __('Save Changes') }}
                                        </button>

                                        @if (session('status') === 'profile-updated')
                                            <div x-data="{ show: true }" x-show="show"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0 transform scale-95"
                                                x-transition:enter-end="opacity-100 transform scale-100"
                                                x-transition:leave="transition ease-in duration-200"
                                                x-transition:leave-start="opacity-100 transform scale-100"
                                                x-transition:leave-end="opacity-0 transform scale-95"
                                                x-init="setTimeout(() => show = false, 2000)"
                                                class="flex items-center text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-3 py-1 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                {{ __('Saved successfully!') }}
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Password -->
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl transition-all duration-300 hover:shadow-md">
                <div class="p-6 sm:p-8">
                    <section>
                        <header class="mb-6">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 text-purple-500 dark:text-purple-400 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ __('Update Password') }}
                                </h2>
                            </div>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Ensure your account is using a long, random password to stay secure.') }}
                            </p>
                            <div class="h-1 w-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mt-2"></div>
                        </header>

                        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('put')

                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="update_password_current_password"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 mr-1 text-purple-500 dark:text-purple-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            {{ __('Current Password') }}
                                        </span>
                                    </label>
                                </div>
                                <div class="relative group input-wrapper">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-400 group-focus-within:text-purple-500 transition-colors duration-200"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input id="update_password_current_password" name="current_password" type="password"
                                        autocomplete="current-password" class="custom-input pl-10 mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/60 text-gray-900 dark:text-gray-100
                                            focus:border-purple-500 focus:ring focus:ring-purple-500/30 focus:ring-opacity-50
                                            hover:border-gray-400 dark:hover:border-gray-500
                                            transition-all duration-200 shadow-sm backdrop-blur-sm
                                            py-3 text-base" />
                                    <div
                                        class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-blue-500 to-purple-600 group-focus-within:w-full transition-all duration-300">
                                    </div>
                                </div>
                                @error('current_password', 'updatePassword')
                                    <div
                                        class="flex items-center mt-2 text-sm text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-md border-l-4 border-red-500 dark:border-red-500/70 animate-fadeIn">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="update_password_password"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 mr-1 text-purple-500 dark:text-purple-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                            </svg>
                                            {{ __('New Password') }}
                                        </span>
                                    </label>
                                </div>
                                <div class="relative group input-wrapper">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-400 group-focus-within:text-purple-500 transition-colors duration-200"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                    </div>
                                    <input id="update_password_password" name="password" type="password"
                                        autocomplete="new-password" class="custom-input pl-10 mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/60 text-gray-900 dark:text-gray-100
                                            focus:border-purple-500 focus:ring focus:ring-purple-500/30 focus:ring-opacity-50
                                            hover:border-gray-400 dark:hover:border-gray-500
                                            transition-all duration-200 shadow-sm backdrop-blur-sm
                                            py-3 text-base" />
                                    <div
                                        class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-blue-500 to-purple-600 group-focus-within:w-full transition-all duration-300">
                                    </div>
                                </div>
                                @error('password', 'updatePassword')
                                    <div
                                        class="flex items-center mt-2 text-sm text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-md border-l-4 border-red-500 dark:border-red-500/70 animate-fadeIn">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="update_password_password_confirmation"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 mr-1 text-purple-500 dark:text-purple-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            {{ __('Confirm Password') }}
                                        </span>
                                    </label>
                                </div>
                                <div class="relative group input-wrapper">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-400 group-focus-within:text-purple-500 transition-colors duration-200"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <input id="update_password_password_confirmation" name="password_confirmation"
                                        type="password" autocomplete="new-password" class="custom-input pl-10 mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/60 text-gray-900 dark:text-gray-100
                                            focus:border-purple-500 focus:ring focus:ring-purple-500/30 focus:ring-opacity-50
                                            hover:border-gray-400 dark:hover:border-gray-500
                                            transition-all duration-200 shadow-sm backdrop-blur-sm
                                            py-3 text-base" />
                                    <div
                                        class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-blue-500 to-purple-600 group-focus-within:w-full transition-all duration-300">
                                    </div>
                                </div>
                                @error('password_confirmation', 'updatePassword')
                                    <div
                                        class="flex items-center mt-2 text-sm text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-md border-l-4 border-red-500 dark:border-red-500/70 animate-fadeIn">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="flex items-center gap-4 pt-2">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-blue-600 hover:to-purple-700 focus:outline-none focus:border-purple-700 focus:ring focus:ring-purple-200 active:from-blue-700 active:to-purple-800 disabled:opacity-25 transition-all duration-300 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('Update Password') }}
                                </button>

                                @if (session('status') === 'password-updated')
                                    <div x-data="{ show: true }" x-show="show"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 transform scale-95"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100 transform scale-100"
                                        x-transition:leave-end="opacity-0 transform scale-95"
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="flex items-center text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-3 py-1 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ __('Password updated!') }}
                                    </div>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <!-- Delete Account -->
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl transition-all duration-300 hover:shadow-md">
                <div class="p-6 sm:p-8">
                    <section class="space-y-6">
                        <header class="mb-6">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 dark:text-red-400 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ __('Delete Account') }}
                                </h2>
                            </div>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                            </p>
                            <div class="h-1 w-16 bg-gradient-to-r from-red-500 to-pink-600 rounded-full mt-2"></div>
                        </header>

                        <div
                            class="p-4 sm:p-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-300">
                                        {{ __('Warning: This action cannot be undone') }}
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700 dark:text-red-400">
                                        <p>
                                            {{ __('When you delete your account:') }}
                                        </p>
                                        <ul class="list-disc pl-5 mt-1 space-y-1">
                                            <li>{{ __('All your personal information will be erased') }}</li>
                                            <li>{{ __('You will lose access to all your data and content') }}</li>
                                            <li>{{ __('Your account cannot be recovered') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-start">
                            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-pink-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-red-600 hover:to-pink-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:from-red-700 active:to-pink-800 disabled:opacity-25 transition-all duration-300 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                {{ __('Delete Account') }}
                            </button>
                        </div>

                        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                            <div class="p-6">
                                <div class="flex items-center justify-center mb-6">
                                    <div
                                        class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-8 w-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                </div>

                                <h2 class="text-lg font-medium text-center text-gray-900 dark:text-gray-100 mb-4">
                                    {{ __('Are you absolutely sure?') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 text-center mb-6">
                                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                </p>

                                <form method="post" action="{{ route('profile.destroy') }}">
                                    @csrf
                                    @method('delete')

                                    <div class="mt-6">
                                        <label for="password" class="sr-only">{{ __('Password') }}</label>

                                        <div class="relative group input-wrapper">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors duration-200"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </div>
                                            <input id="password" name="password" type="password"
                                                placeholder="{{ __('Password') }}" class="custom-input pl-10 mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/60 text-gray-900 dark:text-gray-100
                                                    focus:border-red-500 focus:ring focus:ring-red-500/30 focus:ring-opacity-50
                                                    hover:border-gray-400 dark:hover:border-gray-500
                                                    transition-all duration-200 shadow-sm backdrop-blur-sm
                                                    py-3 text-base" />
                                            <div
                                                class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-red-500 to-pink-600 group-focus-within:w-full transition-all duration-300">
                                            </div>
                                        </div>

                                        @error('password', 'userDeletion')
                                            <div
                                                class="flex items-center mt-2 text-sm text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-md border-l-4 border-red-500 dark:border-red-500/70 animate-fadeIn">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 flex-shrink-0"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <span>{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mt-6 flex justify-end space-x-3">
                                        <button type="button" x-on:click="$dispatch('close')"
                                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                            {{ __('Cancel') }}
                                        </button>

                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-pink-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-red-600 hover:to-pink-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:from-red-700 active:to-pink-800 disabled:opacity-25 transition-all duration-300 ease-in-out">
                                            {{ __('Delete Account') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </x-modal>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Enhanced input styling with vanilla CSS */
        .custom-input {
            min-height: 48px;
            font-size: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-width: 2px;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 0.5rem;
        }

        .input-wrapper:hover .custom-input {
            border-color: rgba(139, 92, 246, 0.3);
        }

        .custom-input:focus {
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
            border-color: rgba(139, 92, 246, 0.8);
        }

        /* Dark mode adjustments */
        .dark .custom-input {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Adjust the icon positioning for the taller inputs */
        .relative.group .absolute.inset-y-0.left-0.pl-3 {
            height: 100%;
            display: flex;
            align-items: center;
        }

        /* Add a subtle transition effect when focusing on inputs */
        .custom-input {
            transition: all 0.2s ease-in-out;
        }
    </style>

    <script>
        function updateFileName(input) {
            const fileName = input.files[0]?.name || "{{ __('No file selected') }}";
            document.getElementById('selected-file').textContent = fileName;
        }
    </script>
@endsection
