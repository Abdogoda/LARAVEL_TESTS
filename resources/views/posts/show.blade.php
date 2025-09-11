@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <article class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-2xl overflow-hidden mb-8 group hover:bg-white/8 transition-all duration-300">
        <div class="relative z-10 px-6 py-4 border-b border-white/10 bg-white/5">
            <div class="flex items-center justify-between">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="inline-flex items-center px-3 py-1 mr-1 rounded-full text-xs font-medium bg-gradient-to-r from-indigo-500/20 via-purple-500/20 to-pink-500/20 text-purple-300 border border-purple-400/30 backdrop-blur-sm hover:scale-105 transition-transform duration-200">
                        <svg class="w-4 h-4 mr-1 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <a href="{{ route('posts.index', ['category' => $post->category->slug]) }}" class="hover:text-purple-200 transition-colors duration-200">
                            {{ $post->category->name }}
                        </a>
                    </span>
                    
                    <!-- Post Status Badge -->
                    <div class="flex items-center group/status">
                        @if($post->status === 'approved' && $post->published_at && $post->published_at->isPast())
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-green-500/20 to-emerald-500/20 text-emerald-300 border border-emerald-400/30 backdrop-blur-sm group-hover/status:scale-105 transition-transform duration-200">
                                <div class="w-2 h-2 bg-emerald-400 rounded-full mr-1 animate-pulse"></div>
                                Published
                            </span>
                        @elseif($post->status === 'approved' && $post->published_at && $post->published_at->isFuture())
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-blue-500/20 to-indigo-500/20 text-blue-300 border border-blue-400/30 backdrop-blur-sm group-hover/status:scale-105 transition-transform duration-200">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-1 animate-pulse"></div>
                                Scheduled
                            </span>
                        @elseif($post->status === 'pending')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-yellow-500/20 to-orange-500/20 text-yellow-300 border border-yellow-400/30 backdrop-blur-sm group-hover/status:scale-105 transition-transform duration-200">
                                <div class="w-2 h-2 bg-yellow-400 rounded-full mr-1 animate-pulse"></div>
                                Pending
                            </span>
                        @elseif($post->status === 'rejected')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-red-500/20 to-rose-500/20 text-red-300 border border-red-400/30 backdrop-blur-sm group-hover/status:scale-105 transition-transform duration-200">
                                <div class="w-2 h-2 bg-red-400 rounded-full mr-1"></div>
                                Rejected
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-gray-500/20 to-slate-500/20 text-gray-300 border border-gray-400/30 backdrop-blur-sm group-hover/status:scale-105 transition-transform duration-200">
                                <div class="w-2 h-2 bg-gray-400 rounded-full mr-1"></div>
                                Draft
                            </span>
                        @endif
                    </div>
                </div>

                @auth
                <div class="flex items-center space-x-4">
                          @if(auth()->user()->id === $post->user_id)
                            <a href="{{ route('posts.edit', $post) }}" class="group/edit inline-flex items-center px-2 py-1 rounded-lg text-indigo-400 hover:text-indigo-300 text-sm font-medium bg-indigo-500/20 hover:bg-indigo-500/30 border border-indigo-400/30 hover:border-indigo-400/50 backdrop-blur-sm transition-all duration-200 hover:scale-105">
                              <svg class="w-4 h-4 mr-1.5 group-hover/edit:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                              </svg>
                              Edit
                            </a>
                          @endif
                          @if (auth()->user()->id === $post->user_id || auth()->user()->isAdmin())
                            <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this post?')"
                                        class="group/delete inline-flex items-center px-2 py-1 rounded-lg text-red-400 hover:text-red-300 text-sm font-medium bg-red-500/20 hover:bg-red-500/30 border border-red-400/30 hover:border-red-400/50 backdrop-blur-sm transition-all duration-200 hover:scale-105">
                                    <svg class="w-4 h-4 mr-1.5 group-hover/delete:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                            @endif
                        </div>
                @endauth
            </div>
        </div>

        <!-- Post Content -->
        <div class="relative z-10 px-6 py-8">
            <!-- Author Info -->
            <div style="padding-bottom: 10px" class="flex items-center gap-2 mb-6 border-b border-white/10">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-purple-400 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-indigo-300 hover:text-indigo-200 transition-colors duration-200">{{ $post->user->name }}</h3>
                    <p class="text-sm text-gray-400 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Published {{ $post->published_at ? $post->published_at->format('M d, Y \a\t g:i A') : $post->created_at->format('M d, Y \a\t g:i A') }}
                    </p>
                </div>
            </div>

            <h1 class="text-4xl font-bold  from-white via-purple-200 to-pink-200 mb-6 group-hover:from-indigo-200 group-hover:via-purple-100 group-hover:to-pink-100 transition-all duration-300">
                {{ $post->title }}
            </h1>
            
            <!-- Featured Image -->
            @if($post->image)
                <div class="mb-8 rounded-xl overflow-hidden bg-white/5 border border-white/10 hover:scale-[1.02] transition-transform duration-300">
                    <img src="{{ asset('storage/' . $post->image) }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-auto object-cover">
                </div>
            @endif
            
            <div class="prose prose-lg max-w-none prose-invert text-gray-200 group-hover:text-gray-100 transition-colors duration-300">
                {!! $post->content !!}
            </div>
        </div>
    </article>

    <!-- Navigation -->
    <div class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-lg p-6 mb-8 overflow-hidden hover:bg-white/8 transition-all duration-300">
        <!-- Background gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-slate-500/5 via-gray-500/5 to-zinc-500/5 opacity-60"></div>
        
        <div class="relative z-10 flex justify-between items-center">
            <div class="flex-1">
                @if($previousPost)
                    <div class="text-left group/prev">
                        <p class="text-sm text-gray-400 mb-2 group-hover/prev:text-indigo-400 transition-colors duration-200">Previous Post</p>
                        <a href="{{ route('posts.show', $previousPost->slug) }}" 
                           class="inline-flex items-center text-indigo-400 hover:text-indigo-300 font-medium group-hover/prev:scale-105 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2 group-hover/prev:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            {{ Str::limit($previousPost->title, 40) }}
                        </a>
                    </div>
                @endif
            </div>
            
            <div class="flex-shrink-0 mx-6">
                <a href="{{ route('posts.index') }}" class="group/all inline-flex items-center px-4 py-2 rounded-lg btn btn-secondary bg-white/10 backdrop-blur-sm border-white/20 hover:bg-white/20 hover:scale-105 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2 group-hover/all:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z" />
                    </svg>
                    All Posts
                </a>
            </div>

            <div class="flex-1 text-right">
                @if($nextPost)
                    <div class="text-right group/next">
                        <p class="text-sm text-gray-400 mb-2 group-hover/next:text-purple-400 transition-colors duration-200">Next Post</p>
                        <a href="{{ route('posts.show', $nextPost->slug) }}" 
                           class="inline-flex items-center text-purple-400 hover:text-purple-300 font-medium group-hover/next:scale-105 transition-all duration-200">
                            {{ Str::limit($nextPost->title, 40) }}
                            <svg class="w-4 h-4 ml-2 group-hover/next:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
