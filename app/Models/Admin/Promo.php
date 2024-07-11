<?php

namespace App\Models\Admin;

use App\Base\Uuid\UuidModel;
use App\Models\Admin\PromoUser;
use App\Models\Traits\HasActive;
use App\Models\Admin\ServiceLocation;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Promo extends Model
{
    use UuidModel,HasActive;

    protected $table = 'promo';

    protected $fillable = [
        'code','service_location_id','minimum_trip_amount','maximum_discount_amount','discount_percent','total_uses','uses_per_user','from','to','active','created_by','updated_by','user_id'
    ];

    /**
     * The relationships that can be loaded with query string filtering includes.
     *
     * @var array
     */
    public $includes = [
        'promoUsers','serviceLocation'
    ];

    public function getFromDateAttribute()
    {
        return now()->parse($this->from)->toDateString();
    }

    public function getToDateAttribute()
    {
        return now()->parse($this->to)->toDateString();
    }
    public function serviceLocation()
    {
        return $this->belongsTo(ServiceLocation::class, 'service_location_id', 'id');
    }

    public function promoUsers()
    {
        return $this->hasMany(PromoUser::class, 'promo_code_id', 'id');
    }
    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
