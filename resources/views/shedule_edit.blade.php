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
    .add_button{
        border: 2px solid white;
        padding: 3px 5px;
        border-radius: 5px;
        margin: 10px 0;
    }
    .shedule_desk li{
        margin-bottom: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid white;
    }
    .shedule_desk li form{
        display: flex;
        justify-content: center;
        background-color: rgb(214, 63, 63);
        width: 20px;
        height: 20px;
        line-height: 20px;
        border-radius: 20%;
        margin: auto 10px;
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
                    <form method="POST" action="{{ route('shedule_store') }}">
                        @csrf

                        <div>
                            <label for="course">Курс:</label>
                            <select id="course" name="course" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                @foreach ($courses as $course)
                                    <option value="{{$course->id}}">{{$course->name}} {{$course->difficulty_level}}</option>
                                @endforeach
                            </select>
                            <!-- <button onclick="event.preventDefault(); alert(document.getElementById('course').value);">test</button> -->
                        </div>

                        <div>
                            <label for="sequence">Номер по порядку:</label>
                            <!-- <input type="number" id="sequence" name="sequence" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"> -->
                            <select id="sequence" name="sequence" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                <option value=1>1</option>
                                <option value=2>2</option>
                                <option value=3>3</option>
                                <option value=4>4</option>
                                <option value=5>5</option>
                                <option value=6>6</option>
                                <option value=7>7</option>
                                <option value=8>8</option>
                            </select>
                        </div>

                        <div>
                            <label for="day_of_week">День недели:</label>
                            <select id="day_of_week" name="day_of_week" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                <option value="Mon">Понедельник</option>
                                <option value="Tue">Вторник</option>
                                <option value="Wed">Среда</option>
                                <option value="Thu">Четверг</option>
                                <option value="Fri">Пятница</option>
                                <option value="Sat">Суббота</option>
                            </select>
                        </div>

                        <button class="add_button" type="submit">Добавить в расписание</button>
                    </form>

                    <div class="shedule_desk">
                    <div>
                        <h2>Понедельник</h2>
                        @foreach ($monday as $item)
                            <li>{{ $item['sequence'] }}. {{ $item['course_name'] }}
                                <form action="{{ route('schedule_destroy', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete_button" type="submit">X</button>
                                </form>
                            </li>
                        @endforeach
                    </div>

                    <div>
                        <h2>Вторник</h2>
                        @foreach ($tuesday as $item)
                        <li>{{ $item['sequence'] }}. {{ $item['course_name'] }}
                        <form action="{{ route('schedule_destroy', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete_button" type="submit">X</button>
                                </form>
                                </li>
                        @endforeach
                    </div>

                    <div>
                        <h2>Среда</h2>
                        @foreach ($wednesday as $item)
                        <li>{{ $item['sequence'] }}. {{ $item['course_name'] }}
                        <form action="{{ route('schedule_destroy', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete_button" type="submit">X</button>
                                </form>
                                </li>
                        @endforeach
                    </div>

                    <div>
                        <h2>Четверг</h2>
                        @foreach ($thursday as $item)
                        <li>{{ $item['sequence'] }}. {{ $item['course_name'] }}
                        <form action="{{ route('schedule_destroy', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete_button" type="submit">X</button>
                                </form>
                                </li>
                        @endforeach
                    </div>

                    <div>
                        <h2>Пятница</h2>
                        @foreach ($friday as $item)
                        <li>{{ $item['sequence'] }}. {{ $item['course_name'] }}
                        <form action="{{ route('schedule_destroy', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete_button" type="submit">X</button>
                                </form>
                                </li>
                        @endforeach
                    </div>

                    <div>
                        <h2>Суббота</h2>
                        @foreach ($saturday as $item)
                        <li>{{ $item['sequence'] }}. {{ $item['course_name'] }}
                        <form action="{{ route('schedule_destroy', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete_button" type="submit">X</button>
                                </form>
                        </li>
                        @endforeach
                    </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
