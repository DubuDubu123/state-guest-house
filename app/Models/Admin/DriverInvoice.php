<?php

namespace App\Models\Admin;

use Carbon\Carbon;
use App\Base\Uuid\UuidModel;
use App\Models\Traits\HasActive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Driver;
use App\Models\Payment\DriverSubscription;
class DriverInvoice extends Model {
	use HasActive, UuidModel;
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'driver_invoices';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'driver_id', 'amount', 'is_paid','invoice_number','gst','invoice_amount','is_subscription_invoice','subscription_id','from','to','no_of_rides'
	];

	

	/**
	 * The relationships that can be loaded with query string filtering includes.
	 *
	 * @var array
	 */
	public $includes = [
		'driver'
	];

	 /**
     * The driver that the uploaded data belongs to.
     * @tested
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }
	/**
	 * Get formatted and converted timezone of user's created at in dd/mm/yyyy format.
	 *
	 * @param string $value
	 * @return string
	 */
	public function getConvertedCreatedAtAttribute()
	{
	    if ($this->created_at == null || !auth()->user()->exists()) {
	        return null;
	    }

	    $timezone = auth()->user()->timezone ?: env('SYSTEM_DEFAULT_TIMEZONE');

	    return Carbon::parse($this->created_at)
	        ->setTimezone($timezone)
	        ->format('d/m/Y'); // Formatting for dd/mm/yyyy
	}

    /**
    * Get formated and converted timezone of user's created at.
    *
    * @param string $value
    * @return string
    */
    public function getConvertedFromAttribute()
    {
        if ($this->from==null||!auth()->user()->exists()) {
            return null;
        }
        $timezone = auth()->user()->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
      return Carbon::parse($this->from)->timezone($timezone)->format('jS M\'y h:i A');        
        // return Carbon::parse($this->from)->timezone($timezone)->format('d-m-Y H:i:s');
    }
    /**
    * Get formated and converted timezone of user's created at.
    *
    * @param string $value
    * @return string
    */
    public function getConvertedToAttribute()
    {
        if ($this->to==null||!auth()->user()->exists()) {
            return null;
        }
        $timezone = auth()->user()->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
        // return Carbon::parse($this->to)->timezone($timezone)->format('d-m-Y H:i:s');
      return Carbon::parse($this->from)->timezone($timezone)->format('jS M\'y h:i A');     
    }
    public function driverSubscription()
    {
        return $this->belongsTo(DriverSubscription::class, 'subscription_id', 'id');
    }  	    
}
