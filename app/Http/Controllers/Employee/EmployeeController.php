<?php

namespace App\Http\Controllers\Employee;

use Auth;
use Hash;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Country;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Http\Resources\EmployeeResources;


class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::where('company_id', $this->companyId());
        if (!empty($request->q)) {
            $employees = $employees
                ->whereHas('user', function ($q) use ($request) {
                    $q->where('first_name', 'like', "%$request->q%")->orWhere('last_name', 'like', "%$request->q%");
                })
                ->orWhere('code', 'like', "%$request->q%")
                ->orWhere('number', 'like', "%$request->q%");
        }
        if (!empty($request->status) || $request->status != '') {
            $employees = $employees->whereHas('user', function ($q) use ($request) {
                $q->where('active_status', '=', $request->status);
            });
        }
        return Inertia::render('Employee/Index', [
            'employees' => EmployeeResources::collection($employees->paginate(10)->append($request->all())),
        ]);
    }

    public function create()
    {
        return Inertia::render('Employee/Form');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
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
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }
        $employee = Employee::where('company_id', $this->companyId())->first();
        if ($employee) {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'image_id' => $request->image_id,
            ]);

            if (
                $employee = Employee::create([
                    'code' => 'ARS' . date('Y') . $user->id,
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
                    'company_id' => $this->companyId(),
                ])
            ) {
                return redirect('/employees')->with(['message', 'Employee created successfully']);
            }
        }
        return redirect('/employees')->with(['message', 'Employee not created']);
    }

    public function edit($id)
    {
        $employee = Employee::where('company_id', $this->companyId())->find($id);

        if ($employee) {
            return Inertia::render('Employee/Form', [
                'employee' => new EmployeeResources($employee),
            ]);
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
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
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }
        $employee = Employee::where('company_id', $this->companyId())->find($id);

        if ($employee) {
            if ($request->image_id) {
                User::where('id', $employee->user_id)->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'image_id' => $request->image_id,
                ]);
            } else {
                User::where('id', $employee->user_id)->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                ]);
            }
            if (
                $employee = Employee::where(['id' => $employee->id])->update([
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
                if ($request->requsetingFrom == 'employees/edit') {
                    return redirect(url('employees'))->with('message', 'Employee Updated successfully');
                }
                return redirect(url('employees/' . $id))->with('message', 'Employee Updated successfully');
            }
        }
        return redirect()->with('message', 'Employee not updated');
    }

    public function address($id)
    {
        $employee = $this->employee($id);

        if ($employee->address != null) {
            return Inertia::render('Employee/Address', [
                'address' => new AddressResource($employee?->address),
                'user' => $this->employeeHeader($id),
            ]);
        } else {
            return Inertia::render('Employee/Address', [
                'address' => new AddressResource($employee),
                'user' => $this->employeeHeader($id),
            ]);
        }
        return redirect()->back();
    }
    public function addressEdit($id)
    {
        // dd($id);
        $employee = $this->employee($id);
        // return new AddressResource($employee?->address?->address);
        $countries = Country::get();
        if ($employee->address != null) {
            return Inertia::render('Employee/UserAddress', [
                'address' => new AddressResource($employee?->address),
                'countries' => $countries,
                'user' => $this->employeeHeader($id),

            ]);
        } else {
            return Inertia::render('Employee/UserAddress', [
                'countries' => $countries,
                'user' => $this->employeeHeader($id),
            ]);
        }
        return redirect()->back();
    }

    public function emailUpdate(Request $request, $id)
    {
        // dd($request);
        if ($request->ajax()) {
            if ($request->confirm_password == null) {
                return response()->json(['success' => false, 'message' => 'Please Insert password']);
            }
            if (Hash::check($request->confirm_password, Auth::user()->password)) {
                $userEmail = User::where('id', $id)->update([
                    'email' => $request->email,
                ]);
                return response()->json(['success' => true, 'message' => 'Successfully Change Email!']);
            }
            return response()->json(['success' => false, 'message' => "Don't Have Autherity To change Email! Please insert correct password"]);
        } else {
            return $this->errorAjax();
        }
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        if (strcmp($request->old_password, $user->password == 1)) {
            User::where('id', $id)->update([
                'password' => Hash::make($request->new_password),
            ]);
            return response()->json(['success' => true, 'message' => 'Password changed successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => "Old Password Doesn't match!"]);
        }
    }

    public function overview($id)
    {
        $employee = $this->employee($id);
        if ($employee) {
            return Inertia::render('Employee/Overview', [
                'employee' => new EmployeeResources($employee),
                'user' => $this->employeeHeader($id),
            ]);
        }
        return redirect()->back();
    }

    function overviewEdit($id)
    {
        $employee = $this->employee($id);
        if ($employee) {
            return Inertia::render('Employee/Edit', [
                'employee' => new EmployeeResources($employee),
                'user' => $this->employeeHeader($id),
            ]);
        }
        return redirect()->back();
    }

    public function setting($id)
    {
        $employee = $this->employee($id);
        if ($employee) {
            return Inertia::render('Employee/Setting', [
                'employee' => new EmployeeResources($employee),
                'user' => $this->employeeHeader($id),
            ]);
        }
        return redirect()->back();
    }
    public function security($id)
    {
        $employee = $this->employee($id);
        if ($employee) {
            return Inertia::render('Employee/Security', [
                'employee' => new EmployeeResources($employee),
                'user' => $this->employeeHeader($id),
            ]);
        }
        return redirect()->back();
    }

    public function attendance($id)
    {
        $employee = $this->employee($id);
        if ($employee) {
            return Inertia::render('Employee/Attendance', [
                'employee' => new EmployeeResources($employee),
                'user' => $this->employeeHeader($id),

            ]);
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        $employee = Employee::where('company_id', $this->companyId())->find($id);

        if ($employee->delete()) {
            return response()->json(['success' => true, 'message' => 'Employee has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }

    public function deactivate($id)
    {
        $employee = Employee::join('users', 'users.id', 'employees.user_id')
            ->select('users.id as userId', 'users.active_status', 'employees.id as empId')
            ->where('employees.id', $id)
            ->update([
                'active_status' => 0,
            ]);
        if ($employee) {
            return response()->json(['success' => true, 'message' => 'Employee has been  Deactivating.']);
        }
        return response()->json(['success' => true, 'message' => 'Employee has been  Deactivating.']);
    }
}
