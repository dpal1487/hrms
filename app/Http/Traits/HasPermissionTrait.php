<?php
namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
trait HasPermissionsTrait{

    //give permission 

    public function getAllPermission($permission)
    {
        return Permission::whereIn('slug' , $permission)->get();
    }
    public function hasPermission($permission)
    {
        // return (bool)
    }
}

?>