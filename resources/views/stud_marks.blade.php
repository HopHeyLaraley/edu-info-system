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
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="container">
                                <div class="table-container">
                                    <div class="course-column">
                                        <div class="course-names">
                                            @foreach ($groups as $group)
                                                <div>{{ $group->course->name }} - Уровень {{ $group->difficulty_level }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="scrollable-table">
                                        <div class="table-responsive">
                                            <table class="table table-striped mt-4">
                                                <thead>
                                                    <tr>
                                                        @foreach ($dates as $date)
                                                            <th class="{{ \Carbon\Carbon::parse($date)->isToday() ? 'current-date' : '' }}">
                                                                {{ \Carbon\Carbon::parse($date)->format('d.m') }}
                                                            </th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($groups as $group)
                                                        <tr>
                                                            @foreach ($dates as $date)
                                                                <td>
                                                                    @if (isset($marks[$group->course->id]))
                                                                        @php
                                                                            $mark = $marks[$group->course->id]->firstWhere('date', $date);
                                                                        @endphp
                                                                        {{ $mark ? $mark->mark : '-' }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <style>
                                .table th, .table td {
                                    border: 1px solid #dee2e6;
                                }
                                .table th {
                                    /* background-color: #f8f9fa; */
                                }
                                .table td {
                                    text-align: center;
                                }
                                .table-responsive {
                                    white-space: nowrap;
                                }
                                .current-date {
                                    background-color: #437c54;
                                }
                                .table-container {
                                    display: flex;
                                    flex-direction: row;
                                }
                                .course-column {
                                    padding-top: 45px;
                                    width: 200px; /* Ширина колонки с названиями курсов */
                                    /* position: sticky; */
                                    /* top: 0; */
                                    /* background-color: white; Чтобы названия курсов были видны над таблицей */
                                }
                                .course-names {
                                    /* position: relative; */
                                    height: 100%;
                                    overflow-y: auto;
                                }
                                .course-names div{
                                    margin-bottom: 5px;
                                    border-bottom: 1px solid #dee2e6;
                                }
                                .scrollable-table {
                                    flex: 1;
                                    overflow-x: auto;
                                }
                            </style>
                            
                        </div>
                    </div>

                    

                
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var currentDateCell = document.querySelector('.current-date');
            if (currentDateCell) {
                var tableContainer = document.querySelector('.scrollable-table');
                tableContainer.scrollTo(currentDateCell.offsetLeft - tableContainer.clientWidth / 2, 0);
            }
        });
    </script>
    
</x-app-layout>
