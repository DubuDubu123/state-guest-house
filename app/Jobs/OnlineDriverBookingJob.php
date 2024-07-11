<?php

namespace App\Jobs;

use Illuminate\Mail\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Notifications\AndroidPushNotification;
use Log;
use App\Models\Request\RequestMeta;
use App\Models\Request\Request as RequestRequest;
use App\Models\Request\RequestPlace;
use App\Helpers\Rides\FetchDriversFromFirebaseHelpers;
use Kreait\Firebase\Contract\Database; 
use App\Models\Admin\Driver;
use App\Jobs\Notifications\SendPushNotification;
use Illuminate\Support\Facades\App;
use App\Models\Request\DriverRejectedRequest; 
use App\Jobs\NoDriverFoundNotifyJob; 
use App\Base\Constants\Setting\Settings;
use Illuminate\Support\Facades\DB;
use Sk\Geohash\Geohash;
use Carbon\Carbon;

class OnlineDriverBookingJob implements ShouldQueue
{
    use Dispatchable,Queueable,InteractsWithQueue,SerializesModels;  
   
    /**
    * The data.
    *
    * @var data
    */
    protected $driver;

    /**
     * Create a new job instance.
     *
     * @param $title,$body,$image,$data
     */
    public function __construct($driver)
    {
        $this->driver = $driver;   
        
        // $this->handle();
    }

