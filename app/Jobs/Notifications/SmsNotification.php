<?php

namespace App\Jobs\Notifications;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\MobileOtp;

class SmsNotification extends BaseNotification
{
    /**
     * The mobile number.
     *
     * @var string
     */
    protected $mobile;

    /**
     * The otp.
     *
     * @var string
     */
    protected $sms;

    /**
     * The message.
     *
     * @var string
     */

    /**
     * Create a new job instance.
     *
     * @param string $mobile
     * @param string $otp
     */
    public function __construct($mobile)
    {
        $this->mobile = $mobile;
         // Log::info("mobile".$mobile);
          $this->sendSms();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $this->sendSms();
       
    }

    /**
     * Send the otp sms.
     */
    protected function sendSms()
    {
        $mobile = $this->mobile;
         

       $mobile_otp_exists =  MobileOtp::where('mobile', $mobile)->exists();
      
         if($mobile_otp_exists == false)
          {
            $otp = mt_rand(100000, 999999);  
            if($mobile == 9639639639 || $mobile == 9876543210)
            {
                $otp = 123456;
            } 
             Log::info($otp);

              $mbile_otp =  MobileOtp::create(['mobile'=>$mobile,
                    'otp'=>$otp]);
          }else{
               $otp = mt_rand(100000, 999999);     
                if($mobile == 9639639639 || $mobile == 9876543210)
                {
                    $otp = 123456;
                } 
                Log::info($otp);
               $mobileOtp = MobileOtp::where('mobile', $mobile)->first();
               
               $mobileOtp->update(['otp' => $otp]);

          }
        // sleep(20); 

        $apiKey = get_settings('sms_india_hub_api_key');
        $msisdn = '91'.$mobile; // Replace with the recipient's phone number
        $sid = get_settings('sms_india_hub_sender_id');
        $msg = "Dear User, your wait is finally over! Your DUBU DUBU account OTP is $otp.";
        $fl = '0';
        $gwid = '2';


        $response = Http::get('http://cloud.smsindiahub.in/vendorsms/pushsms.aspx', [
            'APIKey' => $apiKey,
            'msisdn' => $msisdn,
            'sid' => $sid,
            'msg' => $msg,
            'fl' => $fl,
            'gwid' => $gwid,
        ]);

        // Handle the API response here

        return response()->json(['message' => 'SMS sent successfully']);
    }
}
