<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Jobs\NotifyViaMqtt;
use App\Models\Admin\Driver;
use App\Jobs\NotifyViaSocket;
use App\Models\Request\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Request\RequestMeta;
use App\Jobs\NoDriverFoundNotifyJob;
use App\Base\Constants\Masters\PushEnums;
use App\Jobs\Notifications\AndroidPushNotification;
use App\Transformers\Requests\TripRequestTransformer;
use App\Transformers\Requests\CronTripRequestTransformer;
use App\Models\Request\DriverRejectedRequest;
use Sk\Geohash\Geohash;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Log;
use App\Jobs\Notifications\SendPushNotification; 
use App\Models\Request\RequestCycles; 
use Illuminate\Support\Collection;
use App\Helpers\Rides\FetchDriversFromFirebaseHelpers; 
use App\Models\User;
use App\Base\Constants\Setting\Settings;



class AssignDriversForRegularRides extends Command
{
    use FetchDriversFromFirebaseHelpers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign_drivers:for_regular_rides';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign Drivers for regular rides';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $ride_cancelation_time =Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s');

        $uncompleted_requests = Request::where('created_at', '<', $ride_cancelation_time)
            ->where('is_completed', 0)
            ->where('is_cancelled', 0)
            ->where('is_driver_started', 0)
            ->get();

       if($uncompleted_requests) {  
        foreach ($uncompleted_requests as $uncompleted_request) 
        {
            $update_parms['is_cancelled'] = true;
            $update_parms['cancelled_at'] = date('Y-m-d H:i:s');
            $update_parms['cancel_method'] = 0;
            
            $uncompleted_request->update($update_parms);            

            $this->database->getReference('requests/'.$uncompleted_request->id)->update(['is_cancelled'=>true,'updated_at'=> Database::SERVER_TIMESTAMP]); 
                $get_request_datas = RequestCycles::where('request_id', $uncompleted_request->id)->first(); 
                if($get_request_datas)
                {  
                    $request_data = json_decode(base64_decode($get_request_datas->request_data), true);
                    $request_datas['request_id'] = $uncompleted_request->id;
                    $request_datas['user_id'] = $uncompleted_request->user_id; 
                    $request_datas['driver_id'] = null;   
                    $default_image_path = config('base.default.user.profile_picture');
                    $data[0]['image'] = env('APP_URL').$default_image_path; 
                    $driver_details['image'] = env('APP_URL').$default_image_path;
                    $data[0]['dricver_details'] = $driver_details;
                    $data[0]['created_at'] = date("Y-m-d H:i:s", time());  
                    $data[0]['process_type'] = "system_cancelled";
                    $request_datas['orderby_status'] = intval($get_request_datas->orderby_status) + 1; 
                    if ($request_data === null) { 
                        $request_data = [];
                    }
                    $request_data1 = array_merge($request_data, $data);
                    $request_datas['request_data'] = base64_encode(json_encode($request_data1));  
                    $insert_request_cycles = RequestCycles::where('id',$get_request_datas->id)->update($request_datas);
    
                } 
         }
      }
      $user_timeout = get_settings(Settings::USER_CONFIRM_BOOKING_TIMEOUT);
      $user_confirmed_request_time =Carbon::now()->subSeconds($user_timeout)->format('Y-m-d H:i:s');
      $user_confirmed_requests = Request::where('is_completed', 0)
            ->where('is_cancelled', 0)
            ->where('is_driver_started', true)
            ->where('user_rated', false)
            ->where('driver_id', '!=', null) 
            ->where('accepted_at', '<=', $user_confirmed_request_time)
            ->get(); 
        // Log::info(json_encode($user_confirmed_request_time));
        Log::info(json_encode($user_confirmed_requests));
        Log::info("===========================================================================");
            if($user_confirmed_requests) {  
                foreach ($user_confirmed_requests as $user_confirmed_request) 
                {   
                    $updated_params['user_confirmed'] = true;
                    $this->database->getReference('requests/'.$user_confirmed_request->id)->update(['modified_by_user'=>time()]);
                    Request::where('id',$user_confirmed_request->id)->update($updated_params);
                }
            }

        $current_time = Carbon::now()->format('Y-m-d H:i:s');
        $sub_5_min = Carbon::now()->subMinutes(20)->format('Y-m-d H:i:s');
        // DB::enableQueryLog();
        $requests = Request::where('is_later', 0)
                    ->where('is_completed', 0)
                    ->where('is_cancelled', 0)
                    ->where('assign_method', 0)
                    ->where('is_driver_started', 0)
                    ->get();
        // dd($current_time);

        // dd($sub_5_min);

        if ($requests->count()==0) {
            return $this->info('no-regular-rides-found');
        }

        // dd(DB::getQueryLog());
        foreach ($requests as $key => $request) {
        Log::info($request->id);
        Log::info("request-datas");

            $this->fetchDriversFromFirebase($request);

        }

        $this->info('success');
    }
}
