<x-guest-layout>
    <!--   -->

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label class="block font-medium text-sm text-gray-700" for="name">
                {{ __('auth.name') }}
            </label>

            <input class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" id="name" type="text" name="name" required="required" autofocus="autofocus">
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700" for="email">
                {{ __('auth.email') }}
            </label>

            <input class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" id="email" type="email" name="email" required="required">
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700" for="password">
                {{ __('auth.password') }}
            </label>

            <input class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" id="password" type="password" name="password" required="required" autocomplete="new-password">
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700" for="password_confirmation">
                {{ __('auth.confirm_password') }}
            </label>

            <input class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" id="password_confirmation" type="password" name="password_confirmation" required="required">
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('auth.already_registered') }}
            </a>

            <button type="submit" class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">
                {{ __('auth.register') }}
            </button>
        </div>
    </form>
</x-guest-layout>
