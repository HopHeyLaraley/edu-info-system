<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shedule;
use App\Models\Course;

class SheduleController extends Controller
{
    //
    public function shedule(){

        $courses = Course::all();

        $mondayShedules = Shedule::where('day_of_week', 'mon')->get();

        // Создание пустого массива для хранения данных о расписании на понедельник
        $monday = [];

        // Обход всех элементов расписания на понедельник
        foreach ($mondayShedules as $shedule) {
            // Получение данных о курсе по course_id
            $courseName = Course::find($shedule->course_id)->name;

            // Добавление данных в массив $monday
            $monday[] = [
                'id' => $shedule->id,
                'course_name' => $courseName,
                'sequence' => $shedule->sequence,
                'day_of_week' => $shedule->day_of_week,
            ];
        }
        usort($monday, function($a, $b) {
            return $a['sequence'] - $b['sequence'];
        });


        $tuesdayShedules = Shedule::where('day_of_week', 'tue')->get();
        // Создание пустого массива для хранения данных о расписании на понедельник
        $tuesday = [];

        // Обход всех элементов расписания на понедельник
        foreach ($tuesdayShedules as $shedule) {
            // Получение данных о курсе по course_id
            $courseName = Course::find($shedule->course_id)->name;

            // Добавление данных в массив $monday
            $tuesday[] = [
                'id' => $shedule->id,
                'course_name' => $courseName,
                'sequence' => $shedule->sequence,
                'day_of_week' => $shedule->day_of_week,
            ];
        }
        usort($tuesday, function($a, $b) {
            return $a['sequence'] - $b['sequence'];
        });


        $wednesdayShedules = Shedule::where('day_of_week', 'wed')->get();
        // Создание пустого массива для хранения данных о расписании на понедельник
        $wednesday = [];

        // Обход всех элементов расписания на понедельник
        foreach ($wednesdayShedules as $shedule) {
            // Получение данных о курсе по course_id
            $courseName = Course::find($shedule->course_id)->name;

            // Добавление данных в массив $monday
            $wednesday[] = [
                'id' => $shedule->id,
                'course_name' => $courseName,
                'sequence' => $shedule->sequence,
                'day_of_week' => $shedule->day_of_week,
            ];
        }
        usort($wednesday, function($a, $b) {
            return $a['sequence'] - $b['sequence'];
        });


        $thursdayShedules = Shedule::where('day_of_week', 'thu')->get();
        // Создание пустого массива для хранения данных о расписании на понедельник
        $thursday = [];

        // Обход всех элементов расписания на понедельник
        foreach ($thursdayShedules as $shedule) {
            // Получение данных о курсе по course_id
            $courseName = Course::find($shedule->course_id)->name;

            // Добавление данных в массив $monday
            $thursday[] = [
                'id' => $shedule->id,
                'course_name' => $courseName,
                'sequence' => $shedule->sequence,
                'day_of_week' => $shedule->day_of_week,
            ];
        }
        usort($thursday, function($a, $b) {
            return $a['sequence'] - $b['sequence'];
        });


        $fridayShedules = Shedule::where('day_of_week', 'fri')->get();
        // Создание пустого массива для хранения данных о расписании на понедельник
        $friday = [];

        // Обход всех элементов расписания на понедельник
        foreach ($fridayShedules as $shedule) {
            // Получение данных о курсе по course_id
            $courseName = Course::find($shedule->course_id)->name;

            // Добавление данных в массив $monday
            $friday[] = [
                'id' => $shedule->id,
                'course_name' => $courseName,
                'sequence' => $shedule->sequence,
                'day_of_week' => $shedule->day_of_week,
            ];
        }
        usort($friday, function($a, $b) {
            return $a['sequence'] - $b['sequence'];
        });


        $saturdayShedules = Shedule::where('day_of_week', 'sat')->get();
        // Создание пустого массива для хранения данных о расписании на понедельник
        $saturday = [];

        // Обход всех элементов расписания на понедельник
        foreach ($saturdayShedules as $shedule) {
            // Получение данных о курсе по course_id
            $courseName = Course::find($shedule->course_id)->name;

            // Добавление данных в массив $monday
            $saturday[] = [
                'id' => $shedule->id,
                'course_name' => $courseName,
                'sequence' => $shedule->sequence,
                'day_of_week' => $shedule->day_of_week,
            ];
        }
        usort($saturday, function($a, $b) {
            return $a['sequence'] - $b['sequence'];
        });

        return view('shedule')->with([
            'courses' => $courses,
            'monday' => $monday,
            'tuesday' => $tuesday,
            'wednesday' => $wednesday,
            'thursday' => $thursday,
            'friday' => $friday,
            'saturday' => $saturday,
        ]);
    }

