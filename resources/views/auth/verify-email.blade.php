@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="max-w-md mx-auto bg-gray-800 border border-gray-700 rounded-lg shadow-lg p-8">
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-yellow-900/20 border border-yellow-700 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-white">Verify Your Email</h1>
        <p class="text-gray-300 mt-2">We've sent a verification link to your email address</p>
    </div>

    <div class="bg-yellow-900/20 border border-yellow-700 rounded-lg p-4 mb-6">
        <p class="text-sm text-yellow-300">
            Before continuing, please check your email for a verification link. 
            If you didn't receive the email, you can request a new one below.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="bg-green-900/20 border border-green-700 text-green-300 px-4 py-3 rounded mb-6">
            A new verification link has been sent to your email address.
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-900/20 border border-green-700 text-green-300 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="w-full px-4 py-2 text-white text-sm font-medium rounded-md transition-colors duration-200 mb-4" style="background-color: #2563eb;" onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor='#2563eb'">
            Resend Verification Email
        </button>
    </form>

    <div class="text-center">
        <a href="{{ route('profile.show') }}" class="text-sm text-gray-400 hover:text-gray-300 underline mr-4">
            Back to Profile
        </a>
    </div>
</div>
@endsection
