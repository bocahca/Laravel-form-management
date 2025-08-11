<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    {{-- Container Utama --}}
    <div class="w-full max-w-5xl mx-auto">
        <div class="flex flex-col md:flex-row bg-white shadow-lg rounded-lg overflow-hidden">

            <div class="w-full md:w-3/5 p-8 md:p-12 flex flex-col justify-center">
                <div class="max-w-md mx-auto">
                    <h2 class="font-heading text-4xl font-bold text-gray-900">
                        Web Title
                    </h2>
                    <p class="mt-4 text-xl text-gray-600">
                        Aliqet consectetur id magna ac integer. Aliqet consectetur id magna
                    </p>

                    <div class="mt-8 bg-white p-6 rounded-lg shadow-md border border-gray-100">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-primary-light/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-heading text-lg font-semibold text-gray-900">PDSI ITGOV</h3>
                                <p class="mt-1 text-gray-600">Kementerian Komunikasi dan Digital</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-2/5 bg-gray-50 md:border-l">
                <div class="h-full flex flex-col justify-center p-8 md:p-12">
                    <div class="w-full max-w-sm mx-auto">
                        @auth
                            {{-- Tampilan untuk user yang sudah login --}}
                            <div class="text-center">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Welcome Back!</h2>
                                <p class="text-gray-600 mb-6">You are logged in as {{ auth()->user()->name }}</p>
                                <a href="{{ route('dashboard') }}"
                                    class="inline-block w-full py-3 px-4 bg-primary text-white text-center font-medium rounded-md hover:bg-primary-dark transition-colors">
                                    Go to Dashboard
                                </a>
                            </div>
                        @else
                            <div class="text-start mb-8">
                                <h2 class="text-2xl font-bold text-gray-900">Sign in</h2>
                            </div>

                            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                                @csrf
                                <div>
                                    <x-input-label for="email" value="Email" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                        :value="old('email')" required autofocus />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="password" value="Password" />
                                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                        required autocomplete="current-password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                                <div class="block mt-4">
                                    <label for="remember_me" class="inline-flex items-center">
                                        <input id="remember_me" type="checkbox"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            name="remember">
                                        <span class="ms-2 text-sm text-gray-600">Remember me</span>
                                    </label>
                                </div>
                                <div>
                                    <x-primary-button class="w-full justify-center py-3 bg-primary">
                                        Log in
                                    </x-primary-button>
                                </div>
                                <div class="text-sm text-center">
                                    <span class="text-gray-600">Don't have an account?</span>
                                    <a href="{{ route('register') }}"
                                        class="ml-1 font-medium text-primary hover:text-primary-dark">
                                        Sign up
                                    </a>
                                </div>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
