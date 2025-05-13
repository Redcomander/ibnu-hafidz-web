@extends('layouts.dashboard-layout')

@section('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stats-card {
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .stats-icon {
            transition: all 0.3s ease;
        }

        .stats-card:hover .stats-icon {
            transform: scale(1.1);
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

            <!-- Page header -->
            <div class="mb-8 animate__animated animate__fadeIn">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1
                            class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 via-violet-600 to-blue-600 dark:from-purple-400 dark:via-violet-400 dark:to-blue-400 inline-block animate__animated animate__fadeInUp">
                            Article Analytics
                        </h1>
                        <p
                            class="mt-2 text-slate-600 dark:text-slate-400 max-w-2xl animate__animated animate__fadeInUp animate__delay-1s">
                            Detailed analytics for "{{ $article->title }}"
                        </p>
                    </div>
                    <div class="flex items-center space-x-3 animate__animated animate__fadeInRight">
                        <a href="{{ route('articles.show', ['category' => $article->category->slug, 'article' => $article->slug]) }}"
                            class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition duration-300 flex items-center whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View Article
                        </a>
                        <a href="{{ route('articles.index') }}"
                            class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-medium shadow-lg shadow-purple-500/20 hover:shadow-purple-500/40 transition duration-300 flex items-center whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            All Articles
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div
                    class="stats-card bg-white/70 dark:bg-slate-800/50 rounded-xl shadow-lg border border-slate-200/50 dark:border-slate-700/30 p-6 glass-effect">
                    <div class="flex items-center">
                        <div
                            class="stats-icon p-4 rounded-lg bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-lg shadow-purple-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div class="ml-6">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Views</p>
                            <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ number_format($totalViews) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="stats-card bg-white/70 dark:bg-slate-800/50 rounded-xl shadow-lg border border-slate-200/50 dark:border-slate-700/30 p-6 glass-effect">
                    <div class="flex items-center">
                        <div
                            class="stats-icon p-4 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-lg shadow-blue-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-6">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Unique Visitors</p>
                            <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ number_format($uniqueViews) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="stats-card bg-white/70 dark:bg-slate-800/50 rounded-xl shadow-lg border border-slate-200/50 dark:border-slate-700/30 p-6 glass-effect">
                    <div class="flex items-center">
                        <div
                            class="stats-icon p-4 rounded-lg bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow-lg shadow-green-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="ml-6">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Engagement Rate</p>
                            <p class="text-3xl font-bold text-slate-800 dark:text-white">
                                {{ $totalViews > 0 ? number_format(($uniqueViews / $totalViews) * 100, 1) : 0 }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Views chart -->
            <div
                class="bg-white/70 dark:bg-slate-800/50 rounded-xl shadow-lg border border-slate-200/50 dark:border-slate-700/30 p-6 glass-effect mb-8">
                <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Views Over Time</h2>
                <div class="h-80">
                    <canvas id="viewsChart"></canvas>
                </div>
            </div>

            <!-- Article details -->
            <div
                class="bg-white/70 dark:bg-slate-800/50 rounded-xl shadow-lg border border-slate-200/50 dark:border-slate-700/30 p-6 glass-effect">
                <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Article Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-4">Basic Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-slate-500 dark:text-slate-400">Title:</span>
                                <span class="text-slate-800 dark:text-white font-medium">{{ $article->title }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500 dark:text-slate-400">Category:</span>
                                <span
                                    class="text-slate-800 dark:text-white font-medium">{{ $article->category ? $article->category->name : 'Uncategorized' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500 dark:text-slate-400">Author:</span>
                                <span
                                    class="text-slate-800 dark:text-white font-medium">{{ $article->author ? $article->author->name : 'Unknown' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500 dark:text-slate-400">Status:</span>
                                <span
                                    class="text-slate-800 dark:text-white font-medium">{{ ucfirst($article->status) }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-4">Publishing Information
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-slate-500 dark:text-slate-400">Created:</span>
                                <span
                                    class="text-slate-800 dark:text-white font-medium">{{ $article->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500 dark:text-slate-400">Published:</span>
                                <span
                                    class="text-slate-800 dark:text-white font-medium">{{ $article->published_at ? $article->published_at->format('M d, Y H:i') : 'Not published' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500 dark:text-slate-400">Last Updated:</span>
                                <span
                                    class="text-slate-800 dark:text-white font-medium">{{ $article->updated_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500 dark:text-slate-400">Reading Time:</span>
                                <span
                                    class="text-slate-800 dark:text-white font-medium">{{ $article->reading_time ?? '5 min read' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Prepare data for the chart
            const viewsData = @json($viewsByDay);
            const labels = viewsData.map(item => item.date);
            const data = viewsData.map(item => item.views);

            // Create the chart
            const ctx = document.getElementById('viewsChart').getContext('2d');
            const viewsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Views',
                        data: data,
                        backgroundColor: 'rgba(124, 58, 237, 0.2)',
                        borderColor: 'rgba(124, 58, 237, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(124, 58, 237, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                title: function (tooltipItems) {
                                    return tooltipItems[0].label;
                                },
                                label: function (context) {
                                    return `Views: ${context.parsed.y}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: document.documentElement.classList.contains('dark') ? 'rgba(148, 163, 184, 0.1)' : 'rgba(203, 213, 225, 0.5)'
                            },
                            ticks: {
                                precision: 0,
                                color: document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
