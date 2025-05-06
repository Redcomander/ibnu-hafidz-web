<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::latest()->paginate(15);
        return view('gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('galeri.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'media.*' => 'nullable|file|max:40960', // max 40MB per file
            'video_url' => 'nullable|url',
            'upload_type' => 'required|in:file,url,youtube',
        ]);

        $photoCount = 0;
        $videoCount = 0;

        // Handle file uploads
        if ($request->upload_type === 'file' && $request->hasFile('media')) {
            $files = $request->file('media');

            foreach ($files as $file) {
                if (str_starts_with($file->getMimeType(), 'image/')) {
                    $photoCount++;
                } elseif (str_starts_with($file->getMimeType(), 'video/')) {
                    $videoCount++;
                }
            }
        }

        // Check if we have a video URL or YouTube URL
        $hasVideoUrl = $request->upload_type === 'url' && !empty($request->video_url);
        $hasYoutubeUrl = $request->upload_type === 'youtube' && !empty($request->video_url);

        if ($hasVideoUrl || $hasYoutubeUrl) {
            $videoCount++;
        }

        if ($photoCount > 10 || $videoCount > 5) {
            return back()->withErrors([
                'media' => 'Max 10 photos and 5 videos per upload.',
            ]);
        }

        // Process file uploads
        $index = 1;
        if ($request->upload_type === 'file' && $request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $type = str_starts_with($file->getMimeType(), 'image/') ? 'photo' : 'video';
                $path = $file->store('gallery', 'public');

                // Create thumbnail for videos
                if ($type === 'video') {
                    $this->createVideoThumbnail($path);
                }

                Gallery::create([
                    'title' => $request->title . ' ' . $index,
                    'type' => $type,
                    'path' => $path,
                    'source' => 'upload',
                ]);

                $index++;
            }
        }

        // Process YouTube URL if provided
        if ($hasYoutubeUrl) {
            $success = $this->storeYoutubeVideo($request->video_url, $request->title . ' ' . $index);

            if (!$success) {
                return back()->withErrors(['video_url' => 'Failed to process YouTube video.']);
            }
        }

        // ✅ FIXED: Process YouTube URL if provided
        if ($hasYoutubeUrl) {
            $this->storeYoutubeVideo($request->video_url, $request->title . ' ' . $index);
        }

        return redirect()->route('galeri.index')->with('success', 'Media uploaded successfully!');
    }

    /**
     * Extract YouTube video ID from URL
     */
    private function extractYoutubeId($url)
    {
        $pattern = '%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';

        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }

        return null;
    }


    /**
     * Store a YouTube video
     */
    private function storeYoutubeVideo($url, $title)
    {
        try {
            // Extract YouTube video ID
            $videoId = $this->extractYoutubeId($url);

            if (!$videoId) {
                \Log::error('Invalid YouTube URL: ' . $url);
                return false;
            }

            // Thumbnail URLs
            $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
            $thumbnailFallbackUrl = "https://img.youtube.com/vi/{$videoId}/0.jpg";

            // Storage path
            $filename = 'youtube_' . $videoId;
            $thumbnailPath = 'thumbnails/' . $filename . '.jpg';
            $fullThumbnailPath = storage_path('app/public/' . $thumbnailPath);

            // Ensure directory exists
            if (!file_exists(dirname($fullThumbnailPath))) {
                mkdir(dirname($fullThumbnailPath), 0755, true);
            }

            // Attempt to download thumbnail with SSL verification disabled
            $response = Http::withoutVerifying()->get($thumbnailUrl);

            if (!$response->successful() || empty($response->body())) {
                $response = Http::withoutVerifying()->get($thumbnailFallbackUrl);
            }

            if ($response->successful()) {
                file_put_contents($fullThumbnailPath, $response->body());
            } else {
                $this->createDefaultVideoThumbnail($filename);
            }

            // Save to database
            Gallery::create([
                'title' => $title,
                'type' => 'video',
                'path' => 'youtube:' . $videoId,
                'source' => 'youtube',
                'original_url' => $url,
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to process YouTube video: ' . $e->getMessage());
            return false;
        }
    }




    /**
     * Store a video from URL
     */
    private function storeVideoFromUrl($url, $title)
    {
        try {
            // Generate a unique filename
            $filename = Str::random(40) . '.mp4';
            $path = 'gallery/' . $filename;
            $fullPath = storage_path('app/public/' . $path);

            // Ensure directory exists
            $directory = dirname($fullPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Download the video
            $response = Http::timeout(120)->get($url);
            if ($response->successful()) {
                file_put_contents($fullPath, $response->body());

                // Create thumbnail
                $this->createVideoThumbnail($path);

                // Save to database
                Gallery::create([
                    'title' => $title,
                    'type' => 'video',
                    'path' => $path,
                    'source' => 'url',
                    'original_url' => $url,
                ]);

                return true;
            }

            return false;
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Failed to download video from URL: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('gallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $gallery = Gallery::findOrFail($id);
        $gallery->title = $request->title;
        $gallery->save();

        return redirect()->route('galeri.index')->with('success', 'Gallery item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Gallery::findOrFail($id);

        // Delete the file from storage if it's not a YouTube video
        if ($gallery->source !== 'youtube' && Storage::disk('public')->exists($gallery->path)) {
            Storage::disk('public')->delete($gallery->path);
        }

        // Delete thumbnail if it's a video
        if ($gallery->type === 'video') {
            if ($gallery->source === 'youtube') {
                // Extract video ID for YouTube videos
                $videoId = str_replace('youtube:', '', $gallery->path);
                $thumbnailPath = 'thumbnails/youtube_' . $videoId . '.jpg';
            } else {
                $thumbnailPath = 'thumbnails/' . pathinfo($gallery->path, PATHINFO_FILENAME) . '.jpg';
            }

            if (Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
        }

        $gallery->delete();

        return redirect()->route('galeri.index')->with('success', 'Gallery item deleted successfully!');
    }

    /**
     * Create a thumbnail for a video file
     */
    private function createVideoThumbnail($videoPath)
    {
        try {
            // Ensure the thumbnails directory exists
            if (!Storage::disk('public')->exists('thumbnails')) {
                Storage::disk('public')->makeDirectory('thumbnails');
            }

            $filename = pathinfo($videoPath, PATHINFO_FILENAME);
            $thumbnailPath = storage_path('app/public/thumbnails/' . $filename . '.jpg');

            // Use FFmpeg to extract a frame from the video
            $videoFullPath = storage_path('app/public/' . $videoPath);
            $ffmpegCommand = "ffmpeg -i {$videoFullPath} -ss 00:00:01 -vframes 1 {$thumbnailPath}";

            exec($ffmpegCommand);

            // If FFmpeg fails or is not available, create a default thumbnail
            if (!file_exists($thumbnailPath)) {
                $this->createDefaultVideoThumbnail($filename);
            }

            return true;
        } catch (\Exception $e) {
            // Create a default thumbnail if there's an error
            $this->createDefaultVideoThumbnail(pathinfo($videoPath, PATHINFO_FILENAME));
            return false;
        }
    }

    /**
     * Create a default thumbnail for videos when FFmpeg fails
     * Using native PHP GD library instead of Intervention Image
     */
    private function createDefaultVideoThumbnail($filename)
    {
        // Create a simple image with text using GD library
        $width = 640;
        $height = 360;
        $image = imagecreatetruecolor($width, $height);

        // Set background to black
        $black = imagecolorallocate($image, 0, 0, 0);
        imagefill($image, 0, 0, $black);

        // Set text color to white
        $white = imagecolorallocate($image, 255, 255, 255);

        // Add text
        $text = 'Video Preview';
        $font = 5; // Built-in font (1-5)

        // Calculate text position to center it
        $textWidth = imagefontwidth($font) * strlen($text);
        $textHeight = imagefontheight($font);
        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2;

        // Draw the text
        imagestring($image, $font, $x, $y, $text, $white);

        // Save the image
        $thumbnailPath = storage_path('app/public/thumbnails/' . $filename . '.jpg');
        imagejpeg($image, $thumbnailPath, 90);
        imagedestroy($image);
    }

    /**
     * Mass delete selected gallery items
     */
    public function massDestroy(Request $request)
    {
        $request->validate([
            'selected' => 'required|array',
            'selected.*' => 'exists:galleries,id',
        ]);

        $selectedIds = $request->input('selected', []);
        $galleries = Gallery::whereIn('id', $selectedIds)->get();

        foreach ($galleries as $gallery) {
            // Delete the file from storage if it's not a YouTube video
            if ($gallery->source !== 'youtube' && Storage::disk('public')->exists($gallery->path)) {
                Storage::disk('public')->delete($gallery->path);
            }

            // Delete thumbnail if it's a video
            if ($gallery->type === 'video') {
                if ($gallery->source === 'youtube') {
                    // Extract video ID for YouTube videos
                    $videoId = str_replace('youtube:', '', $gallery->path);
                    $thumbnailPath = 'thumbnails/youtube_' . $videoId . '.jpg';
                } else {
                    $thumbnailPath = 'thumbnails/' . pathinfo($gallery->path, PATHINFO_FILENAME) . '.jpg';
                }

                if (Storage::disk('public')->exists($thumbnailPath)) {
                    Storage::disk('public')->delete($thumbnailPath);
                }
            }
        }

        Gallery::whereIn('id', $selectedIds)->delete();

        return redirect()->route('galeri.index')->with('success', count($selectedIds) . ' items deleted successfully!');
    }

    /**
     * Display photo gallery
     */
    public function galleryPhoto()
    {
        $galleries = Gallery::where('type', 'photo')->latest()->get();
        return view('gallery.gallery-photo', compact('galleries'));
    }

    /**
     * Display video gallery
     */
    public function galleryVideo()
    {
        $galleries = Gallery::where('type', 'video')->latest()->get();
        return view('gallery.gallery-video', compact('galleries'));
    }
}
