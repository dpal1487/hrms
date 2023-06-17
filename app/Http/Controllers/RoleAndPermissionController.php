<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\Role as ModelsRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Image;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class RoleAndPermissionController extends Controller
{

    public function index()
    {
        $permissions = Permission::get();
        $roles = Role::get();
        return Inertia::render('UserManagement/Roles/RoleList', [
            'permissions' => PermissionResource::collection($permissions),
            'roles' => RoleResource::collection($roles),
        ]);
    }
    public function userList(Request $request)
    {
        $roles = ModelsRole::get();
        $users = User::get();
        return Inertia::render('UserManagement/Users/UserList', [
            'roles' => RoleResource::collection($roles),
            'users' => UserResource::collection($users),
        ]);
    }

    public function userEdit($id)
    {
        $user = User::find($id);
        $roles = ModelsRole::get();

        return Inertia::render('UserManagement/Users/UserEdit', [
            'user' => new UserResource($user),
            'roles' => RoleResource::collection($roles),

        ]);
    }

    public function roleView()
    {
        return Inertia::render(('UserManagement/Roles/RoleView'));
    }



    public function avatarImage(Request $request)
    {


        if ($request->ajax()) {

            if (Auth::user()) {
                $image = $request->file('image');
                if ($image) {
                    $extension = $request->image->extension();
                    $file_path = 'assets/images/users/avatar/';
                    $name = time() . '_' . $request->image->getClientOriginalName();

                    $result = Image::make($image)->save($file_path  . $name);

                    $result->resize(200, 200);

                    $result = $result->save($file_path . $name);

                    $userAvatar = User::where('id', $request->id)->update([
                        'avatar' => $name,
                        'full_path' => url($file_path . $name),
                    ]);
                    if ($userAvatar) {
                        return response()->json([
                            'success' => true,
                            'data' => $userAvatar,
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Image uploade Fail',

                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Do not have permission to change image'
                ], 400);
            }
        } else {
            return $this->errorAjax();
        }
    }
    public function update(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first()]);
        }
        $user = User::where('id', $id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ]);
        if ($user) {
            return redirect("/users")->with('flash', ['message' => 'User successfully updated.']);
        }
        return redirect()->back()->withErrors(['Opps something went wrong!']);
    }

    
}
