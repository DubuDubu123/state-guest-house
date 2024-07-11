<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Base\Services\OTP\Handler\OTPHandlerContract;
use DB;
use Twilio;
use App\Models\User;
use App\Base\Libraries\SMS\SMSContract;
use App\Base\Services\ImageUploader\ImageUploaderContract;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Helpers\Exception\ExceptionHelpers;
use App\Base\Constants\Auth\Role;
use App\Jobs\Notifications\Auth\Registration\UserNotification;
use Mail;
use Log;
use App\Models\MobileOtp;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Session;
use App\Models\MembershipTariff;
use App\Models\UsersMembership;
use Carbon\Carbon;

class HomeController extends LoginController
{
    use ExceptionHelpers;
    /**
     * The OTP handler instance.
     *
     * @var \App\Base\Services\OTP\Handler\OTPHandlerContract
     */
    protected $otpHandler;

    /**
     * The user model instance.
     *
     * @var \App\Models\User
     */
    protected $user;

    protected $smsContract;

    protected $imageUploader;

     
    public function __construct(User $user, OTPHandlerContract $otpHandler, SMSContract $smsContract,ImageUploaderContract $imageUploader)
    {
        $this->user = $user;
        $this->otpHandler = $otpHandler; 
        $this->smsContract = $smsContract;
        $this->imageUploader = $imageUploader;

    }
    public function index()
    { 
        // $apiKey = "Pte4eXLw90iLEGNTQqoPLQ";
        // $msisdn = '919566754418'; // Replace with the recipient's phone number
        // $sid = "DUBUAT";
        // $msg = "Dear User, Your IAS Mess account OTP is 123456.";
        // $fl = '0';
        // $gwid = '2';     
        // $response = Http::get('http://cloud.smsindiahub.in/vendorsms/pushsms.aspx', [
        // 'APIKey' => $apiKey,
        // 'msisdn' => $msisdn,
        // 'sid' => $sid,
        // 'msg' => $msg,
        // 'fl' => $fl,
        // 'gwid' => $gwid,
        // ]);

// Log the response for debugging purposes
// \Log::info('SMS API Response', ['response' => $response->body(), 'status' => $response->status(), 'headers' => $response->headers()]);
// dd("test");
// Dump the response to see the details
// dd($response->json());
        
        // Log the response for debugging purposes
        // \Log::info('SMS API Response', ['response' => $response->body(), 'status' => $response->status(), 'headers' => $response->headers()]);
        // // dd("test");
        // // Dump the response to see the details
        // dd($response->json());
 
// process_payment.php

// Function to encrypt data as per SBIePay encryption method


// Sanitize input data (in production, use proper validation and sanitization)
// $EncryptTrans = encryptData($_POST['EncryptTrans']);
// $EncryptbillingDetails = encryptData($_POST['EncryptbillingDetails']);
// $EncryptshippingDetails = encryptData($_POST['EncryptshippingDetails']);
// $EncryptpaymentDetails = encryptData($_POST['EncryptpaymentDetails']);
// $merchIdVal = $_POST['merchIdVal'];

// // Construct request to SBIePay endpoint
// $sbiepay_url = 'https://test.sbiepay.sbi/secure/AggregatorHostedListener';

// // Prepare data to be sent to SBIePay
// $post_data = array(
//     'EncryptTrans' => $EncryptTrans,F
//     'EncryptbillingDetails' => $EncryptbillingDetails,
//     'EncryptshippingDetails' => $EncryptshippingDetails,
//     'EncryptpaymentDetails' => $EncryptpaymentDetails,
//     'merchIdVal' => $merchIdVal
// );

// // Initialize cURL session
// $ch = curl_init();

// // Set cURL options
// curl_setopt($ch, CURLOPT_URL, $sbiepay_url);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// // Execute cURL session
// $response = curl_exec($ch);

// // Check for cURL errors
// if(curl_errno($ch)) {
//     echo 'Error:' . curl_error($ch);
// }

// // Close cURL session
// curl_close($ch);

// // Process response from SBIePay (handle success or failure)
// echo "Response from SBIePay:<br>";
// echo $response; // Display the response (you may want to process this further)
// exit;

//         $random_key = "LPAAS-GJLNV-ZSVIL-ZSWER";
//         $unique_id = uniqid('ref_', true);
//         $unique_host_device = substr(uniqid('device_', true), 0, 20);
//         $device_id = 'DEVICE123456789';
//         $mac_address = 'MAC123456';
//         $ip = $_SERVER['REMOTE_ADDR']; 
//         $mac_address = shell_exec('arp -a ' . escapeshellarg($ip)); 
//         // Usage example
//         $aadhaarNumber = "277279126294"; // Replace with the actual Aadhaar number
//         $transactionId = "1234567890"; // Replace with the actual transaction ID
//         $name = "Ranjith Kumar M"; // Replace with the actual name
//         $url = "https://tnpreauth.tn.gov.in/clientgwapi/api/Aadhaar/DoDemoAuth"; 
//         // // The parameters required by the API
//         $data = array(
//             "AUAKUAParameters" => array(
//                 "LAT" => "13.0843",
//                 "LONG" => "80.2705", 
//                 "DEVID" => $device_id, 
//                 "DEVMACID" => $mac_address, 
//                 "CONSENT" => "Y", 
//                 "SHRC" => "Y", 
//                 "VER" => "2.5",  
//                 "ENV" => "2",   
//                 "REF" => $unique_id,
//                 "RRN" => $transactionId,
//                 "SERTYPE" => "07",
//                 "SLK" => $random_key, 
//                 "UDC" => $unique_host_device,
//                 "UID" => $aadhaarNumber,
//                 "ISPA" => false, 
//                 "ISPFA" => false,
//                 "ISPI" => true,
//                 "PIMS"=> "E",
//                 "NAME" => $name
//             ),
//             "ENVIRONMENT" => 0,
//             "PIDXML" => ""
//         );

//     $data_string = json_encode($data);

//     $ch = curl_init($url);

//     // Set cURL options
//     curl_setopt($ch, CURLOPT_POST, 1);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//         'Content-Type: application/xml',
//         'Content-Length: ' . strlen($data_string))
//     );

//     // Execute cURL request and capture the response
//     $response = curl_exec($ch);
//     dd($response); 
//     if (curl_errno($ch)) {
//         $error_msg = curl_error($ch);
//         curl_close($ch);
//         return "cURL error: " . $error_msg;
//     }

//     // Close cURL session
//     curl_close($ch);
//     dd($response);
 
// dd($resp);
// exit; 
// dd("dsff");
        // $sender_id = 'KTSSSC';
        // $template_id = '1707168862643740857';
        // $phone = 8270512348;
        // $msg = "Your PSCK-FS Verification Code is 123456 valid for 5 Mins - KLABS";
        // $username = 'Indiaklabss5';
        // $apikey = '6F96A-CEFE5';
        // $uri = 'https://chatway.in/api/send-file';
        // // dd($phone);
        // // Construct the URL with query parameters
        // $url = $uri . '?' . http_build_query(array(
        //     'username' => $username,  
        //     'token' => 'Sk42QU00b1lLQ0RQcGxnbURKcVdJdz09',  
        //     'message' => $msg,
        //     'number' => $phone
        // ));
        // //    echo $url;
        // //    exit;
        // $ch = curl_init();
            
        // // Set the URL
        // curl_setopt($ch, CURLOPT_URL, $url);
        
        // // Set the HTTP method to GET (since we're sending data in the URL)
        // curl_setopt($ch, CURLOPT_HTTPGET, true);
        
        // // Set CURLOPT_RETURNTRANSFER so that curl_exec returns the response
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // $response = curl_exec($ch);
        
        // // Check for errors
        // if(curl_errno($ch)) {
        //     // echo 'Curl error: ' . curl_error($ch);
        //     $response = [
        //         'status' => true,
        //         'message' => curl_error($ch)
        //     ];
        //     return response()->json($response);
        // } else {
        //     // Process the response
        //     echo $response;
        // }
        
        // // Close the cURL handle
        // curl_close($ch);
        // exit;
        return view('index'); 
    }
    public function register()
    {
        $membership_tariff = MembershipTariff::get(); 
        return view('admin.register',compact('membership_tariff')); 
    }
    public function forget_user()
    {
        return view('admin.forget-userid'); 
    }
    public function forget_password()
    {
        return view('admin.forget-password'); 
    }
    public function register_confirmation()
    {
        return view('admin.register-confirmation'); 

    }
    public function reset_password($token)
    {
        $check_data_expires = new \stdClass();
        $check_data_expires = User::where('email_confirmation_token',$token)->first();  
    //    dd($check_data_expires);
        if(!$check_data_expires)
        {
            redirect('/login');
        }
        else{ 
            // if($check_data_expires->id){
            //     Session::put('resend_user_id',$check_data_expires->id); 
            // }
            
            User::where('id',$check_data_expires->id)->update(['email_confirmation_token'=>NULL]);
        }
        return view('admin.verify-otp',compact('check_data_expires')); 
    }

