<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolePermission extends Model
{
    use HasFactory;
    protected $fillable = [
        "role_id",
        "permission_id",
    ] ;

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class);
    // }
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

}
