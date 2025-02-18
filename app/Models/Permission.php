<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Feature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "feature_id"

    ];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
