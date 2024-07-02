<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SheduleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TelegramController;
use App\Models\Shedule;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [TelegramController::class, 'main']);

Route::get('/dashboard', [PageController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/shedule', [SheduleController::class, 'shedule'])->middleware(['auth', 'verified'])->name('shedule');

Route::get('/shedules', [SheduleController::class, 'shedule_edit'])->middleware(['auth', 'verified'])->name('shedule_edit');
Route::post('/shedules/add', [SheduleController::class, 'shedule_store'])->middleware(['auth', 'verified'])->name('shedule_store');
Route::delete('/shedules/delete/{id}', [SheduleController::class, 'shedule_destroy'])->middleware(['auth', 'verified'])->name('schedule_destroy');

Route::get('/courses', [CourseController::class, 'courses'])->middleware(['auth', 'verified'])->name('course_edit');
Route::post('/courses/add', [CourseController::class, 'store'])->middleware(['auth', 'verified'])->name('course_store');
Route::delete('/courses/delete/{id}', [CourseController::class, 'course_destroy'])->middleware(['auth', 'verified'])->name('course_destroy');

Route::get('/courses_list', [CourseController::class, 'courses_list'])->middleware(['auth', 'verified'])->name('courses');
// Route::post('/courses_list', [CourseController::class, 'courses_list'])->middleware(['auth', 'verified'])->name('courses');
Route::post('/course_store_test', [CourseController::class, 'course_store_test'])->middleware(['auth', 'verified'])->name('course_store_test');
Route::post('/course_sign_up/{id}', [CourseController::class, 'course_sign_up'])->middleware(['auth', 'verified'])->name('course_sign_up');
Route::post('/submit_test', [CourseController::class, 'submit_test'])->middleware(['auth', 'verified'])->name('submit_test');

Route::get('/teach_marks', [MarksController::class, 'index'])->middleware(['auth', 'verified'])->name('teach_marks');
Route::post('/teach_marks', [MarksController::class, 'store'])->middleware(['auth', 'verified'])->name('marks_store');

Route::get('/stud_marks', [MarksController::class, 'stud_marks'])->middleware(['auth', 'verified'])->name('stud_marks');

Route::get('/teach_attendance', [AttendanceController::class, 'index'])->middleware(['auth', 'verified'])->name('teach_attendance');
Route::post('/teach_attendance', [AttendanceController::class, 'store'])->middleware(['auth', 'verified'])->name('attendance_store');

Route::get('/stud_attendance', [AttendanceController::class, 'stud_attends'])->middleware(['auth', 'verified'])->name('stud_attendance');

Route::get('/test', function(){return view('test');});


Route::get('/files', [FileController::class, 'index'])->name('files_index');
Route::post('/files/upload', [FileController::class, 'upload'])->name('files_upload');
Route::post('/files/create-folder', [FileController::class, 'createFolder'])->name('files_createFolder');
Route::get('/files/{path}', [FileController::class, 'show'])->where('path', '.*')->name('files_show');
Route::get('/files-back/{path}', [FileController::class, 'goBack'])->where('path', '.*')->name('files_goBack');
Route::post('/files/download', [FileController::class, 'download'])->name('files_download');


// Route::get('/files', function(){
//     return view('files');
// })->middleware(['auth', 'verified'])->name('files');

Route::get('/chat', [ChatController::class, 'loadMessages'])->middleware(['auth', 'verified'])->name('chat');
// Route::get('/loadmessages', [ChatController::class, 'loadMessages'])->name('load_messages');
Route::post('/sendmessage', [ChatController::class, 'sendMessage'])->name('send_message');
Route::post('/telegram/webhook', [ChatController::class, 'handleWebhook'])->name('telegram_webhook');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
