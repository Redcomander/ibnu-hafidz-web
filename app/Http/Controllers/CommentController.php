<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Google_Client;

class CommentController extends Controller
{
    /**
     * Get configured Google Client
     */
    protected function getGoogleClient()
    {
        $client = new Google_Client(['client_id' => config('services.google.client_id')]);

        // Disable SSL verification in local/development environment
        if (app()->environment('local', 'development')) {
            $client->setHttpClient(
                new \GuzzleHttp\Client(['verify' => false])
            );
        }

        return $client;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Article $article)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'body' => 'required|string|max:1000',
                'google_token' => 'required|string',
                'profile_picture' => 'nullable|url',
            ]);

            // Verify Google token
            $client = $this->getGoogleClient();
            $payload = $client->verifyIdToken($request->google_token);

            if (!$payload) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid Google authentication.'
                    ], 400);
                }
                return back()->with('error', 'Invalid Google authentication.');
            }

            // Verify email matches the Google account
            if ($payload['email'] !== $request->email) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email mismatch with Google account.'
                    ], 400);
                }
                return back()->with('error', 'Email mismatch with Google account.');
            }

            // Create the comment
            $comment = $article->comments()->create([
                'name' => $request->name,
                'email' => $request->email,
                'body' => $request->body,
                'profile_picture' => $request->profile_picture,
                'google_id' => $payload['sub'],
                'is_approved' => true, // Auto-approve or set to false if moderation is needed
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Comment posted successfully.',
                    'comment' => $comment
                ]);
            }

            return back()->with('success', 'Komentar berhasil dikirim.');

        } catch (\Exception $e) {
            Log::error('Comment store error: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Authentication failed. Please try again.');
        }
    }

    /**
     * Store a reply to a comment.
     */
    public function reply(Request $request)
    {
        try {
            $request->validate([
                'article_id' => 'required|exists:articles,id',
                'parent_id' => 'required|exists:comments,id',
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'body' => 'required|string|max:1000',
                'google_token' => 'required|string',
                'profile_picture' => 'nullable|url',
            ]);

            // Verify Google token
            $client = $this->getGoogleClient();
            $payload = $client->verifyIdToken($request->google_token);

            if (!$payload) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid Google authentication.'
                    ], 400);
                }
                return back()->with('error', 'Invalid Google authentication.');
            }

            // Verify email matches the Google account
            if ($payload['email'] !== $request->email) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email mismatch with Google account.'
                    ], 400);
                }
                return back()->with('error', 'Email mismatch with Google account.');
            }

            // Create the reply
            $reply = Comment::create([
                'article_id' => $request->article_id,
                'parent_id' => $request->parent_id,
                'name' => $request->name,
                'email' => $request->email,
                'body' => $request->body,
                'profile_picture' => $request->profile_picture,
                'google_id' => $payload['sub'],
                'is_approved' => true, // Auto-approve or set to false if moderation is needed
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reply posted successfully.',
                    'reply' => $reply
                ]);
            }

            return back()->with('success', 'Reply posted successfully.');

        } catch (\Exception $e) {
            Log::error('Reply store error: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Authentication failed. Please try again.');
        }
    }

    public function like(Request $request, Comment $comment)
    {
        try {
            $googleId = null;
            $ipAddress = $request->ip();

            // If Google token is provided, verify it
            if ($request->has('google_token')) {
                $client = $this->getGoogleClient();
                $payload = $client->verifyIdToken($request->google_token);

                if ($payload) {
                    $googleId = $payload['sub'];
                    $ipAddress = null; // Use Google ID instead of IP
                }
            }

            // Check if already liked
            $existingLike = CommentLike::where('comment_id', $comment->id)
                ->where(function ($query) use ($googleId, $ipAddress) {
                    if ($googleId) {
                        $query->where('google_id', $googleId);
                    } else {
                        $query->where('ip_address', $ipAddress);
                    }
                })->first();

            if ($existingLike) {
                // Unlike
                $existingLike->delete();
                $comment->decrement('likes_count');
                $action = 'unliked';
            } else {
                // Like
                CommentLike::create([
                    'comment_id' => $comment->id,
                    'google_id' => $googleId,
                    'ip_address' => $ipAddress,
                ]);
                $comment->increment('likes_count');
                $action = 'liked';
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'likes_count' => $comment->likes_count,
                    'action' => $action
                ]);
            }

            return back();

        } catch (\Exception $e) {
            Log::error('Like error: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'An error occurred. Please try again.');
        }
    }
}
