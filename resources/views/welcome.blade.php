@extends('layouts.app')

@section('title', 'Welcome to BlogMaster Pro')

@section('content')
<div class="relative min-h-screen overflow-hidden">
    <!-- Animated Background -->
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-purple-900/20 to-slate-900"></div>
        <!-- Floating particles -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-40 right-20 w-96 h-96 bg-cyan-500/8 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute bottom-20 left-1/3 w-80 h-80 bg-pink-500/8 rounded-full blur-3xl animate-pulse delay-2000"></div>
        <!-- Grid pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.03"%3E%3Cpath d="m36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10">
        <!-- Hero Section -->
        <section class="relative pb-20 lg:pb-32 px-4 sm:px-6 lg:px-8">
            <!-- Floating decorative elements -->
            <div class="absolute top-8 right-8 w-3 h-3 bg-purple-400/40 rounded-full animate-bounce"></div>
            <div class="absolute top-12 right-16 w-2 h-2 bg-cyan-400/30 rounded-full animate-bounce delay-100"></div>
            <div class="absolute top-6 right-24 w-1 h-1 bg-pink-400/50 rounded-full animate-bounce delay-200"></div>
            
            <div class="max-w-7xl mx-auto">
                <!-- Hero Content -->
                <div class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl shadow-2xl overflow-hidden group hover:bg-white/8 transition-all duration-500">
                    <!-- Gradient overlay -->
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 via-cyan-500/5 to-pink-500/10 opacity-60  transition-opacity duration-500"></div>
                    
                    <div class="relative z-10 p-8 lg:p-16 text-center">
                        <div class="mb-8">
                            <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-cyan-400 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                        </div>
                        
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-8  from-purple-400 via-cyan-400 to-pink-400 group-hover:scale-105 transition-transform duration-300">
                            BlogMaster Pro
                        </h1>
                        
                        <p class="text-xl lg:text-2xl text-gray-300 max-w-4xl mx-auto mb-12 leading-relaxed group-hover:text-gray-200 transition-colors duration-300">
                            Where stories come to life. Create, share, and discover extraordinary content with our advanced blogging platform featuring 
                            <span class="text-purple-400 font-semibold">admin moderation</span>, 
                            <span class="text-cyan-400 font-semibold">rich media support</span>, and 
                            <span class="text-pink-400 font-semibold">beautiful design</span>.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                            @auth
                                <a href="{{ route('posts.create') }}" class="group/btn relative bg-gradient-to-r from-purple-500 to-cyan-500 text-white p-4 rounded-xl font-semibold  shadow-2xl hover:shadow-purple-500/25 transition-all duration-300 hover:scale-105 transform">
                                    <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-cyan-600 rounded-xl opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                                    <div class="relative flex items-center">
                                        <svg class="w-6 h-6 mr-3 group-hover/btn:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Start Writing Now
                                    </div>
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="group/btn relative bg-white/10 backdrop-blur-sm border border-white/20 text-white p-4 rounded-xl font-semibold  hover:bg-white/15 transition-all duration-300 hover:scale-105 transform">
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 mr-3 group-hover/btn:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            Admin Dashboard
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ route('profile.show') }}" class="group/btn relative bg-white/10 backdrop-blur-sm border border-white/20 text-white p-4 rounded-xl font-semibold  hover:bg-white/15 transition-all duration-300 hover:scale-105 transform">
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 mr-3 group-hover/btn:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                            My Profile
                                        </div>
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('register') }}" class="group/btn relative bg-gradient-to-r from-purple-500 to-cyan-500 text-white p-4 rounded-xl font-semibold  shadow-2xl hover:shadow-purple-500/25 transition-all duration-300 hover:scale-105 transform">
                                    <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-cyan-600 rounded-xl opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                                    <div class="relative flex items-center">
                                        <svg class="w-6 h-6 mr-3 group-hover/btn:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                        Join the Community
                                    </div>
                                </a>
                                <a href="{{ route('posts.index') }}" class="group/btn relative bg-white/10 backdrop-blur-sm border border-white/20 text-white p-4 rounded-xl font-semibold  hover:bg-white/15 transition-all duration-300 hover:scale-105 transform">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 mr-3 group-hover/btn:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Explore Posts
                                    </div>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-5xl font-bold  from-purple-400 via-cyan-400 to-pink-400 mb-6">
                        Powerful Features
                    </h2>
                    <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                        Everything you need to create, manage, and share exceptional content
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Admin Moderation -->
                    <div class="group relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 hover:bg-white/8 hover:scale-105 transition-all duration-500 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-red-500/10 to-orange-500/10 opacity-0  transition-opacity duration-500"></div>
                        <div class="absolute top-4 right-4 w-2 h-2 bg-red-400/40 rounded-full animate-pulse"></div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-orange-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-4 group-hover:text-red-300 transition-colors duration-300">
                                Admin Review System
                            </h3>
                            <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                                Content moderation with approval workflow, rejection feedback, and quality control to maintain high standards.
                            </p>
                        </div>
                    </div>

                    <!-- Rich Media -->
                    <div class="group relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 hover:bg-white/8 hover:scale-105 transition-all duration-500 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-pink-500/10 opacity-0  transition-opacity duration-500"></div>
                        <div class="absolute top-4 right-4 w-2 h-2 bg-purple-400/40 rounded-full animate-pulse delay-100"></div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-4 group-hover:text-purple-300 transition-colors duration-300">
                                Image & Media Support
                            </h3>
                            <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                                Upload and showcase images, with automatic optimization and responsive display across all devices.
                            </p>
                        </div>
                    </div>

                    <!-- Rich Text Editor -->
                    <div class="group relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 hover:bg-white/8 hover:scale-105 transition-all duration-500 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-blue-500/10 opacity-0  transition-opacity duration-500"></div>
                        <div class="absolute top-4 right-4 w-2 h-2 bg-cyan-400/40 rounded-full animate-pulse delay-200"></div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-gradient-to-br from-cyan-400 to-blue-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-4 group-hover:text-cyan-300 transition-colors duration-300">
                                CKEditor Integration
                            </h3>
                            <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                                Professional rich text editor with formatting, tables, links, and advanced content creation tools.
                            </p>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="group relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 hover:bg-white/8 hover:scale-105 transition-all duration-500 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-500/10 opacity-0  transition-opacity duration-500"></div>
                        <div class="absolute top-4 right-4 w-2 h-2 bg-green-400/40 rounded-full animate-pulse delay-300"></div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-4 group-hover:text-green-300 transition-colors duration-300">
                                Smart Categories
                            </h3>
                            <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                                Organize content with intelligent categorization, filtering, and discovery features for better content navigation.
                            </p>
                        </div>
                    </div>

                    <!-- User Management -->
                    <div class="group relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 hover:bg-white/8 hover:scale-105 transition-all duration-500 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 opacity-0  transition-opacity duration-500"></div>
                        <div class="absolute top-4 right-4 w-2 h-2 bg-indigo-400/40 rounded-full animate-pulse delay-500"></div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-gradient-to-br from-indigo-400 to-purple-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-4 group-hover:text-indigo-300 transition-colors duration-300">
                                User Roles & Permissions
                            </h3>
                            <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                                Role-based access control with admin and user permissions, secure authentication and profile management.
                            </p>
                        </div>
                    </div>

                    <!-- Modern UI -->
                    <div class="group relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 hover:bg-white/8 hover:scale-105 transition-all duration-500 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/10 to-orange-500/10 opacity-0  transition-opacity duration-500"></div>
                        <div class="absolute top-4 right-4 w-2 h-2 bg-yellow-400/40 rounded-full animate-pulse delay-700"></div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-4 group-hover:text-yellow-300 transition-colors duration-300">
                                Glass Morphism Design
                            </h3>
                            <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                                Beautiful, modern interface with glass morphism effects, smooth animations, and responsive design.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="py-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <div class="relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl shadow-2xl overflow-hidden group hover:bg-white/8 transition-all duration-500">
                    <!-- Background gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 via-cyan-500/5 to-pink-500/10 opacity-60  transition-opacity duration-500"></div>
                    
                    <!-- Floating decorative elements -->
                    <div class="absolute top-6 right-6 w-3 h-3 bg-purple-400/40 rounded-full animate-bounce"></div>
                    <div class="absolute top-10 right-12 w-2 h-2 bg-cyan-400/30 rounded-full animate-bounce delay-100"></div>
                    <div class="absolute top-8 right-20 w-1 h-1 bg-pink-400/50 rounded-full animate-bounce delay-200"></div>
                    
                    <div class="relative z-10 p-12 lg:p-16">
                        <h2 class="text-4xl lg:text-5xl font-bold  from-purple-400 via-cyan-400 to-pink-400 mb-6 group-hover:scale-105 transition-transform duration-300">
                            Ready to Share Your Story?
                        </h2>
                        <p class="text-xl text-gray-300 mb-10 leading-relaxed max-w-2xl mx-auto group-hover:text-gray-200 transition-colors duration-300">
                            Join thousands of writers and readers in our vibrant community. Create engaging content, connect with like-minded individuals, and watch your audience grow.
                        </p>
                        
                        @guest
                        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                            <a href="{{ route('register') }}" class="group/btn relative bg-gradient-to-r from-purple-500 to-cyan-500 text-white p-4 rounded-xl font-semibold  shadow-2xl hover:shadow-purple-500/25 transition-all duration-300 hover:scale-105 transform">
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-cyan-600 rounded-xl opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                                <div class="relative flex items-center">
                                    <svg class="w-6 h-6 mr-3 group-hover/btn:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    Start Your Journey
                                </div>
                            </a>
                            <a href="{{ route('posts.index') }}" class="group/btn relative bg-white/10 backdrop-blur-sm border border-white/20 text-white p-4 rounded-xl font-semibold  hover:bg-white/15 transition-all duration-300 hover:scale-105 transform">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 mr-3 group-hover/btn:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    Browse Stories
                                </div>
                            </a>
                        </div>
                        @else
                        <a href="{{ route('posts.create') }}" class="group/btn relative bg-gradient-to-r from-purple-500 to-cyan-500 text-white p-4 rounded-xl font-semibold  shadow-2xl hover:shadow-purple-500/25 transition-all duration-300 hover:scale-105 transform inline-flex items-center">
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-cyan-600 rounded-xl opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative flex items-center">
                                <svg class="w-6 h-6 mr-3 group-hover/btn:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create Your Next Post
                            </div>
                        </a>
                        @endguest
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection