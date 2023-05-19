<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\User;
use App\Http\Resources\EmployeeResources;
use Inertia\Inertia;

class SecurityController extends Controller
{
    public function security($id)
    {
        $employee = $this->employee($id);

        $employee = Employee::where(['id' => $employee->id, 'company_id' => $this->companyId()])->first();
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
                return response()->json(['success' => false, 'message' => 'Please Insert password']);
            }
            if (Hash::check($request->confirm_password, Auth::user()->password)) {
                $userEmail = User::where('id', $id)->update([
                    'email' => $request->email,
                ]);
                if ($userEmail) {

                    return response()->json(['success' => true, 'message' => 'Successfully Change Email!']);
                }
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
    public function deactivate($id)
    {

        $employee = Employee::where(['company_id' => $this->companyId(), 'id' => $id])->first();

        // return $employee->user_id;
        if ($employee) {
            User::where('id', $employee->user_id)->update(['status'=> 0]);
            return response()->json(['success' => true, 'message' => 'Employee has been  Deactivating.']);
        }
        return response()->json(['success' => true, 'message' => 'Employee has been  Deactivating.']);
    }
}
