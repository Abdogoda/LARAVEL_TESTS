@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="relative mb-8 overflow-hidden">
        <!-- Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-red-500/10 via-orange-500/10 to-yellow-500/10"></div>
        <div class="absolute inset-0"></div>
        
        <!-- Floating particles -->
        <div class="absolute top-4 right-8 w-3 h-3 bg-red-400/40 rounded-full animate-bounce"></div>
        <div class="absolute top-8 right-16 w-2 h-2 bg-orange-400/30 rounded-full animate-bounce delay-100"></div>
        <div class="absolute top-6 right-24 w-1 h-1 bg-yellow-400/50 rounded-full animate-bounce delay-200"></div>
        
        <div class="relative z-10 bg-white/5 border border-white/10 rounded-xl shadow-2xl p-8">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-orange-400 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold  from-red-400 via-orange-400 to-yellow-400">
                        Admin Dashboard
                    </h1>
                    <p class="text-gray-300 text-lg">Manage post reviews and content moderation</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white/5 border border-white/10 rounded-xl p-6 hover:bg-white/8 transition-all duration-300">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Pending Review</p>
                    <p class="text-2xl font-bold text-yellow-400">{{ $pendingPosts->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white/5 border border-white/10 rounded-xl p-6 hover:bg-white/8 transition-all duration-300">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-400 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Approved</p>
                    <p class="text-2xl font-bold text-green-400">{{ $approvedPosts->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white/5 border border-white/10 rounded-xl p-6 hover:bg-white/8 transition-all duration-300">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-red-400 to-pink-400 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Rejected</p>
                    <p class="text-2xl font-bold text-red-400">{{ $rejectedPosts->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white/5 border border-white/10 rounded-xl p-6 hover:bg-white/8 transition-all duration-300">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-indigo-400 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-.707.414l-4 1a1 1 0 01-1.263-1.263l1-4a2 2 0 01.414-.707zM7 20h10M5 20a2 2 0 002-2v-1a2 2 0 012-2h6a2 2 0 012 2v1a2 2 0 002 2" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Total Writers</p>
                    <p class="text-2xl font-bold text-purple-400">{{ $totalWriters }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Posts -->
    @if($pendingPosts->count() > 0)
    <div class="bg-white/5 border border-white/10 rounded-xl shadow-2xl mb-8 overflow-hidden">
        <div class="px-6 py-4 border-b border-white/10 bg-gradient-to-r from-yellow-500/10 to-orange-500/10">
            <h2 class="text-xl font-bold text-yellow-400 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Posts Pending Review
            </h2>
        </div>
        <div class="divide-y divide-white/10">
            @foreach($pendingPosts as $post)
            <div class="p-6 hover:bg-white/5 transition-colors duration-200">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-4 mb-3">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-16 h-16 object-cover rounded-lg border border-white/20">
                            @else
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-500 to-gray-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-1">{{ $post->title }}</h3>
                                <p class="text-sm text-gray-400">
                                    By {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                                </p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-500/20 text-purple-300 border border-purple-400/30 mt-1">
                                    {{ $post->category->name }}
                                </span>
                            </div>
                        </div>
                        <p class="text-gray-300 mb-4">{{ Str::limit(strip_tags($post->content), 150) }}</p>
                    </div>
                    <div class="flex items-center space-x-2 ml-4">
                        <a href="{{ route('posts.show', $post->slug) }}" 
                           class="inline-flex items-center px-3 py-2 bg-blue-500/20 text-blue-300 rounded-lg hover:bg-blue-500/30 transition-colors duration-200 border border-blue-400/30">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View
                        </a>
                        <a href="{{ route('admin.review-post', $post) }}" 
                           class="inline-flex items-center px-3 py-2 bg-yellow-500/20 text-yellow-300 rounded-lg hover:bg-yellow-500/30 transition-colors duration-200 border border-yellow-400/30">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Review
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="px-6 py-4 border-t border-white/10">
            {{ $pendingPosts->links() }}
        </div>
    </div>
    @else
    <div class="bg-white/5 border border-white/10 rounded-xl p-8 text-center mb-8">
        <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-400 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-300 mb-2">All Caught Up!</h3>
        <p class="text-gray-400">No posts pending review at the moment.</p>
    </div>
    @endif

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recently Approved -->
        @if($approvedPosts->count() > 0)
        <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-white/10 bg-gradient-to-r from-green-500/10 to-emerald-500/10">
                <h3 class="text-lg font-semibold text-green-400 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Recently Approved
                </h3>
            </div>
            <div class="divide-y divide-white/10">
                @foreach($approvedPosts as $post)
                <div class="p-4">
                    <h4 class="font-medium text-white mb-1">{{ $post->title }}</h4>
                    <p class="text-sm text-gray-400">
                        By {{ $post->user->name }} • Approved {{ $post->reviewed_at ? $post->reviewed_at->diffForHumans() : 'recently' }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Recently Rejected -->
        @if($rejectedPosts->count() > 0)
        <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-white/10 bg-gradient-to-r from-red-500/10 to-pink-500/10">
                <h3 class="text-lg font-semibold text-red-400 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Recently Rejected
                </h3>
            </div>
            <div class="divide-y divide-white/10">
                @foreach($rejectedPosts as $post)
                <div class="p-4">
                    <h4 class="font-medium text-white mb-1">{{ $post->title }}</h4>
                    <p class="text-sm text-gray-400">
                        By {{ $post->user->name }} • Rejected {{ $post->reviewed_at ? $post->reviewed_at->diffForHumans() : 'recently' }}
                    </p>
                    @if($post->review_notes)
                        <p class="text-xs text-red-300 mt-1">{{ Str::limit($post->review_notes, 100) }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
