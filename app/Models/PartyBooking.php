<?php

namespace App\Models;
use App\Base\Uuid\UuidModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class PartyBooking extends Model
{
    use HasFactory,UuidModel,SearchableTrait;

    protected $table="party_booking";
    
    protected $searchable = [
        'columns' => [
            'party_booking.booking_id' => 20,
            'users.email'=> 20, 
            'users.name'=> 20, 
            'users.userid'=> 20, 
            'users.mobile'=> 20, 
        ],
        'joins' => [
            'users' => ['party_booking.user_id','users.id'],
        ],
    ];  

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
		return $this->belongsTo(User::class, 'booked_by', 'id');
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
