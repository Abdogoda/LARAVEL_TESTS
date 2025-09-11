@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Verify Your Email</h1>
        <p class="text-gray-600 mt-2">We've sent a verification link to your email address</p>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <p class="text-sm text-yellow-800">
            Before continuing, please check your email for a verification link. 
            If you didn't receive the email, you can request a new one below.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="w-full btn btn-primary mb-4">
            Resend Verification Email
        </button>
    </form>

    <div class="text-center">
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-sm text-gray-600 hover:text-gray-800 underline">
                Sign out
            </button>
        </form>
    </div>
</div>
@endsection
