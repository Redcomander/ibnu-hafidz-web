@extends('layouts.dashboard-layout')

@section('head')
    <style>
        .ql-editor {
            min-height: 200px;
            max-height: 400px;
            overflow-y: auto;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 0 0 0.5rem 0.5rem;
        }

        .ql-toolbar {
            border-radius: 0.5rem 0.5rem 0 0;
            background-color: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        .dark .ql-toolbar .ql-stroke {
            stroke: #cbd5e1;
        }

        .dark .ql-toolbar .ql-fill {
            fill: #cbd5e1;
        }

        .dark .ql-toolbar .ql-picker {
            color: #cbd5e1;
        }

        .thumbnail-preview {
            transition: all 0.3s ease;
        }

        .thumbnail-preview:hover {
            transform: scale(1.05);
        }

        .status-toggle input:checked~.dot {
            transform: translateX(100%);
            background-color: #10b981;
        }

        .status-toggle input:checked~.track {
            background-color: rgba(16, 185, 129, 0.2);
        }

        .form-card {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
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

        .animate-float-slow {
            animation: float 8s ease-in-out infinite;
        }
    </style>
@endsection

@section('content')
    <div
        class="py-8 min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 transition-colors duration-300">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Decorative elements -->
            <div
                class="absolute top-10 right-10 w-64 h-64 bg-purple-500/10 dark:bg-purple-500/20 rounded-full blur-3xl -z-10 animate-float">
            </div>
            <div
                class="absolute bottom-10 left-10 w-72 h-72 bg-blue-500/10 dark:bg-blue-500/20 rounded-full blur-3xl -z-10 animate-float-slow">
            </div>

            <!-- Page header -->
            <div class="mb-8 text-center">
                <h1
                    class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-500 dark:from-purple-400 dark:to-blue-400 inline-block">
                    Create New Article
                </h1>
                <p class="mt-2 text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Share your knowledge and insights with the world. Create compelling content that engages your audience.
                </p>
            </div>

            <!-- Form card -->
            <div
                class="bg-white/70 dark:bg-slate-800/70 rounded-2xl shadow-xl border border-slate-200/50 dark:border-slate-700/50 p-6 md:p-8 form-card">
                <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Title input -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                            Article Title
                        </label>
                        <input type="text" name="title" id="title"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white/50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-purple-500 dark:focus:ring-blue-500 focus:border-transparent transition duration-200"
                            placeholder="Enter a captivating title" value="{{ old('title') }}" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category dropdown -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                            Category
                        </label>
                        <div class="relative">
                            <select name="category_id" id="category_id"
                                class="appearance-none w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white/50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-purple-500 dark:focus:ring-blue-500 focus:border-transparent transition duration-200">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-700 dark:text-slate-300">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Thumbnail upload -->
                    <div>
                        <label for="thumbnail" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                            Thumbnail Image
                        </label>
                        <div class="mt-1 flex items-center space-x-4">
                            <div class="flex-shrink-0 h-32 w-32 rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-700 border-2 border-dashed border-slate-300 dark:border-slate-600 flex items-center justify-center thumbnail-preview"
                                id="thumbnail-preview">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label for="thumbnail"
                                    class="cursor-pointer bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center transition duration-150 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    Upload Image
                                </label>
                                <input type="file" name="thumbnail" id="thumbnail" class="hidden" accept="image/*"
                                    onchange="previewThumbnail(this)">
                                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                                    Recommended size: 1200×630 pixels. Max 2MB.
                                </p>
                            </div>
                        </div>
                        @error('thumbnail')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rich text editor -->
                    <div>
                        <label for="body" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                            Article Content
                        </label>
                        <div id="editor" class="rounded-xl overflow-hidden border border-slate-300 dark:border-slate-600">
                        </div>
                        <input type="hidden" name="body" id="quill-body" value="{{ old('body') }}">
                        @error('body')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status toggle -->
                    <div>
                        <span class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Publication Status
                        </span>
                        <div class="flex items-center space-x-3">
                            <label for="status-toggle" class="inline-flex items-center cursor-pointer">
                                <div class="relative status-toggle">
                                    <input type="checkbox" id="status-toggle" class="sr-only" onchange="updateStatus(this)">
                                    <div class="track w-12 h-6 bg-slate-200 dark:bg-slate-700 rounded-full"></div>
                                    <div
                                        class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-300 ease-in-out">
                                    </div>
                                </div>
                            </label>
                            <span id="status-text"
                                class="text-sm font-medium text-slate-500 dark:text-slate-400">Draft</span>
                            <input type="hidden" name="status" id="status" value="draft">
                        </div>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            Draft articles are not visible to the public until published.
                        </p>
                    </div>

                    <!-- Form actions -->
                    <div class="flex items-center justify-end space-x-4 pt-4">
                        <a href="{{ route('articles.index') }}"
                            class="px-5 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition duration-200">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 text-white font-medium shadow-md hover:shadow-lg transition duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Create Article
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
         var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                [{ 'script': 'sub' }, { 'script': 'super' }],
                [{ 'indent': '-1' }, { 'indent': '+1' }],
                [{ 'direction': 'rtl' }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'font': [] }],
                [{ 'align': [] }],
                ['clean'],
                ['link', 'image', 'video']
            ]
        }
    });

    quill.on('text-change', function() {
        document.getElementById('quill-body').value = quill.root.innerHTML;
    });


        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
                document.getElementById('image-preview').classList.remove('hidden');
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        // Dark mode styles for Quill editor
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.querySelector('.ql-toolbar').classList.add('dark:bg-gray-700', 'dark:border-gray-600');
            document.querySelector('.ql-container').classList.add('dark:bg-gray-700', 'dark:border-gray-600',
                'dark:text-white');
        }



        // Thumbnail preview
        function previewThumbnail(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('thumbnail-preview');
                    preview.innerHTML = `<img src="${e.target.result}" class="h-full w-full object-cover">`;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Status toggle
        function updateStatus(checkbox) {
            const statusText = document.getElementById('status-text');
            const statusInput = document.getElementById('status');

            if (checkbox.checked) {
                statusText.textContent = 'Published';
                statusInput.value = 'published';
            } else {
                statusText.textContent = 'Draft';
                statusInput.value = 'draft';
            }
        }
    </script>
@endsection
