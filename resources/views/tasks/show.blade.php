@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-5 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('tasks.view') }}</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8">
            <h2 class="text-2xl font-bold text-white">{{ $task->name }}</h2>
            <div class="mt-3 flex items-center text-blue-100 text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $task->created_at->format('d.m.Y H:i') }}
            </div>
        </div>

        <div class="p-6 space-y-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                    {{ __('tasks.description') }}
                </h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $task->description ?? '—' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        {{ __('tasks.status') }}
                    </h3>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="3"/>
                            </svg>
                            {{ $task->status->name }}
                        </span>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        {{ __('tasks.creator') }}
                    </h3>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr($task->creator->name, 0, 1)) }}
                        </div>
                        <div class="ml-3">
                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $task->creator->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                    {{ __('tasks.assigned_to') }}
                </h3>
                @if($task->assignedTo)
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr($task->assignedTo->name, 0, 1)) }}
                        </div>
                        <div class="ml-3">
                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $task->assignedTo->name }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 italic">Не назначен</p>
                @endif
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                    {{ __('tasks.labels') }}
                </h3>
                @if($task->labels->isNotEmpty())
                    <div class="flex flex-wrap gap-2">
                        @foreach($task->labels as $label)
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                </svg>
                                {{ $label->name }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 italic">Нет меток</p>
                @endif
            </div>
        </div>

        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-between items-center">
            <a 
                href="{{ route('tasks.index') }}" 
                class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition duration-150 ease-in-out"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('tasks.back') }}
            </a>

            @can('update', $task)
                <div class="flex gap-2">
                    <a 
                        href="{{ route('tasks.edit', $task) }}" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        {{ __('tasks.edit') }}
                    </a>
                </div>
            @endcan
        </div>
    </div>
</div>
@endsection

