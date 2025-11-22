<x-guest-layout>
    <!-- Validation Errors -->
    <x-validation-errors />

    {!! html()->form('POST', route('password.store'))->open() !!}

        {!! html()->hidden('token', $request->route('token')) !!}

        <!-- Email Address -->
        <div>
            {!! html()->label(__('Email'), 'email')->class('block font-medium text-sm text-gray-700') !!}

            {!! html()->email('email', old('email', $request->email))->class('rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full')->required()->autofocus()->attribute('autocomplete', 'username') !!}
        </div>

        <!-- Password -->
        <div class="mt-4">
            {!! html()->label(__('Password'), 'password')->class('block font-medium text-sm text-gray-700') !!}

            {!! html()->password('password')->class('rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full')->required()->attribute('autocomplete', 'new-password') !!}
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            {!! html()->label(__('Confirm Password'), 'password_confirmation')->class('block font-medium text-sm text-gray-700') !!}

            {!! html()->password('password_confirmation')->class('rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full')->required()->attribute('autocomplete', 'new-password') !!}
        </div>

        <div class="flex items-center justify-end mt-4">
            {!! html()->submit(__('Reset Password'))->class('inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded') !!}
        </div>

    {!! html()->form()->close() !!}
</x-guest-layout>
