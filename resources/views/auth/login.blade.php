@if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="">Dashboard</a>
                    @else
                        <div class="auth-block row">
                            <div class="col"></div>
                            <a href="{{ route('login') }}" class="col btn btn-primary link-light link-underline-opacity-0">Log in</a>
                            <div class="col"></div>
                        </div>
                        @if (Route::has('register'))
                        <div class="auth-block row">
                            <div class="col"></div>
                            <a href="{{ route('register') }}" class="col btn btn-primary link-light link-underline-opacity-0">Register</a>
                            <div class="col"></div>
                        </div>
                        @endif
                    @endauth
                </div>
            @endif
<x-guest-layout>
<style>
        .auth-block {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .auth-block .col {
            flex: 1;
        }
        .auth-block .col a {
            display: block;
            text-align: center;
        }
        .dashboard-link {
            display: block;
            text-align: center;
            margin: 20px 0;
            font-size: 1.2em;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        form div {
            margin-bottom: 15px;
        }
        form .block {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .ms-4 {
            margin-left: 1rem;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
