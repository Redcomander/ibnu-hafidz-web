<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Scripts -->

    <style>
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

        .form-group {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s forwards;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Add a subtle pulse animation to the login button */
        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.4);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(76, 175, 80, 0);
            }
        }

        button[type="submit"]:hover {
            animation: pulse 2s infinite;
        }

        .logo-pulse {
            animation: logoPulse 3s ease-in-out infinite;
        }

        @keyframes logoPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-600 to-green-700 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute inset-0">
            <div class="absolute w-40 h-40 bg-white/5 rounded-full top-20 left-[10%]"
                style="animation: float 8s ease-in-out infinite"></div>
            <div class="absolute w-24 h-24 bg-white/5 rounded-full bottom-20 right-[15%]"
                style="animation: float 6s ease-in-out infinite 1s"></div>
            <div class="absolute w-32 h-32 bg-white/5 rounded-full top-1/2 left-[80%]"
                style="animation: float 10s ease-in-out infinite 2s"></div>

            <!-- Grid pattern overlay -->
            <div class="absolute inset-0 opacity-10">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                    <defs>
                        <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M0 20 L40 20" stroke="white" stroke-width="1" fill="none" />
                            <path d="M20 0 L20 40" stroke="white" stroke-width="1" fill="none" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid-pattern)" />
                </svg>
            </div>
        </div>

        <div class="w-full max-w-md z-10">
            <!-- Logo and Title -->
            <div class="text-center mb-10">
                <div class="flex justify-center">
                    <div
                        class="h-24 w-24 bg-white rounded-full flex items-center justify-center shadow-lg mb-4 overflow-hidden relative p-1">
                        <!-- Ibnu Hafidz Logo -->
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Lambang%20Ibnu%20Hafidz-KBZHflvZ9cBy2R3JZYZ1BgP5kIM64l.png"
                            alt="Ibnu Hafidz Logo" class="h-20 w-20 object-contain logo-pulse">
                    </div>
                </div>
                <h2 class="text-3xl font-extrabold text-white">Selamat Datang Kembali</h2>
                <p class="mt-2 text-sm text-white/80">Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 px-6 pt-6 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="px-6 py-8">
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Username -->
                        <div class="form-group">
                            <label for="username"
                                class="block text-sm font-medium text-gray-700 mb-1">{{ __('Username') }}</label>
                            <div class="relative transition-all duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input id="username" type="text" name="username" value="{{ old('username') }}" required
                                    autofocus autocomplete="username"
                                    class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 ease-in-out"
                                    placeholder="Username">
                            </div>
                            @error('username')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 mb-1">{{ __('Password') }}</label>
                            <div class="relative transition-all duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input id="password" type="password" name="password" required
                                    autocomplete="current-password"
                                    class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 ease-in-out"
                                    placeholder="••••••••">
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center form-group">
                            <input id="remember_me" name="remember" type="checkbox"
                                class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded transition-all duration-300 ease-in-out">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                                {{ __('Remember me') }}
                            </label>
                        </div>

                        <div class="form-group">
                            <button type="submit"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-lg text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 ease-in-out shadow-md hover:shadow-lg transform hover:-translate-y-1">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-green-100 group-hover:text-white transition-all duration-300 ease-in-out"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                </span>
                                {{ __('Log in') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add focus animations to input fields
            const inputs = document.querySelectorAll('input[type="username"], input[type="password"]');

            inputs.forEach(input => {
                input.addEventListener('focus', function () {
                    this.parentElement.classList.add('transform', 'scale-105');
                    this.classList.add('border-green-500');
                });

                input.addEventListener('blur', function () {
                    this.parentElement.classList.remove('transform', 'scale-105');
                    if (!this.value) {
                        this.classList.remove('border-green-500');
                    }
                });
            });
        });
    </script>
</body>

</html>
