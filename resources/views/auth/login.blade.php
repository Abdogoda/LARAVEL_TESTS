@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-2xl p-8 overflow-hidden group hover:bg-white/8 transition-all duration-300">
    <!-- Dynamic gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 via-indigo-500/5 to-purple-500/10 opacity-60 transition-opacity duration-300"></div>
    
    <!-- Animated border glow -->
    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-400/20 via-indigo-400/20 to-purple-400/20 opacity-0 blur-sm transition-opacity duration-300"></div>
    
    <!-- Floating elements -->
    <div class="absolute top-4 right-4 w-2 h-2 bg-blue-400/40 rounded-full opacity-50 animate-pulse"></div>
    <div class="absolute top-8 right-8 w-1 h-1 bg-indigo-400/30 rounded-full opacity-40 animate-pulse delay-100"></div>
    <div class="absolute top-6 right-12 w-1.5 h-1.5 bg-purple-400/50 rounded-full opacity-60 animate-pulse delay-200"></div>
    
    <div class="relative z-10">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-purple-400 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold  from-white via-blue-200 to-purple-200 group-hover:from-blue-200 group-hover:via-indigo-100 group-hover:to-purple-100 transition-all duration-300">Welcome Back</h1>
            <p class="text-gray-300 group-hover:text-gray-200 transition-colors duration-300 mt-2">Sign in to your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-6 group/field">
                <label style="display: flex" for="email" class="text-sm font-medium text-blue-300 mb-3 flex items-center group-hover/field:text-blue-200 transition-colors duration-200">
                    <div class="w-5 h-5 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-md flex items-center justify-center mr-2 group-hover/field:scale-110 transition-transform duration-200">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    Email
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                    class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:border-blue-400/50 hover:bg-white/15 transition-all duration-200 @error('email') border-red-400/50 @else border-white/20 @enderror"
                    placeholder="Enter your email address"
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-400 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6 group/field">
                <label style="display: flex" for="password" class="text-sm font-medium text-indigo-300 mb-3 flex items-center group-hover/field:text-indigo-200 transition-colors duration-200">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-md flex items-center justify-center mr-2 group-hover/field:scale-110 transition-transform duration-200">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    Password
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400/50 focus:border-indigo-400/50 hover:bg-white/15 transition-all duration-200 @error('password') border-red-400/50 @else border-white/20 @enderror"
                    placeholder="Enter your password"
                >
                @error('password')
                    <p class="mt-2 text-sm text-red-400 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center group/remember">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        name="remember" 
                        class="h-4 w-4 bg-white/10 border-white/20 text-purple-500 focus:ring-purple-400/50 focus:ring-offset-transparent rounded group-hover/remember:scale-110 transition-transform duration-200"
                    >
                    <label for="remember" class="ml-3 text-sm text-gray-300 group-hover/remember:text-white transition-colors duration-200">
                        Remember me
                    </label>
                </div>
                <a href="{{ route('password.request') }}" class="text-sm text-purple-400 hover:text-purple-300 hover:scale-105 transition-all duration-200">
                    Forgot password?
                </a>
            </div>

            <!-- Submit Button -->
            <div class="mb-6">
                <button 
                    type="submit" 
                    class="w-full group/signin inline-flex items-center justify-center px-6 py-3 rounded-lg text-white font-medium bg-gradient-to-r from-blue-500/30 to-purple-500/30 hover:from-blue-500/50 hover:to-purple-500/50 backdrop-blur-sm border border-blue-400/30 hover:border-purple-400/50 transition-all duration-200 hover:scale-105"
                >
                    <svg class="w-5 h-5 mr-2 group-hover/signin:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Sign In
                </button>
            </div>

            <!-- Register Link -->
            <div class="text-center">
                <p class="text-sm text-gray-400">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-medium hover:scale-105 inline-block transition-all duration-200">
                        Create one here
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
