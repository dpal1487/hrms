<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EmployeeResources;
use App\Http\Resources\AddressResource;

use Inertia\Inertia;
use App\Models\Employee;
use App\Models\Country;
use App\Models\User;
use Auth;
use Hash;
use Image;
use App\Models\Image as DBImage;

class EmployeeController extends Controller
{
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
        if (!empty($request->status))  {
            $employees = $employees->whereHas('user', function ($q) use ($request) {
                $q->where('active_status','=', $request->status);
            });
        }
        return Inertia::render('Employee/Index', [
            'employees' => EmployeeResources::collection($employees->paginate(4)),
        ]);
    }

    public function create()
    {
        return Inertia::render('Employee/Form');
    }

    public function store(Request $request)
    {
        $request->validate([
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
            'department_id' => 'required',
        ]);

        $image = $request->file('image');

        // dd($image);

        if ($image) {
            $extension = $request->image->extension();
            $file_path = 'assets/images/users/';
            $name = time() . '_' . $request->image->getClientOriginalName();

            $result = Image::make($image)->save($file_path . 'original/' . $name);
            $smallthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_small_' . '.' . $extension;
            $mediumthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_medium_' . '.' . $extension;

            $smallThumbnailFolder = 'assets/images/users/thumbnail/small/';
            $mediumThumbnailFolder = 'assets/images/users/thumbnail/medium/';

            // $result = $result->save($file_path.'original/'.$name);

            $result->resize(200, 200);
            $result = $result->save($file_path . '/thumbnail/small/' . $smallthumbnail);

            $result->resize(100, 100);
            $result = $result->save($file_path . '/thumbnail/medium/' . $mediumthumbnail);

            $Imagefile = DBImage::create([
                'name' => $name,
                'original_path' => url($file_path),
                'small_path' => url($file_path . $name),
                'medium_path' => url($smallThumbnailFolder . $smallthumbnail),
                'large_path' => url($mediumThumbnailFolder . $mediumthumbnail),
            ]);

            // dd($Imagefile);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'image_id' => $Imagefile->id,
            'avatar' => $image,
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
            ])
        ) {
            // return response()->json(['success' => true, 'message' => 'Employee created successfully']);

            return redirect('/employees')->with(['message', 'Employee created successfully']);
        }
        return redirect('/employees')->with(['message', 'Employee not created']);
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
        // return route('employees.add');
        // dd($request->requsetingFrom);
        $image = $request->file('image');

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            // 'email' => 'required',
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

        $image = $request->file('image');

        if ($image) {
            $extension = $request->image->extension();
            $file_path = 'assets/images/users/';
            $name = time() . '_' . $request->image->getClientOriginalName();

            $result = Image::make($image)->save($file_path . 'original/' . $name);
            $smallthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_small_' . '.' . $extension;
            $mediumthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_medium_' . '.' . $extension;

            $smallThumbnailFolder = 'assets/images/users/thumbnail/small/';
            $mediumThumbnailFolder = 'assets/images/users/thumbnail/medium/';

            // $result = $result->save($file_path.'original/'.$name);

            $result->resize(200, 200);
            $result = $result->save($file_path . '/thumbnail/small/' . $smallthumbnail);

            $result->resize(100, 100);
            $result = $result->save($file_path . '/thumbnail/medium/' . $mediumthumbnail);

            $Imagefile = DBImage::create([
                'name' => $name,
                'original_path' => url($file_path),
                'small_path' => url($file_path . $name),
                'medium_path' => url($smallThumbnailFolder . $smallthumbnail),
                'large_path' => url($mediumThumbnailFolder . $mediumthumbnail),
            ]);
            // dd($Imagefile);
        }

        if ($image) {
            $user = User::where(['id' => $employee->user->id])->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'image_id' => $Imagefile->id,
                'avatar' => $image,
            ]);
        } else {
            $user = User::where(['id' => $employee->user->id])->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
            ]);
        }

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
            if ($request->requsetingFrom == 'employees/edit') {
                return redirect(url('employees'))->with('message', 'Employee Updated successfully');
            }
            return redirect(url('employees/' . $id . '/overview'))->with('message', 'Employee Updated successfully');
        }
        return redirect()->with('message', 'Employee not updated');
    }

    public function emailUpdate(Request $request, $id)
    {
        // dd($request);
        if (Hash::check($request->confirm_password, Auth::user()->password)) {
            $userEmail = User::where('id', $id)->update([
                'email' => $request->email,
            ]);
            return response()->json(['success' => true, 'message' => 'Successfully Change Email!']);
        } else {
            return response()->json(['success' => false, 'message' => "Don't Have Autherity To change Email! Please insert correct password"]);
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
    public function show($id)
    {
        $employee = Employee::find($id);

        return Inertia::render('Employee/Overview', [
            'employee' => new EmployeeResources($employee),
        ]);
    }
    public function overview($id)
    {
        $employee = Employee::find($id);

        return Inertia::render('Employee/Overview', [
            'employee' => new EmployeeResources($employee),
        ]);
    }

    function overviewEdit($id)
    {
        $employee = Employee::find($id);

        return Inertia::render('Employee/Edit', [
            'employee' => new EmployeeResources($employee),
        ]);
    }

    public function setting($id)
    {
        $employee = Employee::find($id);

        return Inertia::render('Employee/Setting', [
            'employee' => new EmployeeResources($employee),
        ]);
    }
    public function security($id)
    {
        $employee = Employee::find($id);

        return Inertia::render('Employee/Security', [
            'employee' => new EmployeeResources($employee),
        ]);
    }
    public function address($id)
    {
        $employee = Employee::find($id);
        // return new EmployeeResources($employee);

        return Inertia::render('Employee/Address', [
            'employee' => new EmployeeResources($employee),
        ]);
    }

    public function addressEdit($id)
    {
        $employee = Employee::find($id);
        $countries = Country::get();

        // dd($countries);

        return Inertia::render('Employee/UserAddress', [
            'employee' => new EmployeeResources($employee),
            'countries' => $countries,
        ]);
    }
    public function attendance($id)
    {
        $employee = Employee::find($id);

        return Inertia::render('Employee/Attendance', [
            'employee' => new EmployeeResources($employee),
        ]);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
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
