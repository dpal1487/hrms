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
    public function index(Request $request)
    {
        $employees = new Employee();
        if (!empty($request->q)) {
            $employees = $employees
                ->whereHas('user', function ($q) use ($request) {
                    $q->where('first_name', 'like', "%$request->q%")->orWhere('last_name', 'like', "%$request->q%");
                })
                ->orWhere('code', 'like', "%$request->q%")
                ->orWhere('number', 'like', "%$request->q%");
        }
        return Inertia::render('Employee/Index', [
            'employees' => EmployeeResources::collection($employees->paginate(10)),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Employee/Form');
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
            'emergency_number' => 'required|integer',
            'pan_number' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}/',
            'father_name' => 'required',
            'formalities' => 'required|integer',
            'salary' => 'required',
            'offer_acceptance' => 'required|integer',
            'probation_period' => 'required',
            'date_of_confirmation' => 'required',
            'department_id' => 'required',
        ]);
        $user = User::create([
            'first_name' => $request->first_name,
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
            // return response()->json(['success' => true, 'message' => 'Employee created successfully']);

            return redirect('/employees');
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
        $employee = Employee::find($id);

        return Inertia::render('Employee/View', [
            'employee' => new EmployeeResources($employee),
        ]);

        return $employee;
    }

    public function edit($id)
    {
        $employee = Employee::find($id);

        // $employee = new EmployeeResources($employee);

        return Inertia::render('Employee/Form', [
            'employee' => new EmployeeResources($employee),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_joining' => 'required',
            'number' => 'required|numeric',
            'qualification' => 'required',
            'emergency_number' => 'required|integer',
            'pan_number' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}/',
            'father_name' => 'required',
            'formalities' => 'required|integer',
            'salary' => 'required',
            'offer_acceptance' => 'required|integer',
            'probation_period' => 'required',
            'date_of_confirmation' => 'required',
            'department_id' => 'required',
        ]);

        $employee = Employee::find($id);

        $employee = new EmployeeResources($employee);

        $user = User::where(['id' => $employee->user->id])->get();

        $user = User::where(['id' => $employee->user->id])->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        if (
            $employee = Employee::where(['id' => $employee->id])->update([
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
                'department_id' => $request->department_id,
                'user_id' => $employee->user->id,
            ])
        ) {
            // return response()->json(['success'=>true,'message'=>'Employee Updated successfully']);

            return redirect('/employees');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if ($employee->delete()) {
            return response()->json(['success' => true, 'message' => 'Employee has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
