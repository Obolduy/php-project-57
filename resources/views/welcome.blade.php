<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token" />

    <title>{{ __('welcome.app_name') }}</title>

        <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
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
                        @guest
                            <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('welcome.login') }}
                            </a>
                            <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                                {{ __('welcome.register') }}
                            </a>
                        @endguest
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

        <section class="flex-grow bg-white dark:bg-gray-900 flex items-center">
            <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 w-full mt-16">
                <div class="mr-auto place-self-center lg:col-span-7">
                    <h1 class="max-w-2xl mb-4 text-4xl font-extrabold leading-none tracking-tight md:text-5xl xl:text-6xl dark:text-white">
                        {{ __('welcome.greeting') }}
                    </h1>
                    <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
                        {{ __('welcome.description') }}
                    </p>
                    <div class="space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                        <a href="https://hexlet.io" class="inline-block bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow" target="_blank">
                            {{ __('welcome.learn_more') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>
        </div>
    </body>
</html>
