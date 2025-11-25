@extends('layouts.main')

@section('content')
<div class="w-full">
    <h1 class="mb-5 text-2xl font-bold text-gray-900 dark:text-white">{{ __('tasks.title') }}</h1>

    <div class="w-full flex items-center">
        <div>
            <form method="GET" action="{{ route('tasks.index') }}">
                <div class="flex gap-2">
                    <select class="rounded border-gray-300 text-gray-900 bg-white py-2 px-3" name="filter[status_id]" id="filter[status_id]">
                        <option value selected="selected">{{ __('tasks.status') }}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" {{ request('filter.status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <select class="rounded border-gray-300 text-gray-900 bg-white py-2 px-3" name="filter[created_by_id]" id="filter[created_by_id]">
                        <option value selected="selected">{{ __('tasks.creator') }}</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('filter.created_by_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <select class="rounded border-gray-300 text-gray-900 bg-white py-2 px-3" name="filter[assigned_to_id]" id="filter[assigned_to_id]">
                        <option value selected="selected">{{ __('tasks.assigned_to') }}</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('filter.assigned_to_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        {{ __('tasks.apply') }}
                    </button>
                </div>
            </form>
        </div>

        <div class="ml-auto">
            @auth
                <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('tasks.create') }}
                </a>
            @endauth
        </div>
    </div>

    <table class="mt-4 w-full text-gray-900 dark:text-gray-100">
        <thead class="border-b-2 border-solid border-gray-800 dark:border-gray-200 text-left text-gray-900 dark:text-white">
            <tr>
                <th class="py-2 font-semibold">{{ __('tasks.id') }}</th>
                <th class="py-2 font-semibold">{{ __('tasks.status') }}</th>
                <th class="py-2 font-semibold">{{ __('tasks.name') }}</th>
                <th class="py-2 font-semibold">{{ __('tasks.creator') }}</th>
                <th class="py-2 font-semibold">{{ __('tasks.assigned_to') }}</th>
                <th class="py-2 font-semibold">{{ __('tasks.created_at') }}</th>
                @auth
                    <th class="py-2 font-semibold">{{ __('tasks.actions') }}</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
                <tr class="border-b border-dashed border-gray-300 dark:border-gray-600 text-left hover:bg-gray-50 dark:hover:bg-gray-800">
                    <td class="py-3 text-gray-700 dark:text-gray-300">{{ $task->id }}</td>
                    <td class="py-3 text-gray-700 dark:text-gray-300">{{ $task->status->name }}</td>
                    <td class="py-3">
                        <a class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium" href="{{ route('tasks.show', $task) }}">
                            {{ $task->name }}
                        </a>
                    </td>
                    <td class="py-3 text-gray-700 dark:text-gray-300">{{ $task->creator->name }}</td>
                    <td class="py-3 text-gray-700 dark:text-gray-300">{{ $task->assignedTo ? $task->assignedTo->name : '' }}</td>
                    <td class="py-3 text-gray-600 dark:text-gray-400">{{ $task->created_at->format('d.m.Y') }}</td>
                    @auth
                        <td class="py-3">
                            @can('update', $task)
                                <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ __('tasks.edit') }}
                                </a>
                            @endcan
                            @can('delete', $task)
                                <a href="{{ route('tasks.destroy', $task) }}" 
                                   class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 ml-2"
                                   data-confirm="{{ __('tasks.confirm_delete') }}"
                                   data-method="delete"
                                   onclick="event.preventDefault(); if(confirm(this.dataset.confirm)) { var form = document.createElement('form'); form.method = 'POST'; form.action = this.href; var csrfInput = document.createElement('input'); csrfInput.type = 'hidden'; csrfInput.name = '_token'; csrfInput.value = '{{ csrf_token() }}'; form.appendChild(csrfInput); var methodInput = document.createElement('input'); methodInput.type = 'hidden'; methodInput.name = '_method'; methodInput.value = 'DELETE'; form.appendChild(methodInput); document.body.appendChild(form); form.submit(); }">
                                    {{ __('tasks.delete') }}
                                </a>
                            @endcan
                        </td>
                    @endauth
                </tr>
            @empty
                <tr class="border-b border-dashed border-gray-300 dark:border-gray-600 text-left">
                    <td colspan="{{ auth()->check() ? 7 : 6 }}" class="text-center py-4 text-gray-500 dark:text-gray-400">
                        {{ __('tasks.no_tasks') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($tasks->hasPages())
        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    @endif
</div>
@endsection
