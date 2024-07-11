<?php

namespace App\Models\Admin;

use App\Base\Uuid\UuidModel;
use App\Models\Traits\HasActive;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasActiveCompanyKey;
use App\Models\User;

class ComplaintTitle extends Model
{
    use HasActive,UuidModel,HasActiveCompanyKey;

    protected $fillable = [
        'user_type','title','complaint_type','active','company_key','created_by','updated_by'
    ];

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    
}
