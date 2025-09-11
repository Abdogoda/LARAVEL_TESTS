@extends('layouts.app')

@section('title', 'Review Post: ' . $post->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="relative mb-8 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/10 via-orange-500/10 to-red-500/10"></div>
        <div class="relative z-10 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-2xl p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold  from-yellow-400 to-orange-400">
                            Review Post
                        </h1>
                        <p class="text-gray-400">Review and moderate content</p>
                    </div>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-500/20 text-gray-300 rounded-lg hover:bg-gray-500/30 transition-colors duration-200 border border-gray-400/30">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Post Content -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-2xl mb-8 overflow-hidden">
        <!-- Post Meta -->
        <div class="px-6 py-4 border-b border-white/10 bg-white/5">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-purple-500/20 to-pink-500/20 text-purple-300 border border-purple-400/30">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        {{ $post->category->name }}
                    </span>
                    
                    <div class="flex items-center text-sm text-gray-300">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-purple-400 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span>{{ $post->user->name }}</span>
                    </div>
                    
                    <div class="flex items-center text-sm text-gray-400">
                        <svg class="w-4 h-4 mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $post->created_at->format('M d, Y \a\t g:i A') }}
                    </div>
                </div>
                
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-yellow-500/20 to-orange-500/20 text-yellow-300 border border-yellow-400/30">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Pending Review
                </span>
            </div>
        </div>

        <!-- Post Content -->
        <div class="p-6">
            <h1 class="text-3xl font-bold text-white mb-6">{{ $post->title }}</h1>
            
            @if($post->image)
                <div class="mb-6 rounded-xl overflow-hidden">
                    <img src="{{ asset('storage/' . $post->image) }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-auto object-cover">
                </div>
            @endif
            
            <div class="prose prose-lg max-w-none prose-invert text-gray-200">
                {!! $post->content !!}
            </div>
        </div>
    </div>

    <!-- Review Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Approve Form -->
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-6 hover:bg-white/8 transition-all duration-300">
            <h3 class="text-xl font-semibold text-green-400 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Approve Post
            </h3>
            <p class="text-gray-400 mb-4">This post meets quality standards and can be published.</p>
            
            <form method="POST" action="{{ route('admin.approve-post', $post) }}">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="approve_notes" class="block text-sm font-medium text-gray-300 mb-2">
                        Admin Notes (Optional)
                    </label>
                    <textarea name="notes" 
                              id="approve_notes"
                              rows="3" 
                              placeholder="Add any notes about this approval..."
                              class="block w-full bg-white/10 border border-white/20 text-white rounded-lg py-2 px-3 placeholder-gray-400 focus:ring-2 focus:ring-green-400/50 focus:border-green-400/50"></textarea>
                </div>
                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white font-medium rounded-lg hover:from-green-600 hover:to-emerald-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Approve & Publish
                </button>
            </form>
        </div>

        <!-- Reject Form -->
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-6 hover:bg-white/8 transition-all duration-300">
            <h3 class="text-xl font-semibold text-red-400 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Reject Post
            </h3>
            <p class="text-gray-400 mb-4">This post needs changes before it can be published.</p>
            
            <form method="POST" action="{{ route('admin.reject-post', $post) }}">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="reject_notes" class="block text-sm font-medium text-gray-300 mb-2">
                        Rejection Reason <span class="text-red-400">*</span>
                    </label>
                    <textarea name="notes" 
                              id="reject_notes"
                              rows="4" 
                              required
                              placeholder="Explain what needs to be changed for the post to be approved..."
                              class="block w-full bg-white/10 border border-white/20 text-white rounded-lg py-2 px-3 placeholder-gray-400 focus:ring-2 focus:ring-red-400/50 focus:border-red-400/50 @error('notes') border-red-400/50 @enderror"></textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-500 to-pink-500 text-white font-medium rounded-lg hover:from-red-600 hover:to-pink-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Reject Post
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
