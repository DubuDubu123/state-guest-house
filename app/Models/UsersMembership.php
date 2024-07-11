<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersMembership extends Model
{
    use HasFactory;

    protected $table = "users_membership";

    public function membership_details()
    {
        return $this->belongsto(MembershipTariff::class, 'id', 'membership_type');
    }
}
