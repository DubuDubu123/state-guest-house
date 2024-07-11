<?php

namespace App\Http\Requests\Admin\Zone;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class AssignZoneTypeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $route = Route::currentRouteName();
        return [
            'type' => $route == 'updateTypePrice' ? '' :'required|exists:vehicle_types,id',
            'payment_type' => 'required',
            'ride_now_cancellation_fee' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'ride_now_price_per_time'=>'required|regex:/^\d*(\.\d{1,2})?$/',

        ];
    }
}
