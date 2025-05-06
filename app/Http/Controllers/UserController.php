<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the currently logged in user
        $currentUser = Auth::user();

        // Update last activity timestamp for current user
        if ($currentUser) {
            $currentUser->last_activity = now();
            $currentUser->save();
        }

        // Get search query
        $search = $request->input('search');

        // Query for other users with search and pagination
        $query = User::where('id', '!=', $currentUser->id ?? 0);

        // Apply search if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Get paginated results
        $users = $query->latest()->paginate(8);

        // Define what "online" means (active in the last 5 minutes)
        $onlineThreshold = Carbon::now()->subMinutes(5);

        return view('user.index', compact('currentUser', 'users', 'search', 'onlineThreshold'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users|alpha_dash',
            'password' => 'required|string|min:8|confirmed',
            'foto_guru' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload if provided
        if ($request->hasFile('foto_guru')) {
            $fotoPath = $request->file('foto_guru')->store('teacher-photos', 'public');
            $validated['foto_guru'] = $fotoPath;
        }

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => $validated['password'], // This will be automatically hashed by the model
            'foto_guru' => $validated['foto_guru'] ?? null,
            'last_activity' => now(),
        ]);

        // Redirect with success message
        return redirect()->route('teachers.index')
            ->with('success', 'Teacher created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function checkStatus()
    {
        // Define what "online" means (active in the last 2 minutes)
        $onlineThreshold = Carbon::now()->subMinutes(2);

        // Get all users except the current user
        $users = User::where('id', '!=', Auth::id())->get();

        // Create an array of user IDs and their online status
        $statuses = [];
        foreach ($users as $user) {
            $statuses[$user->id] = $user->isOnline();
        }

        return response()->json($statuses);
    }

    /**
     * Update current user's last activity timestamp
     */
    public function updateActivity()
    {
        $user = Auth::user();

        if ($user) {
            $user->last_activity = now();
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 401);
    }
}