      /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {  
        $database = App::make(Database::class); 
        $driver_id = "driver_".$this->driver->id;
        $fire_drivers = $database->getReference('drivers')
            ->orderByKey() 
            ->equalTo($driver_id)
            ->getValue();
            // Log::info("testttt");
            // Log::info($fire_drivers);
            // Log::info("fire drivers --------------");
            if(array_key_exists('vehicle_type',$fire_drivers[$driver_id]))
            {
                // Log::info("fire drivers --------------");
                $request_meta_ids = RequestMeta::pluck('request_id')->toArray(); 
                $get_request_datas = RequestRequest::where('is_later', 0)
                ->where('is_completed', 0)
                ->where('is_cancelled', 0)
                ->where('assign_method', 0)
                ->where('is_driver_started', 0)
                ->whereNotIn('id', $request_meta_ids) 
                ->get();
                // Log::info($get_request_datas);   
                $driver_search_radius = get_settings('driver_search_radius')?:30;
                $get_request_meta_datas = RequestMeta::where('driver_id', $this->driver->id)->get();
                if(count($get_request_meta_datas) == 0)
                {
                    foreach($get_request_datas as $k=>$request_detail)
                    {
                        $rejected_driver_ids = DriverRejectedRequest::where('request_id',$request_detail->id)->pluck('driver_id')->toArray();
                        $id = $this->driver->id;
                        if (in_array($id, $rejected_driver_ids)) {
                            // Driver ID is present in the rejected driver IDs
                            Log::info("Driver ID $id is present in the rejected driver IDs.");
                        } else {
                            // Driver ID is not present in the rejected driver IDs
                            Log::info("Driver ID $id is not present in the rejected driver IDs.");
                            $pick_lat = $request_detail->pick_lat;
                            $pick_lng = $request_detail->pick_lng;
                            $drop_lat = $request_detail->drop_lat;
                            $drop_lng = $request_detail->drop_lng;
                            $distance = distance_between_two_coordinates($pick_lat,$pick_lng,$fire_drivers[$driver_id]['l'][0],$fire_drivers[$driver_id]['l'][1],'K');
        
                            if($distance <= $driver_search_radius){ 
                                Log::info("distace true"); 
                            
                           
                            // $haversine = "(6371 * acos(cos(radians($pick_lat)) * cos(radians(pick_lat)) * cos(radians(pick_lng) - radians($pick_lng)) + sin(radians($pick_lat)) * sin(radians(pick_lat))))";
                            // $request_place_data = RequestPlace::selectRaw("{$haversine} AS distance")->whereRaw("{$haversine} < ?", [$driver_search_radius])->get();
                            // if(count($request_place_data) > 0)
                            // {
                                $database->getReference('request-meta/'.$request_detail->id)->set(['driver_id'=>$this->driver->id,'request_id'=>$request_detail->id,'user_id'=>$request_detail->user_id,'active'=>1,'updated_at'=> Database::SERVER_TIMESTAMP]);
                                $driver = Driver::find($this->driver->id);
                                $notifable_driver = $driver->user;
        
                                $title = trans('push_notifications.new_request_title',[],$notifable_driver->lang);
                                $body = trans('push_notifications.new_request_body',[],$notifable_driver->lang); 
                                dispatch(new SendPushNotification($notifable_driver,$title,$body));
                                $selected_drivers["distance_to_pickup"] = $distance;
                                $selected_drivers["driver_id"] = $driver->id;
                                $selected_drivers["request_id"] = $request_detail->id;
                                $selected_drivers["user_id"] = $request_detail->user_id;
                                $selected_drivers["active"] = 1;
                                $selected_drivers["assign_method"] = 1;
                                $selected_drivers["created_at"] =   date('Y-m-d H:i:s');
                                $selected_drivers["updated_at"] = date('Y-m-d H:i:s');
                                RequestMeta::create($selected_drivers);
                                $request_detail->attempt_for_schedule += 1;
                                $request_detail->save(); 
                                Log::info("Fire drivers success");
                                break;
        
                        }
                        }
                       
                    }
                }
                else{
                    Log::info(json_encode($get_request_meta_datas));
                }
               
                
            }
            $requests = RequestRequest::where('is_later', 0)
                    ->where('is_completed', 0)
                    ->where('is_cancelled', 0)
                    ->where('assign_method', 0)
                    ->where('is_driver_started', 0)
                    ->get();
            foreach ($requests as $key => $request) {
                Log::info($request->id);
                Log::info("request-datas"); 
                    $this->fetchDriversFromFirebase($request);
        
                }

            // Log::info($fire_drivers);

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
        $database = App::make(Database::class); 
        $check_meta_request_exists = RequestMeta::where('request_id',$request_detail->id)->get();
        // Log::info(json_encode($check_meta_request_exists)); 
        if(count($check_meta_request_exists) > 0)
        {
            return null; 
        }
       

        $pick_lat = $request_detail->pick_lat;
        $pick_lng = $request_detail->pick_lng;
        $drop_lat = $request_detail->drop_lat;
        $drop_lng = $request_detail->drop_lng;
        $user_detail = $request_detail->userDetail;
        $type_id = $request_detail->zoneType->type_id;

        $driver_search_radius = get_settings('driver_search_radius')?:30;
        
        $radius = kilometer_to_miles($driver_search_radius);

        $calculatable_radius = ($radius/2);

        $calulatable_lat = 0.0144927536231884 * $calculatable_radius;
        $calulatable_long = 0.0181818181818182 * $calculatable_radius;

        $lower_lat = ($pick_lat - $calulatable_lat);
        $lower_long = ($pick_lng - $calulatable_long);

        $higher_lat = ($pick_lat + $calulatable_lat);
        $higher_long = ($pick_lng + $calulatable_long);

        $g = new Geohash();

        $lower_hash = $g->encode($lower_lat,$lower_long, 12);
        $higher_hash = $g->encode($higher_lat,$higher_long, 12);

        $conditional_timestamp = Carbon::now()->subMinutes(7)->timestamp;

        $vehicle_type = $type_id;



        $fire_drivers = $database->getReference('drivers')->orderByChild('g')->startAt($lower_hash)->endAt($higher_hash)->getValue();
        
        $firebase_drivers = [];

        $i=-1;
    
        foreach ($fire_drivers as $key => $fire_driver) {
            $i +=1; 
            
            $driver_updated_at = Carbon::createFromTimestamp($fire_driver['updated_at'] / 1000)->timestamp;


        if(array_key_exists('vehicle_type',$fire_driver) && $fire_driver['vehicle_type']==$vehicle_type && $fire_driver['is_active']==1 && $fire_driver['is_available']==1 && $conditional_timestamp < $driver_updated_at){


                $distance = distance_between_two_coordinates($pick_lat,$pick_lng,$fire_driver['l'][0],$fire_driver['l'][1],'K');

                if($distance <= $driver_search_radius){

                    $firebase_drivers[$fire_driver['id']]['distance']= $distance;

                }

            }elseif(array_key_exists('vehicle_types',$fire_driver)  && in_array($vehicle_type, $fire_driver['vehicle_types']) && $fire_driver['is_active']==1 && $fire_driver['is_available']==1 && $conditional_timestamp < $driver_updated_at)
                {


                $distance = distance_between_two_coordinates($pick_lat,$pick_lng,$fire_driver['l'][0],$fire_driver['l'][1],'K');

                if($distance <= $driver_search_radius){

                    $firebase_drivers[$fire_driver['id']]['distance']= $distance;

                }

            }

        }

        asort($firebase_drivers);

        $current_date = Carbon::now();

         if (!empty($firebase_drivers)) {

            $nearest_driver_ids = [];

            $removable_driver_ids=[];

                foreach ($firebase_drivers as $key => $firebase_driver) {
                    
                    $nearest_driver_ids[]=$key;


                $has_enabled_my_route_drivers=Driver::where('id',$key)->where('active', 1)->where('approve', 1)->where('available', 1)->where(function($query){
                    $query;
                })->where('enable_my_route_booking',1)->first();


                $route_coordinates=null;

                if($has_enabled_my_route_drivers){

                    Log::info("my-route-driver");

                    //get line string from helper
                    $route_coordinates = get_line_string($pick_lat, $pick_lng, $drop_lat, $drop_lng);

                }       
                        if($has_enabled_my_route_drivers!=null &$route_coordinates!=null){

                            $enabled_route_matched = $has_enabled_my_route_drivers->intersects('route_coordinates',$route_coordinates)->first();
                            
                            if(!$enabled_route_matched){

                                $removable_driver_ids[]=$key;
                            }

                            $current_location_of_driver = $has_enabled_my_route_drivers->enabledRoutes()->whereDate('created_at',$current_date)->orderBy('created_at','desc')->first();

                            if($current_location_of_driver){

                         $distance_between_drop_to_my_route = distance_between_two_coordinates($drop_lat, $drop_lng, $has_enabled_my_route_drivers->my_route_lat, $has_enabled_my_route_drivers->my_route_lng,'K');

                        if($distance_between_drop_to_my_route > 5){

                                $removable_driver_ids[]=$key;

                        }
                            
    
                            }
                            
                        }


                }

            $rejected_driver_ids = DriverRejectedRequest::where('request_id',$request_detail->id)->pluck('driver_id')->toArray();

            $nearest_driver_ids = array_diff($nearest_driver_ids,$removable_driver_ids);
            $nearest_driver_ids = array_diff($nearest_driver_ids,$rejected_driver_ids);

            // Log::info($nearest_driver_ids);
            // Log::info("Nearest driver idsssssssss-------------------");

            if(count($nearest_driver_ids)==0){

                $request_detail->attempt_for_schedule += 1;
                $request_detail->save();

                $no_of_attempts = get_settings('maximum_time_for_find_drivers_for_regular_ride');

                $no_of_attempts +=3;

                if ($request_detail->attempt_for_schedule>$no_of_attempts) {
                        
                        // Update cancel param in firebase
                        $database->getReference('requests/'.$request_detail->id)->update(['is_cancelled' => true,'updated_at'=> Database::SERVER_TIMESTAMP]);

                        $no_driver_request_ids = [];
                        $no_driver_request_ids[0] = $request_detail->id;
                        dispatch(new NoDriverFoundNotifyJob($no_driver_request_ids));
                }

                return null; 


                }

            $driver_search_radius = get_settings('driver_search_radius')?:30;

                $haversine = "(6371 * acos(cos(radians($pick_lat)) * cos(radians(pick_lat)) * cos(radians(pick_lng) - radians($pick_lng)) + sin(radians($pick_lat)) * sin(radians(pick_lat))))";
                // Get Drivers who are all going to accept or reject the some request that nears the user's current location.

                $meta_drivers = RequestMeta::whereHas('request.requestPlace', function ($query) use ($haversine,$driver_search_radius) {
                    $query->select('request_places.*')
                    ->selectRaw("{$haversine} AS distance")
                ->whereRaw("{$haversine} < ?", [$driver_search_radius]);
                })->pluck('driver_id')->toArray();


                $nearest_drivers = Driver::where('active', 1)->where('approve', 1)->where('available', 1)->whereIn('id', $nearest_driver_ids)->whereNotIn('id', $meta_drivers)->orderByRaw(DB::raw("FIELD(id, " . implode(',', $nearest_driver_ids) . ")"))->limit(10)->get();

                if ($nearest_drivers->count()==0) {
                    
                $request_detail->attempt_for_schedule += 1;
                $request_detail->save();

                $no_of_attempts = get_settings('maximum_time_for_find_drivers_for_regular_ride');

                $no_of_attempts +=3;

                if ($request_detail->attempt_for_schedule>$no_of_attempts) {

                        $database->getReference('requests/'.$request_detail->id)->update(['is_cancelled' => true,'updated_at'=> Database::SERVER_TIMESTAMP]);

                        $no_driver_request_ids = [];
                        $no_driver_request_ids[0] = $request_detail->id;
                        dispatch(new NoDriverFoundNotifyJob($no_driver_request_ids));
                }

                    return null; 
                }
        //Create Meta & Send Ride Request to the Nearest Drivers
        $selected_drivers = [];
        $i = 0;
        Log::info($nearest_driver_ids);
        Log::info("nearest_drivers ==============-------------------------------======================");
        foreach ($nearest_drivers as $driver_key => $driver) {

            // $selected_drivers[$i]["request_id"] = $request_detail->id;
            foreach ($firebase_drivers as $key => $firebase_driver) {

                    if($driver->id==$key){
                        $selected_drivers[$i]["distance_to_pickup"] = $firebase_driver['distance'];
                    }
            }
            
            // if(!$request_detail->if_dispatch){
                $selected_drivers[$i]["user_id"] = $user_detail->id;                
            // }
            $selected_drivers[$i]["driver_id"] = $driver->id;
            $selected_drivers[$i]["active"] = 1;
            $selected_drivers[$i]["assign_method"] = 1;
            $selected_drivers[$i]["created_at"] = date('Y-m-d H:i:s');
            $selected_drivers[$i]["updated_at"] = date('Y-m-d H:i:s');


        // Add Driver into Firebase Request Meta
        $database->getReference('request-meta/'.$request_detail->id)->set(['driver_id'=>$driver->id,'request_id'=>$request_detail->id,'user_id'=>$request_detail->user_id,'active'=>1,'updated_at'=> Database::SERVER_TIMESTAMP]);

        
        $driver = Driver::find($driver->id);

        $notifable_driver = $driver->user;

        $title = trans('push_notifications.new_request_title',[],$notifable_driver->lang);
        $body = trans('push_notifications.new_request_body',[],$notifable_driver->lang);

        dispatch(new SendPushNotification($notifable_driver,$title,$body));


        if(get_settings('trip_dispatch_type')==0){
            $selected_drivers[$i]["active"] = 1;
        }else{
            if($driver_key==0){
                break;                
            }
        }

            $i++;
        }


        Log::info($selected_drivers);
        foreach ($selected_drivers as $key => $selected_driver) {
            $request_detail->requestMeta()->create($selected_driver);
        }

        return "success";

            
        } else {

            $request_detail->attempt_for_schedule += 1;
                $request_detail->save();

                $no_of_attempts = get_settings('maximum_time_for_find_drivers_for_regular_ride');

                $no_of_attempts +=3;

                if ($request_detail->attempt_for_schedule>$no_of_attempts) {

                    $database->getReference('requests/'.$request_detail->id)->update(['is_cancelled' => true,'no_driver'=>1,'updated_at'=> Database::SERVER_TIMESTAMP]);

                        $no_driver_request_ids = [];
                        $no_driver_request_ids[0] = $request_detail->id;
                        dispatch(new NoDriverFoundNotifyJob($no_driver_request_ids));
                }
            return null;

        }

    }
}
