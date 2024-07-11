<?php

namespace App\Helpers\Rides;

use Kreait\Firebase\Contract\Database;
use Sk\Geohash\Geohash;
use Carbon\Carbon;
use App\Models\Request\RequestMeta;
use Illuminate\Support\Facades\DB;
use App\Models\Request\Request;
use Illuminate\Support\Facades\Log;
use App\Base\Constants\Setting\Settings;
use App\Models\Admin\Driver;
use App\Jobs\Notifications\SendPushNotification;
use App\Models\Request\DriverRejectedRequest;

trait GetFirebaseDriversHelpers
{


    public function __construct(Database $database)
    {
        
        $this->database = $database;

    }

    /**
     * Respond with drivers data.
     * Status code = 200
     *
     * @param mixed|null $data
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    //
    protected function fetchDriversFromFirebase($request_detail)
    {
        $lat = $request_detail->lat;
        $lng = $request_detail->lng;

        $driver_search_radius = get_settings('driver_search_radius')?:30;
        
        $radius = kilometer_to_miles($driver_search_radius);

        $calculatable_radius = ($radius/2);

        $calulatable_lat = 0.0144927536231884 * $calculatable_radius;
        $calulatable_long = 0.0181818181818182 * $calculatable_radius;

        $lower_lat = ($lat - $calulatable_lat);
        $lower_long = ($lng - $calulatable_long);

        $higher_lat = ($lat + $calulatable_lat);
        $higher_long = ($lng + $calulatable_long);

        $g = new Geohash();

        $lower_hash = $g->encode($lower_lat,$lower_long, 12);
        $higher_hash = $g->encode($higher_lat,$higher_long, 12);

        $conditional_timestamp = Carbon::now()->subMinutes(7)->timestamp;

        $fire_drivers = $this->database->getReference('drivers')->orderByChild('g')->startAt($lower_hash)->endAt($higher_hash)->getValue();


        $firebase_drivers = [];

        $i=-1;
    
        foreach ($fire_drivers as $key => $fire_driver) {
            $i +=1; 

        dd($fire_driver);


        }
        
        $firebase_drivers = [];

   
        return $fire_drivers ?? [];


    }
    
}
