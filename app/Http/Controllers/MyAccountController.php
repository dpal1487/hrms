<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Country;
use Inertia\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AddressResource;
use App\Http\Resources\EmployeeResources;
use App\Http\Resources\UserResource;

class MyAccountController extends Controller
{

    public function overview()
    {
        $user = User::where('id', Auth::user()->id)->first();
        if ($user->address) {
            return Inertia::render(
                'User/Overview',
                [
                    'user' => new UserResource($user),
                    'address' => new AddressResource($user->address),
                ]
            );
        } else {
            return Inertia::render(
                'User/Overview',
                [
                    'user' => new UserResource($user),
                ]
            );
        }
        return redirect()->back();
    }

    public function security()
    {
        $user = User::where('id', Auth::user()->id)->first();
        // return new AddressResource($user->address);
        if ($user->address) {
            return Inertia::render('User/Security', [
                'user' => new UserResource($user),
                'address' => new AddressResource($user->address),
            ]);
        } else {
            return Inertia::render(
                'User/Overview',
                [
                    'user' => new UserResource($user),
                ]
            );
        }
        return redirect()->back();
    }



    public function address()
    {
        $user = User::where('id', Auth::user()->id)->first();


        if ($user->address != null) {
            return Inertia::render('User/Address', [
                'address' => new AddressResource($user?->address),
                'user' => new UserResource($user),
            ]);
        } else {
            return Inertia::render('User/Address', [
                'user' => new UserResource($user),

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
