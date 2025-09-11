@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white">Categories</h1>
                <p class="text-gray-300 mt-2">Browse posts by category</p>
            </div>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Category
                    </a>
                @endif
            @endauth
        </div>
    </div>

    <!-- Categories Grid -->
    @if($categories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($categories as $category)
                <div class="group relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-lg hover:shadow-2xl hover:bg-white/10 transition-all duration-300 hover:scale-101 hover:-translate-y-2 overflow-hidden">
                    <!-- Gradient overlay for glass effect -->
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 via-purple-500/5 to-pink-500/10 opacity-0  transition-opacity duration-300"></div>
                    
                    <!-- Animated border -->
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-500/20 via-purple-500/20 to-pink-500/20 opacity-0  blur-sm transition-opacity duration-300"></div>
                    
                    <div class="relative p-6 z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-white mb-2 group-hover:text-blue-300 transition-colors duration-200">
                                    <a href="{{ route('categories.show', $category->slug) }}" class="hover:text-blue-400 transition-colors duration-200">
                                        {{ $category->name }}
                                    </a>
                                </h3>
                                @if($category->description)
                                    <p class="text-gray-300 text-sm mb-4 group-hover:text-gray-200 transition-colors duration-200">{{ $category->description }}</p>
                                @endif
                            </div>

                            @auth
                                @if(auth()->user()->isAdmin())
                                    <div class="flex items-center space-x-2 ml-4 opacity-70  transition-opacity duration-200">
                                        <a href="{{ route('categories.edit', $category) }}" class="text-gray-400 hover:text-blue-400 transform hover:scale-110 transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        @if($category->posts_count == 0)
                                            <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to delete this category?')"
                                                        class="text-gray-400 hover:text-red-400 transform hover:scale-110 transition-all duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            @endauth
                        </div>

                        <!-- Stats -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 text-sm text-gray-400 group-hover:text-gray-300 transition-colors duration-200">
                                <div class="flex items-center transform group-hover:scale-105 transition-transform duration-200">
                                    <svg class="w-4 h-4 mr-1 text-blue-400 group-hover:text-blue-300 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    {{ $category->posts_count }} {{ Str::plural('post', $category->posts_count) }}
                                </div>
                                
                                @if($category->latest_post)
                                    <div class="flex items-center transform group-hover:scale-105 transition-transform duration-200">
                                        <svg class="w-4 h-4 mr-1 text-purple-400 group-hover:text-purple-300 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $category->latest_post->created_at->diffForHumans() }}
                                    </div>
                                @endif
                            </div>

                            <a href="{{ route('categories.show', $category->slug) }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium transform group-hover:translate-x-1 transition-all duration-200 group-hover:scale-105">
                                View Posts →
                            </a>
                        </div>

                        <!-- Latest Post Preview -->
                        @if($category->latest_post)
                            <div class="mt-4 pt-4 border-t border-gray-700">
                                <p class="text-xs text-gray-400 mb-1">Latest post:</p>
                                <a href="{{ route('posts.show', $category->latest_post->slug) }}" 
                                   class="text-sm text-gray-200 hover:text-blue-400 line-clamp-2">
                                    {{ $category->latest_post->title }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="bg-gray-800 border border-gray-700 px-4 py-3 rounded-lg">
                {{ $categories->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-gray-800 border border-gray-700 rounded-lg shadow p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            <h3 class="text-lg font-medium text-white mb-2">No categories yet</h3>
            <p class="text-gray-300 mb-6">Categories help organize posts by topic or theme.</p>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">Create the first category</a>
                @endif
            @endauth
        </div>
    @endif
</div>
@endsection
