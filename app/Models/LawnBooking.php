<?php

namespace App\Models;
use App\Base\Uuid\UuidModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawnBooking extends Model
{
    use HasFactory,UuidModel;

    protected $table="lawn_booking";

     /**
	 * The user who owns the mobile number.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
    /**
	 * The user who owns the mobile number.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function booked_user() {
		return $this->belongsTo(User::class, 'id', 'booked_by');
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
        $timezone = 'Asia/kolkata';
        return Carbon::parse($this->created_at)->setTimezone($timezone)->format('jS M h:i A');
    }
}
