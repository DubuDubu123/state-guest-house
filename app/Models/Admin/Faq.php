<?php

namespace App\Models\Admin;

use App\Base\Uuid\UuidModel;
use App\Models\Traits\HasActive;
use App\Models\Admin\ServiceLocation;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasActiveCompanyKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Faq extends Model
{
    use UuidModel,HasActive,HasActiveCompanyKey;
    // ,SoftDeletes;

    protected $fillable = [
        'question','answer','user_type','active','company_key','created_by','updated_by','hyper_link'
    ];

    /**
     * The relationships that can be loaded with query string filtering includes.
     *
     * @var array
     */
    // public $includes = [
    //     'serviceLocation','serviceLocation.zones'
    // ];

    public function serviceLocation()
    {
        return $this->belongsTo(ServiceLocation::class, 'service_location_id', 'id');
    }
    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }}
