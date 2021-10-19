<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;


class EmployeeController extends Controller
{
    //get all employees
    public function index()
    {
        $employees = Employee::all();
        return $employees;
    }
    //save employee
    public function store(Request $request)
    {
        $name = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
        $surname = filter_var($request->input('surname'), FILTER_SANITIZE_STRING);
        $email = filter_var($request->input('email'), FILTER_SANITIZE_EMAIL);
        $job_title = filter_var($request->input('job_title'), FILTER_SANITIZE_STRING);
        $phone = filter_var($request->input('phone'), FILTER_SANITIZE_STRING);
        $active = $request->input('active');
        $department_id = filter_var($request->input('department_id'), FILTER_SANITIZE_NUMBER_INT);

        $request->validate([
            'name' => 'required',
            'surname' => 'required',
        ]);

        $employee = new Employee();
        $employee ->name = $name;
        $employee ->surname = $surname;
        $employee ->email = $email;
        $employee ->job_title = $job_title;
        $employee ->phone = $phone;
        $employee ->active = $active;
        $employee ->department_id = $department_id;

        if($employee->save()){
            return "success";
        }else{
            return "error";
        } 
    }

    //edit employee
    // public function update(Request $request, $id)
    // {
    //     // $name = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
    //     // $surname = filter_var($request->input('surname'), FILTER_SANITIZE_STRING);
    //     // $email = filter_var($request->input('email'), FILTER_SANITIZE_EMAIL);
    //     // $job_title = filter_var($request->input('job_title'), FILTER_SANITIZE_STRING);
    //     // $phone = filter_var($request->input('phone'), FILTER_SANITIZE_STRING);
    //     // $active = $request->input('active');
    //     // $department_id = filter_var($request->input('department_id'), FILTER_SANITIZE_NUMBER_INT);

    //     // $request->validate([
    //     //     'name' => 'required',
    //     //     'surname' => 'required',
    //     // ]);

    //     $employee = Employee::find($id);
      
        // $employee ->name = $name;
        // $employee ->surname = $surname;
        // $employee ->email = $email;
        // $employee ->job_title = $job_title;
        // $employee ->phone = $phone;
        // $employee ->active = $active;
        // $employee ->department_id = $department_id;


    //     $employee->update($request->all());
    //     return $employee;
    //     // if($employee->save()){
    //     //     return response()->json(['status' => true, 'message' => 'Employee updated successfully']);
    //     // } 
    //     // else{
    //     //     return response()->json(['status' => false, 'message' => 'There is some error, please try again']);

    //     // }
        

        
       
    // }

    
    public function update(Request $request, $id)
    {

        $employee = Employee::find($id);

        $employee->update($request->all());

        return response()->json($employee, 200);
    }

    public function delete($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();         

    }
}
