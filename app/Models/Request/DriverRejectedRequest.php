<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Driver;
use App\Models\Request\Request as RequestRequest;
use Carbon\Carbon;

class DriverRejectedRequest extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'driver_rejected_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['request_id','driver_id','is_after_accept','reason','custom_reason'];

    /**
    * The accessors to append to the model's array form.
    *
    * @var array
    */
    protected $appends = [
       'converted_created_at','converted_updated_at'
    ];

    /**
     * The relationships that can be loaded with query string filtering includes.
     *
     * @var array
     */
    public $includes = [

    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }
    public function request()
    {
        return $this->belongsTo(RequestRequest::class, 'request_id', 'id');
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
        $timezone = $this->request->serviceLocationDetail->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
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
        $timezone = $this->request->serviceLocationDetail->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
        return Carbon::parse($this->updated_at)->setTimezone($timezone)->format('jS M h:i A');
    }

}
