<?php

namespace App\Models\Payment;

use App\Base\Uuid\UuidModel;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Admin\Driver;
use Log;

class DriverSubscription extends Model
{
    use UuidModel;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'driver_subscriptions';

    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'driver_id', 'subscription_type', 'active', 'paid_amount','amount','gst', 'expired_at','transaction_id','is_free_trial','day_before_nofified','hour_before_nofified'
    ];

    /**
     * The relationships that can be loaded with query string filtering includes.
     *
     * @var array
     */
    public $includes = [

    ];

    /**
    * The accessors to append to the model's array form.
    *
    * @var array
    */
    protected $appends = [
        'converted_expired_at'
    ];
    /**
    * Get formated and converted timezone of user's created at.
    *
    * @param string $value
    * @return string
    */
    public function getConvertedExpiredAtAttribute()
    {
        if(auth()->user())
        {
            $timezone = auth()->user()->timezone;
        }
        else{
            $timezone = env('SYSTEM_DEFAULT_TIMEZONE');
        }
        // $timezone = auth()->user()->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
        return Carbon::parse($this->expired_at)->format('jS M Y h:i A');
    }
    public function getConvertedExpiredAtYearAttribute()
    {
        $timezone = auth()->user()->timezone ?: env('SYSTEM_DEFAULT_TIMEZONE');
            return Carbon::parse($this->expired_at)->format('jS M Y h:i A');
    }  
    public function getConvertedCreatedAtYearAttribute()
    {
        $timezone = auth()->user()->timezone ?: env('SYSTEM_DEFAULT_TIMEZONE');

        return Carbon::parse($this->created_at)->tz('Asia/Kolkata')->format('jS M Y h:i A');
    }
      
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }  
}
