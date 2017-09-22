<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Validator;

use App\Address;
use App\Employee;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listEmployees()
    {
        if(request('order')){
            if(request('filter')){
                $employees = Employee::where(request('filter'), '=', request('value'))->orderBy(request('order'), 'asc')->get();
                $employees->load('addresses');
                return $employees;
            }
            else {
                $employees = Employee::orderBy(request('order'), 'asc')->get();
                $employees->load('addresses');
                return $employees;
            }
        }
        if(request('filter')){
            $employees = Employee::where(request('filter'), '=', request('value'))->get();
            $employees->load('addresses');
            return $employees;
        }
        $employees = Employee::all();
        $employees->load('addresses');
        return $employees;
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|unique:employees',
            'email' => 'required|email|unique',
            'birthdate' => 'required|date|date_format:d/m/Y'
        ]);

        if($validation->fails()){
            return response()->json(['status' => 0, 'errors' => $validation->errors()]);
        }

        $employee = Employee::create($request->all());

        return response()->json(['status' => 1, 'employee' => $employee]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->input, [
            'name' => [
                'required',
                Rule::unique('employees')->ignore($request->id)
            ],
            'email' => [
                'required',
                Rule::unique('employees')->ignore($request->id)
            ],
            'birthdate' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['status' => 0, 'errors' => $validator->errors()]);
        }
        else{
            $employee = Employee::find($request->id)->update($request->input);
            return response()->json(['status' => 1]);
        }
    }

    public function destroy($id)
    {
        Employee::find($id)->delete();
        return response()->json(['status' => 1]);
    }

}