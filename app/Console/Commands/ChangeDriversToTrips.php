<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Request\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Request\RequestMeta;
use Illuminate\Support\Facades\Log;
use App\Jobs\NoDriverFoundNotifyJob;
use App\Jobs\SendRequestToNextDriversJob;
use Kreait\Firebase\Contract\Database;
use App\Helpers\Rides\FetchDriversFromFirebaseHelpers; 
use App\Models\Request\DriverRejectedRequest;
use App\Models\Request\RequestCycles; 
use App\Models\Admin\Driver;
use App\Models\User;

class ChangeDriversToTrips extends Command 
{
    use FetchDriversFromFirebaseHelpers;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drivers:totrip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the request to other drivers when the driver doesn\'t respond';

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
        // Log::info("succccccccessss");
        $driver_timeout = 60;
        // Get the current time
        $currentDateTime = Carbon::now();

        // Add 60 minutes
        $oneMinuteAgo = $currentDateTime->subMinute();
        // Log::info($oneMinuteAgo);
        // Log::info($currentDateTime);

        $request_meta = RequestMeta::where('created_at', '<=', $oneMinuteAgo) 
        ->where('active', 1)
        ->get();
        // $request_meta = RequestMeta::whereActive(true)->get();
        // Log::info(json_encode($request_meta));
        // Log::info(count($request_meta));
       
       
        if (count($request_meta)==0) {
            return $this->info('no-meta-drivers-found');
        }
        DB::beginTransaction();
        try {
            $meta_ids = $request_meta->pluck('id');
            $request_ids = $request_meta->pluck('request_id');
            // Log::info("meta-idsss");
            // Log::info(json_encode($meta_ids));
            
            
            foreach ($meta_ids as $key => $meta_id) {
                $request_meta_detable = RequestMeta::where('id', $meta_id)->first();
                $request_detail = Request::find($request_meta_detable->request_id);
                $driver = Driver::find($request_meta_detable->driver_id);
                $driver->available = true;
                $driver->save();
                // Log::info(json_encode($request_detail));
                // Delete Meta Driver From Firebase  
                 $this->database->getReference('request-meta/'.$request_meta_detable->request_id)->set(['driver_id'=>'','request_id'=>$request_meta_detable->request_id,'user_id'=>$request_meta_detable->user_id,'active'=>1,'is_accepted'=>0,'transport_type'=>$request_detail->transport_type,'updated_at'=> Database::SERVER_TIMESTAMP]);
                 DriverRejectedRequest::create([
                    'request_id'=>$request_detail->id,
                    'is_after_accept'=>false,
                    'driver_id'=>$driver->id,
                    'custom_reason'=>"Driver killed the application"]);
                    RequestMeta::where('id', $meta_id)->delete();
                    $get_request_datas = RequestCycles::where('request_id', $request_detail->id)->first();
                    if($get_request_datas)
                    { 
                        $user_data = User::find($driver->user_id);
                        $request_data = json_decode(base64_decode($get_request_datas->request_data), true);
                        $request_datas['request_id'] = $request_detail->id;
                        $request_datas['user_id'] = $request_detail->user_id; 
                        $request_datas['driver_id'] = $driver->id; 
                        $driver_details['name'] = $driver->name;
                        $driver_details['mobile'] = $driver->mobile;
                        $driver_details['image'] = $user_data->profile_picture; 
                        $rating = number_format($user_data->rating, 2); 
                        $ratingValue = $driver->driverRating()->where('user_rating',1)->avg('rating');
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
                // Delete Driver data from Mysql Request Meta
                // $request_meta_detable->delete();
                $this->fetchDriversFromFirebase($request_detail,"change_drivers_to_trip");
            }
            // RequestMeta::whereIn('id', $meta_ids)->delete();



            // $data = RequestMeta::whereIn('request_id', $request_ids)->groupBy('request_id')->selectRaw('Min(id) as request_meta_id, request_id')->get();

            // $next_driver_request_meta_id = $data->pluck('request_meta_id');

            // $updated_request_id = $data->pluck('request_id');

            // $request_meta =  RequestMeta::whereIn('id', $next_driver_request_meta_id)->update(['active'=>true]);

            // $array_updated_request_ids = $updated_request_id->toArray();
            // $array_request_ids = $request_ids->toArray();

            // $no_driver_request_ids = array_diff($array_request_ids, $array_updated_request_ids);
            // // Send Notifications to users
            // // dispatch(new NoDriverFoundNotifyJob($no_driver_request_ids));
            // // Send Request to other drivers
            // dispatch(new SendRequestToNextDriversJob($next_driver_request_meta_id,$this->database));

            $this->info('success');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            Log::error('Error while changing requests to other drivers');
            return $this->info('unknown error occured');
        }
        DB::commit();
    }
}
