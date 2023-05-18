<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'guard_name'];

    public function permissions()
    {
        return $this->hasMany(RolePermission::class, 'id', 'role_id');
    }

    public function users()
    {
        return $this->hasMany(UserRole::class, 'id', 'role_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($role) {
            $role->slug = Str::slug($role->name);
        });
    }
}
