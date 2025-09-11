@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="max-w-md mx-auto relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-2xl p-8 overflow-hidden group hover:bg-white/8 transition-all duration-300">
    <!-- Dynamic gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-orange-500/10 via-amber-500/5 to-yellow-500/10 opacity-60 transition-opacity duration-300"></div>
    
    <!-- Animated border glow -->
    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-orange-400/20 via-amber-400/20 to-yellow-400/20 opacity-0 blur-sm transition-opacity duration-300"></div>
    
    <!-- Floating elements -->
    <div class="absolute top-4 right-4 w-2 h-2 bg-orange-400/40 rounded-full opacity-50 animate-pulse"></div>
    <div class="absolute top-8 right-8 w-1 h-1 bg-amber-400/30 rounded-full opacity-40 animate-pulse delay-100"></div>
    <div class="absolute top-6 right-12 w-1.5 h-1.5 bg-yellow-400/50 rounded-full opacity-60 animate-pulse delay-200"></div>
    
    <div class="relative z-10">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-yellow-400 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 012-2m0 0V7a2 2 0 012-2m5 0V7a2 2 0 00-2-2m-5 0h6" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold  from-white via-orange-200 to-yellow-200 group-hover:from-orange-200 group-hover:via-amber-100 group-hover:to-yellow-100 transition-all duration-300">Password Reset</h1>
            <p class="text-gray-300 group-hover:text-gray-200 transition-colors duration-300 mt-2">Enter your email to receive a reset link</p>
        </div>

        @if (session('status'))
            <div class="mb-6 relative bg-green-500/10 backdrop-blur-sm border border-green-400/30 rounded-lg p-4 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-green-500/5 to-emerald-500/5"></div>
                <div class="relative z-10 flex items-center text-green-300">
                    <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email -->
            <div class="mb-8 group/field">
                <label style="display: flex" for="email" class="text-sm font-medium text-orange-300 mb-3 flex items-center group-hover/field:text-orange-200 transition-colors duration-200">
                    <div class="w-5 h-5 bg-gradient-to-r from-orange-400 to-amber-400 rounded-md flex items-center justify-center mr-2 group-hover/field:scale-110 transition-transform duration-200">
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
                    autofocus
                    class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border text-white rounded-lg shadow-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400/50 focus:border-orange-400/50 hover:bg-white/15 transition-all duration-200 @error('email') border-red-400/50 @else border-white/20 @enderror"
                    placeholder="Enter your registered email address"
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

            <!-- Submit Button -->
            <div class="mb-6">
                <button 
                    type="submit" 
                    class="w-full group/reset inline-flex items-center justify-center px-6 py-3 rounded-lg text-white font-medium bg-gradient-to-r from-orange-500/30 to-yellow-500/30 hover:from-orange-500/50 hover:to-yellow-500/50 backdrop-blur-sm border border-orange-400/30 hover:border-yellow-400/50 transition-all duration-200 hover:scale-105"
                >
                    <svg class="w-5 h-5 mr-2 group-hover/reset:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    Send Reset Link
                </button>
            </div>

            <!-- Back to Login -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-orange-400 hover:text-orange-300 font-medium hover:scale-105 inline-flex items-center transition-all duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
