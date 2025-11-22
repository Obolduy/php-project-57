<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-validation-errors />

    {!! html()->form('POST', route('login'))->open() !!}

        <!-- Email Address -->
        <div>
            {!! html()->label(__('auth.email'), 'email')->class('block font-medium text-sm text-gray-700') !!}

            {!! html()->email('email')->class('rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full')->required()->autofocus() !!}
        </div>

        <!-- Password -->
        <div class="mt-4">
            {!! html()->label(__('auth.password'), 'password')->class('block font-medium text-sm text-gray-700') !!}

            {!! html()->password('password')->class('rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full')->required()->attribute('autocomplete', 'current-password') !!}
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                {!! html()->checkbox('remember', false)->id('remember_me')->class('rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50') !!}
                <span class="ml-2 text-sm text-gray-600">{{ __('auth.remember_me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('auth.forgot_password') }}
                </a>
            @endif

            {!! html()->submit(__('auth.log_in'))->class('inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-3') !!}
        </div>

    {!! html()->form()->close() !!}
</x-guest-layout>
