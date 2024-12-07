<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function getCourses() {
        $courses = Courses::all();
        return response()->json($courses);
    }
}
