@extends('layouts.app')

@section('title', 'Edit Post: ' . $post->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white">Edit Post</h1>
                <p class="text-gray-300 mt-2">Update your post content and settings</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('posts.show', $post->slug) }}" class="group/view inline-flex items-center px-4 py-2 rounded-lg text-blue-300 hover:text-blue-200 bg-blue-500/20 hover:bg-blue-500/30 backdrop-blur-sm border border-blue-400/30 hover:border-blue-400/50 transition-all duration-200 hover:scale-105">
                    <svg class="w-4 h-4 mr-2 group-hover/view:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View Post
                </a>
            </div>
        </div>
    </div>

    <!-- Post Status -->
    <div class="relative mb-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-lg p-4 overflow-hidden hover:bg-white/8 transition-all duration-300">
        <!-- Background gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-slate-500/5 via-gray-500/5 to-zinc-500/5 opacity-60"></div>
        
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <div class="flex items-center group/status">
                        <span class="text-sm font-medium text-gray-200 mr-3">Status:</span>
                        @if($post->status === 'approved' && $post->published_at && $post->published_at->isPast())
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-green-500/20 to-emerald-500/20 text-emerald-300 border border-emerald-400/30 backdrop-blur-sm group-hover/status:scale-105 transition-transform duration-200">
                                <div class="w-2 h-2 bg-emerald-400 rounded-full mr-2 animate-pulse"></div>
                                Published
                            </span>
                        @elseif($post->status === 'approved' && $post->published_at && $post->published_at->isFuture())
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-blue-500/20 to-indigo-500/20 text-blue-300 border border-blue-400/30 backdrop-blur-sm group-hover/status:scale-105 transition-transform duration-200">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></div>
                                Scheduled
                            </span>
                        @elseif($post->status === 'pending')
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-yellow-500/20 to-orange-500/20 text-yellow-300 border border-yellow-400/30 backdrop-blur-sm group-hover/status:scale-105 transition-transform duration-200">
                                <div class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></div>
                                Pending Review
                            </span>
                        @elseif($post->status === 'rejected')
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-red-500/20 to-rose-500/20 text-red-300 border border-red-400/30 backdrop-blur-sm group-hover/status:scale-105 transition-transform duration-200">
                                <div class="w-2 h-2 bg-red-400 rounded-full mr-2"></div>
                                Rejected
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-gray-500/20 to-slate-500/20 text-gray-300 border border-gray-400/30 backdrop-blur-sm group-hover/status:scale-105 transition-transform duration-200">
                                <div class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                                Draft
                            </span>
                        @endif
                    </div>
                    @if($post->published_at)
                        <div class="text-sm text-gray-300 flex items-center group/pub hover:text-purple-300 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2 text-purple-400 group-hover/pub:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <span class="font-medium">Publication:</span>
                                {{ $post->published_at->format('M d, Y \a\t g:i A') }}
                                @if($post->published_at->isFuture())
                                    <span class="text-purple-400">({{ $post->published_at->diffForHumans() }})</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <div class="text-sm text-gray-400 flex items-center group/update hover:text-cyan-300 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2 text-cyan-400 group-hover/update:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span><span class="font-medium">Last updated:</span> {{ $post->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-2xl p-8 mb-8 overflow-hidden group hover:bg-white/8 transition-all duration-300">
        <div class="relative z-10">
            <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('posts._form')
            </form>
        </div>
    </div>

    <!-- Delete Section -->
    <div class="relative bg-white/5 backdrop-blur-sm border border-red-400/20 rounded-xl shadow-lg p-6 overflow-hidden hover:bg-red-500/10 transition-all duration-300">
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-red-300 flex items-center mb-2">
                        <div class="w-6 h-6 bg-gradient-to-r from-red-400 to-rose-400 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        Delete Post
                    </h3>
                    <p class="text-sm text-red-200">
                        Permanently delete this post. This action cannot be undone.
                    </p>
                </div>
                <form method="POST" action="{{ route('posts.destroy', $post) }}" class="ml-6">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to delete this post? This action cannot be undone.')"
                            class="group/delete inline-flex items-center px-4 py-2 rounded-lg text-red-300 hover:text-red-200 bg-red-500/20 hover:bg-red-500/30 backdrop-blur-sm border border-red-400/30 hover:border-red-400/50 transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4 mr-2 group-hover/delete:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete Post
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
