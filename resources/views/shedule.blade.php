<style>
    .shedule_desk{
        display: flex;
        flex-wrap: wrap;
    }
    .shedule_desk div{
        min-width: 30%;
        border: 2px solid white;
        padding: 5px 15px;
        min-height: 200px;
        margin: 10px;
        border-radius: 10px;
    }
    .shedule_desk div h2{
        text-align: center;
    }
    .shedule_desk li{
        margin-bottom: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid white;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Расписание') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="shedule_desk">
                    <div>
                        <h2>Понедельник</h2>
                        @foreach ($monday as $item)
                            <li>{{ $item['sequence'] }}. {{ $item['course_name'] }}</li>
                        @endforeach
                    </div>

                    <div>
                        <h2>Вторник</h2>
                        @foreach ($tuesday as $item)
                        <li>{{ $item['sequence'] }}. {{ $item['course_name'] }}</li>
                        @endforeach
                    </div>

                    <div>
                        <h2>Среда</h2>
                        @foreach ($wednesday as $item)
                        <li>{{ $item['sequence'] }}. {{ $item['course_name'] }}</li>
                        @endforeach
                    </div>

                    <div>
                        <h2>Четверг</h2>
                        @foreach ($thursday as $item)
                        <li>{{ $item['sequence'] }}. {{ $item['course_name'] }}</li>
                        @endforeach
                    </div>

                    <div>
                        <h2>Пятница</h2>
                        @foreach ($friday as $item)
                        <li>{{ $item['sequence'] }}. {{ $item['course_name'] }}</li>
                        @endforeach
                    </div>

                    <div>
                        <h2>Суббота</h2>
                        @foreach ($saturday as $item)
                        <li>{{ $item['sequence'] }}. {{ $item['course_name'] }}</li>
                        @endforeach
                    </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
