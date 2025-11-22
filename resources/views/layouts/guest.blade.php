<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token" />

    <title>{{ __('welcome.app_name') }}</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white dark:bg-gray-900">
    <div id="app" class="min-h-screen flex flex-col">
        <header class="fixed w-full top-0 z-50 bg-white dark:bg-gray-900">
            <nav class="bg-white border-gray-200 py-2.5 dark:bg-gray-900 shadow-md">
                <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{ __('welcome.app_name') }}</span>
                    </a>

                    <div class="flex items-center lg:order-2">
                        <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('welcome.login') }}
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                            {{ __('welcome.register') }}
                        </a>
                    </div>

                    <div class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1">
                        <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                            <li>
                                <a href="{{ route('tasks.index') }}" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                                    {{ __('welcome.tasks') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('task_statuses.index') }}" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                                    {{ __('welcome.statuses') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('labels.index') }}" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                                    {{ __('welcome.labels') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <section class="bg-white dark:bg-gray-900 min-h-screen flex items-center justify-center pt-20">
            <div class="w-full max-w-md px-4">
                @include('flash::message')

                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 mt-6">
                    {{ $slot }}
                </div>
            </div>
        </section>
    </div>
</body>
</html>
