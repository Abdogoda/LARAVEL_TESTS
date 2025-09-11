@extends('layouts.app')

@section('title', 'Create New Post')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Create New Post</h1>
        <p class="text-gray-300 mt-2">Share your thoughts and ideas with the community</p>
    </div>

    <!-- Form -->
    <div class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-2xl p-8 mb-8 overflow-hidden group hover:bg-white/8 transition-all duration-300">
        <!-- Dynamic gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 via-emerald-500/5 to-teal-500/10 opacity-60 transition-opacity duration-300"></div>
        
        <!-- Animated border glow -->
        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-green-400/20 via-emerald-400/20 to-teal-400/20 opacity-0 blur-sm transition-opacity duration-300"></div>
        
        <!-- Floating creative elements -->
        <div class="absolute top-6 right-6 w-3 h-3 bg-emerald-400/40 rounded-full opacity-50 animate-pulse"></div>
        <div class="absolute top-12 right-16 w-2 h-2 bg-green-400/30 rounded-full opacity-40 animate-pulse delay-100"></div>
        <div class="absolute top-8 right-24 w-1 h-1 bg-teal-400/50 rounded-full opacity-60 animate-pulse delay-200"></div>
        
        <div class="relative z-10">
            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf
                @include('posts._form')
            </form>
        </div>
    </div>

    <!-- Tips Section -->
    <div class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-lg p-6 overflow-hidden hover:bg-white/8 transition-all duration-300">
        <!-- Background gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 via-cyan-500/5 to-indigo-500/10 opacity-60"></div>
        
        <div class="relative z-10">
            <h3 class="text-lg font-medium text-cyan-300 mb-4 flex items-center group/tips hover:text-cyan-200 transition-colors duration-200">
                <div class="w-8 h-8 bg-gradient-to-br from-cyan-400 to-blue-400 rounded-lg flex items-center justify-center mr-3 group-hover/tips:scale-110 transition-transform duration-200">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                Writing Tips
            </h3>
            <div class="space-y-3 text-sm text-cyan-200">
                <div class="flex items-start group/tip hover:text-white transition-colors duration-200">
                    <div class="w-2 h-2 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-full mt-2 mr-3 group-hover/tip:scale-125 transition-transform duration-200"></div>
                    <p>Choose a clear, descriptive title that captures your main idea</p>
                </div>
                <div class="flex items-start group/tip hover:text-white transition-colors duration-200">
                    <div class="w-2 h-2 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-full mt-2 mr-3 group-hover/tip:scale-125 transition-transform duration-200"></div>
                    <p>Select the most appropriate category for better discoverability</p>
                </div>
                <div class="flex items-start group/tip hover:text-white transition-colors duration-200">
                    <div class="w-2 h-2 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-full mt-2 mr-3 group-hover/tip:scale-125 transition-transform duration-200"></div>
                    <p>Use line breaks to make your content easy to read</p>
                </div>
                <div class="flex items-start group/tip hover:text-white transition-colors duration-200">
                    <div class="w-2 h-2 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full mt-2 mr-3 group-hover/tip:scale-125 transition-transform duration-200"></div>
                    <p>Save as draft to continue writing later, or publish immediately</p>
                </div>
                <div class="flex items-start group/tip hover:text-white transition-colors duration-200">
                    <div class="w-2 h-2 bg-gradient-to-r from-pink-400 to-red-400 rounded-full mt-2 mr-3 group-hover/tip:scale-125 transition-transform duration-200"></div>
                    <p>Set a future publication date to schedule your post</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
