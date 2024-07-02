<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;

use Carbon\Carbon;

class AttendanceController extends Controller
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

        return view('teach_attendance', [
            'groups' => $groups,
            'students' => $students,
            'dates' => $dates,
            'courseId' => $courseId, // Передаем course_id в представление
        ]);
    }



    private function generateDates($daysOfWeek)
    {
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addWeeks(4); // например, на 4 недели вперед
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
        $attends = $data['attends'];

        foreach ($attends as $studentId => $studentAttend) {
            $courseId = $data['course'][$studentId]['course_id'];

            foreach ($studentAttend as $date => $attend) {
                // Проверяем, если оценка не равна 0, то сохраняем ее
                if ($attend != '0') {
                    Attendance::updateOrCreate(
                        [
                            'student_id' => $studentId,
                            'course_id' => $courseId,
                            'date' => $date,
                        ],
                        [
                            'attendance' => $attend,
                        ]
                    );
                }
            }
        }
        return redirect()->back()->with('success', 'Оценки успешно сохранены');
    }

    public function stud_attends(){
        $userId = auth()->user()->id;
        $student = Student::where('user_id', $userId)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Ученик не найден');
        }

        $groups = $student->group()->with('course')->get();

        // Получаем все оценки студента
        $attends = Attendance::where('student_id', $student->id)->get()->groupBy('course_id');

        // Генерация дат, исключая воскресенья
        $dates = $this->generateDatesToStuds();

        return view('stud_attendance', [
            'student' => $student,
            'groups' => $groups,
            'attends' => $attends,
            'dates' => $dates,
        ]);
    }

    private function generateDatesToStuds()
    {
        $startDate = Carbon::now()->subWeeks(4); // например, 4 недели назад
        $endDate = Carbon::now()->addWeeks(4); // например, на 4 недели вперед
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
