@extends('layouts.main')

@section('content')
<div class="w-full">
    <h1 class="mb-5 text-2xl font-bold text-gray-900 dark:text-white">{{ __('labels.title') }}</h1>

    @auth
        <div class="w-full flex">
            <div class="ml-auto">
                <a href="{{ route('labels.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('labels.create') }}
                </a>
            </div>
        </div>
    @endauth

    <table class="mt-4 w-full text-gray-900 dark:text-gray-100">
        <thead class="border-b-2 border-solid border-gray-800 dark:border-gray-200 text-left text-gray-900 dark:text-white">
            <tr>
                <th class="py-2 font-semibold">{{ __('labels.id') }}</th>
                <th class="py-2 font-semibold">{{ __('labels.name') }}</th>
                <th class="py-2 font-semibold">{{ __('labels.description') }}</th>
                <th class="py-2 font-semibold">{{ __('labels.created_at') }}</th>
                @auth
                    <th class="py-2 font-semibold">{{ __('labels.actions') }}</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @forelse ($labels as $label)
                <tr class="border-b border-dashed border-gray-300 dark:border-gray-600 text-left hover:bg-gray-50 dark:hover:bg-gray-800">
                    <td class="py-3 text-gray-700 dark:text-gray-300">{{ $label->id }}</td>
                    <td class="py-3 text-gray-700 dark:text-gray-300">{{ $label->name }}</td>
                    <td class="py-3 text-gray-700 dark:text-gray-300">{{ $label->description ?? '' }}</td>
                    <td class="py-3 text-gray-600 dark:text-gray-400">{{ $label->created_at->format('d.m.Y') }}</td>
                    @auth
                        <td class="py-3">
                            <a href="{{ route('labels.edit', $label) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                {{ __('labels.edit') }}
                            </a>
                            <a href="{{ route('labels.destroy', $label) }}" 
                               class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 ml-2"
                               data-confirm="{{ __('labels.confirm_delete') }}"
                               data-method="delete"
                               onclick="event.preventDefault(); if(confirm(this.dataset.confirm)) { var form = document.createElement('form'); form.method = 'POST'; form.action = this.href; var csrfInput = document.createElement('input'); csrfInput.type = 'hidden'; csrfInput.name = '_token'; csrfInput.value = '{{ csrf_token() }}'; form.appendChild(csrfInput); var methodInput = document.createElement('input'); methodInput.type = 'hidden'; methodInput.name = '_method'; methodInput.value = 'DELETE'; form.appendChild(methodInput); document.body.appendChild(form); form.submit(); }">
                                {{ __('labels.delete') }}
                            </a>
                        </td>
                    @endauth
                </tr>
            @empty
                <tr class="border-b border-dashed border-gray-300 dark:border-gray-600 text-left">
                    <td colspan="{{ auth()->check() ? 5 : 4 }}" class="text-center py-4 text-gray-500 dark:text-gray-400">
                        {{ __('labels.no_labels') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
