@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="rounded-md p-4 mb-4 
                    @if ($message['level'] === 'success') bg-green-50 border border-green-200 text-green-800 dark:bg-green-900 dark:text-green-200 dark:border-green-700
                    @elseif ($message['level'] === 'danger' || $message['level'] === 'error') bg-red-50 border border-red-200 text-red-800 dark:bg-red-900 dark:text-red-200 dark:border-red-700
                    @elseif ($message['level'] === 'warning') bg-yellow-50 border border-yellow-200 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 dark:border-yellow-700
                    @else bg-blue-50 border border-blue-200 text-blue-800 dark:bg-blue-900 dark:text-blue-200 dark:border-blue-700
                    @endif"
                    role="alert"
        >
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    {!! $message['message'] !!}
                </div>
                @if ($message['important'])
                    <button type="button"
                            class="ml-3 inline-flex text-gray-400 hover:text-gray-500 focus:outline-none"
                            onclick="this.parentElement.parentElement.remove()"
                    >
                        <span class="sr-only">Dismiss</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
