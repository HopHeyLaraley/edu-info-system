<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Чат') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(isset($messages))
                    <div id="chat-messages" class="p-4 h-64 overflow-y-auto">
                    @foreach($messages as $message)
                        <div class="mb-2">
                            <span class="font-bold">{{ $message->sender_name }}:</span> {{ $message->text }}
                        </div>
                    @endforeach
                </div>
                    @endif
                    <form id="chat-form" action="{{route('send_message')}}" method="post">
                        @csrf
                        <textarea name="message" rows="4" class="w-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"></textarea>
                        
                        <button type="submit"  class="btn btn-primary mt-2 ">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        

        

    </script>
</x-app-layout>