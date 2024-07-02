<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'group';
    protected $fillable = [
        'course_id',
        'difficulty_level',
        'name',
    ];
    use HasFactory;

    public function student(){
        return $this->belongsToMany(Student::class, 'group_student', 'group_id', 'student_id');
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
