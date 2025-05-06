<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;


class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();

        return response()->json(['employees' => $employees], 200);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ]);

        try {
            $profilePath = null;
            if ($request->hasFile('profile_picture')) {
                $profilePath = $request->file('profile_picture')->store('profiles', 'public');
            }

            $resumeFilePath = null;

            if ($request->hasFile('resume')) {
                $resumeFilePath = $request->file('resume')->store('resumes', 'public');
            }

            Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'skills' => json_encode($request->skills),
                'profile_picture' => $profilePath,
                'resume' => $resumeFilePath,
            ]);

            return response()->json([
                'success' => 'Employee created successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error occured: ' . $th->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        return response()->json(
            $employee,
            200
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ]);

        $employee = Employee::findOrFail($id);

        try {

            if ($request->hasFile('profile_picture')) {
                $employee->profile_picture = $request->file('profile_picture')->store('profiles', 'public');
            }

            if ($request->hasFile('resume')) {
                $employee->resume = $request->file('resume')->store('resumes', 'public');
            }

            $employee->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'skills' => json_encode($request->skills),
                'profile_picture' => $employee->profile_picture,
                'resume' => $employee->resume,
            ]);

            return response()->json([
                'success' => 'Employee Updated successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error occured: ' . $th->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json([
            'message' => 'Employee Deleted successfully',
        ], 200);
    }
}
