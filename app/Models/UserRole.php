<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "email",
        "phone_no",
        "address",
        "role_id",
    ] ;

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
