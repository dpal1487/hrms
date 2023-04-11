<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EmployeeResources;
use Inertia\Inertia;
use App\Models\Employee;
use App\Models\User;
use Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::get();
        return Inertia::render('Employee/Index', [
            'employees' => EmployeeResources::collection($employees),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Employee/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_joining' => 'required',
            'number' => 'required|numeric',
            'qualification' => 'required',
            'emergency_number' => 'required',
            'pan_number' => 'required',
            'father_name' => 'required',
            'formalities' => 'required',
            'salary' => 'required',
            'offer_acceptance' => 'required',
            'probation_period' => 'required',
            'date_of_confirmation' => 'required',
            'notice_period' => 'required',
            'last_working_day' => 'required',
            'full_final' => 'required',
            'department_id' => 'required',
        ]);
        $user = User::create([
            'fisrt_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);
        if (
            $employee = Employee::create([
                'code' => 'ABC123',

                'date_of_joining' => $request->date_of_joining,
                'number' => $request->number,
                'qualification' => $request->qualification,
                'emergency_number' => $request->emergency_number,
                'pan_number' => $request->pan_number,
                'father_name' => $request->father_name,
                'formalities' => $request->formalities,
                'salary' => $request->salary,
                'offer_acceptance' => $request->offer_acceptance,
                'probation_period' => $request->probation_period,
                'date_of_confirmation' => $request->date_of_confirmation,
                'notice_period' => $request->notice_period,
                'last_working_day' => $request->last_working_day,
                'full_final' => $request->full_final,
                'department_id' => $request->department_id,
                'user_id' => $user->id,
            ])
        ) {
            return redirect("/employee/$employee->id");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
