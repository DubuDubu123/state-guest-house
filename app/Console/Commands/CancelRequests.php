<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Contract\Database;
use Carbon\Carbon;
use App\Models\Request\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\Notifications\SendPushNotification;
use App\Base\Constants\Masters\UserType;
use App\Jobs\NoDriverFoundNotifyJob;
use App\Models\Request\RequestCycles; 

class CancelRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel Request over 15 minutes not accepted  biding rides';

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
     * @return int
     */
    public function handle()
    {
        $currentDateTimeUTC = Carbon::now('UTC');

        // Calculate the timestamp for 15 minutes ago in UTC
        $fifteenMinutesAgoUTC = $currentDateTimeUTC->subMinutes(15);

        // Query to get records within the last 15 minutes in UTC
        $requests = Request::where('is_later', 0)
            ->where('is_bid_ride', 1)
            ->where('is_completed', 0)
            ->where('is_cancelled', 0)
            ->where('is_multiple_vehicles',0)
            ->where('is_driver_started', 0)
            ->where('created_at', '<=', $fifteenMinutesAgoUTC)
            ->get();

        if ($requests->count()==0) {
            return $this->info('no-bidding-rides-found');
        }
        // dd(DB::getQueryLog());
        foreach ($requests as $key => $request) {
               $request->update([
                'is_cancelled'=>true,
                'custom_reason'=>"No Drivers Found",
                'cancel_method'=>UserType::AUTOMATIC,
                'cancelled_at'=>date('Y-m-d H:i:s')
            ]);

         $this->database->getReference('requests/'.$request->id)->update(['no_driver'=>1,'cancelled_request'=>1,'updated_at'=> Database::SERVER_TIMESTAMP]);

         $get_request_datas = RequestCycles::where('request_id', $request->id)->first();
            if($get_request_datas)
            {  
                $request_data = json_decode(base64_decode($get_request_datas->request_data), true);
                $request_datas['request_id'] = $request->id;
                $request_datas['user_id'] = $request->user_id; 
                $request_datas['driver_id'] = null;   
                
                $request_datas['driver_id'] = null;   
                $default_image_path = config('base.default.user.profile_picture');
                $data[0]['image'] = env('APP_URL').$default_image_path;
                $data[0]['process_type'] = "system_cancelled";
                $driver_details['image'] = env('APP_URL').$default_image_path;
                $data[0]['dricver_details'] = $driver_details;
                $data[0]['process_type'] = "system_cancelled";
                $data[0]['created_at'] = date("Y-m-d H:i:s", time());  
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


          $this->database->getReference('request-meta/'.$request->id)->remove();

          $this->database->getReference('bid-meta/'.$request->id)->remove();
          $this->database->getReference('requests/' . $request->id)->remove(); 
          


          dispatch(new NoDriverFoundNotifyJob($request->id));
       


        }

          $this->info('success');

    }
}
