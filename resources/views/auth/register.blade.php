<x-guest-layout>
    <!-- Validation Errors -->
    <x-validation-errors />

    {!! html()->form('POST', route('register'))->open() !!}

        <!-- Name -->
        <div>
            {!! html()->label(__('auth.name'), 'name')->class('block font-medium text-sm text-gray-700') !!}

            {!! html()->text('name')->class('rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full')->required()->autofocus() !!}
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            {!! html()->label(__('auth.email'), 'email')->class('block font-medium text-sm text-gray-700') !!}

            {!! html()->email('email')->class('rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full')->required() !!}
        </div>

        <!-- Password -->
        <div class="mt-4">
            {!! html()->label(__('auth.password'), 'password')->class('block font-medium text-sm text-gray-700') !!}

            {!! html()->password('password')->class('rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full')->required()->attribute('autocomplete', 'new-password') !!}
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            {!! html()->label(__('auth.confirm_password'), 'password_confirmation')->class('block font-medium text-sm text-gray-700') !!}

            {!! html()->password('password_confirmation')->class('rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full')->required() !!}
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('auth.already_registered') }}
            </a>

            {!! html()->submit(__('auth.register'))->class('inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4') !!}
        </div>

    {!! html()->form()->close() !!}
</x-guest-layout>