    public function shedule_edit(){

        $courses = Course::all();

        $mondayShedules = Shedule::where('day_of_week', 'mon')->get();

        // Создание пустого массива для хранения данных о расписании на понедельник
        $monday = [];

        // Обход всех элементов расписания на понедельник
        foreach ($mondayShedules as $shedule) {
            // Получение данных о курсе по course_id
            $courseName = Course::find($shedule->course_id)->name;

            // Добавление данных в массив $monday
            $monday[] = [
                'id' => $shedule->id,
                'course_name' => $courseName,
                'sequence' => $shedule->sequence,
                'day_of_week' => $shedule->day_of_week,
            ];
        }
        usort($monday, function($a, $b) {
            return $a['sequence'] - $b['sequence'];
        });


        $tuesdayShedules = Shedule::where('day_of_week', 'tue')->get();
        // Создание пустого массива для хранения данных о расписании на понедельник
        $tuesday = [];

        // Обход всех элементов расписания на понедельник
        foreach ($tuesdayShedules as $shedule) {
            // Получение данных о курсе по course_id
            $courseName = Course::find($shedule->course_id)->name;

            // Добавление данных в массив $monday
            $tuesday[] = [
                'id' => $shedule->id,
                'course_name' => $courseName,
                'sequence' => $shedule->sequence,
                'day_of_week' => $shedule->day_of_week,
            ];
        }
        usort($tuesday, function($a, $b) {
            return $a['sequence'] - $b['sequence'];
        });


        $wednesdayShedules = Shedule::where('day_of_week', 'wed')->get();
        // Создание пустого массива для хранения данных о расписании на понедельник
        $wednesday = [];

        // Обход всех элементов расписания на понедельник
        foreach ($wednesdayShedules as $shedule) {
            // Получение данных о курсе по course_id
            $courseName = Course::find($shedule->course_id)->name;

            // Добавление данных в массив $monday
            $wednesday[] = [
                'id' => $shedule->id,
                'course_name' => $courseName,
                'sequence' => $shedule->sequence,
                'day_of_week' => $shedule->day_of_week,
            ];
        }
        usort($wednesday, function($a, $b) {
            return $a['sequence'] - $b['sequence'];
        });


        $thursdayShedules = Shedule::where('day_of_week', 'thu')->get();
        // Создание пустого массива для хранения данных о расписании на понедельник
        $thursday = [];

        // Обход всех элементов расписания на понедельник
        foreach ($thursdayShedules as $shedule) {
            // Получение данных о курсе по course_id
            $courseName = Course::find($shedule->course_id)->name;

            // Добавление данных в массив $monday
            $thursday[] = [
                'id' => $shedule->id,
                'course_name' => $courseName,
                'sequence' => $shedule->sequence,
                'day_of_week' => $shedule->day_of_week,
            ];
        }
        usort($thursday, function($a, $b) {
            return $a['sequence'] - $b['sequence'];
        });


        $fridayShedules = Shedule::where('day_of_week', 'fri')->get();
        // Создание пустого массива для хранения данных о расписании на понедельник
        $friday = [];

        // Обход всех элементов расписания на понедельник
        foreach ($fridayShedules as $shedule) {
            // Получение данных о курсе по course_id
            $courseName = Course::find($shedule->course_id)->name;

            // Добавление данных в массив $monday
            $friday[] = [
                'id' => $shedule->id,
                'course_name' => $courseName,
                'sequence' => $shedule->sequence,
                'day_of_week' => $shedule->day_of_week,
            ];
        }
        usort($friday, function($a, $b) {
            return $a['sequence'] - $b['sequence'];
        });


        $saturdayShedules = Shedule::where('day_of_week', 'sat')->get();
        // Создание пустого массива для хранения данных о расписании на понедельник
        $saturday = [];

        // Обход всех элементов расписания на понедельник
        foreach ($saturdayShedules as $shedule) {
            // Получение данных о курсе по course_id
            $courseName = Course::find($shedule->course_id)->name;

            // Добавление данных в массив $monday
            $saturday[] = [
                'id' => $shedule->id,
                'course_name' => $courseName,
                'sequence' => $shedule->sequence,
                'day_of_week' => $shedule->day_of_week,
            ];
        }
        usort($saturday, function($a, $b) {
            return $a['sequence'] - $b['sequence'];
        });

        return view('shedule_edit')->with([
            'courses' => $courses,
            'monday' => $monday,
            'tuesday' => $tuesday,
            'wednesday' => $wednesday,
            'thursday' => $thursday,
            'friday' => $friday,
            'saturday' => $saturday,
        ]);
    }

    public function shedule_destroy($id){
        $shedule = Shedule::findOrFail($id);
        $shedule->delete();

        return redirect()->route('shedule_edit');
    }

    public function shedule_store(Request $request){

        
        $data = $request->validate([
            'course' => 'required|numeric',
            'sequence' => 'required|numeric',
            'day_of_week' => 'required|string',
        ]);

        $schedule = new Shedule();
        $schedule->course_id = $data['course'];
        $schedule->sequence = $data['sequence'];
        $schedule->day_of_week = $data['day_of_week'];

        $schedule->save();

        return redirect()->route('shedule_edit');
    }
}
