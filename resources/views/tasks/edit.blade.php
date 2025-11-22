@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-5">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('tasks.edit') }}</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('tasks.name') }} <span class="text-red-500">*</span>
                </label>
                <input 
                    id="name" 
                    type="text" 
                    name="name" 
                    value="{{ old('name', $task->name) }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition duration-150 ease-in-out @error('name') border-red-500 @enderror"
                    required 
                    autofocus
                    placeholder="Введите название задачи"
                >
                @error('name')
                    <div class="text-rose-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('tasks.description') }}
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="5"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition duration-150 ease-in-out resize-none @error('description') border-red-500 @enderror"
                    placeholder="Введите описание задачи (необязательно)"
                >{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <div class="text-rose-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="status_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('tasks.status') }} <span class="text-red-500">*</span>
                </label>
                <select 
                    id="status_id" 
                    name="status_id"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition duration-150 ease-in-out @error('status_id') border-red-500 @enderror"
                    required
                >
                    <option value="">{{ __('tasks.select_status') }}</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" {{ old('status_id', $task->status_id) == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
                @error('status_id')
                    <div class="text-rose-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="assigned_to_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('tasks.assigned_to') }}
                </label>
                <select 
                    id="assigned_to_id" 
                    name="assigned_to_id"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition duration-150 ease-in-out @error('assigned_to_id') border-red-500 @enderror"
                >
                    <option value="">—</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to_id', $task->assigned_to_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('assigned_to_id')
                    <div class="text-rose-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="labels" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('tasks.labels') }}
                </label>
                <select 
                    id="labels" 
                    name="labels[]" 
                    multiple 
                    size="5"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition duration-150 ease-in-out @error('labels') border-red-500 @enderror"
                >
                    @foreach ($labels as $label)
                        <option value="{{ $label->id }}" {{ (is_array(old('labels')) ? in_array($label->id, old('labels')) : $task->labels->contains($label->id)) ? 'selected' : '' }}>
                            {{ $label->name }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Удерживайте Ctrl (Cmd на Mac) для выбора нескольких меток
                </p>
                @error('labels')
                    <div class="text-rose-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                <a 
                    href="{{ route('tasks.index') }}" 
                    class="inline-flex items-center px-6 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-400"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('tasks.cancel') }}
                </a>

                <button 
                    type="submit" 
                    class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('tasks.update') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

