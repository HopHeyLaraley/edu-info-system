<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    use HasFactory;

    public function group(){
        return $this->belongsToMany(Group::class, 'group_student', 'student_id', 'group_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
