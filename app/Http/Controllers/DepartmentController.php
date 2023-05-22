<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $departments = new Department();
        if (!empty($request->q)) {
            $departments = $departments
                ->where('name', 'like', "%$request->q");
        }
        if (!empty($request->status) || $request->status != '') {
            $departments = $departments->where('status', '=', $request->status);
        }
        return Inertia::render('Department/Index', [
            'departments' => DepartmentResource::collection($departments->paginate(10)->appends($request->all())),
        ]);
    }
    public function statusUpdate(Request  $request)
    {

        $department  = Department::where('id', $request->id)->update([
            'status' => $request->status
        ]);
        if ($department) {

            return response()->json([
                'success' => true,
                'message' => 'Status Update successfully',
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ]);
        }
    }
    public function create()
    {
        return Inertia::render('Department/Form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }


        $department = Department::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        if ($department) {
            return response()->json([
                'success' => true,
                'message' => 'Deparment created successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Deparment not created',
            ], 400);
        }
    }


    public function show(Department $department)
    {
        //
    }


    public function edit(Department $department)
    {
        return Inertia::render('Department/Form', [
            'department' => new DepartmentResource($department),
        ]);
    }


    public function update(Request $request, Department $department)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'success' => false], 400);
        }

        $department = Department::where(['id' => $department->id])->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        if ($department) {
            return response()->json([
                'success' => true,
                'message' => 'Deparment updated successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Deparment not updated',
            ], 400);
        }
    }


    public function destroy(Department $department)
    {
        if ($department->delete()) {
            return response()->json(['success' => true, 'message' => 'Deparment has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
    public function selectDelete(Request $request)
    {
        $department = Department::whereIn('id', $request->ids)->delete();

        if ($department) {
            return response()->json(['success' => true, 'message' => 'department has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
