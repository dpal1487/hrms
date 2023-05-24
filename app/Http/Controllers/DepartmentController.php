<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DepartmentResource;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Department/Form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
                'message' => 'Department created successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Department not created',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        // $department = Department::find($id);

        return Inertia::render('Department/Form', [
            'department' => new DepartmentResource($department),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'success' => false], 400);
        }

        // $conversionrate = Department::find($id);


        $department = Department::where(['id' => $department->id])->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        if ($department) {
            return response()->json([
                'success' => true,
                'message' => 'Department updated successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Department not updated',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        // $conversionrate = ConversionRate::find($id);
        if ($department->delete()) {
            return response()->json(['success' => true, 'message' => 'Department has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
    public function selectDelete(Request $request)
    {
        $department = Department::whereIn('id', $request->ids)->delete();

        if ($department) {
            return response()->json(['success' => true, 'message' => 'Department has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
