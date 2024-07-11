<?php

namespace App\Base\Filters\Admin;

use Carbon\Carbon;
use App\Base\Libraries\QueryFilter\FilterContract;

/**
 * Test filter to demonstrate the custom filter usage.
 * Delete later.
 */
class RejectedRequestFilter implements FilterContract
{
    /**
     * The available filters.
     *
     * @return array
     */
    public function filters()
    {

        return [
        ];
    }

    /**
    * Default column to sort.
    *
    * @return string
    */
    public function defaultSort()
    {
        return '-created_at';
    }

    public function is_completed($builder, $value=0)
    {
        if($value){
            $builder->whereHas('requestBill',function($query){
            })->where('is_completed', $value)->where('is_cancelled', 0);

        }else{
            $builder->where('is_completed', $value)->where('is_cancelled', 0);

        }
    }

    
    public function is_cancelled($builder, $value=0)
    {  

        $builder->where('is_cancelled', $value);
    }

    public function is_later($builder, $value=0)
    {        
       $builder->where('is_later', $value)->where('is_completed',false)->where('is_cancelled',false);
        
    }

    public function is_trip_start($builder, $value = 0)
    {
        $builder->where('is_trip_start', $value)->where('is_cancelled', 0);
    }

    public function is_paid($builder, $value = 0)
    {
        $builder->where('is_paid', $value);
    }

    public function payment_opt($builder, $value = 0)
    {
        $builder->where('payment_opt', $value);
    }

    public function vehicle_type($builder, $value = 0)
    {
        $builder->whereHas('zoneType.vehicleType', function ($q) use ($value) {
            $q->where('id', $value);
        });
    }
    public function is_assigned($builder, $value = 0)
    {
        $builder->where('is_trip_start', $value)->where('is_cancelled', 0)->where('is_completed', 0);
    }
    public function cancel_method($builder, $value = 0)
    {
        // dd($value);
        $builder->where('cancel_method', (string)$value);
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
   
}
