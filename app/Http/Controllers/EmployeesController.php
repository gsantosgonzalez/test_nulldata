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
            'name' => 'required|unique:tools',
            'description' => 'required',
            'type_id' => 'required|exists:types,id',
            'area_id' => 'required|exists:areas,id',
            'responsible_id' => 'required|exists:responsibles,id'
        ]);

        if($validation->fails()){
            return response()->json(['status' => 0, 'errors' => $validation->errors()]);
        }

        $tool = \App\Tool::create($request->all());

        return response()->json(['status' => 1, 'tool' => $tool]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->input, [
            'name' => [
                'required',
                Rule::unique('tools')->ignore($request->id)
            ],
            'description' => 'required',
            'type_id' => 'required|exists:types,id',
            'area_id' => 'required|exists:areas,id',
            'responsible_id' => 'required|exists:responsibles,id'
        ]);

        if($validator->fails()){
            return response()->json(['status' => 0, 'errors' => $validator->errors()]);
        }
        else{
            $tool = \App\Tool::find($request->id)->update($request->input);
            return response()->json(['status' => 1]);
        }
    }

    public function destroy($id)
    {
        Tool::find($id)->delete();
        return response()->json(['status' => 1]);
    }

    public function getFilteredTools(Request $request) {

    }

}