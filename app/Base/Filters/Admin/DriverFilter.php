<?php

namespace App\Base\Filters\Admin;

use App\Base\Libraries\QueryFilter\FilterContract;
use Carbon\Carbon;

/**
 * Test filter to demonstrate the custom filter usage.
 * Delete later.
 */
class DriverFilter implements FilterContract {
	/**
	 * The available filters.
	 *
	 * @return array
	 */
	public function filters() {
		return [
			'active','approve','available','date_option','area','date_option'
		];
	}

	public function active($builder, $value = 0) {
		$builder->whereHas('user', function($q)use($value){
			$q->where('active',$value);
		});
    }
    
	public function approve($builder, $value = 0) {
		$builder->where('approve', $value);
    }
    
	public function available($builder, $value = 0) {
		$builder->where('available', $value);
	}

    public function date_option($builder, $value = 0)
    {
        if ($value == 'today') {
            $from = now()->toDateString();
            $to = now()->toDateString();
        } elseif ($value == 'week') {
            $from = now()->subWeek()->toDateString();
            $to = now()->toDateString();
        } elseif ($value == 'month') {
            $from = now()->subMonth()->toDateString();
            $to = now()->toDateString();
        } elseif ($value == 'year') {
            $from = now()->startOfYear()->toDateString();
            $to = now()->endOfYear()->toDateString();
        } else {
            $date = explode('<>', $value);
            $from = Carbon::parse($date[0])->toDateString();
            $to = Carbon::parse($date[1])->toDateString();
        }
        // dd($from,$to);
            $builder->whereBetween('created_at', [$from, $to]);

    }
	
	// public function vehicle_type($builder, $value = 0){
	// 	$builder->whereHas('vehicleType' , function($q) use ($value){
	// 		$q->where('id',$value);
	// 	});
	// }

	public function area($builder, $value = 'all'){
		if($value != 'all'){
			$builder->where('service_location_id',$value);
		}
	}
}
