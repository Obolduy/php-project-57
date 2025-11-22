<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('auth.reset_password_text') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-validation-errors />

    {!! html()->form('POST', route('password.email'))->open() !!}

        <!-- Email Address -->
        <div>
            {!! html()->label(__('auth.email'), 'email')->class('block font-medium text-sm text-gray-700') !!}

            {!! html()->email('email', old('email'))->class('rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full')->required()->autofocus() !!}
        </div>

        <div class="flex items-center justify-end mt-4">
            {!! html()->submit(__('auth.email_password_reset_link'))->class('inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded') !!}
        </div>

    {!! html()->form()->close() !!}
</x-guest-layout>
