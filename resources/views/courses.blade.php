<style>
    .course_button{
        border: 2px solid white;
        padding: 3px 5px;
        border-radius: 5px;
        margin: 10px 0;
    }
    li form{
        display: flex;
        justify-content: center;
        background-color: rgb(214, 63, 63);
        width: 20px;
        height: 20px;
        line-height: 20px;
        border-radius: 20%;
        margin: auto 10px;
    }
    li{
        width: 30%;
        margin-bottom: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid white;
    }
    #test-form-container{
        position: absolute;
        width: 45%;
        max-height: 90%;
        overflow-y: scroll;
        left: 50%;
        top: 30px;
        padding: 20px;
        border-radius: 20px;
        transform: translateX(-50%);
        background-color: rgb(100, 99, 99);
    }
    #add-question{
        position: relative;
    }
    ::-webkit-scrollbar { /* chrome based */
        width: 0px;  /* ширина scrollbar'a */
        background: transparent;  /* опционально */
    }
    .score_input{
        width: 10%;
    }
    .quest_input{
        width: 90%;
    }
    .btn-danger{
        border: 2px solid red;
        padding: 3px 5px;
        border-radius: 5px;
        margin: 10px 0;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Курсы') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                
                    <form action="{{ route('course_store') }}" method="post">
                    @csrf
                        <input type="text" name="course" id="course" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        
                        <select name="teacher" id="teacher" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            @foreach ($teachers as $teacher)
                            <option value="{{$teacher['user']['id']}}">
                                {{$teacher['user']['name']}}
                            </option>
                            @endforeach
                        </select>
                        <button class="course_button" type="submit">Добавить курс</button>
                    </form>

                    @foreach ($courses as $course)
                    <li>
                        {{$course['course_name']}} {{$course['difficulty_level']}}  - {{$course['teacher_name']}}
                        <form action="{{ route('course_destroy', $course['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete_button" type="submit">X</button>
                                </form>
                                <button class="add-test-button" data-course-id="{{ $course['id'] }}">Добавить тест</button>
                    </li>
                    @endforeach

                    <div id="test-form-container" style="display: none;">
                        <button type="button" id="close-form" class="btn btn-danger">Закрыть</button>
                        <form id="test-form" method="POST" action="{{ route('course_store_test') }}">
                            @csrf
                            <input type="hidden" name="course_id" id="course-id">
                            <!-- <div class="form-group">
                                <label for="passing_score">Проходной балл</label>
                                <input type="number" name="passing_score" id="passing_score" class="form-control bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" required>
                            </div> -->
                            <div id="questions-container">
                                <!-- Questions will be added dynamically here -->
                                <button type="button" id="add-question" class="quest_button course_button btn btn-secondary">Добавить вопрос</button>
                            </div>
                            <button type="submit" class="course_button btn btn-primary">Добавить тест</button>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.add-test-button').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('test-form-container').style.display = 'block';
            document.getElementById('course-id').value = this.dataset.courseId;
        });
    });

    document.getElementById('add-question').addEventListener('click', function () {
        const questionIndex = document.querySelectorAll('.question-group').length;
        const questionTemplate = `
            <div class="question-group" data-question-index="${questionIndex}">
                <div class="form-group">
                    <label for="test[questions][${questionIndex}][question]">Вопрос ${questionIndex + 1}</label>
                    <br>
                    <input type="text" name="test[questions][${questionIndex}][question]" class="quest_input form-control bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" required>
                    <br>
                    <label for="test[questions][${questionIndex}][points]">Баллы</label>
                    <input value='1' type="number" name="test[questions][${questionIndex}][points]" class="score_input form-control bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" required>
                </div>
                <div class="answers-container">
                    <button type="button" class="course_button add-answer btn btn-secondary" data-question-index="${questionIndex}">Добавить ответ</button>
                </div>
            </div>`;
        document.getElementById('questions-container').insertAdjacentHTML('beforeend', questionTemplate);
        attachAddAnswerListeners();
    });

    function attachAddAnswerListeners() {
        document.querySelectorAll('.add-answer').forEach(button => {
            button.addEventListener('click', function () {
                const questionIndex = this.dataset.questionIndex;
                const answerIndex = document.querySelectorAll(`.question-group[data-question-index="${questionIndex}"] .answer-group`).length;
                const answerTemplate = `
                    <div class="answer-group">
                        <div class="form-group">
                            <label for="test[questions][${questionIndex}][answers][${answerIndex}][answer]">Ответ ${answerIndex + 1}</label>
                            <input type="text" name="test[questions][${questionIndex}][answers][${answerIndex}][answer]" class="form-control bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" required>
                            <label for="test[questions][${questionIndex}][answers][${answerIndex}][is_correct]">Правильный?</label>
                            <input type="checkbox" name="test[questions][${questionIndex}][answers][${answerIndex}][is_correct]">
                            <button type="button" class="remove-answer btn btn-danger">Удалить</button>
                        </div>
                    </div>`;
                this.insertAdjacentHTML('beforebegin', answerTemplate);
                attachRemoveAnswerListeners();
            });
        });
    }

    function attachRemoveAnswerListeners() {
        document.querySelectorAll('.remove-answer').forEach(button => {
            button.addEventListener('click', function () {
                this.closest('.answer-group').remove();
            });
        });
    }

    attachAddAnswerListeners();
    attachRemoveAnswerListeners();

    document.getElementById('close-form').addEventListener('click', function () {
        document.getElementById('test-form-container').style.display = 'none';
    });
});

</script>
</x-app-layout>