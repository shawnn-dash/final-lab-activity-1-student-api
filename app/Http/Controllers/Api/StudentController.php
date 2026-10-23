<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    // READ ALL STUDENTS
    public function index()
    {
        return response()->json(Student::all());
    }

    // CREATE STUDENT
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|unique:students,student_id',
            'full_name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'year_level' => 'required|integer|between:1,4',
        ]);

        $student = Student::create($validated);

        return response()->json($student, 201);
    }

    // READ ONE STUDENT
    public function show(Student $student)
    {
        return response()->json($student);
    }

    // UPDATE STUDENT

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_id' => [
                'sometimes',
                'required',
                'string',
                Rule::unique('students', 'student_id')
                    ->ignore($student->id),
            ],
            'full_name' => 'sometimes|required|string|max:255',
            'course' => 'sometimes|required|string|max:255',
            'year_level' => 'sometimes|required|integer|between:1,4',
        ]);

        $student->update($validated);

        return response()->json([
            'message' => 'Student updated successfully.',
            'student' => $student->refresh()
        ], 200);
    }


    // DELETE STUDENT
    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully.'
        ]);
    }
}
