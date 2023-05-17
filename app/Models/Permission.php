<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Permission extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug'];
    public function roles()
    {
        return $this->hasMany(Role::class, 'id', 'role_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'role_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($permission) {
            $permission->slug = Str::slug($permission->name);
        });
    }
}
