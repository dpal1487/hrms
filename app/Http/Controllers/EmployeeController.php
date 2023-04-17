<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EmployeeResources;
use App\Http\Resources\AddressResource;

use Inertia\Inertia;
use App\Models\Employee;
use App\Models\User;
use Auth;
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
        return Inertia::render('Employee/Index', [
            'employees' => EmployeeResources::collection($employees->paginate(10)),
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
            'image_id' => $Imagefile->id,
            'avatar' => $image,
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

        return Inertia::render('Employee/Address', [
            'employee' => new EmployeeResources($employee),
        ]);
    }

    public function addressEdit($id)
    {
        $employee = Employee::find($id);
        // return new EmployeeResources($employee);

        return Inertia::render('Employee/UserAddress', [
            'employee' => new EmployeeResources($employee),
        ]);
    }
    public function attendance($id)
    {
        $employee = Employee::find($id);

        return Inertia::render('Employee/Attendance', [
            'employee' => new EmployeeResources($employee),
        ]);
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
        $image = $request->file('image');

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
                'image_id' => $Imagefile->id,
                'avatar' => $image,
            ]);
        } else {
            $user = User::where(['id' => $employee->user->id])->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
            ]);
        }

        // $user = User::where(['id' => $employee->user->id])->update([
        //     'first_name' => $request->first_name,
        //     'last_name' => $request->last_name,
        //     'image_id' => $Imagefile->id,
        //     'avatar' => $image,
        // ]);

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

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if ($employee->delete()) {
            return response()->json(['success' => true, 'message' => 'Employee has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
