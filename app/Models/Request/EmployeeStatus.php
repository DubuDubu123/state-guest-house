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

class EmployeeStatus extends Model
{
    use UuidModel,SearchableTrait,HasActiveCompanyKey;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employee_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','login_at', 'logout_at'];

    /**
    * The accessors to append to the model's array form.
    *
    * @var array
    */
    protected $appends = [
    ];
    /**
     * The relationships that can be loaded with query string filtering includes.
     *
     * @var array
     */


    /**
    * Get formated and converted timezone of user's Trip start time.
    * @return string
    */
    public function getConvertedLoginAtAttribute()
    {
        if ($this->login_at==null) {
            return null;
        }

        
        $timezone = $this->userDetail->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
        
        return Carbon::parse($this->login_at)->setTimezone($timezone)->format('jS M h:i A');
    }
    /**
    * Get formated and converted timezone of user's arrived at.
    * @return string
    */
    public function getConvertedLogoutAtAttribute()
    {
        if ($this->logout_at==null) {
            return null;
        }
        $timezone = $this->userDetail->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
        return Carbon::parse($this->logout_at)->setTimezone($timezone)->format('jS M h:i A');
    }
    /**
    * Get formated and converted timezone of user's accepted at.
    * @return string
    */
    public function userDetail()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
