@extends('layouts.dashboard-layout')

@section('content')
<div class="container px-4 mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold mt-4 dark:text-white">Gallery Management</h1>
        <div class="flex space-x-2">
            <button id="massDeleteBtn" type="button" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors hidden dark:focus:ring-offset-gray-800"
                    onclick="confirmMassDelete()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                Delete Selected
            </button>
            <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors dark:focus:ring-offset-gray-800"
                    onclick="document.getElementById('uploadModal').classList.remove('hidden')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Upload Media
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 relative dark:bg-green-900 dark:border-green-600 dark:text-green-200" role="alert">
        <p>{{ session('success') }}</p>
        <button type="button" class="absolute top-0 right-0 mt-4 mr-4" onclick="this.parentElement.remove()">
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 relative dark:bg-red-900 dark:border-red-600 dark:text-red-200" role="alert">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="absolute top-0 right-0 mt-4 mr-4" onclick="this.parentElement.remove()">
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6 dark:bg-gray-800">
        <div class="bg-gray-50 px-4 py-3 border-b dark:bg-gray-700 dark:border-gray-600">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium dark:text-white">Gallery Items</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div>
                        <select id="typeFilter" class="block w-full pl-3 pr-10 py-1.5 text-sm border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">All Types</option>
                            <option value="photo">Photos</option>
                            <option value="video">Videos</option>
                        </select>
                    </div>
                    <div class="relative">
                        <input type="text" id="searchInput" class="block w-full pl-3 pr-10 py-1.5 text-sm border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Search by title...">
                        <button class="absolute inset-y-0 right-0 px-3 flex items-center" id="searchBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <form id="massDeleteForm" action="{{ route('galeri.massDestroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" id="galleryTable">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400 w-12">
                                <div class="flex items-center">
                                    <input id="selectAll" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-600 dark:border-gray-500">
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400 w-12">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400 w-24">Preview</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Title</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400 w-24">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400 w-40">Upload Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400 w-32">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse ($galleries as $index => $gallery)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" name="selected[]" value="{{ $gallery->id }}" class="gallery-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-600 dark:border-gray-500">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($gallery->type == 'photo')
                                <img src="{{ asset('storage/' . $gallery->path) }}" alt="{{ $gallery->title }}" class="h-12 w-auto object-cover rounded">
                                @else
                                <div class="relative">
                                    @if($gallery->source === 'youtube')
                                        @php
                                            $videoId = str_replace('youtube:', '', $gallery->path);
                                            $thumbnailPath = 'thumbnails/youtube_' . $videoId . '.jpg';
                                        @endphp
                                        <img src="{{ Storage::disk('public')->exists($thumbnailPath) ? asset('storage/' . $thumbnailPath) : 'https://img.youtube.com/vi/' . $videoId . '/0.jpg' }}"
                                             alt="{{ $gallery->title }}" class="h-12 w-auto object-cover rounded">
                                    @else
                                        <img src="{{ asset('storage/thumbnails/' . pathinfo($gallery->path, PATHINFO_FILENAME) . '.jpg') }}"
                                             alt="{{ $gallery->title }}" class="h-12 w-auto object-cover rounded">
                                    @endif
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white drop-shadow-md" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $gallery->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $gallery->type == 'photo' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ ucfirst($gallery->type) }}
                                    @if($gallery->source === 'youtube')
                                        (YouTube)
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $gallery->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button class="preview-btn text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                            data-id="{{ $gallery->id }}"
                                            data-type="{{ $gallery->source === 'youtube' ? 'youtube' : $gallery->type }}"
                                            data-path="{{ $gallery->source === 'youtube' ? $gallery->path : asset('storage/' . $gallery->path) }}"
                                            data-title="{{ $gallery->title }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <button class="edit-btn text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300" data-id="{{ $gallery->id }}" data-title="{{ $gallery->title }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('galeri.destroy', $gallery->id) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to delete this item?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">No gallery items found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>
        <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6 dark:bg-gray-700 dark:border-gray-600">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Total: {{ $galleries->count() }} items
                </div>
                <div>
                    {{ $galleries->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="fixed inset-0 overflow-y-auto hidden z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity dark:bg-gray-900 dark:bg-opacity-75" aria-hidden="true" onclick="document.getElementById('uploadModal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full dark:bg-gray-800">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 dark:bg-gray-800">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                            Upload Media
                        </h3>
                        <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm" class="mt-4">
                            @csrf
                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Title</label>
                                <input type="text" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white" id="title" name="title" required>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">This will be used as the base title for all uploaded files.</p>
                            </div>

                            <div class="mb-4">
                                <label for="upload_type" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Upload Type</label>
                                <div class="flex flex-wrap gap-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="upload_type" value="file" class="text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600" checked onclick="toggleUploadMethod('file')">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">File Upload</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="upload_type" value="url" class="text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600" onclick="toggleUploadMethod('url')">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Video URL</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="upload_type" value="youtube" class="text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600" onclick="toggleUploadMethod('youtube')">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">YouTube URL</span>
                                    </label>
                                </div>
                            </div>

                            <div id="file_upload_section" class="mb-4">
                                <label for="media" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Media Files</label>
                                <div class="flex flex-col items-center justify-center w-full" id="dropzone">
                                    <label for="media" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-700 dark:bg-gray-800 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Images and videos (max 40MB per file)</p>
                                        </div>
                                        <input type="file" id="media" name="media[]" multiple accept="image/*,video/*" class="hidden">
                                    </label>
                                </div>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You can upload up to 10 photos and 5 videos (max 40MB per file).</p>
                            </div>

                            <div id="url_upload_section" class="mb-4 hidden">
                                <label for="video_url" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Video URL</label>
                                <input type="url" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white" id="video_url" name="video_url" placeholder="https://example.com/video.mp4">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter a direct URL to a video file (MP4, MOV, etc.)</p>
                            </div>

                            <div id="youtube_upload_section" class="mb-4 hidden">
                                <label for="video_url" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">YouTube URL</label>
                                <input type="url" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white" id="youtube_url" name="video_url" placeholder="https://www.youtube.com/watch?v=VIDEO_ID">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter a YouTube video URL (e.g., https://www.youtube.com/watch?v=VIDEO_ID)</p>
                            </div>

                            <div class="mt-4">
                                <div class="bg-blue-50 p-4 rounded-md dark:bg-blue-900">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400 dark:text-blue-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Upload Guidelines</h3>
                                            <ul class="mt-2 text-sm text-blue-700 list-disc pl-5 dark:text-blue-300">
                                                <li>Maximum 10 photos and 5 videos per upload</li>
                                                <li>Supported image formats: JPG, PNG, GIF</li>
                                                <li>Supported video formats: MP4, MOV, AVI</li>
                                                <li>Maximum file size: 40MB per file</li>
                                                <li>YouTube videos must be publicly accessible</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="preview-container" class="mt-4 hidden">
                                <h6 class="text-sm font-medium text-gray-700 dark:text-gray-300">Preview:</h6>
                                <div id="media-preview" class="flex flex-wrap gap-2 mt-2"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse dark:bg-gray-700">
                <button type="submit" form="uploadForm" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm dark:focus:ring-offset-gray-800" id="uploadBtn">
                    <svg id="uploadSpinner" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Upload
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800" onclick="document.getElementById('uploadModal').classList.add('hidden')">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div id="previewModal" class="fixed inset-0 overflow-y-auto hidden z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity dark:bg-gray-900 dark:bg-opacity-75" aria-hidden="true" onclick="document.getElementById('previewModal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full dark:bg-gray-800">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 dark:bg-gray-800">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="previewModalLabel">
                            Media Preview
                        </h3>
                        <div class="mt-4 flex justify-center">
                            <div id="photo-preview-container" class="hidden">
                                <img src="/placeholder.svg" id="photo-preview" class="max-h-96 rounded-md" alt="Preview">
                            </div>
                            <div id="video-preview-container" class="hidden">
                                <video id="video-preview" class="max-h-96 rounded-md" controls>
                                    <source src="/placeholder.svg" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div id="youtube-preview-container" class="hidden">
                                <iframe id="youtube-preview" class="w-full h-96 rounded-md" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse dark:bg-gray-700">
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800" onclick="document.getElementById('previewModal').classList.add('hidden')">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 overflow-y-auto hidden z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity dark:bg-gray-900 dark:bg-opacity-75" aria-hidden="true" onclick="document.getElementById('editModal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full dark:bg-gray-800">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 dark:bg-gray-800">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                Edit Gallery Item
                            </h3>
                            <div class="mt-4">
                                <label for="edit-title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                                <input type="text" name="title" id="edit-title" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse dark:bg-gray-700">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm dark:focus:ring-offset-gray-800">
                        Save Changes
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800" onclick="document.getElementById('editModal').classList.add('hidden')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm Mass Delete Modal -->
<div id="confirmMassDeleteModal" class="fixed inset-0 overflow-y-auto hidden z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity dark:bg-gray-900 dark:bg-opacity-75" aria-hidden="true" onclick="document.getElementById('confirmMassDeleteModal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full dark:bg-gray-800">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 dark:bg-gray-800">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10 dark:bg-red-900">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                            Delete Selected Items
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Are you sure you want to delete the selected items? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse dark:bg-gray-700">
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm dark:focus:ring-offset-gray-800" onclick="submitMassDelete()">
                    Delete
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800" onclick="document.getElementById('confirmMassDeleteModal').classList.add('hidden')">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // File input preview
        const mediaInput = document.getElementById('media');
        const previewContainer = document.getElementById('preview-container');
        const mediaPreview = document.getElementById('media-preview');
        const dropzone = document.getElementById('dropzone');

        // Toggle between file upload, URL upload, and YouTube URL
        window.toggleUploadMethod = function(method) {
            const fileSection = document.getElementById('file_upload_section');
            const urlSection = document.getElementById('url_upload_section');
            const youtubeSection = document.getElementById('youtube_upload_section');

            // Hide all sections first
            fileSection.classList.add('hidden');
            urlSection.classList.add('hidden');
            youtubeSection.classList.add('hidden');

            // Remove required attribute from all inputs
            document.getElementById('video_url').removeAttribute('required');
            document.getElementById('youtube_url').removeAttribute('required');
            mediaInput.removeAttribute('required');

            // Show the selected section and set required attribute
            if (method === 'file') {
                fileSection.classList.remove('hidden');
                mediaInput.setAttribute('required', 'required');
            } else if (method === 'url') {
                urlSection.classList.remove('hidden');
                document.getElementById('video_url').setAttribute('required', 'required');
            } else if (method === 'youtube') {
                youtubeSection.classList.remove('hidden');
                document.getElementById('youtube_url').setAttribute('required', 'required');
            }
        };

        // Drag and drop functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropzone.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900', 'dark:border-blue-400');
        }

        function unhighlight() {
            dropzone.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900', 'dark:border-blue-400');
        }

        dropzone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            mediaInput.files = files;
            handleFiles(files);
        }

        function handleFiles(files) {
            mediaPreview.innerHTML = '';

            if (files.length > 0) {
                previewContainer.classList.remove('hidden');

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'relative';

                        if (file.type.startsWith('image/')) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'h-24 w-24 object-cover rounded';
                            previewItem.appendChild(img);
                        } else if (file.type.startsWith('video/')) {
                            const videoThumb = document.createElement('div');
                            videoThumb.className = 'bg-gray-800 flex items-center justify-center h-24 w-24 rounded';

                            const icon = document.createElement('svg');
                            icon.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
                            icon.setAttribute('class', 'h-10 w-10 text-white');
                            icon.setAttribute('fill', 'currentColor');
                            icon.setAttribute('viewBox', '0 0 20 20');
                            icon.innerHTML = '<path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />';

                            videoThumb.appendChild(icon);
                            previewItem.appendChild(videoThumb);
                        }

                        const badge = document.createElement('span');
                        badge.className = file.type.startsWith('image/')
                            ? 'absolute top-0 right-0 m-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
                            : 'absolute top-0 right-0 m-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                        badge.textContent = file.type.startsWith('image/') ? 'Photo' : 'Video';
                        previewItem.appendChild(badge);

                        mediaPreview.appendChild(previewItem);
                    };

                    reader.readAsDataURL(file);
                }
            } else {
                previewContainer.classList.add('hidden');
            }
        }

        mediaInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        // Form submission loading state
        const uploadForm = document.getElementById('uploadForm');
        const uploadBtn = document.getElementById('uploadBtn');
        const uploadSpinner = document.getElementById('uploadSpinner');

        uploadForm.addEventListener('submit', function() {
            uploadBtn.disabled = true;
            uploadSpinner.classList.remove('hidden');
        });

        // Preview modal functionality
        const previewBtns = document.querySelectorAll('.preview-btn');
        const photoPreviewContainer = document.getElementById('photo-preview-container');
        const videoPreviewContainer = document.getElementById('video-preview-container');
        const youtubePreviewContainer = document.getElementById('youtube-preview-container');
        const photoPreview = document.getElementById('photo-preview');
        const videoPreview = document.getElementById('video-preview');
        const youtubePreview = document.getElementById('youtube-preview');
        const previewModalLabel = document.getElementById('previewModalLabel');

        previewBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const type = this.dataset.type;
                const path = this.dataset.path;
                const title = this.dataset.title;

                previewModalLabel.textContent = title;

                // Hide all containers first
                photoPreviewContainer.classList.add('hidden');
                videoPreviewContainer.classList.add('hidden');
                youtubePreviewContainer.classList.add('hidden');

                if (type === 'photo') {
                    photoPreviewContainer.classList.remove('hidden');
                    photoPreview.src = path;
                } else if (type === 'youtube') {
                    youtubePreviewContainer.classList.remove('hidden');
                    const videoId = path.replace('youtube:', '');
                    youtubePreview.src = `https://www.youtube.com/embed/${videoId}`;
                } else {
                    videoPreviewContainer.classList.remove('hidden');
                    videoPreview.src = path;
                }

                document.getElementById('previewModal').classList.remove('hidden');
            });
        });

        // Edit modal functionality
        const editBtns = document.querySelectorAll('.edit-btn');
        const editForm = document.getElementById('editForm');
        const editTitleInput = document.getElementById('edit-title');

        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const title = this.dataset.title;

                editTitleInput.value = title;
                editForm.action = `/dashboard/galeri/${id}`;

                document.getElementById('editModal').classList.remove('hidden');
            });
        });

        // Search and filter functionality
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');
        const typeFilter = document.getElementById('typeFilter');
        const tableRows = document.querySelectorAll('#galleryTable tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const filterType = typeFilter.value.toLowerCase();

            tableRows.forEach(row => {
                if (row.querySelector('td:nth-child(7)')) { // Skip the "No gallery items found" row
                    const title = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                    const type = row.querySelector('td:nth-child(5) span').textContent.toLowerCase();

                    const matchesSearch = title.includes(searchTerm);
                    const matchesType = filterType === '' || type.includes(filterType);

                    if (matchesSearch && matchesType) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        }

        searchBtn.addEventListener('click', filterTable);
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                filterTable();
            }
        });
        typeFilter.addEventListener('change', filterTable);

        // Mass selection functionality
        const selectAllCheckbox = document.getElementById('selectAll');
        const galleryCheckboxes = document.querySelectorAll('.gallery-checkbox');
        const massDeleteBtn = document.getElementById('massDeleteBtn');

        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            galleryCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            updateMassDeleteButton();
        });

        galleryCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateMassDeleteButton);
        });

        function updateMassDeleteButton() {
            const anyChecked = Array.from(galleryCheckboxes).some(checkbox => checkbox.checked);
            if (anyChecked) {
                massDeleteBtn.classList.remove('hidden');
            } else {
                massDeleteBtn.classList.add('hidden');
                selectAllCheckbox.checked = false;
            }
        }

        // Initialize the mass delete button state
        updateMassDeleteButton();

        // Make the confirmMassDelete function available globally
        window.confirmMassDelete = function() {
            document.getElementById('confirmMassDeleteModal').classList.remove('hidden');
        };

        // Make the submitMassDelete function available globally
        window.submitMassDelete = function() {
            document.getElementById('massDeleteForm').submit();
        };
    });
</script>
@endsection
