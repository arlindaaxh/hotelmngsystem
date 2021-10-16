<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
class DepartmentController extends Controller
{
    //get all departments
    public function index()
    {
        $departments = Department::all();
        return $departments;
    }

    //save department
    public function store(Request $request)
    {
        $name = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
        $code = $request->input('code');
        $active = $request->input('active');

        $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        $department = new Department();
        $department ->name = $name;
        $department ->code = $code;
        $department ->active = $active;

        if($department->save()){
            return "success";
        }else{
            return "error";
        } 
    }
}
