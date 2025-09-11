<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $categories = Category::withCount([
            'posts as posts_count' => function ($query) {
                $query->published();
            }
        ])
            ->with([
                'posts' => function ($query) {
                    $query->published()->latest('published_at')->limit(1);
                }
            ])
            ->orderBy('name')
            ->paginate(12);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorize('create', Category::class);
        return view('categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $this->authorize('create', Category::class);

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        $originalSlug = $data['slug'];
        $counter = 1;
        while (Category::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        Category::create($data);

        return redirect()->route('categories.index')
            ->with('message', 'Category created successfully!');
    }

    public function show(string $slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $query = $category->posts()
            ->with(['user', 'category'])
            ->published();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

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

        $posts = $query->paginate(10);

        return view('categories.show', compact('category', 'posts'));
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        return view('categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        $data = $request->validated();

        if ($category->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']);

            $originalSlug = $data['slug'];
            $counter = 1;
            while (Category::where('slug', $data['slug'])->where('id', '!=', $category->id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $category->update($data);

        return redirect()->route('categories.index')
            ->with('message', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        if ($category->posts()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete category that has posts.']);
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('message', 'Category deleted successfully!');
    }
}
