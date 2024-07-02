<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Course extends Model
{
    protected $table = 'courses';
    use HasFactory;

    // public function group(){
    //     return $this->hasOne(Group::class);
    // }

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }
    
    public function schedules()
    {
        return $this->hasMany(Shedule::class);
    }
}
