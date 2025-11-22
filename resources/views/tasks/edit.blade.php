<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('tasks.edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="name" :value="__('tasks.name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $task->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('tasks.description')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $task->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="status_id" :value="__('tasks.status')" />
                            <select id="status_id" name="status_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="">{{ __('Выберите статус') }}</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" {{ old('status_id', $task->status_id) == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('status_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="assigned_to_id" :value="__('tasks.assigned_to')" />
                            <select id="assigned_to_id" name="assigned_to_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">—</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_to_id', $task->assigned_to_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('assigned_to_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="labels" :value="__('Метки')" />
                            <select id="labels" name="labels[]" multiple class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}" {{ (is_array(old('labels')) ? in_array($label->id, old('labels')) : $task->labels->contains($label->id)) ? 'selected' : '' }}>
                                        {{ $label->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('labels')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                                {{ __('tasks.cancel') }}
                            </a>

                            <x-primary-button class="ms-3">
                                {{ __('tasks.update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

