@extends('layouts.app')

@section('title', $category->name . ' - Posts')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="relative mb-8 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-2xl overflow-hidden group hover:bg-white/8 transition-all duration-300">
        <!-- Dynamic gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 via-indigo-500/5 to-blue-500/10 opacity-60 transition-opacity duration-300"></div>
        
        <!-- Floating elements -->
        <div class="absolute top-4 right-4 w-2 h-2 bg-purple-400/40 rounded-full opacity-50 animate-pulse"></div>
        <div class="absolute top-8 right-8 w-1 h-1 bg-indigo-400/30 rounded-full opacity-40 animate-pulse delay-100"></div>
        <div class="absolute top-6 right-12 w-1.5 h-1.5 bg-blue-400/50 rounded-full opacity-60 animate-pulse delay-200"></div>
        
        <div class="relative z-10 p-8">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <nav class="flex items-center space-x-3 text-sm mb-4 group/nav">
                        <a href="{{ route('categories.index') }}" class="text-purple-300 hover:text-purple-200 flex items-center group-hover/nav:scale-105 transition-all duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Categories
                        </a>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-white font-medium">{{ $category->name }}</span>
                    </nav>
                    
                    <h1 class="text-4xl font-bold  from-white via-purple-200 to-indigo-200 mb-4 group-hover:from-purple-200 group-hover:via-indigo-100 group-hover:to-blue-100 transition-all duration-300">
                        {{ $category->name }}
                    </h1>
                    
                    @if($category->description)
                        <p class="text-gray-200 text-lg mb-3 group-hover:text-gray-100 transition-colors duration-300">{{ $category->description }}</p>
                    @endif
                    
                    <div class="flex items-center text-indigo-300 group-hover:text-indigo-200 transition-colors duration-300">
                        <div class="w-6 h-6 bg-gradient-to-br from-indigo-400 to-purple-400 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="font-medium">{{ $posts->total() }} {{ Str::plural('post', $posts->total()) }} in this category</span>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('posts.create', ['category_id' => $category->id]) }}" class="group/create inline-flex items-center px-6 py-3 rounded-lg text-white font-medium bg-gradient-to-r from-purple-500/30 to-indigo-500/30 hover:from-purple-500/50 hover:to-indigo-500/50 backdrop-blur-sm border border-purple-400/30 hover:border-indigo-400/50 transition-all duration-200 hover:scale-105">
                            <svg class="w-5 h-5 mr-2 group-hover/create:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create Post
                        </a>
                        
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('categories.edit', $category) }}" class="group/edit inline-flex items-center px-4 py-3 rounded-lg text-gray-300 hover:text-white font-medium bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 hover:border-white/40 transition-all duration-200 hover:scale-105">
                                <svg class="w-4 h-4 mr-2 group-hover/edit:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Category
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Sort -->
    <div class="relative mb-8 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-lg overflow-hidden group hover:bg-white/8 transition-all duration-300">
        <!-- Background gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-slate-500/5 via-gray-500/5 to-zinc-500/5 opacity-60"></div>
        
        <div class="relative z-10 p-6">
            <form method="GET" action="{{ route('categories.show', $category->slug) }}" class="flex flex-wrap items-center gap-4">
                <!-- Search -->
                <div class="relative flex-1 min-w-80 group/search">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-hover/search:text-purple-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           id="search" 
                           value="{{ request('search') }}"
                           placeholder="Search posts in {{ $category->name }}..." 
                           class="block w-full pl-12 pr-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 text-white rounded-lg shadow-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-400/50 focus:border-purple-400/50 hover:bg-white/15 transition-all duration-200">
                </div>

                <!-- Sort -->
                <div class="relative group/sort">
                    <select name="sort" class="block pl-4 pr-10 py-3 bg-white/10 backdrop-blur-sm border border-white/20 text-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-400/50 focus:border-purple-400/50 hover:bg-white/15 transition-all duration-200 appearance-none">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title A-Z</option>
                    </select>
                </div>

                <button type="submit" class="group/filter inline-flex items-center px-6 py-3 rounded-lg text-white font-medium bg-gradient-to-r from-indigo-500/30 to-purple-500/30 hover:from-indigo-500/50 hover:to-purple-500/50 backdrop-blur-sm border border-indigo-400/30 hover:border-purple-400/50 transition-all duration-200 hover:scale-105">
                    <svg class="w-4 h-4 mr-2 group-hover/filter:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z" />
                    </svg>
                    Filter
                </button>
                
                @if(request()->hasAny(['search', 'sort']))
                    <a href="{{ route('categories.show', $category->slug) }}" class="group/clear inline-flex items-center px-4 py-3 rounded-lg text-gray-300 hover:text-white font-medium bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 hover:border-white/40 transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4 mr-2 group-hover/clear:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Clear
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Posts -->
    @if($posts->count() > 0)
        <div class="space-y-6 mb-8">
            @foreach($posts as $post)
                <article class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-xl overflow-hidden group hover:bg-white/8 hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
                    <!-- Dynamic gradient overlay -->
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 via-indigo-500/3 to-purple-500/5 opacity-50 group-hover:opacity-80 transition-opacity duration-300"></div>
                    
                    <!-- Floating elements -->
                    <div class="absolute top-4 right-4 w-1.5 h-1.5 bg-blue-400/30 rounded-full opacity-40 animate-pulse"></div>
                    <div class="absolute top-6 right-8 w-1 h-1 bg-indigo-400/40 rounded-full opacity-50 animate-pulse delay-75"></div>
                    
                    <div class="relative z-10 p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <!-- Title -->
                                <h2 class="text-2xl font-bold  from-white via-blue-200 to-indigo-200 mb-4 group-hover:from-blue-200 group-hover:via-indigo-100 group-hover:to-purple-100 transition-all duration-300">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:scale-105 inline-block transition-transform duration-200">
                                        {{ $post->title }}
                                    </a>
                                </h2>

                                <!-- Excerpt -->
                                <p class="text-gray-200 mb-6 line-clamp-3 leading-relaxed group-hover:text-gray-100 transition-colors duration-300">
                                    {{ Str::limit(strip_tags($post->content), 200) }}
                                </p>

                                <!-- Meta -->
                                <div class="flex items-center space-x-6 text-sm">
                                    <div class="flex items-center text-blue-300 hover:text-blue-200 transition-colors duration-200 group/author">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-400 rounded-full flex items-center justify-center mr-3 group-hover/author:scale-110 transition-transform duration-200">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <span class="font-medium">{{ $post->user->name }}</span>
                                    </div>
                                    
                                    <div class="flex items-center text-indigo-300 hover:text-indigo-200 transition-colors duration-200 group/time">
                                        <svg class="w-4 h-4 mr-2 text-indigo-400 group-hover/time:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="font-medium">{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                                    </div>
                                    
                                    <!-- Read More Button -->
                                    <a href="{{ route('posts.show', $post->slug) }}" class="group/read inline-flex items-center px-4 py-2 rounded-lg text-purple-300 hover:text-purple-200 bg-purple-500/20 hover:bg-purple-500/30 backdrop-blur-sm border border-purple-400/30 hover:border-purple-400/50 transition-all duration-200 hover:scale-105">
                                        <span class="font-medium">Read More</span>
                                        <svg class="w-4 h-4 ml-2 group-hover/read:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Actions -->
                            @auth
                                @if(auth()->user()->id === $post->user_id)
                                    <div class="flex items-center space-x-3 ml-6">
                                        <a href="{{ route('posts.edit', $post) }}" class="group/edit p-2 rounded-lg text-blue-400 hover:text-blue-300 bg-blue-500/20 hover:bg-blue-500/30 backdrop-blur-sm border border-blue-400/30 hover:border-blue-400/50 transition-all duration-200 hover:scale-105">
                                            <svg class="w-5 h-5 group-hover/edit:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to delete this post?')"
                                                    class="group/delete p-2 rounded-lg text-red-400 hover:text-red-300 bg-red-500/20 hover:bg-red-500/30 backdrop-blur-sm border border-red-400/30 hover:border-red-400/50 transition-all duration-200 hover:scale-105">
                                                <svg class="w-5 h-5 group-hover/delete:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-lg p-4 overflow-hidden hover:bg-white/8 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-500/5 via-gray-500/5 to-zinc-500/5 opacity-60"></div>
                <div class="relative z-10">
                    {{ $posts->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-2xl overflow-hidden group hover:bg-white/8 transition-all duration-300">
            <!-- Background gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-gray-500/5 via-slate-500/3 to-zinc-500/5 opacity-60"></div>
            
            <!-- Floating elements -->
            <div class="absolute top-6 right-6 w-2 h-2 bg-gray-400/30 rounded-full opacity-40 animate-pulse"></div>
            <div class="absolute top-10 right-10 w-1 h-1 bg-slate-400/40 rounded-full opacity-50 animate-pulse delay-100"></div>
            
            <div class="relative z-10 p-12 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-gray-400 to-slate-400 rounded-xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                
                <h3 class="text-2xl font-bold  from-white via-gray-200 to-slate-200 mb-4 group-hover:from-gray-200 group-hover:via-slate-100 group-hover:to-zinc-100 transition-all duration-300">
                    No posts in this category yet
                </h3>
                
                @if(request('search'))
                    <p class="text-gray-200 mb-6 group-hover:text-gray-100 transition-colors duration-300">No posts found matching "{{ request('search') }}" in {{ $category->name }}.</p>
                    <a href="{{ route('categories.show', $category->slug) }}" class="group/clear inline-flex items-center px-6 py-3 rounded-lg text-white font-medium bg-gradient-to-r from-gray-500/30 to-slate-500/30 hover:from-gray-500/50 hover:to-slate-500/50 backdrop-blur-sm border border-gray-400/30 hover:border-slate-400/50 transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4 mr-2 group-hover/clear:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Clear search
                    </a>
                @else
                    <p class="text-gray-200 mb-6 group-hover:text-gray-100 transition-colors duration-300">Be the first to create a post in {{ $category->name }}!</p>
                    @auth
                        <a href="{{ route('posts.create', ['category' => $category->slug]) }}" class="group/create inline-flex items-center px-6 py-3 rounded-lg text-white font-medium bg-gradient-to-r from-purple-500/30 to-indigo-500/30 hover:from-purple-500/50 hover:to-indigo-500/50 backdrop-blur-sm border border-purple-400/30 hover:border-indigo-400/50 transition-all duration-200 hover:scale-105">
                            <svg class="w-5 h-5 mr-2 group-hover/create:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create the first post
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="group/signup inline-flex items-center px-6 py-3 rounded-lg text-white font-medium bg-gradient-to-r from-green-500/30 to-emerald-500/30 hover:from-green-500/50 hover:to-emerald-500/50 backdrop-blur-sm border border-green-400/30 hover:border-emerald-400/50 transition-all duration-200 hover:scale-105">
                            <svg class="w-5 h-5 mr-2 group-hover/signup:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Sign up to create posts
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
