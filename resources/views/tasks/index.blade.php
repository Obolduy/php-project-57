<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('tasks.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6">
                    <form method="GET" action="{{ route('tasks.index') }}" class="flex flex-wrap gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <x-input-label for="filter[status_id]" :value="__('tasks.status')" />
                            <select id="filter[status_id]" name="filter[status_id]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">—</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" {{ request('filter.status_id') == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex-1 min-w-[200px]">
                            <x-input-label for="filter[created_by_id]" :value="__('tasks.creator')" />
                            <select id="filter[created_by_id]" name="filter[created_by_id]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">—</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ request('filter.created_by_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex-1 min-w-[200px]">
                            <x-input-label for="filter[assigned_to_id]" :value="__('tasks.assigned_to')" />
                            <select id="filter[assigned_to_id]" name="filter[assigned_to_id]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">—</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ request('filter.assigned_to_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end">
                            <x-primary-button>
                                {{ __('tasks.apply') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @auth
                        <div class="mb-4">
                            <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('tasks.create') }}
                            </a>
                        </div>
                    @endauth

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('tasks.id') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('tasks.status') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('tasks.name') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('tasks.creator') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('tasks.assigned_to') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('tasks.created_at') }}
                                    </th>
                                    @auth
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('tasks.actions') }}
                                        </th>
                                    @endauth
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($tasks as $task)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $task->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $task->status->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            <a href="{{ route('tasks.show', $task) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                {{ $task->name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $task->creator->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $task->assignedTo ? $task->assignedTo->name : '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $task->created_at->format('d.m.Y') }}
                                        </td>
                                        @auth
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('tasks.edit', $task) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
                                                    {{ __('tasks.edit') }}
                                                </a>
                                                @if ($task->created_by_id === Auth::id())
                                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('tasks.confirm_delete') }}');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                            {{ __('tasks.delete') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        @endauth
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            {{ __('tasks.no_tasks') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

