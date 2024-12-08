<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Levels;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function getCourses() {
        $courses = Courses::all();
        return response()->json($courses);
    }

    public function getCourse($id) {
        $course = Courses::find($id);
        return response()->json($course);
    }

    public function getLevelsOfCourse($id) {
        $levels = Levels::where('course_id', $id)->get();
        return response()->json($levels);
    }
}
