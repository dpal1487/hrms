<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }

        return $request;


        $role = Role::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'guard_name' => 'web',

        ]);
        if ($role) {
            return response()->json([
                'success' => true,
                'message' => 'Role created Successfully',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Role not created'
        ]);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }


        $permission = Role::where('id', $id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),

        ]);
        if ($permission) {
            return response()->json([
                'success' => true,
                'message' => 'Role updated Successfully',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Role not updated'
        ]);
    }
}
