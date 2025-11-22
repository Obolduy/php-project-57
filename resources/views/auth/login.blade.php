<x-guest-layout>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">{{ __('auth.login') }}</h2>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <x-validation-errors />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                {{ __('auth.email') }}
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   autocomplete="username"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                {{ __('auth.password') }}
            </label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="current-password"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" 
                       type="checkbox" 
                       name="remember"
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('auth.remember_me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                    {{ __('auth.forgot_password') }}
                </a>
            @endif

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                {{ __('auth.log_in') }}
            </button>
        </div>

        <div class="mt-6 text-center">
            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('auth.dont_have_account') }}</span>
            <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 font-medium ml-1">
                {{ __('auth.register') }}
            </a>
        </div>
    </form>
</x-guest-layout>
