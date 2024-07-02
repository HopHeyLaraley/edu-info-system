<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Group;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\User;

class CourseController extends Controller
{
    //
    public function courses(){
        $coursesUnformat = Course::with(['teacher.user'])->get();
        $teachers = Teacher::with('user')->get();

        $courses = $coursesUnformat->map(function ($course) {
            return [
                'id' => $course->id,
                'course_name' => $course->name,
                // 'group_id' => $course->group->id,
                // 'group_name' => $course->group->name,
                'difficulty_level' => $course->difficulty_level,
                'teacher_user_id' => $course->teacher->user->id,
                'teacher_id' => $course->teacher->id,
                'teacher_name' => $course->teacher->user->name,
            ];
        });
        // return $teachers;
        return view('courses')->with(['courses'=>$courses, 'teachers'=>$teachers]);
    }

    public function course_destroy($id){
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('course_edit');
    }

    public function store(Request $request){
        $data = $request->validate([
            'course' => 'required|string',
            // 'group' => 'required|numeric',
            // 'difficulty_level' => 'required|string',
            'teacher' => 'required|numeric',
        ]);

        $courseA = new Course();
        $courseA->teacher_id = $data['teacher'];
        $courseA->name = $data['course'];
        $courseA->difficulty_level = "A";

        $courseB = new Course();
        $courseB->teacher_id = $data['teacher'];
        $courseB->name = $data['course'];
        $courseB->difficulty_level = "B";

        $courseC = new Course();
        $courseC->teacher_id = $data['teacher'];
        $courseC->name = $data['course'];
        $courseC->difficulty_level = "C";

        $courseA->save();
        $courseB->save();
        $courseC->save();

        // return "Success";
        return redirect()->route('course_edit');
    }

    public function courses_list(){
        $coursesUnformat = Course::with(['teacher.user'])
        ->get()
        ->unique('name');
    
        // Преобразуем курсы в желаемый формат
        $courses = $coursesUnformat->map(function ($course) {
            return [
                'id' => $course->id,
                'course_name' => $course->name,
                'difficulty_level' => $course->difficulty_level,
                'test' => $course->test,
                'teacher_user_id' => $course->teacher->user->id,
                'teacher_id' => $course->teacher->id,
                'teacher_name' => $course->teacher->user->name,
            ];
        });
    
        // Передаем курсы в представление
        return view('course_list')->with(['courses' => $courses]);
    }
    

    public function course_store_test(Request $request){
        $courseId = $request->input('course_id');
    // $passingScore = $request->input('passing_score');
    $questions = $request->input('test.questions');

    // Формируем JSON из полученных данных
    $testData = [
        // 'passing_score' => $passingScore,
        'questions' => []
    ];

    foreach ($questions as $question) {
        $formattedQuestion = [
            'question' => $question['question'],
            'points' => $question['points'],
            'answers' => []
        ];

        foreach ($question['answers'] as $answer) {
            $formattedQuestion['answers'][] = [
                'answer' => $answer['answer'],
                'is_correct' => isset($answer['is_correct']) ? true : false
            ];
        }

        $testData['questions'][] = $formattedQuestion;
    }

    // Преобразуем массив в JSON
    $testJson = json_encode($testData, JSON_UNESCAPED_UNICODE);

    // return $testJson;
    // Найдем курс и обновим его данные
    $course = Course::find($courseId);
    if ($course) {
        $copyes = Course::where('name',$course->name)->get();

        foreach($copyes as $copy){
            $copy->test = $testJson;
            $copy->save();
        }
        
        // return "Success";
    }

    return redirect()->route('courses')->with('success', 'Тест добавлен');
    }

    public function course_sign_up(){

    }

    public function submit_test(Request $request){
        $courseId = $request->input('course_id');
        $testData = $request->input('test');
        $userId = auth()->user()->id;

        $allAnswers = array();

        $course = Course::find($courseId);
        $test = json_decode($course->test, true);

        $maxPoints = 0;
        $studentPoints = 0;

        foreach ($test['questions'] as $questionIndex => $question) {
            foreach ($question['answers'] as $answerIndex => $answer) {
                if($answer['is_correct']){
                    $allAnswers[$questionIndex]['correct'] = $answer['answer'];
                    $allAnswers[$questionIndex]['points'] = $question['points'];
                    $maxPoints += $question['points'];
                }
            }
        }
        
        foreach($testData['questions'] as $questionIndex => $question){
            foreach ($question as $answerIndex => $answer) {
                $allAnswers[$questionIndex]['student'] = $answer;
            }
        }

        foreach($allAnswers as $answer){
            if($answer['student'] === $answer['correct']){
                $studentPoints += (int)$answer['points'];
            }
        }

        // echo "<pre>";
        // print_r($allAnswers);

        $minC = $maxPoints/3;
        $minB = 2*$minC;

        $difficulty = "";
        if($studentPoints <= $minC){
            $difficulty = "C";
        }else if($studentPoints > $minC && $studentPoints <= $minB){
            $difficulty = "B";
        }else if($studentPoints > $minB){
            $difficulty = "A";
        }

        $group = Group::where("course_id", $courseId)->where("difficulty_level",$difficulty)->first();

        if (!$group) {
            $group = new Group();
            $group->course_id = $courseId;
            $group->difficulty_level = $difficulty;
            $group->name = $course->name . ' - Группа ' . $difficulty;

            $group->save();
        }
    
        // Получение студента
        $student = Student::where('user_id', $userId)->first();
    
        // Добавление студента в группу
        $student->group()->attach($group->id);

        return redirect()->route('courses')->with('success', 'Ученик добавлен');
        // return $student;

        // return $studentPoints;
    }
}
