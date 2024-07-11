<?php

namespace App\Http\Requests\Admin\VehicleTypes;

use App\Http\Requests\BaseRequest;

class CreateRentalRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'category_id' => 'required',
            'no_of_vehicles' => 'required',
            'from' => 'required',
            'to' => 'required',
            'city' => 'required',
            'amount' => 'required',

        ];
    }
}
