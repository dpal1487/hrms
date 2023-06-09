<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    
    public function index(Request $request)
    {
        $permissions = new Permission();
        if (!empty($request->q)) {
            $permissions = $permissions
                ->where('name', 'like', "%$request->q");
        }
        if (!empty($request->status) || $request->status != '') {
            $permissions = $permissions->where('status', '=', $request->status);
        }
        return Inertia::render('UserManagement/Permission', [
            'permissions' => PermissionResource::collection($permissions->paginate(10)->appends($request->all())),
        ]);       
    }

  
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }


        $permission = Permission::create([
            'name' => $request->name,

        ]);
        if ($permission) {
            return response()->json([
                'success' => true,
                'message' => 'Permission created Successfully',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Permission not created'
        ]);
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }


        $permission = Permission::where('id', $id)->update([
            'name' => $request->name,
            'guard_name' => 'web',

        ]);
        if ($permission) {
            return response()->json([
                'success' => true,
                'message' => 'Permission updated Successfully',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Permission not updated'
        ]);
    }

   
    public function destroy($id)
    {
        $permission = Permission::where('id', $id)->first();
        if ($permission->delete()) {
            return response()->json(['success' => true, 'message' => 'Permission has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
