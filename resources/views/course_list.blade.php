<style>
    .add_button{
        border: 2px solid white;
        padding: 3px 5px;
        border-radius: 5px;
        margin: 10px 0;
    }
    li form{
        display: flex;
        justify-content: center;
        background-color: rgb(63, 175, 63);
        /* width: 20px;
        height: 20px; */
        line-height: 20px;
        border-radius: 20px;
        margin: auto 10px;
        padding: 5px;
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
    .send_test{
        border-radius: 20px;
        padding: 5px;
        background-color: #2f86eb;
    }
    .question-group{
        margin-bottom: 15px;
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
                    @foreach ($courses as $course)
                    <li>
                        {{$course['course_name']}}  - {{$course['teacher_name']}}
                        <form action="{{ route('course_sign_up', $course['id']) }}" method="POST">
                                    @csrf
                                    <button type="button" class="enroll-button" data-course-id="{{ $course['id'] }}" data-course-test="{{ $course['test'] }}">Записаться</button>
                                </form>
                    </li>
                    @endforeach
                </div>
                <div id="test-form-container" style="display: none;">
    <button type="button" id="close-form" class="btn btn-danger">Закрыть</button>
    <form id="test-form" method="POST" action="{{ route('submit_test') }}">
        @csrf
        <input type="hidden" name="course_id" id="course-id">
        <!-- Вопросы и ответы будут динамически добавлены здесь через JavaScript -->
        <div id="test-questions-container"></div>
        <button type="submit" class="send_test btn btn-primary">Отправить тест</button>
    </form>
</div>

            </div>
        </div>
    </div>
    <script>
        
       document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.enroll-button').forEach(button => {
        button.addEventListener('click', function () {
            const courseId = this.dataset.courseId;
            let stroka = this.dataset.courseTest;
                let test = JSON.parse(stroka);
        
                // console.log(test.questions);

            // try {
            //     const courseTest = JSON.parse(courseTestRaw.replace(/&quot;/g, '"'));
            //     console.log('Parsed courseTest:', courseTest);

            //     if (!courseTest || !Array.isArray(courseTest.questions)) {
            //         console.error('Invalid courseTest format');
            //         return;
            //     }

                document.getElementById('course-id').value = courseId;
                loadTest(test);
                document.getElementById('test-form-container').style.display = 'block';
            // } catch (error) {
            //     console.error('Failed to parse courseTest:', error);
            // }
        });
    });

    //Закрытие формы тестирования
    document.getElementById('close-form').addEventListener('click', function () {
        document.getElementById('test-form-container').style.display = 'none';
    });

    // Загрузка теста
    function loadTest(test) {
        const questionsContainer = document.getElementById('test-questions-container');
        questionsContainer.innerHTML = ''; // Очистить контейнер вопросов

        test.questions.forEach((question, questionIndex) => {
            const questionElement = document.createElement('div');
            questionElement.className = 'question-group';

            const questionLabel = document.createElement('label');
            questionLabel.textContent = `Вопрос ${questionIndex + 1}: ${question.question}`;
            questionElement.appendChild(questionLabel);

            question.answers.forEach((answer, answerIndex) => {
                const answerElement = document.createElement('div');
                answerElement.className = 'answer-group';

                const answerInput = document.createElement('input');
                answerInput.type = 'radio';
                answerInput.name = `test[questions][${questionIndex}][selected_answer]`;
                answerInput.value = answer.answer;
                answerElement.appendChild(answerInput);

                const answerLabel = document.createElement('label');
                answerLabel.textContent = answer.answer;
                answerElement.appendChild(answerLabel);

                questionElement.appendChild(answerElement);
            });

            questionsContainer.appendChild(questionElement);
        });

        // const passingScoreElement = document.createElement('div');
        // passingScoreElement.className = 'passing-score-group';

        // const passingScoreLabel = document.createElement('label');
        // passingScoreLabel.textContent = `Проходной балл: ${test.passing_score}`;
        // passingScoreElement.appendChild(passingScoreLabel);

        // questionsContainer.appendChild(passingScoreElement);
    }
});


    </script>
</x-app-layout>