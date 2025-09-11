@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Create New Category</h1>
        <p class="text-gray-300 mt-2">Add a new category to organize posts</p>
    </div>

    <!-- Form -->
    <div class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-2xl p-8 mb-8 overflow-hidden group hover:bg-white/8 transition-all duration-300">
        <!-- Dynamic gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-teal-500/10 via-cyan-500/5 to-blue-500/10 opacity-60 transition-opacity duration-300"></div>
        
        <!-- Animated border glow -->
        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-teal-400/20 via-cyan-400/20 to-blue-400/20 opacity-0 blur-sm transition-opacity duration-300"></div>
        
        <!-- Floating creative elements -->
        <div class="absolute top-6 right-6 w-3 h-3 bg-cyan-400/40 rounded-full opacity-50 animate-pulse"></div>
        <div class="absolute top-12 right-16 w-2 h-2 bg-teal-400/30 rounded-full opacity-40 animate-pulse delay-100"></div>
        <div class="absolute top-8 right-24 w-1 h-1 bg-blue-400/50 rounded-full opacity-60 animate-pulse delay-200"></div>
        
        <div class="relative z-10">
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                
                <!-- Name -->
                <div class="mb-6 group/field">
                    <label style="display: flex" for="name" class="text-sm font-medium text-cyan-300 mb-3 flex items-center group-hover/field:text-cyan-200 transition-colors duration-200">
                        <div class="w-5 h-5 bg-gradient-to-r from-cyan-400 to-teal-400 rounded-md flex items-center justify-center mr-2 group-hover/field:scale-110 transition-transform duration-200">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        Category Name
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           placeholder="Enter category name..."
                           class="block w-full bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm py-3 px-4 placeholder-gray-300 focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400/50 hover:bg-white/15 transition-all duration-200 @error('name') border-red-400/50 @else border-white/20 @enderror">
                    @error('name')
                        <p class="mt-2 text-sm text-red-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-400 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Choose a descriptive name that clearly represents the category.
                    </p>
                </div>

                <!-- Description -->
                <div class="mb-6 group/field">
                    <label style="display: flex" for="description" class="text-sm font-medium text-blue-300 mb-3 flex items-center group-hover/field:text-blue-200 transition-colors duration-200">
                        <div class="w-5 h-5 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-md flex items-center justify-center mr-2 group-hover/field:scale-110 transition-transform duration-200">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </div>
                        Description (Optional)
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4" 
                              placeholder="Describe what this category is about..."
                              class="block w-full bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm py-3 px-4 placeholder-gray-300 focus:ring-2 focus:ring-blue-400/50 focus:border-blue-400/50 hover:bg-white/15 transition-all duration-200 @error('description') border-red-400/50 @else border-white/20 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-400 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Help users understand what kind of posts belong in this category.
                    </p>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-white/20">
                    <a href="{{ route('categories.index') }}" class="group/cancel inline-flex items-center px-4 py-2 rounded-lg text-gray-300 hover:text-gray-100 bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 hover:border-white/30 transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4 mr-2 group-hover/cancel:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Cancel
                    </a>
                    
                    <button type="submit" class="group/create inline-flex items-center px-4 py-2 rounded-lg text-cyan-300 hover:text-cyan-200 bg-cyan-500/20 hover:bg-cyan-500/30 backdrop-blur-sm border border-cyan-400/30 hover:border-cyan-400/50 transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4 mr-2 group-hover/create:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tips Section -->
    <div class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-lg p-6 overflow-hidden hover:bg-white/8 transition-all duration-300">
        <!-- Background gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 via-purple-500/5 to-pink-500/10 opacity-60"></div>
        
        <div class="relative z-10">
            <h3 class="text-lg font-medium text-purple-300 mb-4 flex items-center group/tips hover:text-purple-200 transition-colors duration-200">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg flex items-center justify-center mr-3 group-hover/tips:scale-110 transition-transform duration-200">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                Category Guidelines
            </h3>
            <div class="space-y-3 text-sm text-purple-200">
                <div class="flex items-start group/tip hover:text-white transition-colors duration-200">
                    <div class="w-2 h-2 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full mt-2 mr-3 group-hover/tip:scale-125 transition-transform duration-200"></div>
                    <p>Choose clear, descriptive names that users will easily understand</p>
                </div>
                <div class="flex items-start group/tip hover:text-white transition-colors duration-200">
                    <div class="w-2 h-2 bg-gradient-to-r from-pink-400 to-rose-400 rounded-full mt-2 mr-3 group-hover/tip:scale-125 transition-transform duration-200"></div>
                    <p>Keep category names concise but meaningful</p>
                </div>
                <div class="flex items-start group/tip hover:text-white transition-colors duration-200">
                    <div class="w-2 h-2 bg-gradient-to-r from-rose-400 to-red-400 rounded-full mt-2 mr-3 group-hover/tip:scale-125 transition-transform duration-200"></div>
                    <p>Consider how the category will help organize and filter content</p>
                </div>
                <div class="flex items-start group/tip hover:text-white transition-colors duration-200">
                    <div class="w-2 h-2 bg-gradient-to-r from-red-400 to-orange-400 rounded-full mt-2 mr-3 group-hover/tip:scale-125 transition-transform duration-200"></div>
                    <p>The URL slug will be automatically generated from the category name</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
