<?php

namespace App\Base\Filters\Admin;

use App\Base\Libraries\QueryFilter\FilterContract;
use Carbon\Carbon;

/**
 * Test filter to demonstrate the custom filter usage.
 * Delete later.
 */
class UserFilter implements FilterContract {
	/**
	 * The available filters.
	 *
	 * @return array
	 */
	public function filters() {
		return [
			'status','date_option'
		];
	}

	public function status($builder, $value = 0) {
        if($value == 1)
        {
            $builder->where('is_approve', 0)->where('is_deleted',false);
        }
        if($value == 2)
        {
            $builder->where('is_approve', 1)->where('is_deleted',false);
        }
        if($value == 3)
        {
            $builder->where('is_deleted', true);
        }
		
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
            $builder->whereBetween('updated_at', [$from, $to]);

    }
}
