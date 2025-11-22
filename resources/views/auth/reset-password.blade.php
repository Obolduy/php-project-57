<x-guest-layout>
    <!-- Validation Errors -->
    <x-validation-errors />

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label class="block font-medium text-sm text-gray-700" for="email">
                {{ __('Email') }}
            </label>

            <input class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required="required" autofocus="autofocus" autocomplete="username">
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700" for="password">
                {{ __('Password') }}
            </label>

            <input class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" id="password" type="password" name="password" required="required" autocomplete="new-password">
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700" for="password_confirmation">
                {{ __('Confirm Password') }}
            </label>

            <input class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" id="password_confirmation" type="password" name="password_confirmation" required="required" autocomplete="new-password">
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
