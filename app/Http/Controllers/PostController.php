<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Post::with(['user', 'category'])
            ->published();

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Sort
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'oldest':
                $query->oldest('published_at');
                break;
            case 'title':
                $query->orderBy('title');
                break;
            default:
                $query->latest('published_at');
                break;
        }

        $posts = $query->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $this->authorize('create', Post::class);

        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(PostRequest $request)
    {
        $this->authorize('create', Post::class);

        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Make slug unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Post::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('posts', 'public');
            $data['image'] = $imagePath;
        }

        // Set status based on action and user role
        $action = $request->input('action', 'publish');

        if (Auth::user()->isAdmin()) {
            // Admins can publish directly
            $data['status'] = 'approved';
            if ($action === 'publish' && empty($data['published_at'])) {
                $data['published_at'] = now();
            } elseif ($action === 'draft') {
                $data['status'] = 'draft';
                $data['published_at'] = null;
            }
        } else {
            // Regular users submit for review
            if ($action === 'publish') {
                $data['status'] = 'pending';
                $data['published_at'] = $data['published_at'] ?? now();
            } else {
                $data['status'] = 'draft';
                $data['published_at'] = null;
            }
        }

        $post = Post::create($data);

        if ($data['status'] === 'pending') {
            $message = 'Post submitted for review! It will be published once approved by an admin.';
        } elseif ($data['status'] === 'draft') {
            $message = 'Post saved as draft!';
        } else {
            $message = 'Post published successfully!';
        }

        return redirect()->route('posts.show', $post->slug)
            ->with('message', $message);
    }

    public function show(string $slug)
    {
        $post = Post::with(['user', 'category', 'reviewer'])
            ->where('slug', $slug)
            ->firstOrFail();

        $this->authorize('view', $post);

        // Get previous and next published posts
        $previousPost = Post::published()
            ->where('published_at', '<', $post->published_at ?? $post->created_at)
            ->latest('published_at')
            ->first();

        $nextPost = Post::published()
            ->where('published_at', '>', $post->published_at ?? $post->created_at)
            ->oldest('published_at')
            ->first();

        return view('posts.show', compact('post', 'previousPost', 'nextPost'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Make slug unique (excluding current post)
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Post::where('slug', $data['slug'])->where('id', '!=', $post->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($post->image)
                Storage::disk('public')->delete($post->image);

            $image = $request->file('image');
            $imagePath = $image->store('posts', 'public');
            $data['image'] = $imagePath;
        }

        // Handle status based on action and user role
        $action = $request->input('action', 'publish');

        if (Auth::user()->isAdmin()) {
            // Admins can publish directly
            if ($action === 'publish') {
                $data['status'] = 'approved';
                if (empty($data['published_at'])) {
                    $data['published_at'] = now();
                }
            }
        } else {
            // Regular users need reapproval if content changed significantly
            if (
                $action === 'publish'
            ) {
                $data['status'] = 'pending';
                $data['reviewed_by'] = null;
                $data['reviewed_at'] = null;
                $data['review_notes'] = null;
            } else {
                $data['status'] = $post->status;
            }
        }

        $post->update($data);

        if ($data['status'] === 'pending') {
            $message = 'Post updated and submitted for review!';
        } else {
            $message = 'Post updated successfully!';
        }

        return redirect()->route('posts.show', $post->slug)
            ->with('message', $message);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->image)
            Storage::disk('public')->delete($post->image);

        $post->delete();

        return redirect()->route('posts.index')
            ->with('message', 'Post deleted successfully!');
    }
}
