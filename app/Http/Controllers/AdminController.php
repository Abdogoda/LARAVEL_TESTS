<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $pendingPosts = Post::with(['user', 'category'])
            ->pending()
            ->latest()
            ->paginate(10);

        $approvedPosts = Post::with(['user', 'category', 'reviewer'])
            ->approved()
            ->latest()
            ->take(5)
            ->get();

        $rejectedPosts = Post::with(['user', 'category', 'reviewer'])
            ->rejected()
            ->latest()
            ->take(5)
            ->get();

        $totalWriters = User::whereHas('posts')->count();

        return view('admin.dashboard', compact('pendingPosts', 'approvedPosts', 'rejectedPosts', 'totalWriters'));
    }

    public function reviewPost(Post $post)
    {
        return view('admin.review-post', compact('post'));
    }

    public function approvePost(Request $request, Post $post)
    {
        $post->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_notes' => $request->notes,
            'published_at' => $post->published_at ?? now(),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('message', 'Post approved successfully!');
    }

    public function rejectPost(Request $request, Post $post)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $post->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_notes' => $request->notes,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('message', 'Post rejected with feedback.');
    }
}
