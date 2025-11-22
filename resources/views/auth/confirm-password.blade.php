<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <!-- Validation Errors -->
    <x-validation-errors />

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <label class="block font-medium text-sm text-gray-700" for="password">
                {{ __('Password') }}
            </label>

            <input class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" id="password" type="password" name="password" required="required" autocomplete="current-password">
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</x-guest-layout>