    public function test()
    {
        return view('admin.test');
    }
    public function register_user(Request $request)
    { 
        $email = $request->email;
        $validate_exists_email = $this->user->belongsTorole(Role::USER)->where('email', $email)->exists();

        if ($validate_exists_email) {  
                $user = $this->user->belongsTorole(Role::USER)->where('email', $email)->first(); 
                return $this->authenticateAndRespond($user, $request, $needsToken=true); 
                $this->throwCustomException('Provided mobile has already been taken');
        }
        $profile_picture = null;
        $proof = null;

        if ($uploadedFile = $this->getValidatedUpload('imageUpload', $request)) {
            $profile_picture = $this->imageUploader->file($uploadedFile)
                ->saveProfilePicture();
        }
        if ($uploadedFile = $this->getValidatedUpload('proof', $request)) {
            $proof = $this->imageUploader->file($uploadedFile)
                ->saveProfilePicture();
        }
        $userid = $this->user->belongsTorole(Role::USER)->orderBy('created_at', 'DESC')->pluck('userid')->first();

        if ($userid) {
            // Extract the numeric part from the userid
            preg_match('/(\d+)$/', $userid, $matches);
            $numberPart = isset($matches[1]) ? intval($matches[1]) + 1 : 5001; // Increment or default to 1001 if not found
            $userid = "TNIOM" . str_pad($numberPart, 4, '0', STR_PAD_LEFT); // Ensure the number part is at least 4 digits
        } else {
            $userid = "TNIOM5001"; // Default userid
        } 
        $password = bcrypt($request->input('phone'));
        $user_params = [ 
            'salutation' => $request->input('salutation'),
            'name' => $request->input('full_name'), 
            'batch' =>  $request->input('batch'),
            'email' =>  $request->input('email'),
            'mobile' =>  $request->input('phone'),
            'address' =>  $request->input('address'),
            'date_joining'=>$request->input('date_of_join'),
            'dob'=>$request->input('dob'),
            'retired_date'=>$request->input('date_of_retire'), 
            'membership_type'=> $request->input('membership_type'),
            // 'payment_mode'=> $request->input('mode_of_payment'),
            'profile_picture'=> $profile_picture,
            'password'=> $password,
            'proof'=> $proof,
            'userid'=>$userid
        ]; 
        $get_membership_tariff = MembershipTariff::find($request->input('membership_type'));
        $user = $this->user->create($user_params); 
        $member_ship_data = new UsersMembership();
        $member_ship_data->user_id = $user->id;
        $member_ship_data->membership_type = $request->input('membership_type');
        $member_ship_data->date = Carbon::now('Asia/kolkata')->format("Y-m-d H:i:s");
        $member_ship_data->amount = $get_membership_tariff->price;
        $member_ship_data->expiry_date = Carbon::now('Asia/Kolkata')->addYear()->format("Y-m-d H:i:s");
        $member_ship_data->is_lifetime_member = $get_membership_tariff->membership_type;
        $member_ship_data->is_paid = 0;
        $member_ship_data->save();
        $user->attachRole(Role::USER);
        return redirect('/register-confirmation'); 
        
    }
    public function send_email(Request $request)
    { 
        $phone = $request->email;
        $validate_exists_email = $this->user->belongsTorole(Role::USER)->where('mobile', $phone)->first();

        if ($validate_exists_email) { 
            $response = [
                "status"=>false,
                "message"=>"Mobile No does not exists"
            ];
            $details = [
                'title' => "Mail from IAS Officers' Mess",
                'user_details' => $validate_exists_email,
                'type' => 'send_email'
            ];
            
            // Mail::to($request->email)->send(new UserNotification($details)); 
            $response = [
                "status"=>true,
                "message"=>"Email exists"
            ];
            $sender_id = 'KTSSSC';
            $template_id = '1707168862643740857';
            $phone = $validate_exists_email->mobile;
            $otp = mt_rand(100000, 999999);
            $msg = "Your PSCK-FS Verification Code is ".$otp." valid for One minute - KLABS";
            $username = 'Indiaklabss';
            $apikey = '6F96A-CEFE5';
            $uri = 'https://powerstext.in/sms-panel/api/http/index.php';
            // dd($phone);
            // Construct the URL with query parameters
            $url = $uri . '?' . http_build_query(array(
                'username' => $username,
                'apikey' => $apikey,
                'apirequest' => 'Text',
                'sender' => $sender_id,
                'route' => 'TRANS',
                'format' => 'JSON',
                'message' => $msg,
                'mobile' => $phone,
                'TemplateID' => $template_id,
            ));
            
            $ch = curl_init();
            
            // Set the URL
            curl_setopt($ch, CURLOPT_URL, $url);
            
            // Set the HTTP method to GET (since we're sending data in the URL)
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            
            // Set CURLOPT_RETURNTRANSFER so that curl_exec returns the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $response1 = curl_exec($ch);
            
            // Check for errors
            if(curl_errno($ch)) {
                // echo 'Curl error: ' . curl_error($ch);
                $response = [
                    'status' => true,
                    'message' => curl_error($ch)
                ];
                // return response()->json($response);
            } else {
                // Process the response
                // echo $response;
            }
            // echo $response;
            // exit;
            
            // Close the cURL handle
            curl_close($ch);
        }
        else{
            $response = [
                "status"=>false,
                "message"=>"Email does not exists"
            ];
        }
        return response()->json($response);
       
    } 
    public function resend_forget_email(Request $request)
    {  
        $id = $request->id;
        $validate_exists_email = $this->user->where('id', $id)->first(); 
        // dd($validate_exists_email);
        if ($validate_exists_email) { 
            $email = $validate_exists_email->email;
            $response = [
                "status"=>false,
                "message"=>"Mobile number not registered. Please verify or register to proceed"
            ];
            $details = [
                'title' => 'Mail from Laravel App',
                'body' => 'This is a test email sent from a Laravel application.'
            ]; 

            $mobile = $validate_exists_email->mobile;
            
            $mobile_otp = MobileOtp::where('mobile', $mobile)->first();
    
            if (!$mobile_otp) {
                $otp = mt_rand(100000, 999999);
                if ($mobile == 9639639639 || $mobile == 9876543210) {
                    $otp = 123456; // Consider removing fixed OTPs in production.
                }
                Log::info($otp);
    
                $mobile_otp_table = new MobileOtp();
                $mobile_otp_table->mobile = $mobile; 
            
            } else {
                $otp = mt_rand(100000, 999999);
                if ($mobile == 9639639639 || $mobile == 9876543210) {
                    $otp = 123456; // Consider removing fixed OTPs in production.
                }
                Log::info($otp);
    
                $mobile_otp_table = MobileOtp::find($mobile_otp->id);
            }
            $mobile_otp_table->otp = $otp; 
            $mobile_otp_table->verified = false; 
            $mobile_otp_table->save();
            
            // Send SMS
            if ($mobile_otp_table) {
                // dd($mobile);
                $sender_id = 'KTSSSC';
                $template_id = '1707168862643740857';
                $phone = $mobile;
                // $otp = mt_rand(100000, 999999);
                $msg = "Your PSCK-FS Verification Code is ".$otp." valid for 5 Mins - KLABS";
                $username = 'Indiaklabss';
                $apikey = '6F96A-CEFE5';
                $uri = 'https://powerstext.in/sms-panel/api/http/index.php';
                    $data = array(
                    'username'=> $username,
                    'apikey'=> $apikey,
                    'apirequest'=>'Text',
                    'sender'=> $sender_id,
                    'route'=>'TRANS',
                    'format'=>'JSON',
                    'message'=> $msg,
                    'mobile'=> $phone,
                    'TemplateID' => $template_id,
                    );

                    $ch = curl_init($uri);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FAILONERROR, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
                    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
                    $resp = curl_exec($ch);
                    $error = curl_error($ch);
                    curl_close ($ch);
                    // echo json_encode(compact('resp', 'error'));
    
               
                // Log the response for debugging purposes
            
                // dd("test");
                // Dump the response to see the details
                // dd($response->json());
                // Handle response and potential errors from SMS API here.
            }
            $token = Str::random(40);
            $this->user->where('email', $email)->update(['email_confirmation_token'=>$token]);
            // dd($token);
            // Mail::to('ranjith@dubudubu.in')->send(new UserNotification($details));
            // dd($validate_exists_email);
            // dispatch(new UserNotification($validate_exists_email));
            $response = [
                "status"=>true,
                "message"=>"Email exists",
                "token"=>$token,
                "data"=>$validate_exists_email
            ];
        }
        else{
            $response = [
                "status"=>false,
                "message"=>"Email does not exists"
            ];
        }
        return response()->json($response);
    }
    public function send_forget_email(Request $request)
    { 
        $email = $request->email;
        $validate_exists_email = $this->user->belongsTorole(Role::USER)->where('email', $email)->Orwhere('mobile', $email)->first();
        
        // dd($validate_exists_email);
        if ($validate_exists_email) { 
            $response = [
                "status"=>false,
                "message"=>"Email does not exists"
            ];
            $details = [
                'title' => 'Mail from Laravel App',
                'body' => 'This is a test email sent from a Laravel application.'
            ];
    
           

            $mobile = $validate_exists_email->mobile;
            
            $mobile_otp = MobileOtp::where('mobile', $mobile)->first();
    
            if (!$mobile_otp) {
                $otp = mt_rand(100000, 999999);
                if ($mobile == 9639639639 || $mobile == 9876543210) {
                    $otp = 123456; // Consider removing fixed OTPs in production.
                }
                Log::info($otp);
    
                $mobile_otp_table = new MobileOtp();
                $mobile_otp_table->mobile = $mobile; 
            
            } else {
                $otp = mt_rand(100000, 999999);
                if ($mobile == 9639639639 || $mobile == 9876543210) {
                    $otp = 123456; // Consider removing fixed OTPs in production.
                }
                Log::info($otp);
    
                $mobile_otp_table = MobileOtp::find($mobile_otp->id);
            }
            $mobile_otp_table->otp = $otp; 
            $mobile_otp_table->verified = false; 
            $mobile_otp_table->save();
            
            // Send SMS
            if ($mobile_otp_table) {
                Session::put('resend_user_id',$validate_exists_email->id); 
                $sender_id = 'KTSSSC';
                $template_id = '1707168862643740857';
                $phone = $validate_exists_email->mobile;
                // $otp = mt_rand(100000, 999999);
                $msg = "Your PSCK-FS Verification Code is ".$otp." valid for 5 Mins - KLABS";
                $username = 'Indiaklabss';
                $apikey = '6F96A-CEFE5';
                $uri = 'https://powerstext.in/sms-panel/api/http/index.php';
                // dd($phone);
                // Construct the URL with query parameters
                $url = $uri . '?' . http_build_query(array(
                    'username' => $username,
                    'apikey' => $apikey,
                    'apirequest' => 'Text',
                    'sender' => $sender_id,
                    'route' => 'TRANS',
                    'format' => 'JSON',
                    'message' => $msg,
                    'mobile' => $phone,
                    'TemplateID' => $template_id,
                ));
                
                $ch = curl_init();
                
                // Set the URL
                curl_setopt($ch, CURLOPT_URL, $url);
                
                // Set the HTTP method to GET (since we're sending data in the URL)
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                
                // Set CURLOPT_RETURNTRANSFER so that curl_exec returns the response
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                $response1 = curl_exec($ch);
                
                // Check for errors
                if(curl_errno($ch)) {
                    // echo 'Curl error: ' . curl_error($ch);
                    $response = [
                        'status' => true,
                        'message' => curl_error($ch)
                    ];
                    // return response()->json($response);
                } else {
                    // Process the response
                    // echo $response;
                }
                // echo $response;
                // exit;
                
                // Close the cURL handle
                curl_close($ch);
            }
            $token = Str::random(40);
            $this->user->where('id', $validate_exists_email->id)->update(['email_confirmation_token'=>$token]);
            // dd($token);
            // Mail::to('ranjith@dubudubu.in')->send(new UserNotification($details));
            // dd($validate_exists_email);
            // dispatch(new UserNotification($validate_exists_email));
            $response = [
                "status"=>true,
                "message"=>"Email exists",
                "token"=>$token
            ];
        }
        else{
            $response = [
                "status"=>false,
                "message"=>"Email does not exists"
            ];
        }
        return response()->json($response);
    }
     /**
     * Validate the mobile number verification OTP during registration.
     * @bodyParam otp string required Provided otp
     * @bodyParam uuid uuid required uuid comes from sen otp api response
     *
     * @param \App\Http\Requests\Auth\Registration\ValidateRegistrationOTPRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @response {"success":true,"message":"success"}
     */
    public function validateMobileOTP(Request $request)
    {
        // dd($request->all());
        $inputValuesArray = array_filter(explode(',', $request->inputValues), fn($value) => $value !== '');
        // dd($inputValuesArray);
        $otp = "";
        foreach($inputValuesArray as $k=>$v)
        {
            $otp.=$v;
        }
        // dd($otp); 
        $user = User::find($request->id);
        $mobile = $user->mobile;
        $email = $user->email;
        
        $verify_otp = MobileOtp::where('mobile' ,$mobile)->where('otp', $otp)->first();
        // dd($verify_otp);
            // Log::info($otp);
            // Log::info($mobile);
            Log::info($verify_otp);

        if (!$verify_otp) 
        {
            Log::info($otp);
            Log::info($mobile);

            $response = [
                "status"=>false,
                "message"=>"OTP is Invalid"
            ];
            return response()->json($response);

        }

        MobileOtp::where('mobile' ,$mobile)->where('otp', $otp)->update(['verified' => true]);
        
            $token = Str::random(40);
            $this->user->where('email', $email)->update(['reset_token'=>$token]);
            $response = [
                "status"=>true,
                "message"=>"OTP is Invalid",
                "token"=>$token,
            ];
        return response()->json($response);
    }

    public function check_user_exists(Request $request)
    {
        // dd($request->all()); 
        $email = $request->email;
        $mobile = $request->mobile;
        $validate_exists_mobile = $this->user->belongsTorole(Role::USER)->where('mobile', $mobile)->orwhere('email', $email)->exists(); 
        if($validate_exists_mobile) { 
            $message = [
            "status"=>false,
            "message"=>"Email address or Mobile No. already Exists"
            ];
        } 
        else{
            $message = [
                "status"=>true
              ];
        }
        return response()->json($message);
    }
    public function get_user_details(Request $request)
    {
       $get_user_data = User::where('id',$request->data)->first();
       $message = [
        "status"=>true,
        "user"=>$get_user_data
        ];
        return response()->json($message);

    }
} 