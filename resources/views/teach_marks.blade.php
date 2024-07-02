<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Оценки') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container">
                    <h1>Выставление оценок</h1>

                    <form id="select-group-form" method="GET" action="">
                        <div class="form-group">
                            <label for="group">Выберите группу:</label>
                            <select id="group" name="group_id" class="form-control bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" onchange="this.form.submit()">
                                <option value="">Выберите группу</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }} - Уровень {{ $group->difficulty }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    @if($students->isNotEmpty())
                    <form action="{{route('marks_store')}}" method="post">
                        <button type="submit">Сохранить расписание</button>
                    @csrf
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-striped mt-4">
                                <thead>
                                    <tr>
                                        <th>Имя студента</th>
                                        @foreach ($dates as $date)
                                            <th>{{ \Carbon\Carbon::parse($date)->format('d.m') }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                    
                                        <input type="hidden" name="group_id" value="{{$_GET['group_id']}}">
                                        <input type="hidden" name="stud_id" value="{{$student->id}}">
                                        <input type="hidden" name="course[{{ $student->id }}][course_id]" value="{{$courseId}}">
                                        <tr>
                                            <td>{{ $student->user->name }}</td>
                                            @foreach ($dates as $date)
                                                <td>
                                                    <select name="marks[{{ $student->id }}][{{ $date }}]" class="form-control bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                                        <option value="0"> </option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </td>
                                            @endforeach
                                        </tr>
                                        
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        </form>
                    @endif

                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const groupSelect = document.getElementById('group');
                    groupSelect.addEventListener('change', function() {
                        document.getElementById('select-group-form').submit();
                    });
                });
                </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
