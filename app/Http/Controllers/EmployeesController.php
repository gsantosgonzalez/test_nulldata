<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Employee;

class EmployeesController extends Controller
{
    
    public function index()
    {
    	$employees = Employee::all();
    	$employees->load('addresses');
    	return view('employees/index')->with(['employees' => $employees]);
    }

}
