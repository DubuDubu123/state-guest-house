<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportsTariffBooking extends Model
{
    use HasFactory;

    protected $table="sports_booking_tariff";   

      /**
	 * The user who owns the mobile number.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function tariff() {
		return $this->belongsto(SportsTariff::class, 'tariff_id', 'id');
	} 
}
