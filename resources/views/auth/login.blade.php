<x-guest-layout>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">{{ __('auth.login') }}</h2>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <x-validation-errors />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label class="block font-medium text-sm text-gray-700" for="email">
                {{ __('auth.email') }}
            </label>

            <input class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" id="email" type="email" name="email" required="required" autofocus="autofocus">
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700" for="password">
                {{ __('auth.password') }}
            </label>

            <input class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" id="password" type="password" name="password" required="required" autocomplete="current-password">
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('auth.remember_me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('auth.forgot_password') }}
                </a>
            @endif

            <button type="submit" class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-3">
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
