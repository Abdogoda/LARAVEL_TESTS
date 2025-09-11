@extends('layouts.app')

@section('title', 'Edit Category: ' . $category->name)

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="relative mb-8 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-2xl overflow-hidden group hover:bg-white/8 transition-all duration-300">
        <!-- Dynamic gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 via-indigo-500/5 to-purple-500/10 opacity-60 transition-opacity duration-300"></div>
        
        <!-- Floating elements -->
        <div class="absolute top-4 right-4 w-2 h-2 bg-blue-400/40 rounded-full opacity-50 animate-pulse"></div>
        <div class="absolute top-8 right-8 w-1 h-1 bg-indigo-400/30 rounded-full opacity-40 animate-pulse delay-100"></div>
        <div class="absolute top-6 right-12 w-1.5 h-1.5 bg-purple-400/50 rounded-full opacity-60 animate-pulse delay-200"></div>
        
        <div class="relative z-10 p-8">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-white via-blue-200 to-indigo-200 mb-4 group-hover:from-blue-200 group-hover:via-indigo-100 group-hover:to-purple-100 transition-all duration-300">
                        Edit Category
                    </h1>
                    <p class="text-gray-200 text-lg group-hover:text-gray-100 transition-colors duration-300">Update category details and settings</p>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('categories.show', $category->slug) }}" class="group/view inline-flex items-center px-4 py-3 rounded-lg text-white font-medium bg-gradient-to-r from-blue-500/30 to-indigo-500/30 hover:from-blue-500/50 hover:to-indigo-500/50 backdrop-blur-sm border border-blue-400/30 hover:border-indigo-400/50 transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4 mr-2 group-hover/view:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        View Category
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Stats -->
    <div class="relative mb-8 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-lg overflow-hidden group hover:bg-white/8 transition-all duration-300">
        <!-- Background gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 via-teal-500/3 to-cyan-500/5 opacity-60"></div>
        
        <!-- Floating elements -->
        <div class="absolute top-3 right-3 w-1.5 h-1.5 bg-emerald-400/40 rounded-full opacity-50 animate-pulse"></div>
        <div class="absolute top-5 right-6 w-1 h-1 bg-teal-400/30 rounded-full opacity-40 animate-pulse delay-150"></div>
        
        <div class="relative z-10 p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-6">
                    <div class="flex items-center text-emerald-300 hover:text-emerald-200 transition-colors duration-200 group/posts">
                        <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-teal-400 rounded-lg flex items-center justify-center mr-3 group-hover/posts:scale-110 transition-transform duration-200">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="font-medium">{{ $category->posts()->count() }} {{ Str::plural('post', $category->posts()->count()) }}</span>
                    </div>
                    
                    <div class="flex items-center text-teal-300 hover:text-teal-200 transition-colors duration-200 group/date">
                        <div class="w-8 h-8 bg-gradient-to-br from-teal-400 to-cyan-400 rounded-lg flex items-center justify-center mr-3 group-hover/date:scale-110 transition-transform duration-200">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="font-medium">Created {{ $category->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
                
                <div class="flex items-center text-cyan-300 group/slug hover:text-cyan-200 transition-colors duration-200">
                    <span class="text-sm font-medium mr-2">Slug:</span>
                    <code class="bg-white/10 backdrop-blur-sm border border-cyan-400/30 px-3 py-1 rounded-lg text-xs font-mono text-cyan-200 group-hover/slug:bg-white/20 group-hover/slug:border-cyan-400/50 transition-all duration-200">{{ $category->slug }}</code>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-2xl overflow-hidden group hover:bg-white/8 transition-all duration-300 mb-8">
        <!-- Dynamic gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 via-indigo-500/5 to-blue-500/10 opacity-60 transition-opacity duration-300"></div>
        
        <!-- Floating elements -->
        <div class="absolute top-6 right-6 w-2 h-2 bg-purple-400/40 rounded-full opacity-50 animate-pulse"></div>
        <div class="absolute top-10 right-10 w-1 h-1 bg-indigo-400/30 rounded-full opacity-40 animate-pulse delay-100"></div>
        <div class="absolute top-8 right-14 w-1.5 h-1.5 bg-blue-400/50 rounded-full opacity-60 animate-pulse delay-200"></div>
        
        <div class="relative z-10 p-8">
            <form method="POST" action="{{ route('categories.update', $category) }}">
                @csrf
                @method('PUT')
                
                <!-- Name -->
                <div class="mb-8 group/field">
                    <label style="display: flex" for="name" class="text-lg font-medium text-purple-300 mb-4 flex items-center group-hover/field:text-purple-200 transition-colors duration-200">
                        <div class="w-6 h-6 bg-gradient-to-r from-purple-400 to-indigo-400 rounded-lg flex items-center justify-center mr-3 group-hover/field:scale-110 transition-transform duration-200">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        Category Name
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $category->name) }}"
                           placeholder="Enter category name..."
                           @class([
                               'block w-full px-4 py-3 bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-400/50 focus:border-purple-400/50 hover:bg-white/15 transition-all duration-200',
                               'border-red-400/50' => $errors->has('name'),
                               'border-white/20' => !$errors->has('name')
                           ])>
                    @error('name')
                        <p class="mt-3 text-sm text-red-400 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-sm text-indigo-300 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        The URL slug will be updated if you change the name.
                    </p>
                </div>

                <!-- Description -->
                <div class="mb-8 group/field">
                    <label style="display: flex" for="description" class="text-lg font-medium text-indigo-300 mb-4 flex items-center group-hover/field:text-indigo-200 transition-colors duration-200">
                        <div class="w-6 h-6 bg-gradient-to-r from-indigo-400 to-blue-400 rounded-lg flex items-center justify-center mr-3 group-hover/field:scale-110 transition-transform duration-200">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </div>
                        Description (Optional)
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4" 
                              placeholder="Describe what this category is about..."
                              @class([
                                  'block w-full px-4 py-3 bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400/50 focus:border-indigo-400/50 hover:bg-white/15 transition-all duration-200 resize-none',
                                  'border-red-400/50' => $errors->has('description'),
                                  'border-white/20' => !$errors->has('description')
                              ])>{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="mt-3 text-sm text-red-400 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-sm text-blue-300 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Help users understand what kind of posts belong in this category.
                    </p>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-white/20">
                    <a href="{{ route('categories.index') }}" class="group/cancel inline-flex items-center px-6 py-3 rounded-lg text-gray-300 hover:text-white font-medium bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 hover:border-white/40 transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4 mr-2 group-hover/cancel:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Cancel
                    </a>
                    
                    <button type="submit" class="group/update inline-flex items-center px-6 py-3 rounded-lg text-white font-medium bg-gradient-to-r from-purple-500/30 to-indigo-500/30 hover:from-purple-500/50 hover:to-indigo-500/50 backdrop-blur-sm border border-purple-400/30 hover:border-indigo-400/50 transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4 mr-2 group-hover/update:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Section -->
    @if($category->posts()->count() === 0)
        <div class="relative bg-white/5 backdrop-blur-sm border border-red-400/20 rounded-xl shadow-lg overflow-hidden hover:bg-red-500/10 transition-all duration-300">
            <!-- Background gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-red-500/10 via-rose-500/5 to-pink-500/10 opacity-60 transition-opacity duration-300"></div>
            
            <!-- Floating elements -->
            <div class="absolute top-4 right-4 w-2 h-2 bg-red-400/40 rounded-full opacity-50 animate-pulse"></div>
            <div class="absolute top-8 right-8 w-1 h-1 bg-rose-400/30 rounded-full opacity-40 animate-pulse delay-100"></div>
            <div class="absolute top-6 right-12 w-1.5 h-1.5 bg-pink-400/50 rounded-full opacity-60 animate-pulse delay-200"></div>
            
            <div class="relative z-10 p-8">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-300 via-rose-300 to-pink-300 mb-3 flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-r from-red-400 to-rose-400 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            Delete Category
                        </h3>
                        <p class="text-red-200 hover:text-red-100 transition-colors duration-300">
                            Permanently delete this category. This action cannot be undone.
                        </p>
                    </div>
                    <form method="POST" action="{{ route('categories.destroy', $category) }}" class="ml-6">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to delete this category? This action cannot be undone.')"
                                class="group/delete inline-flex items-center px-6 py-3 rounded-lg text-red-300 hover:text-red-200 bg-red-500/20 hover:bg-red-500/30 backdrop-blur-sm border border-red-400/30 hover:border-red-400/50 transition-all duration-200 hover:scale-105">
                            <svg class="w-4 h-4 mr-2 group-hover/delete:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete Category
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="relative bg-white/5 backdrop-blur-sm border border-yellow-400/20 rounded-xl shadow-lg overflow-hidden hover:bg-yellow-500/10 transition-all duration-300">
            <!-- Background gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/10 via-amber-500/5 to-orange-500/10 opacity-60 transition-opacity duration-300"></div>
            
            <!-- Floating elements -->
            <div class="absolute top-4 right-4 w-2 h-2 bg-yellow-400/40 rounded-full opacity-50 animate-pulse"></div>
            <div class="absolute top-8 right-8 w-1 h-1 bg-amber-400/30 rounded-full opacity-40 animate-pulse delay-100"></div>
            <div class="absolute top-6 right-12 w-1.5 h-1.5 bg-orange-400/50 rounded-full opacity-60 animate-pulse delay-200"></div>
            
            <div class="relative z-10 p-8">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-yellow-400 to-amber-400 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-amber-300 to-orange-300 mb-2">
                            Cannot Delete Category
                        </h3>
                        <p class="text-yellow-200 hover:text-yellow-100 transition-colors duration-300">
                            This category has {{ $category->posts()->count() }} {{ Str::plural('post', $category->posts()->count()) }}. 
                            Delete or move all posts before deleting the category.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
