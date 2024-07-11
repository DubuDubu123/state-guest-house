<?php

namespace App\Models\Request;

use Carbon\Carbon;
use App\Models\User;
use App\Base\Uuid\UuidModel;
use App\Models\Admin\Driver;
use App\Models\Admin\ServiceLocation;
use App\Models\Admin\ZoneType;
use App\Models\Admin\UserDetails;
use App\Models\Request\AdHocUser;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasActiveCompanyKey;
use Nicolaslopezj\Searchable\SearchableTrait;
use App\Models\Admin\CancellationReason;
use App\Models\Master\PackageType;
use App\Models\Admin\Owner;
use App\Models\Admin\RentalCategory;

class RentalRequest extends Model
{
    use UuidModel,SearchableTrait,HasActiveCompanyKey;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rental_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','category_id','completed_at','cancelled_at','is_completed','is_cancelled','cancelled_by','no_of_vehicles','from','to','is_confirmed','city','vehicle','amount',];

    /**
    * The accessors to append to the model's array form.
    *
    * @var array
    */
    protected $appends = [
       'converted_completed_at','converted_cancelled_at','converted_created_at','converted_updated_at',
    ];
    /**
     * The relationships that can be loaded with query string filtering includes.
     *
     * @var array
     */
    public $includes = [
       'userDetail'
    ];

    public function rentalCategory()
    {
        return $this->belongsTo(RentalCategory::class, 'category_id', 'id');
    }

    public function userDetail()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function zoneType()
    {
        return $this->belongsTo(ZoneType::class, 'zone_type_id', 'id')->withTrashed();
    }


    public function zoneTypePackage()
    {
        return $this->belongsTo(ZoneTypePackage::class, 'zone_type_id', 'id');
    }

    public function getConvertedCompletedAtAttribute()
    {
        if ($this->completed_at==null) {
            return null;
        }
                $timezone = $this->userDetail->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
        return Carbon::parse($this->completed_at)->setTimezone($timezone)->format('jS M h:i A');
    }
    /**
    * Get formated and converted timezone of user's cancelled at.
    * @return string
    */
    public function getConvertedCancelledAtAttribute()
    {
        if ($this->cancelled_at==null) {
            return null;
        }
                $timezone = $this->userDetail->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
        return Carbon::parse($this->cancelled_at)->setTimezone($timezone)->format('jS M h:i A');
    }
    /**
    * Get formated and converted timezone of user's created at.
    * @return string
    */
    public function getConvertedCreatedAtAttribute()
    {
        if ($this->created_at==null) {
            return null;
        }
        $timezone = $this->userDetail->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
        return Carbon::parse($this->created_at)->setTimezone($timezone)->format('jS M h:i A');
    }
    /**
    * Get formated and converted timezone of user's created at.
    * @return string
    */
    public function getConvertedUpdatedAtAttribute()
    {
        if ($this->updated_at==null) {
            return null;
        }
                $timezone = $this->userDetail->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
        return Carbon::parse($this->updated_at)->setTimezone($timezone)->format('jS M h:i A');
    }
    /**
    * Get formated and converted timezone of user's created at.
    * @return string
    */
    public function getConvertedFromAttribute()
    {
        if ($this->from==null) {
            return null;
        }
        $timezone = auth()->user()->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
       return Carbon::parse($this->from)->setTimezone($timezone)->format('jS M Y');
    }
    /**
    * Get formated and converted timezone of user's created at.
    * @return string
    */
    public function getConvertedToAttribute()
    {
        if ($this->to==null) {
            return null;
        }
        $timezone = auth()->user()->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
       return Carbon::parse($this->to)->setTimezone($timezone)->format('jS M Y');
    }
    public function getCurrencyAttribute()
    {
        if ($this->zoneType->zone->serviceLocation->exists()) {
            return $this->zoneType->zone->serviceLocation->currency_symbol;
        }
        return get_settings('currency_symbol');
    }

    protected $searchable = [
        'columns' => [
            'users.name' => 20,
            'users.mobile' => 20,
        ],
        'joins' => [
            'users' => ['rental_requests.user_id','users.id'],
        ],
    ];


}
