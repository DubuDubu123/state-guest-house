<?php

namespace App\Jobs;

use App\Jobs\NotifyViaMqtt;
use App\Jobs\NotifyViaSocket;
use Illuminate\Bus\Queueable;
use App\Models\Request\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Base\Constants\Masters\PushEnums;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Notifications\AndroidPushNotification;
use App\Transformers\Requests\TripRequestTransformer;
use App\Transformers\Requests\CronTripRequestTransformer;
use App\Jobs\Notifications\SendPushNotification;
use App\Models\Request\RequestCycles; 
use Log;

class NoDriverFoundNotifyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $requestids;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($requestids)
    {
        $this->requestids = $requestids;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->requestids as $key => $request_id) {
            $request_detail = Request::find($request_id);
            $request_detail->update(['is_cancelled'=>true,'cancel_method'=>0,'cancelled_at'=>date('Y-m-d H:i:s')]);
            $request_detail->fresh();
            $get_request_datas = RequestCycles::where('request_id', $request_id)->first();
            Log::info($get_request_datas);
            Log::info("get_request_datas-------------------------");
            if($get_request_datas)
            {  
                $request_data = json_decode(base64_decode($get_request_datas->request_data), true);
                $request_datas['request_id'] = $request_detail->id;
                $request_datas['user_id'] = $request_detail->user_id; 
                $request_datas['driver_id'] = null;   
               
                $default_image_path = config('base.default.user.profile_picture');
                $data[0]['image'] = env('APP_URL').$default_image_path;
                $data[0]['process_type'] = "system_cancelled";
                $driver_details['image'] = env('APP_URL').$default_image_path;
                $data[0]['dricver_details'] = $driver_details;
                $data[0]['created_at'] = date("Y-m-d H:i:s", time());  
                $request_datas['orderby_status'] = intval($get_request_datas->orderby_status) + 1; 
                if ($request_data === null) { 
                    $request_data = [];
                }
                $request_data1 = array_merge($request_data, $data);
                $request_datas['request_data'] = base64_encode(json_encode($request_data1));  
                $insert_request_cycles = RequestCycles::where('id',$get_request_datas->id)->update($request_datas);

            } 
            $request_result =  fractal($request_detail, new CronTripRequestTransformer);
            $pus_request_detail = $request_result->toJson();
            
            $push_data = ['notification_enum'=>PushEnums::NO_DRIVER_FOUND];
        if($request_detail->userDetail()->exists()){

            if ($request_result->userDetail->fcm_token!=null) {
                $user = $request_detail->userDetail;

                $title = trans('push_notifications.no_driver_found_title',[],$user->lang);
                $body = trans('push_notifications.no_driver_found_body',[],$user->lang);

                dispatch(new SendPushNotification($user,$title,$body));
            }
          }

        }
    }
}
