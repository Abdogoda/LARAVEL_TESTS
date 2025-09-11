@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-md mx-auto relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-2xl p-8 overflow-hidden group hover:bg-white/8 transition-all duration-300">
    <!-- Dynamic gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 via-emerald-500/5 to-teal-500/10 opacity-60 transition-opacity duration-300"></div>
    
    <!-- Animated border glow -->
    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-green-400/20 via-emerald-400/20 to-teal-400/20 opacity-0 blur-sm transition-opacity duration-300"></div>
    
    <!-- Floating elements -->
    <div class="absolute top-4 right-4 w-2 h-2 bg-green-400/40 rounded-full opacity-50 animate-pulse"></div>
    <div class="absolute top-8 right-8 w-1 h-1 bg-emerald-400/30 rounded-full opacity-40 animate-pulse delay-100"></div>
    <div class="absolute top-6 right-12 w-1.5 h-1.5 bg-teal-400/50 rounded-full opacity-60 animate-pulse delay-200"></div>
    
    <div class="relative z-10">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-teal-400 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold  from-white via-green-200 to-teal-200 group-hover:from-green-200 group-hover:via-emerald-100 group-hover:to-teal-100 transition-all duration-300">Join Our Community</h1>
            <p class="text-gray-300 group-hover:text-gray-200 transition-colors duration-300 mt-2">Create your account to get started</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-6 group/field">
                <label style="display: flex" for="name" class="text-sm font-medium text-green-300 mb-3 flex items-center group-hover/field:text-green-200 transition-colors duration-200">
                    <div class="w-5 h-5 bg-gradient-to-r from-green-400 to-emerald-400 rounded-md flex items-center justify-center mr-2 group-hover/field:scale-110 transition-transform duration-200">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    Full Name
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required 
                    autofocus
                    class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400/50 focus:border-green-400/50 hover:bg-white/15 transition-all duration-200 @error('name') border-red-400/50 @else border-white/20 @enderror"
                    placeholder="Enter your full name"
                >
                @error('name')
                    <p class="mt-2 text-sm text-red-400 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-6 group/field">
                <label style="display: flex" for="email" class="text-sm font-medium text-emerald-300 mb-3 flex items-center group-hover/field:text-emerald-200 transition-colors duration-200">
                    <div class="w-5 h-5 bg-gradient-to-r from-emerald-400 to-teal-400 rounded-md flex items-center justify-center mr-2 group-hover/field:scale-110 transition-transform duration-200">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    Email Address
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required
                    class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-400/50 focus:border-emerald-400/50 hover:bg-white/15 transition-all duration-200 @error('email') border-red-400/50 @else border-white/20 @enderror"
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
                <label style="display: flex" for="password" class="text-sm font-medium text-teal-300 mb-3 flex items-center group-hover/field:text-teal-200 transition-colors duration-200">
                    <div class="w-5 h-5 bg-gradient-to-r from-teal-400 to-cyan-400 rounded-md flex items-center justify-center mr-2 group-hover/field:scale-110 transition-transform duration-200">
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
                    class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400/50 hover:bg-white/15 transition-all duration-200 @error('password') border-red-400/50 @else border-white/20 @enderror"
                    placeholder="Create a secure password"
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

            <!-- Confirm Password -->
            <div class="mb-8 group/field">
                <label style="display: flex" for="password_confirmation" class="text-sm font-medium text-cyan-300 mb-3 flex items-center group-hover/field:text-cyan-200 transition-colors duration-200">
                    <div class="w-5 h-5 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-md flex items-center justify-center mr-2 group-hover/field:scale-110 transition-transform duration-200">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Confirm Password
                </label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    required
                    class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400/50 hover:bg-white/15 transition-all duration-200 border-white/20"
                    placeholder="Confirm your password"
                >
            </div>

            <!-- Submit Button -->
            <div class="mb-6">
                <button 
                    type="submit" 
                    class="w-full group/signup inline-flex items-center justify-center px-6 py-3 rounded-lg text-white font-medium bg-gradient-to-r from-green-500/30 to-teal-500/30 hover:from-green-500/50 hover:to-teal-500/50 backdrop-blur-sm border border-green-400/30 hover:border-teal-400/50 transition-all duration-200 hover:scale-105"
                >
                    <svg class="w-5 h-5 mr-2 group-hover/signup:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Create Account
                </button>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <p class="text-sm text-gray-400">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-green-400 hover:text-green-300 font-medium hover:scale-105 inline-block transition-all duration-200">
                        Sign in here
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
