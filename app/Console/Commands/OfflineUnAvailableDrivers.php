<?php

namespace App\Console\Commands;

use App\Models\Admin\Driver;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Jobs\Notifications\AndroidPushNotification;
use App\Jobs\Notifications\SendPushNotification;
use Log;
use App\Models\Request\RequestCycles; 
use App\Models\Request\Request;
use App\Models\User;
use App\Models\Request\RequestMeta;
use App\Models\Request\DriverRejectedRequest;
use App\Helpers\Rides\FetchDriversFromFirebaseHelpers; 

class OfflineUnAvailableDrivers extends Command
{
    use FetchDriversFromFirebaseHelpers;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offline:drivers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Offline Un Available Drivers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Database $database)
    {
        parent::__construct();
        $this->database = $database;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $current_timestamp = Carbon::now()->timestamp;
        $conditional_timestamp = Carbon::now()->subMinutes(15);

        $one_hr_conditional_time = Carbon::now()->subSeconds(15);

        $drivers = $this->database->getReference('drivers')->orderByChild('is_active')->equalTo(1)->getValue();

        foreach ($drivers as $key => $driver) {
            $driver_updated_at = Carbon::createFromTimestamp($driver['updated_at'] / 1000);
                
                // if($driver['id']==4190){
                
                // $this->info("last_location_updated_at:".$driver_updated_at);

                // }

                $mysql_driver = Driver::where('id', $driver['id'])->first();
                // Check if the driver is on trip
                if($mysql_driver && $mysql_driver->requestDetail()->where('is_completed',false)->where('is_cancelled',false)->exists()){
                    goto end;
                }
                
            // Log::info($one_hr_conditional_time);
            // Log::info("Time diffrerence");
            // Log::info($driver_updated_at);
            if($one_hr_conditional_time > $driver_updated_at){
                // Log::info($driver['id']);
                // if($driver['id']==4190){
                
                // $this->info("one_hour_conditional:".$driver_updated_at);
                
                // }
                    // Log::info("Make offlinessss");

                goto make_offline;
            }

            
            
            if ($conditional_timestamp > $driver_updated_at) {
                
                $this->info("some-drivers-are-there");

                // if($driver['id']==4190){
                
                // $this->info("15_mins_conditional:".$driver_updated_at);
                
                // }

                if ($mysql_driver){
                    $notifable_driver = $mysql_driver->user;
                    $title = trans('push_notifications.reminder_push_title',[],$notifable_driver->lang);
                    $body = trans('push_notifications.reminder_push_body',[],$notifable_driver->lang);

                    dispatch(new SendPushNotification($notifable_driver,$title,$body));

                }


                goto end;

            }else{

                // if($driver['id']==4190){
                
                // $this->info("else_part:".$driver_updated_at);
                
                // }

                goto end;


            }

                
                
                make_offline:

                // Get last online record
                if ($mysql_driver && $mysql_driver->driverAvailabilities()) {

                    $updatable_offline_date_time = Carbon::createFromTimestamp($driver['updated_at']/1000);

                    $availability = $mysql_driver->driverAvailabilities()->where('is_online', true)->orderBy('online_at', 'desc')->first();
                    $created_params['duration'] = 0;
                    if ($availability) {
                        $last_online_date_time = Carbon::parse($availability->online_at);
                        $last_offline_date = Carbon::parse($updatable_offline_date_time);
                        $duration = $last_offline_date->diffInMinutes($last_online_date_time);
                        $created_params['duration'] = $availability->duration+$duration;
                        $availability->update(['is_online'=>false,'offline_at'=>$updatable_offline_date_time,'duration'=>$availability->duration+$duration]);

                    }else{
                        $created_params['duration'] = 0;  
                        $created_params['is_online'] = false;
                        $created_params['online_at'] = $updatable_offline_date_time;
                        $created_params['offline_at'] = $updatable_offline_date_time;
                        $mysql_driver->driverAvailabilities()->create($created_params);

                    }
                    
                    $mysql_driver->active = 0;
                    $mysql_driver->save();

                    $request_meta = RequestMeta::where('driver_id', $mysql_driver->id)->first();

                    // Log::info(json_encode($mysql_driver));
                    // Log::info(json_encode($request_meta));
                    if($request_meta)
                    {
                        $request_detail = Request::where('id', $request_meta->request_id)->first();
                        DriverRejectedRequest::create([
                            'request_id'=>$request_meta->request_id,
                            'is_after_accept'=>false,
                            'driver_id'=>$mysql_driver->id,
                            'custom_reason'=>"Driver killed the application"]);
                        RequestMeta::where('id', $request_meta->id)->delete();
                        $get_request_datas = RequestCycles::where('request_id', $request_detail->id)->first();
                        if($get_request_datas)
                        { 
                            $user_data = User::find($mysql_driver->user_id);
                            $request_data = json_decode(base64_decode($get_request_datas->request_data), true);
                            $request_datas['request_id'] = $request_detail->id;
                            $request_datas['user_id'] = $request_detail->user_id; 
                            $request_datas['driver_id'] = $mysql_driver->id; 
                            $driver_details['name'] = $mysql_driver->name;
                            $driver_details['mobile'] = $mysql_driver->mobile;
                            $driver_details['image'] = $user_data->profile_picture; 
                            $rating = number_format($user_data->rating, 2); 
                            $ratingValue = $mysql_driver->driverRating()->where('user_rating',1)->avg('rating');
                            $rating = round($ratingValue,2);
                            $data[0]['rating'] = $rating; 
                            $data[0]['status'] = 9; 
                            $data[0]['process_type'] = "driver_system_cancelled"; 
                            $data[0]['dricver_details'] = $driver_details;
                            $data[0]['created_at'] = date("Y-m-d H:i:s", time());  
                            $data[0]['orderby_status'] = intval($get_request_datas->orderby_status) + 1;
                            $request_datas['orderby_status'] = intval($get_request_datas->orderby_status) + 1;
                           
                            if ($request_data === null) {
                                // If $request_data is null, initialize it as an empty array
                                $request_data = [];
                            }
                            $request_data1 = array_merge($request_data, $data);
                            $request_datas['request_data'] = base64_encode(json_encode($request_data1));  
                            // Log::info("Request Data: " . json_encode($request_data));
                            // Log::info("Data: " . json_encode($data));
                            // Log::info("Merged Data: " . json_encode($request_data1));
                            $insert_request_cycles = RequestCycles::where('id',$get_request_datas->id)->update($request_datas); 
                        }
                        $this->fetchDriversFromFirebase($request_detail,"change_drivers_to_trip");
                    }
                   

                    $this->database->getReference('drivers/'.'driver_'.$driver['id'])->update(['is_active'=>0,'updated_at'=> Database::SERVER_TIMESTAMP]);


                    $notifable_driver = $mysql_driver->user;
                    $title = trans('push_notifications.you_are_offline_title',[],$notifable_driver->lang);
                    $body = trans('push_notifications.you_are_offline_body',[],$notifable_driver->lang);

                    dispatch(new SendPushNotification($notifable_driver,$title,$body));


                }


                end:
                
                

        // $this->info("no-need-to-offline-for-".$driver['id']);

        }

        // $this->info("success");
    }
}
