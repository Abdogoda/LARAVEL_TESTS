@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white">All Posts</h1>
                <p class="text-gray-300 mt-2">Discover amazing content from our community</p>
            </div>
            @auth
                <a href="{{ route('posts.create') }}" class="btn btn-primary">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Post
                </a>
            @endauth
        </div>
    </div>

    <!-- Filter and Search -->
    <div class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-lg hover:shadow-2xl hover:bg-white/10 transition-all duration-300 mb-8 p-6 overflow-hidden">
        <!-- Animated gradient background -->
        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/10 via-blue-500/5 to-purple-500/10 opacity-60"></div>
        <div class="relative z-10">
            <form method="GET" action="{{ route('posts.index') }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-center sm:space-x-4">
            <!-- Search -->
            <div class="flex-1">
                <label for="search" class="sr-only">Search posts</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           id="search" 
                           value="{{ request('search') }}"
                           placeholder="Search posts..." 
                           class="block w-full pl-10 pr-3 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-md leading-5 placeholder-gray-300 text-white focus:outline-none focus:placeholder-gray-200 focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400/50 sm:text-sm transition-all duration-200 hover:bg-white/15">
                </div>
            </div>

            <!-- Category Filter -->
            <div>
                <select name="category" class="block w-full pl-3 pr-10 py-2 text-base bg-white/10 backdrop-blur-sm border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-purple-400/50 focus:border-purple-400/50 sm:text-sm rounded-md transition-all duration-200 hover:bg-white/15">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort By -->
            <div>
                <select name="sort" class="block w-full pl-3 pr-10 py-2 text-base bg-white/10 backdrop-blur-sm border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:border-blue-400/50 sm:text-sm rounded-md transition-all duration-200 hover:bg-white/15">
                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title A-Z</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="group/filter inline-flex items-center px-6 py-3 rounded-lg text-white font-medium bg-gradient-to-r from-indigo-500/30 to-purple-500/30 hover:from-indigo-500/50 hover:to-purple-500/50 backdrop-blur-sm border border-indigo-400/30 hover:border-purple-400/50 transition-all duration-200 hover:scale-105">
                    <svg class="w-4 h-4 mr-2 group-hover/filter:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z" />
                    </svg>
                    Filter
                </button>
            </div>

            <!-- Clear Filters -->
            @if(request()->hasAny(['search', 'category', 'sort']))
                <div>
                    <a href="{{ route('posts.index') }}" class="text-gray-300 hover:text-cyan-400 transition-colors duration-200 hover:scale-105 transform inline-block">Clear</a>
                </div>
            @endif
        </form>
        </div>
    </div>

    <!-- Posts Grid -->
    @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($posts as $post)
                <article class="group relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-lg hover:shadow-2xl hover:bg-white/10 transition-all duration-300 hover:scale-105 hover:-translate-y-3 overflow-hidden">
                    <!-- Dynamic gradient overlay -->
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 via-cyan-500/5 to-blue-500/10 opacity-0  transition-opacity duration-300"></div>
                    
                    <!-- Animated glow border -->
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-emerald-400/20 via-cyan-400/20 to-blue-400/20 opacity-0  blur-sm transition-opacity duration-300"></div>
                    
                    <!-- Floating particles effect -->
                    <div class="absolute top-4 right-4 w-2 h-2 bg-cyan-400/60 rounded-full opacity-0  transition-opacity duration-300 animate-pulse"></div>
                    <div class="absolute top-6 right-8 w-1 h-1 bg-blue-400/40 rounded-full opacity-0  transition-opacity duration-500 animate-pulse delay-100"></div>
                    
                    <div class="relative p-6 z-10">
                        <!-- Featured Image -->
                        @if($post->image)
                            <div class="mb-4 -mx-6 -mt-6">
                                <img src="{{ asset('storage/' . $post->image) }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @endif
                        
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-emerald-500/20 via-cyan-500/20 to-blue-500/20 text-cyan-300 border border-cyan-400/30 backdrop-blur-sm group-hover:scale-105 transition-transform duration-200">
                                <svg class="w-3 h-3 mr-1.5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                {{ $post->category->name }}
                            </span>
                            @auth
                                @if(auth()->user()->id === $post->user_id)
                                    <div class="flex items-center space-x-2 opacity-70  transition-opacity duration-200">
                                        <a href="{{ route('posts.edit', $post) }}" class="text-gray-400 hover:text-emerald-400 transform hover:scale-110 transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to delete this post?')"
                                                    class="text-gray-400 hover:text-red-400 transform hover:scale-110 transition-all duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        <!-- Title -->
                        <h2 class="text-xl font-semibold text-white mb-3 group-hover:text-cyan-300 transition-colors duration-200">
                            <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-cyan-400 transition-colors duration-200 group-hover:scale-105 inline-block transform">
                                {{ $post->title }}
                            </a>
                        </h2>

                        <!-- Excerpt -->
                        <p class="text-gray-300 mb-4 line-clamp-3 group-hover:text-gray-200 transition-colors duration-200">
                            {{ Str::limit(strip_tags($post->content), 120) }}
                        </p>

                        <!-- Meta Information -->
                        <div class="flex items-center justify-between text-sm text-gray-400 group-hover:text-gray-300 transition-colors duration-200">
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center transform group-hover:scale-105 transition-transform duration-200">
                                    <div class="w-6 h-6 bg-gradient-to-br from-emerald-400 to-cyan-400 rounded-full flex items-center justify-center mr-2">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <span class="text-cyan-300 group-hover:text-cyan-200 transition-colors duration-200">{{ $post->user->name }}</span>
                                </div>
                            </div>
                            <div class="flex items-center transform group-hover:scale-105 transition-transform duration-200">
                                <svg class="w-4 h-4 mr-1 text-blue-400 group-hover:text-blue-300 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                            </div>
                        </div>

                        <!-- Read more link -->
                        <div class="mt-4 pt-4 border-t border-white/10">
                            <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center text-cyan-400 hover:text-cyan-300 text-sm font-medium transform group-hover:translate-x-2 transition-all duration-200 group-hover:scale-105">
                                Continue reading 
                                <svg class="w-4 h-4 ml-1 transform group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 px-4 py-3 rounded-xl shadow-lg hover:bg-white/10 transition-all duration-300">
                {{ $posts->appends(request()->query())->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-lg p-12 text-center overflow-hidden">
            <!-- Background gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-gray-500/5 via-blue-500/5 to-purple-500/5"></div>
            
            <div class="relative z-10">
                <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-gray-400/20 to-blue-400/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-white mb-2">No posts found</h3>
                @if(request()->hasAny(['search', 'category']))
                    <p class="text-gray-300 mb-6">Try adjusting your search or filter criteria.</p>
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary hover:scale-105 transform transition-all duration-200">Clear filters</a>
                @else
                    <p class="text-gray-300 mb-6">Be the first to create a post and share your thoughts!</p>
                    @auth
                        <a href="{{ route('posts.create') }}" class="btn btn-primary hover:scale-105 transform transition-all duration-200">Create the first post</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary hover:scale-105 transform transition-all duration-200">Sign up to create posts</a>
                    @endauth
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
