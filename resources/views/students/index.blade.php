@extends('layouts.dashboard-layout')

@section('head')
    @include('students.style')
@endsection

@section('content')
    <div
        class="py-6 min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Enhanced decorative elements -->
            <div
                class="absolute top-10 right-10 w-64 h-64 bg-indigo-500/10 dark:bg-indigo-500/20 rounded-full blur-3xl -z-10 animate-float">
            </div>
            <div class="absolute bottom-10 left-10 w-72 h-72 bg-purple-500/10 dark:bg-purple-500/20 rounded-full blur-3xl -z-10 animate-float"
                style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-1/3 w-48 h-48 bg-cyan-500/10 dark:bg-cyan-500/20 rounded-full blur-3xl -z-10 animate-float"
                style="animation-delay: 4s;"></div>

            <!-- Page header with breadcrumbs -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <nav class="flex mb-2" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a href="{{ route('dashboard') }}"
                                        class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                            </path>
                                        </svg>
                                        Dashboard
                                    </a>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="ml-1 text-sm font-medium text-slate-700 dark:text-slate-300">Student
                                            Management</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                        <h1
                            class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500 dark:from-indigo-400 dark:to-purple-400 inline-block">
                            Student Management
                        </h1>
                        <p class="mt-1 text-slate-600 dark:text-slate-400">
                            Manage all student records and information
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0 flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('student.create') }}"
                            class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add New Student
                        </a>
                        <div class="relative group">
                            <button type="button"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                                More Actions
                            </button>
                            <div
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
                                <a href="{{ route('student.export') }}"
                                    class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        Export Data
                                    </div>
                                </a>
                                <a href="{{ route('student.import.form') }}"
                                    class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                        </svg>
                                        Import Data
                                    </div>
                                </a>
                                <a href="{{ route('student.template') }}"
                                    class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Download Template
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="student-card glass-card p-6 group">
                    <div class="flex items-center">
                        <div
                            class="flex-shrink-0 p-3 rounded-lg bg-indigo-500/10 text-indigo-500 dark:bg-indigo-500/20 group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Students</p>
                            <div class="flex items-end">
                                <p class="mt-1 text-3xl font-semibold text-slate-900 dark:text-white">{{ $totalStudents }}
                                </p>
                                <span class="ml-2 text-xs font-medium text-emerald-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    {{ number_format(($totalStudents - $lastMonthTotal) / max(1, $lastMonthTotal) * 100, 1) }}%
                                </span>
                            </div>
                            <div class="mt-3 progress-bar">
                                <div class="progress-value"
                                    style="width: {{ min(100, ($totalStudents / $targetStudents) * 100) }}%"></div>
                            </div>
                            <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                {{ $totalStudents }} of {{ $targetStudents }} target students
                            </div>
                        </div>
                    </div>
                </div>

                <div class="student-card glass-card p-6 group">
                    <div class="flex items-center">
                        <div
                            class="flex-shrink-0 p-3 rounded-lg bg-purple-500/10 text-purple-500 dark:bg-purple-500/20 group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">New Students</p>
                            <div class="flex items-end">
                                <p class="mt-1 text-3xl font-semibold text-slate-900 dark:text-white">{{ $newStudents }}</p>
                                <span class="ml-2 text-xs font-medium text-emerald-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    {{ number_format(($newStudents - $lastMonthNew) / max(1, $lastMonthNew) * 100, 1) }}%
                                </span>
                            </div>
                            <div class="mt-3 progress-container">
                                <div class="progress-title">
                                    <span>Onboarding Progress</span>
                                    <span class="progress-percentage">{{ $newStudentProgress }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-value" style="width: {{ $newStudentProgress }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="student-card glass-card p-6 group">
                    <div class="flex items-center">
                        <div
                            class="flex-shrink-0 p-3 rounded-lg bg-emerald-500/10 text-emerald-500 dark:bg-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Gender Distribution</p>
                            <div class="mt-1 flex items-center">
                                <div class="flex-1">
                                    <div class="flex justify-between mb-1 text-xs">
                                        <span class="text-blue-500 font-medium">Male</span>
                                        <span class="text-blue-500 font-medium">{{ $maleStudents }}</span>
                                    </div>
                                    <div class="h-2 bg-blue-100 dark:bg-blue-900/30 rounded-full overflow-hidden">
                                        <div class="h-full bg-blue-500 rounded-full"
                                            style="width: {{ $totalStudents > 0 ? ($maleStudents / $totalStudents) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                                <div class="mx-2 text-slate-300 dark:text-slate-600">|</div>
                                <div class="flex-1">
                                    <div class="flex justify-between mb-1 text-xs">
                                        <span class="text-pink-500 font-medium">Female</span>
                                        <span class="text-pink-500 font-medium">{{ $femaleStudents }}</span>
                                    </div>
                                    <div class="h-2 bg-pink-100 dark:bg-pink-900/30 rounded-full overflow-hidden">
                                        <div class="h-full bg-pink-500 rounded-full"
                                            style="width: {{ $totalStudents > 0 ? ($femaleStudents / $totalStudents) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="student-card glass-card p-6 group">
                    <div class="flex items-center">
                        <div
                            class="flex-shrink-0 p-3 rounded-lg bg-amber-500/10 text-amber-500 dark:bg-amber-500/20 group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Status Distribution</p>
                            <div class="mt-1 grid grid-cols-2 gap-2">
                                <div>
                                    <div class="flex justify-between mb-1 text-xs">
                                        <span class="text-emerald-500 font-medium">Baru</span>
                                        <span class="text-emerald-500 font-medium">{{ $activeStudents }}</span>
                                    </div>
                                    <div class="h-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500 rounded-full"
                                            style="width: {{ $totalStudents > 0 ? ($activeStudents / $totalStudents) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1 text-xs">
                                        <span class="text-amber-500 font-medium">Pindahan</span>
                                        <span class="text-amber-500 font-medium">{{ $pendingStudents }}</span>
                                    </div>
                                    <div class="h-2 bg-amber-100 dark:bg-amber-900/30 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-500 rounded-full"
                                            style="width: {{ $totalStudents > 0 ? ($pendingStudents / $totalStudents) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1 text-xs">
                                        <span class="text-red-500 font-medium">Lain-lain</span>
                                        <span class="text-red-500 font-medium">{{ $inactiveStudents }}</span>
                                    </div>
                                    <div class="h-2 bg-red-100 dark:bg-red-900/30 rounded-full overflow-hidden">
                                        <div class="h-full bg-red-500 rounded-full"
                                            style="width: {{ $totalStudents > 0 ? ($inactiveStudents / $totalStudents) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button id="refreshStats" type="button"
                                        class="mt-1 text-xs font-medium text-amber-500 flex items-center hover:text-amber-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Refresh Stats
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mass Action Bar (Hidden by default) -->
            <div id="mass-action-bar" class="mb-4 hidden">
                <div class="glass-card p-4 bg-indigo-50 dark:bg-indigo-900/30 border-l-4 border-indigo-500">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="text-sm font-medium text-indigo-700 dark:text-indigo-300">
                                <span id="selected-count">0</span> students selected
                            </span>
                        </div>
                        <div class="flex space-x-2">
                            <button type="button" onclick="confirmMassDelete()"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Selected
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="mb-8">
                <div class="glass-card p-6">
                    <form action="{{ route('student.index') }}" method="GET">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <label for="search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" id="search"
                                        class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm bg-white dark:bg-slate-800 dark:border-slate-700 dark:text-white"
                                        placeholder="Search by name, NIS, NISN, or other details..."
                                        value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="flex-shrink-0 flex flex-col sm:flex-row gap-2">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Search
                                </button>
                                <button type="button" id="toggleFilters"
                                    class="inline-flex items-center px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Filters
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 transition-transform"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <button type="button" id="clearFilters"
                                    class="inline-flex items-center px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Clear
                                </button>
                            </div>
                        </div>

                        <div id="additionalFilters"
                            class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 {{ request()->anyFilled(['jurusan', 'status', 'jenis_kelamin', 'agama', 'tahun_masuk', 'kelas']) ? '' : 'hidden' }}">
                            <div>
                                <label for="jurusan"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-300">Major</label>
                                <select id="jurusan" name="jurusan"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-slate-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg bg-white dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                                    <option value="">All Majors</option>
                                    @foreach ($jurusanOptions as $jurusan)
                                        <option value="{{ $jurusan }}" {{ request('jurusan') == $jurusan ? 'selected' : '' }}>
                                            {{ $jurusan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="status_santri"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                                <select id="status_santri" name="status_santri"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-slate-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg bg-white dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                                    <option value="">All Statuses</option>
                                    @foreach ($statusSantriOptions as $status)
                                        <option value="{{ $status }}" {{ request('status_santri') == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="jenis_kelamin"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-300">Gender</label>
                                <select id="jenis_kelamin" name="jenis_kelamin"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-slate-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg bg-white dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                                    <option value="">All Genders</option>
                                    <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                        Male</option>
                                    <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                        Female</option>
                                </select>
                            </div>
                            <div>
                                <label for="agama"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-300">Religion</label>
                                <select id="agama" name="agama"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-slate-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg bg-white dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                                    <option value="">All Religions</option>
                                    @foreach ($agamaOptions as $agama)
                                        <option value="{{ $agama }}" {{ request('agama') == $agama ? 'selected' : '' }}>
                                            {{ $agama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="tahun_masuk"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-300">Entry Year</label>
                                <select id="tahun_masuk" name="tahun_masuk"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-slate-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg bg-white dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                                    <option value="">All Years</option>
                                    @foreach ($tahunMasukOptions as $tahun)
                                        <option value="{{ $tahun }}" {{ request('tahun_masuk') == $tahun ? 'selected' : '' }}>
                                            {{ $tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div>
                                <label for="kelas"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-300">Class</label>
                                <select id="kelas" name="kelas"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-slate-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg bg-white dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                                    <option value="">All Classes</option>
                                    @foreach ($kelasOptions as $kelas)
                                        <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>
                                            {{ $kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                        </div>

                        <!-- Active filters -->
                        @if (request()->anyFilled(['search', 'jurusan', 'status', 'jenis_kelamin', 'agama', 'tahun_masuk', 'kelas']))
                            <div class="mt-4">
                                <h3 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Active filters:</h3>
                                <div id="activeFilters" class="flex flex-wrap gap-2">
                                    @if (request('search'))
                                        <div
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                                            Search: {{ request('search') }}
                                            <button type="button" onclick="removeFilter('search')"
                                                class="ml-1 inline-flex text-indigo-500 focus:outline-none">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                    @if (request('jurusan'))
                                        <div
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                            Major: {{ request('jurusan') }}
                                            <button type="button" onclick="removeFilter('jurusan')"
                                                class="ml-1 inline-flex text-blue-500 focus:outline-none">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                    @if (request('status'))
                                        <div
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                            Status: {{ request('status') }}
                                            <button type="button" onclick="removeFilter('status')"
                                                class="ml-1 inline-flex text-emerald-500 focus:outline-none">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                    @if (request('jenis_kelamin'))
                                        <div
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                            Gender: {{ request('jenis_kelamin') }}
                                            <button type="button" onclick="removeFilter('jenis_kelamin')"
                                                class="ml-1 inline-flex text-purple-500 focus:outline-none">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                    @if (request('agama'))
                                        <div
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                            Religion: {{ request('agama') }}
                                            <button type="button" onclick="removeFilter('agama')"
                                                class="ml-1 inline-flex text-amber-500 focus:outline-none">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                    @if (request('tahun_masuk'))
                                        <div
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                            Entry Year: {{ request('tahun_masuk') }}
                                            <button type="button" onclick="removeFilter('tahun_masuk')"
                                                class="ml-1 inline-flex text-red-500 focus:outline-none">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                    @if (request('kelas'))
                                        <div
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-300">
                                            Class: {{ request('kelas') }}
                                            <button type="button" onclick="removeFilter('kelas')"
                                                class="ml-1 inline-flex text-cyan-500 focus:outline-none">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Student Table -->
            <div class="glass-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                        <thead class="bg-slate-50 dark:bg-slate-800/50">
                            <tr>
                                <th scope="col" class="px-3 py-3 text-left">
                                    <div class="flex items-center">
                                        <input id="select-all" type="checkbox" class="select-checkbox"
                                            onclick="toggleAllCheckboxes()">
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Student
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    NIS/NISN
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Major
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                            @forelse ($students as $student)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="select-checkbox student-checkbox"
                                            value="{{ $student->id }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center overflow-hidden">
                                                @if ($student->profile_photo)
                                                    <img src="{{ asset('storage/' . $student->profile_photo) }}"
                                                        alt="{{ $student->nama_lengkap }}" class="h-10 w-10 object-cover">
                                                @else
                                                    <span class="text-lg font-medium text-slate-500 dark:text-slate-400">
                                                        {{ substr($student->nama_lengkap, 0, 1) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-slate-900 dark:text-white">
                                                    {{ $student->nama_lengkap }}
                                                </div>
                                                <div class="text-sm text-slate-500 dark:text-slate-400 flex items-center">
                                                    @if ($student->jenis_kelamin === 'Laki-laki')
                                                        <span class="inline-block w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                                                        Male
                                                    @else
                                                        <span class="inline-block w-2 h-2 rounded-full bg-pink-500 mr-2"></span>
                                                        Female
                                                    @endif
                                                    @if ($student->tanggal_lahir)
                                                        <span class="mx-1">•</span>
                                                        {{ \Carbon\Carbon::parse($student->tanggal_lahir)->age }} years
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-slate-900 dark:text-white">{{ $student->nis ?? '-' }}</div>
                                        <div class="text-sm text-slate-500 dark:text-slate-400">{{ $student->nisn ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-slate-900 dark:text-white">{{ $student->jurusan ?? '-' }}</div>
                                        <div class="text-sm text-slate-500 dark:text-slate-400">{{ $student->kelas ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($student->status === 'Active')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                                                Active
                                            </span>
                                        @elseif ($student->status === 'Inactive')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                Inactive
                                            </span>
                                        @elseif ($student->status === 'Pending')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                                                Pending
                                            </span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300">
                                                {{ $student->status ?? 'Unknown' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('student.show', $student->id) }}"
                                                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('student.edit', $student->id) }}"
                                                class="text-amber-600 dark:text-amber-400 hover:text-amber-900 dark:hover:text-amber-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <button type="button" onclick="confirmDelete({{ $student->id }})"
                                                class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-white">No students
                                                found</h3>
                                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                                Get started by creating a new student.
                                            </p>
                                            <div class="mt-6">
                                                <a href="{{ route('student.create') }}"
                                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd"
                                                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    New Student
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-slate-900 dark:text-white" id="modal-title">
                                Delete Student
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-500 dark:text-slate-400">
                                    Are you sure you want to delete this student? All of their data will be permanently
                                    removed.
                                    This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 dark:bg-slate-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                    </form>
                    <button type="button" onclick="closeModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-slate-300 dark:border-slate-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-800 text-base font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mass Delete Confirmation Modal -->
    <div id="massDeleteModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-slate-900 dark:text-white" id="modal-title">
                                Delete Selected Students
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-500 dark:text-slate-400">
                                    Are you sure you want to delete the selected students? All of their data will be
                                    permanently removed.
                                    This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 dark:bg-slate-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form id="massDeleteForm" method="POST" action="{{ route('student.mass-delete') }}">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="mass-delete-ids" name="ids">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete All Selected
                        </button>
                    </form>
                    <button type="button" onclick="closeMassDeleteModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-slate-300 dark:border-slate-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-800 text-base font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('students.script')
@endsection
