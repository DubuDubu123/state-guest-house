<?php

namespace App\Models;

use App\Base\Uuid\UuidModel;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Nicolaslopezj\Searchable\SearchableTrait;


class MobileOtp extends Model {
   
   	use UuidModel,SearchableTrait;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'mobile_otp_verifications';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'mobile', 'otp', 'verified',
	];

    protected $searchable = [
        'columns' => [
            'mobile_otp_verifications.mobile' => 20,
            'mobile_otp_verifications.verified'=> 20,
        ],
    ];


	/**
	 * The user who owns the mobile number.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function user() {
		return $this->belongsTo(User::class, 'mobile', 'mobile');
	}

	/**
	 * Check if the OTP for the mobile number has been verified.
	 *
	 * @return bool
	 */
	public function isVerified() {
		return (bool) $this->verified;
	}

    /**
    * Get formated and converted timezone of user's created at.
    *
    * @param string $value
    * @return string
    */
    public function getConvertedCreatedAtAttribute()
    {
        if ($this->created_at==null||!auth()->user()->exists()) {
            return null;
        }
        $timezone = auth()->user()->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
        return Carbon::parse($this->created_at)->setTimezone($timezone)->format('jS M h:i A');
    }

	
}
