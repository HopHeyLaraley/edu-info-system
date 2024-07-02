<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark;
use App\Models\Group;
use App\Models\Student;

use Carbon\Carbon;

class MarksController extends Controller
{
    //
    public function index(Request $request)
    {
        $groups = Group::all();
        $students = collect();
        $dates = [];
        $courseId = null; // Добавляем переменную для хранения course_id

        if ($request->has('group_id') && !empty($request->input('group_id'))) {
            $groupId = $request->input('group_id');
            $group = Group::with('course.schedules')->find($groupId);

            if ($group && $group->course && $group->course->schedules->isNotEmpty()) {
                $students = $group->student()->with('user')->get();

                // Получаем расписание курса
                $scheduleDays = $group->course->schedules->pluck('day_of_week')->toArray();

                // Генерация дат на основе расписания
                $dates = $this->generateDates($scheduleDays);

                // Получаем course_id
                $courseId = $group->course->id;
            }
        }

        return view('teach_marks', [
            'groups' => $groups,
            'students' => $students,
            'dates' => $dates,
            'courseId' => $courseId,
        ]);
    }



    private function generateDates($daysOfWeek)
    {
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addWeeks(4);
        $dates = [];

        while ($startDate->lte($endDate)) {
            if (in_array($startDate->format('D'), $daysOfWeek)) {
                $dates[] = $startDate->format('Y-m-d');
            }
            $startDate->addDay();
        }

        return $dates;
    }


    public function store(Request $request)
    {
        $data = $request->all();
        $marks = $data['marks'];

        foreach ($marks as $studentId => $studentMarks) {
            $courseId = $data['course'][$studentId]['course_id'];

            foreach ($studentMarks as $date => $mark) {
                // Проверяем, если оценка не равна 0, то сохраняем ее
                if ($mark != '0') {
                    Mark::updateOrCreate(
                        [
                            'student_id' => $studentId,
                            'course_id' => $courseId,
                            'date' => $date,
                        ],
                        [
                            'mark' => (int)$mark,
                        ]
                    );
                }
            }
        }
        return redirect()->back()->with('success', 'Оценки успешно сохранены');
    }

    public function stud_marks(){
        $userId = auth()->user()->id;
        $student = Student::where('user_id', $userId)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Ученик не найден');
        }

        $groups = $student->group()->with('course')->get();

        // Получаем все оценки студента
        $marks = Mark::where('student_id', $student->id)->get()->groupBy('course_id');

        // Генерация дат, исключая воскресенья
        $dates = $this->generateDatesToStuds();

        return view('stud_marks', [
            'student' => $student,
            'groups' => $groups,
            'marks' => $marks,
            'dates' => $dates,
        ]);
    }

    private function generateDatesToStuds()
    {
        $startDate = Carbon::now()->subWeeks(4);
        $endDate = Carbon::now()->addWeeks(4);
        $dates = [];

        while ($startDate->lte($endDate)) {
            if ($startDate->format('D') != 'Sun') {
                $dates[] = $startDate->format('Y-m-d');
            }
            $startDate->addDay();
        }

        return $dates;
    }

}
