@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Profile</h1>
        <p class="text-gray-300 mt-2">Manage your account information and settings</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-800 border border-green-700 text-green-100 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gray-800 border border-gray-700 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-400 truncate">My Posts</dt>
                        <dd class="text-lg font-medium text-white">{{ $userPosts->total() }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 border border-gray-700 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-400 truncate">Account Status</dt>
                        <dd class="text-lg font-medium text-white">
                            {{ auth()->user()->isAdmin() ? 'Admin' : 'User' }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Form -->
    <div class="bg-gray-800 border border-gray-700 rounded-lg shadow-lg">
        <div class="px-6 py-4 border-b border-gray-700">
            <h2 class="text-lg font-semibold text-white">Profile Information</h2>
            <p class="text-sm text-gray-400 mt-1">Update your account's profile information and email address.</p>
        </div>
        
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PATCH')
            
            <!-- Avatar Section -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-3">Profile Picture</label>
                <div class="flex items-center space-x-6">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover border-2 border-gray-600 cursor-pointer" onclick="document.getElementById('avatar').click()">
                    @else
                        <div class="w-20 h-20 rounded-full bg-gray-600 flex items-center justify-center border-2 border-gray-500 cursor-pointer" onclick="document.getElementById('avatar').click()">
                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                    <div>
                        <input type="file" name="avatar" id="avatar" accept="image/*" style="display: none">
                    </div>
                </div>
            </div>

            <!-- Profile Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           required>
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           required>
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-300 mb-2">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $user->location) }}" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="City, Country">
                    @error('location')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Website -->
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-300 mb-2">Website</label>
                    <input type="url" name="website" id="website" value="{{ old('website', $user->website) }}" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="https://yourwebsite.com">
                    @error('website')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Bio -->
            <div class="mb-6">
                <label for="bio" class="block text-sm font-medium text-gray-300 mb-2">Bio</label>
                <textarea name="bio" id="bio" rows="4" 
                          class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                          placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                @error('bio')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 text-white text-sm font-medium rounded-md transition-colors duration-200" style="background-color: #2563eb;" onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor='#2563eb'">
                    Update Profile
                </button>
            </div>
        </form>
    </div>

    <!-- Change Password Section -->
    <div class="mt-8 bg-gray-800 border border-gray-700 rounded-lg shadow-lg">
        <div class="px-6 py-4 border-b border-gray-700">
            <h2 class="text-lg font-semibold text-white">Change Password</h2>
            <p class="text-sm text-gray-400 mt-1">Update your password to keep your account secure.</p>
        </div>
        
        <form method="POST" action="{{ route('profile.password') }}" class="p-6">
            @csrf
            @method('PATCH')
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-300 mb-2">Current Password</label>
                    <input type="password" name="current_password" id="current_password" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('current_password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">New Password</label>
                    <input type="password" name="password" id="password" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-4 py-2 text-white text-sm font-medium rounded-md transition-colors duration-200" style="background-color: #dc2626;" onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <!-- Recent Posts -->
    <div class="mt-8 bg-gray-800 border border-gray-700 rounded-lg shadow-lg">
        <div class="px-6 py-4 border-b border-gray-700">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-medium text-white">Your Recent Posts</h2>
                @if($userPosts->count() > 0)
                    <a href="{{ route('posts.create') }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium">
                        Create New Post
                    </a>
                @endif
            </div>
        </div>
        
        @if($userPosts->count() > 0)
            <div class="divide-y divide-gray-700">
                @foreach($userPosts as $post)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-1">
                                    <h3 class="text-sm font-medium text-white">
                                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-400">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    @switch($post->status)
                                        @case('approved')
                                            @if($post->published_at && $post->published_at->isPast())
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-900/50 text-green-300 border border-green-700">
                                                    Published
                                                </span>
                                            @elseif($post->published_at)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-900/50 text-yellow-300 border border-yellow-700">
                                                    Scheduled
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-900/50 text-green-300 border border-green-700">
                                                    Approved
                                                </span>
                                            @endif
                                            @break
                                        @case('pending')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-900/50 text-orange-300 border border-orange-700">
                                                Under Review
                                            </span>
                                            @break
                                        @case('rejected')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-900/50 text-red-300 border border-red-700">
                                                Rejected
                                            </span>
                                            @break
                                        @case('draft')
                                        @default
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-700 text-gray-300 border border-gray-600">
                                                Draft
                                            </span>
                                            @break
                                    @endswitch
                                </div>
                                <div class="flex items-center space-x-4 text-sm text-gray-400">
                                    <span>{{ $post->category->name }}</span>
                                    <span>•</span>
                                    <span>Created {{ $post->created_at->diffForHumans() }}</span>
                                    @if($post->published_at)
                                        <span>•</span>
                                        <span>{{ $post->published_at->isPast() ? 'Published' : 'Scheduled for' }} {{ $post->published_at->format('M d, Y') }}</span>
                                    @endif
                                    @if($post->status === 'pending')
                                        <span>•</span>
                                        <span class="text-orange-400">Awaiting Review</span>
                                    @elseif($post->status === 'rejected' && $post->reviewed_at)
                                        <span>•</span>
                                        <span class="text-red-400">Rejected {{ $post->reviewed_at->diffForHumans() }}</span>
                                    @elseif($post->status === 'approved' && $post->reviewed_at)
                                        <span>•</span>
                                        <span class="text-green-400">Approved {{ $post->reviewed_at->diffForHumans() }}</span>
                                    @endif
                                </div>
                                @if($post->status === 'rejected' && $post->review_notes)
                                    <div class="mt-2 p-2 bg-red-900/20 border border-red-700/30 rounded text-xs text-red-300">
                                        <strong>Review Notes:</strong> {{ $post->review_notes }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('posts.edit', $post) }}" class="text-blue-400 hover:text-blue-300 text-sm">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this post?')"
                                            class="text-red-400 hover:text-red-300 text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($userPosts->hasPages())
                <div class="px-6 py-4 border-t border-gray-700">
                    {{ $userPosts->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-white">No posts yet</h3>
                <p class="mt-1 text-sm text-gray-400">Get started by creating your first blog post.</p>
                <div class="mt-6">
                    <a href="{{ route('posts.index') }}" class="btn btn-primary">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create your first post
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
