<?php

namespace App\Http\Requests\Admin\Driver;

use App\Http\Requests\BaseRequest;

class CreateDriverRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50',
            'mobile'=>'required|mobile_number|min:10',
            // 'email'=>'required|email',
            // 'address'=>'required|min:10',
            // 'state'=>'max:100',
            // 'city'=>'required',
            // 'country'=>'required|exists:countries,id',
            'gender'=>'required',
            // 'is_company_driver' => 'sometimes|required|in:0,1',
            'company'=>'sometimes',
            'type' => 'sometimes|required',
            // 'owner_id'=>'required',
            'aadhar_number' => 'required|max:12|min:12',
            'driving_license_number' => 'required|max:50',
            // 'vehicle_insurence_number'=> 'required|max:50',
            // 'rc_number'=> 'required|max:50',




        ];
    }
}
