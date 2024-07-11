<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBookingGuest extends Model
{
    use HasFactory;

    protected $table="room_booking_guest";

    protected $fillable = [
        'booking_id', 'room', 'per_day_price', 'guest_type'
    ];

   /**
	 * The user who owns the mobile number.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function booking_details() {
		return $this->belongsTo(RoomBooking::class, 'id', 'booking_id');
	}
}
