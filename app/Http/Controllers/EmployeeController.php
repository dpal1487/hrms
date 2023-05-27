<?php

namespace App\Http\Controllers;

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
use App\Http\Resources\CountryResource;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\EmployeeResources;
use App\Models\Address;
use App\Models\Department;
use App\Models\EmployeeAddress;

class EmployeeController extends Controller
{

    public $department;

    public function __construct()
    {
        $this->department = Department::get();
    }
    public function index(Request $request)
    {
        $employees = Employee::where('company_id', $this->companyId());

        if (!empty($request->q)) {
            $employees =
                $employees->where('first_name', 'like', "%$request->q%")
                ->orWhere('last_name', 'like', "%$request->q%")
                ->orWhere('code', 'like', "%$request->q%")
                ->orWhere('number', 'like', "%$request->q%")
                ->orWhere('salary', 'like', "%$request->q%");
        }

        return Inertia::render('Employee/Index', [
            'employees' => EmployeeResources::collection($employees->paginate(10)->append($request->all())),
        ]);
    }

    public function create()
    {
        return Inertia::render('Employee/Form', [
            'departments' => DepartmentResource::collection($this->department),
        ]);
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
            'department' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first()]);
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $employee =  Employee::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
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
            'department_id' => $request->department,
            'user_id' => $user->id,
            'image_id' => $request->image_id,
            'company_id' => $this->companyId(),
        ]);
        if ($employee) {
            return redirect("/employees")->with('flash', ['message' => 'Employee Successfully created.']);
        }
        return redirect()->back()->withErrors(['message' => "Opps something went wrong"]);
    }

    public function edit($id)
    {
        $employee = Employee::where('company_id', $this->companyId())->find($id);

        if ($employee) {
            return Inertia::render('Employee/Form', [
                'employee' => new EmployeeResources($employee),
                'user' => $this->employeeHeader($id),
                'departments' => DepartmentResource::collection($this->department),

            ]);
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
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
            'department' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first()]);
        }
        $employee = Employee::where('company_id', $this->companyId())->find($id);

        if ($employee) {
            if ($request->image_id) {
                User::where('id', $employee->user_id)->update([
                    'email' => $request->email,

                ]);
            }
            $employee = Employee::where(['id' => $employee->id])->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
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
                'department_id' => $request->department,
                'user_id' => $employee->user->id,
                'image_id' => $request->image_id,

            ]);
            if ($employee) {
                if ($request->page) {
                    return redirect("/employee/$id")->with('flash', ['message' => 'Employee Updated Successfully.']);
                }
                return redirect("/employees")->with('flash', ['message' => 'Employee Updated Successfully.']);
            }
            return redirect()->back()->withErrors(['message' => "Opps something went wrong"]);
        }
        return redirect()->back()->withErrors(['message' => "Don't Have Access"]);
    }

    public function address($id)
    {
        $employee = $this->employee($id);
        $countries = Country::get();


        if ($employee->address != null) {
            return Inertia::render('Employee/Address', [
                'address' => new AddressResource($employee?->address),
                'employee' => new EmployeeResources($employee),
                'countries' => new CountryResource($countries),
                'user' => $this->employeeHeader($id),
            ]);
        } else {
            return Inertia::render('Employee/Address', [
                'address' => new AddressResource($employee),
                'employee' => new EmployeeResources($employee),
                'countries' => new CountryResource($countries),
                'user' => $this->employeeHeader($id),
            ]);
        }
        return redirect()->back();
    }
    public function updateAddress(Request $request, $id)
    {
        $address = [];
        $validator =  Validator::make($request->all(), [
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first()]);
        }
        if (Employee::where(['company_id' => $this->companyId()])->first()) {
            if ($address = EmployeeAddress::where(['employee_id' => $id])->first()) {
                $address = Address::where(['id' => $address->address_id])->update([
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country,
                    'pincode' => $request->pincode,
                    'is_primary' => $request->is_primary ? 1 : 0,
                ]);
                if ($address) {
                    return redirect("/employee/$id/address")->with('flash', ['message' => 'Address successfully updated.']);
                }
            }
            return redirect()->back()->withErrors(['message' => 'Opps something went wrong!']);
        }
        return redirect()->back();
    }

    public function overview($id)
    {
        $employee = $this->employee($id);
        if ($employee) {
            return Inertia::render('Employee/Overview', [
                'employee' => new EmployeeResources($employee),
                'user' => $this->employeeHeader($id),
                'departments' => DepartmentResource::collection($this->department),
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
    public function emailUpdate(Request $request, $id)
    {

        if ($request->ajax()) {
            if ($request->confirm_password == null) {
                return redirect()->back()->withErrors(['message' => "Please Insert password!"]);
            }
            $validator =  Validator::make($request->all(), [
                'email' => 'required|unique:users,email',
            ]);
            if ($validator->fails()) {

                return redirect()->back()->withErrors(['message' => $validator->errors()->first()]);
            }

            $employee = Employee::with('user')->where('id', $id)->first();

            if (Hash::check($request->confirm_password, $employee->user->password)) {

                if ($employee) {
                    $userEmail = User::where('id', $employee->user_id)->update([
                        'email' => $request->email,
                    ]);
                    if ($userEmail) {
                        return redirect("/employee/$id/security")->with('flash', ['message' => 'Email successfully updated.']);
                    }
                }
            }
            return redirect()->back()->withErrors(['message' => "Don't Have Autherity To change Email! Please insert correct password!"]);
        } else {
            return $this->errorAjax();
        }
    }

    public function changePassword(Request $request, $id)
    {

        if ($request->ajax()) {
            $validator =  Validator::make($request->all(), [
                'new_password' => 'required',
                'confirm_password' => 'required',
            ]);
            if ($validator->fails()) {

                return redirect()->back()->withErrors(['message' => $validator->errors()->first()]);
            }

            $employee = Employee::with('user')->where('id', $id)->first();

            if ($employee) {
                User::where('id', $employee->user_id)->update([
                    'password' => Hash::make($request->new_password),
                ]);
                return redirect("/employee/$id/security")->with('flash', ['message' => 'Password changed successfully!']);
            } else {
                return redirect()->back()->withErrors(['message' => "Old Password Doesn't match!"]);
            }
        } else {
            return $this->errorAjax();
        }
    }
    public function deactivate($id)
    {
        $employee = Employee::with('user')->where('id', $id)->first();
        if ($employee) {
            User::where('id', $employee->user_id)->update(['status' => 0]);
            return response()->json(['success' => true, 'message' => 'User has been  Deactivating.']);
        }
        return response()->json(['success' => true, 'message' => "Don't Have Autherity To Deactivate"]);
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
    public function selectDelete(Request $request)
    {
        $employee = Employee::whereIn('id', $request->ids)->delete();

        if ($employee) {
            return response()->json(['success' => true, 'message' => 'Employee has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
