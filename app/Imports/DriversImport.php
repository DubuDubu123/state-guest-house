<?php

namespace App\Imports;

use App\Models\Admin\Driver;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Country;
use App\Base\Constants\Auth\Role;
use App\Models\Admin\ServiceLocation;
use App\Models\Admin\Company;
use App\Models\Master\CarMake;
use App\Models\Master\CarModel;
use App\Models\Admin\VehicleType;
use App\Models\User;

class DriversImport implements ToModel , WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */




    public function model(array $row)
    { 
        print_r($row);
        // exit;
        // $countries = Country::all();
        // $carmake = CarMake::active()->get();
        // $country_id =  Country::where('code', $row['country'])->pluck('id')->first();
        // $service_locations = ServiceLocation::where('id' , $row['service_locations'])->pluck('country')->first();
        // $types = VehicleType::where('name' , $row['vehicletype'])->pluck('id')->first();
        // $carmake = CarMake::where('name' , $row['carmake'])->pluck('id')->first();
        // $carmodel = CarModel::where('name' , $row['carmodel'])->pluck('id')->first();
        // $user_id = User::where('name', $row['user'])->pluck('id')->first();
        $user_id = User::where('id')->get();

        // $created_params = [
        //     "user_id" => $user_id,
        //     "name" => $row['name'],
        //     "email" => $row['email'],
        //     "mobile" => $row['mobile'],
        //     "gender" => $row['gender'],
        //     "car_color" => $row['car_color'],
        //     "car_number" => $row['car_number'],
        //     "car_make" => $row['car_make'],
        //     "car_model" => $row['car_model'],
        //     "aadhar_number" => $row['aadhar_number'],
        //     "driving_license_number" => $row['driving_license_number'],
        //     "vehicle_insurence_number" => $row['vehicle_insurence_number'],
        //     "rc_number" => $row['rc_number'],
        //     'service_locations_id'=>$services,
        //     // 'service_locations_id'=>$service_locations,
        //     'types'=>$types,
        //     // 'carmake' =>$carmake,
        //     // 'carmodel' => $carmodel,
        //     // 'user' =>$user_id,
        //     // 'refferal_code'=>str_random(6),
        // ];
        
        // $driver = Driver::create($created_params);
        // Create Empty Wallet to the user
        // $driver->userWallet()->create(['amount_added'=>0]);

        
        // $user->attachRole(RoleSlug::DRIVER);

        // return $driver;
    }
}
