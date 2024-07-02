<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Admin;
use App\Models\StudentParent;
use App\Models\Teacher;


class PageController extends Controller
{
    public function dashboard(){
        $user = Auth::user();
        $sub_user = "";
        if($user->role==="user"){
        }
        else if($user->role==="admin")
        {
            $sub_user = Admin::where('user_id', $user->id)->first();
        }
        else if($user->role==="student")
        {
            $sub_user = Student::where('user_id', $user->id)->first();
        }
        else if($user->role==="teacher")
        {
            $sub_user = Teacher::where('user_id', $user->id)->first();
        }
        else if($user->role==="parent")
        {
            $sub_user = StudentParent::where('user_id', $user->id)->first();
        }

        return view('dashboard')->with([
            'user' => $user,
            'sub_user' => $sub_user,
        ]);;
    }
}
