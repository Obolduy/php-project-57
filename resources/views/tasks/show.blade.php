<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('tasks.view') }}: {{ $task->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">{{ __('tasks.name') }}</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $task->name }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">{{ __('tasks.description') }}</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $task->description ?? '—' }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">{{ __('tasks.status') }}</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $task->status->name }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">{{ __('tasks.creator') }}</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $task->creator->name }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">{{ __('tasks.assigned_to') }}</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $task->assignedTo ? $task->assignedTo->name : '—' }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">{{ __('Метки') }}</h3>
                        @if($task->labels->isNotEmpty())
                            <div class="flex flex-wrap gap-2">
                                @foreach($task->labels as $label)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $label->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-700 dark:text-gray-300">—</p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">{{ __('tasks.created_at') }}</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $task->created_at->format('d.m.Y H:i:s') }}</p>
                    </div>

                    <div class="flex items-center justify-start mt-6">
                        <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Назад') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

