<?php

namespace App\Http\Controllers\Web\Admin;

use Socialite;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin\Driver;
use App\Models\Admin\Zone;
use App\Models\Admin\DriverAvailability;
use App\SocialAccountService;
use App\Charts\TodayTripChart;
use App\Models\Request\Request as Requests;
use App\Charts\OverallTripChart;
use App\Base\Constants\Auth\Role;
use App\Models\Request\RequestBill;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Web\BaseController;
use App\Models\Payment\DriverWallet;
use Kreait\Firebase\Contract\Database;
use App\Base\Constants\Setting\Settings;
use Illuminate\Http\Request;
use Mail; 
use Hash;
use DB; 
use Illuminate\Support\Str;
use App\Jobs\ForgotPassword;


class AdminViewController extends BaseController
{

     public function __construct(Database $database)
    {
        $this->database = $database;
    }

   

    /**
     * Redirect to admin login
     */
    public function viewLogin()
    {
        $host_name = request()->getHost();

        $conditional_host = explode('.',$host_name);

        if($conditional_host[0] =='tagxi-docs'){

        return redirect('user-manual');

        }
        
        if($conditional_host[0] =='tagxi-server'){

            $user = User::belongsToRole('super-admin')->first();

            auth('web')->login($user, true);
            
            return redirect('dashboard');


        }
        
        if($conditional_host[0] =='tagxi-dispatch'){

        $user = User::belongsToRole('dispatcher')->first();
        
        auth('web')->login($user, true);

        return redirect('dispatch/dashboard');

        }

        return view('admin.login1');
    }

    public function dispatchRequest()
    {
        $main_menu = 'driver_profile_dashboard';

        $sub_menu = null;
        $sub_menu_1 = '';
        return view('admin.newDispatcherRequest')->with(compact('main_menu','sub_menu','sub_menu_1'));
    }
    public function driverPrfDashboard()
    {
         $main_menu = 'driver_profile_dashboard';

        $sub_menu = null;
        $sub_menu_1 = '';
        // $item = $driver;
        // dd($item);
        return view('admin.driver-profile-dashboard')->with(compact('main_menu','sub_menu','sub_menu_1'));
    }

    public function driverPrfDashboardView(Driver $driver)
    {
        $main_menu = 'driver_profile_dashboard';
        
        $sub_menu = null;
        $sub_menu_1 = '';
        $item = $driver;
 
       
        // $request_detail = $driver->requestDetail()->OrderBy('id','asc')->first();
       
        // if ($request_detail) {
            
        $firebase_request_detail = $this->database->getReference('drivers/driver_'.$driver->id);
        $zone = Zone::companyKey()->first();
        // dd($firebase_request_detail);
        // $default_lat = $firebase_request_detail["l"][0];
        // $default_lng = $firebase_request_detail["l"][1];
        if (env('APP_FOR')=='live')
        {
          $firebase_driver = $this->database->getReference('drivers/driver_'.$driver->id)->getValue();
          // dd($firbase_driver);

        }else{
        $firebase_driver['is_active'] = 0;

        }


         $default_lat = $zone->lat;
        $default_lng = $zone->lng;
//new flow
$currentDate = Carbon::now();
//new flow

        $today = date('Y-m-d');

        $currency = $driver->user->countryDetail->currency_symbol;
        // dd($currency);

        //card
        $totalTrips = Requests::where('driver_id',$item->id)->whereIsCompleted(true)->count();
        $todayTrips = Requests::where('driver_id',$item->id)->whereIsCompleted(true)->whereDate('trip_start_time',$currentDate)->count();
        $todayEarning = RequestBill::whereHas('requestDetail', function ($query) use($item,$currentDate) {
            $query->companyKey()->where('driver_id',$item->id)->whereDate('trip_start_time',$currentDate)->whereIsCompleted(true);
            })->sum('total_amount');
        $totalEarning = RequestBill::whereHas('requestDetail', function ($query) use($item,$currentDate) {
                    $query->companyKey()->where('driver_id',$item->id)->whereIsCompleted(true);
                    })->sum('total_amount');
        $wallet = DriverWallet::where('user_id',$item->id)->first();
        // dd($wallet);
        if (!empty($wallet)) {
           $wallet_amount = $wallet->amount_balance;
        } else {
            $wallet_amount = 0;
        }

         //Overall Earning
        $overall_earning_cash = RequestBill::whereHas('requestDetail', function ($query) use($item) {
            $query->companyKey()->where('driver_id',$item->id)->where('payment_opt','1')->whereIsCompleted(true);
            })->sum('total_amount');
        $overall_earning_card = RequestBill::whereHas('requestDetail', function ($query) use($item) {
                    $query->companyKey()->where('driver_id',$item->id)->where('payment_opt','4')->whereIsCompleted(true);
            })->sum('total_amount');
        $overall_earning_wallet = RequestBill::whereHas('requestDetail', function ($query) use($item) {
                        $query->companyKey()->where('driver_id',$item->id)->where('payment_opt','2')->whereIsCompleted(true);
                        })->sum('total_amount');
        $total_overall_earnings = $overall_earning_cash + $overall_earning_card + $overall_earning_wallet;
//new flow
        
$currentDate = Carbon::now();

$overallEarnings = [];
// Loop through the last six months
for ($i = 0; $i < 6; $i++) {
    // Get the date of the current month in the loop
    $date = $currentDate->copy()->subMonths($i);
    
    // Get the month and year of the current date
    $month = $date->month;
    $year = $date->year;

    // Query to get the overall earnings for the current month
    $overallEarning = RequestBill::whereHas('requestDetail', function ($query) use ($item, $month, $year) {
        $query->companyKey()->where('driver_id', $item->id)
            ->whereMonth('trip_start_time', $month)
            ->whereYear('trip_start_time', $year)
            ->whereIsCompleted(true);
    })->sum('total_amount');

    // Store the overall earning for the current month in an array
    $overallEarnings[] = $overallEarning;
}

// Reverse the array to have the oldest month first
$overallEarnings = array_reverse($overallEarnings);
//new flow


        $overall_earning_commision = RequestBill::whereHas('requestDetail', function ($query) use($item) {
                        $query->companyKey()->where('driver_id',$item->id)->whereIsCompleted(true);
                        })->sum('admin_commision_with_tax');
        $overall_earning_driver_commision = RequestBill::whereHas('requestDetail', function ($query) use($item) {
                        $query->companyKey()->where('driver_id',$item->id)->whereIsCompleted(true);
                        })->sum('driver_commision'); 
        
         if ($total_overall_earnings > 0) {
        $overall_earning_cash_percent = ($overall_earning_cash/$total_overall_earnings) * 100;
        $overall_earning_card_percent = ($overall_earning_card/$total_overall_earnings) * 100;
        $overall_earning_wallet_percent = ($overall_earning_wallet/$total_overall_earnings) * 100;
        } else {
         $overall_earning_cash_percent =0;
         $overall_earning_card_percent =0;
         $overall_earning_wallet_percent =0;
        }

        //overall trips
        $total_completedTrips = Requests::companyKey()->where('driver_id',$item->id)->whereIsCompleted(true)->count();
        $total_cancelledTrips = Requests::companyKey()->where('driver_id',$item->id)->whereIsCancelled(true)->count();

        $to = Carbon::now()->month; //Get current month
        $from = Carbon::now()->subMonths(4)->month;
        $data=[];
         foreach (range($from, $to) as $month) {

            $data[$month]['y'] = Carbon::now()->month($month)->shortEnglishMonth;
            $data[$month]['a'] = Requests::companyKey()->where('driver_id',$item->id)->whereMonth('created_at', $month)->whereIsCompleted(true)->count();
            $data[$month]['u'] = Requests::companyKey()->where('driver_id',$item->id)->whereMonth('created_at', $month)->whereIsCancelled(true)->count();
          
        }
        //ongoing trip info
         $trip_info = Requests::companyKey()->where('driver_id',$item->id)->whereIsCompleted(false)->whereIsCancelled(false)->get();

         //shify_history
         $history = DriverAvailability::where('driver_id',$item->id)->paginate(10);
        // dd($data);


        


        // dd($item->user_id);
        return view('admin.driver-profile-dashboard-view')->with(compact('main_menu','sub_menu','item','totalTrips','todayTrips','todayEarning','totalEarning','wallet_amount','currency','overall_earning_card','overall_earning_wallet','overall_earning_cash','total_overall_earnings','overall_earning_cash_percent','overall_earning_card_percent','overall_earning_wallet_percent','overall_earning_commision','overall_earning_driver_commision','total_completedTrips','total_cancelledTrips','data','trip_info','history','default_lat','default_lng','sub_menu_1','firebase_driver','overallEarnings'));
    }

    
    public function viewTestDashboard()
    {
         $main_menu = 'dashboard';

        $sub_menu = null;
        $sub_menu_1 = '';
        $today = date('Y-m-d');
        //card
        $total_drivers = Driver::count();
        $driver_approval = Driver::where('approve',0)->count();
        $driver_approval_waiting = Driver::where('approve',1)->count();
        $total_users = User::count();
        
        //today's Trips
        $today_completedTrips = Requests::companyKey()->whereIsCompleted(true)->whereDate('trip_start_time',$today)->count();
        $today_cancelledTrips = Requests::companyKey()->whereIsCancelled(true)->whereDate('trip_start_time',$today)->count();
        $today_scheduledTrips = Requests::companyKey()->whereIsCompleted(false)->whereIsCancelled(false)->whereIsLater(true)->whereDate('trip_start_time',$today)->count();
        
        //overall trips
         $total_completedTrips = Requests::companyKey()->whereIsCompleted(true)->count();
        $total_cancelledTrips = Requests::companyKey()->whereIsCancelled(true)->count();
        $total_scheduledTrips = Requests::companyKey()->whereIsCompleted(false)->whereIsCancelled(false)->whereIsLater(true)->count();
        
        //today's Earning
        $today_earning_cash = RequestBill::whereHas('requestDetail', function ($query) {
            $query->companyKey()->where('payment_opt',1)->whereIsCompleted(true)->whereDate('trip_start_time',date('Y-m-d'));
            })->sum('total_amount');
        $today_earning_card = RequestBill::whereHas('requestDetail', function ($query) {
                    $query->companyKey()->where('payment_opt',0)->whereIsCompleted(true)->whereDate('trip_start_time',date('Y-m-d'));
            })->sum('total_amount');
        $today_earning_wallet = RequestBill::whereHas('requestDetail', function ($query) {
                        $query->companyKey()->where('payment_opt',2)->whereIsCompleted(true)->whereDate('trip_start_time',date('Y-m-d'));
                        })->sum('total_amount'); 

        //Overall Earning
        $overall_earning_cash = RequestBill::whereHas('requestDetail', function ($query) {
            $query->companyKey()->where('payment_opt',1)->whereIsCompleted(true);
            })->sum('total_amount');
        $overall_earning_card = RequestBill::whereHas('requestDetail', function ($query) {
                    $query->companyKey()->where('payment_opt',0)->whereIsCompleted(true);
            })->sum('total_amount');
        $overall_earning_wallet = RequestBill::whereHas('requestDetail', function ($query) {
                        $query->companyKey()->where('payment_opt',2)->whereIsCompleted(true);
                        })->sum('total_amount');

        //cancelation chart
        $to = Carbon::now()->month; //Get current month
        $from = Carbon::now()->subMonths(4)->month;
        $data=[];
         foreach (range($from, $to) as $month) {

            $data[$month]['y'] = Carbon::now()->month($month)->shortEnglishMonth;
            $data[$month]['a'] = Requests::whereMonth('trip_start_time', $month)->where('cancel_method','0')->whereIsCancelled(true)->count();
            $data[$month]['u'] = Requests::whereMonth('trip_start_time', $month)->where('cancel_method','1')->whereIsCancelled(true)->count();
            $data[$month]['d'] = Requests::whereMonth('trip_start_time', $month)->where('cancel_method','2')->whereIsCancelled(true)->count();
        }

        //users
        $active_users = User::whereActive(true)->count();
        $inactive_users = User::whereActive(false)->count();
        // $total_users = Requests::all();
        // $total_user_taken_trip = Requests::companyKey()->unique('user_id')->distinct()->count();
        $total_android_users = User::whereLoginBy('android')->count();
        $total_ios_users = User::whereLoginBy('ios')->count();
        $today_reg_users = User::whereDate('created_at',$today)->get();
        // dd($total_user_taken_trip);


        //driver dashboard
        $driver_total_android_users = Driver::whereHas('user', function ($query) {
                $query->whereLoginBy('android');
            })->count();
         $driver_total_ios_users = Driver::whereHas('user', function ($query) {
                $query->whereLoginBy('ios');
            })->count(); 
         $today_reg_drivers = Driver::whereHas('user', function ($query) {
                $query->whereDate('created_at',date('Y-m-d'));
            })->get();




         $completed_rides = Requests::companyKey()->whereIsCompleted(true)->count();
        $totalearnings = RequestBill::whereHas('requestDetail', function ($query) {
            $query->companyKey()->whereIsCompleted(true);
            })->sum('total_amount');
        
        // dd($personal_info);
        
        

          // dd($today_reg_drivers);

         return view('admin.admin-dashboard')->with(compact('main_menu','sub_menu','total_drivers','driver_approval','driver_approval_waiting','total_users','today_completedTrips','today_cancelledTrips','today_scheduledTrips','today_earning_wallet','today_earning_card','today_earning_cash','overall_earning_wallet','overall_earning_card','overall_earning_cash','data','active_users','inactive_users','total_users','total_android_users','total_ios_users','today_reg_users','sub_menu_1'));
    }
    public function dashboard()
    {
        // set default locale if none selected @TODO

        if(!Session::get('applocale')){
            Session::put('applocale', 'en');
        }

        
        $page = trans('pages_names.dashboard');

        $main_menu = 'dashboard';

        $sub_menu = null;
        $sub_menu_1 = '';

        //card
       
         $today = date('Y-m-d');
        
         $total_drivers = Driver::whereHas('user', function ($query) {
                        $query->companyKey();
                    })->count();
         
         $driver_approval = Driver::whereHas('user', function ($query) {
                        $query->companyKey();
                    })->where('approve',1)->count(); 
        
         $driver_approval_waiting = Driver::whereHas('user', function ($query) {
                        $query->companyKey();
                    })->where('approve',0)->count();
        
        $total_users = User::belongsToRole('user')->companyKey()->count();
        $driver_approval_percent = $driver_approval?($driver_approval/$total_drivers) * 100:0;
        $driver_approval_waiting_percent = $driver_approval_waiting?($driver_approval_waiting/$total_drivers) * 100:0;

        //today's Trips
        $today_completedTrips = Requests::companyKey()->whereIsCompleted(true)->whereDate('trip_start_time',$today)->count();
        $today_cancelledTrips = Requests::companyKey()->whereIsCancelled(true)->whereDate('trip_start_time',$today)->count();
        $today_scheduledTrips = Requests::companyKey()->whereIsCompleted(false)->whereIsCancelled(false)->whereIsLater(true)->whereDate('trip_start_time',$today)->count();

         //today's Earning
        $today_earning_cash = RequestBill::whereHas('requestDetail', function ($query) {
            $query->companyKey()->where('payment_opt','1')->whereIsCompleted(true)->whereDate('trip_start_time',date('Y-m-d'));
            })->sum('total_amount');
        $today_earning_card = RequestBill::whereHas('requestDetail', function ($query) {
                    $query->companyKey()->where('payment_opt','0')->whereIsCompleted(true)->whereDate('trip_start_time',date('Y-m-d'));
            })->sum('total_amount');
        $today_earning_wallet = RequestBill::whereHas('requestDetail', function ($query) {
                        $query->companyKey()->where('payment_opt','2')->whereIsCompleted(true)->whereDate('trip_start_time',date('Y-m-d'));
                        })->sum('total_amount'); 
        $today_earnings = $today_earning_cash + $today_earning_card + $today_earning_wallet;
        $today_earning_commision = RequestBill::whereHas('requestDetail', function ($query) {
                        $query->companyKey()->whereIsCompleted(true)->whereDate('trip_start_time',date('Y-m-d'));
                        })->sum('admin_commision_with_tax');
        $today_earning_driver_commision = RequestBill::whereHas('requestDetail', function ($query) {
                        $query->companyKey()->whereIsCompleted(true)->whereDate('trip_start_time',date('Y-m-d'));
                        })->sum('driver_commision'); 
        if ($today_earnings > 0) {
            # code...
        $today_cash_percent = ($today_earning_cash/$today_earnings) * 100;
        $today_card_percent = ($today_earning_card/$today_earnings) * 100;
        $today_wallet_percent = ($today_earning_wallet/$today_earnings) * 100;
        } else {
         $today_cash_percent =0;
         $today_card_percent =0;
         $today_wallet_percent =0;
        }

         //cancellation chart
        $to = Carbon::now()->month; //Get current month
        $from = Carbon::now()->subMonths(5)->month;
        $data=[];
         foreach (range($from, $to) as $month) {

            $data[$month]['y'] = Carbon::now()->month($month)->shortEnglishMonth;
            $data[$month]['a'] = Requests::companyKey()->whereMonth('created_at', $month)->where('cancel_method','0')->whereIsCancelled(true)->count();
            $data[$month]['u'] = Requests::companyKey()->whereMonth('created_at', $month)->where('cancel_method','1')->whereIsCancelled(true)->count();
            $data[$month]['d'] = Requests::companyKey()->whereMonth('created_at', $month)->where('cancel_method','2')->whereIsCancelled(true)->count();
        }
         // dd($data);

        $req_can_automatic = Requests::companyKey()->where('cancel_method','0')->whereIsCancelled(true)->count();
        $req_can_user = Requests::companyKey()->where('cancel_method','1')->whereIsCancelled(true)->count();
        $req_can_driver = Requests::companyKey()->where('cancel_method','2')->whereIsCancelled(true)->count();
        $total_req_can = $req_can_automatic + $req_can_user + $req_can_driver;
        // dd($data);

          //Overall Earning
        $overall_earning_cash = RequestBill::whereHas('requestDetail', function ($query) {
            $query->companyKey()->where('payment_opt','1')->whereIsCompleted(true);
            })->sum('total_amount');
        $overall_earning_card = RequestBill::whereHas('requestDetail', function ($query) {
                    $query->companyKey()->where('payment_opt','0')->whereIsCompleted(true);
            })->sum('total_amount');
        $overall_earning_wallet = RequestBill::whereHas('requestDetail', function ($query) {
                        $query->companyKey()->where('payment_opt','2')->whereIsCompleted(true);
                        })->sum('total_amount');
        $total_overall_earnings = $overall_earning_cash + $overall_earning_card + $overall_earning_wallet;

        //month wise overall earning
        $jan_overall_earning = RequestBill::whereHas('requestDetail', function ($query) {
                        $query->companyKey()->whereMonth('trip_start_time', 1)->whereIsCompleted(true);
                        })->sum('total_amount');
        
        $feb_overall_earning = RequestBill::whereHas('requestDetail', function ($query) {
                                $query->companyKey()->whereMonth('trip_start_time', 2)->whereIsCompleted(true);
                                })->sum('total_amount');
                
        $mar_overall_earning = RequestBill::whereHas('requestDetail', function ($query) {
                                $query->companyKey()->whereMonth('trip_start_time', 3)->whereIsCompleted(true);
                                })->sum('total_amount');
                
        $apr_overall_earning = RequestBill::whereHas('requestDetail', function ($query) {
                                $query->companyKey()->whereMonth('trip_start_time', 4)->whereIsCompleted(true);
                                })->sum('total_amount');
                
        $may_overall_earning = RequestBill::whereHas('requestDetail', function ($query) {
                                $query->companyKey()->whereMonth('trip_start_time', 5)->whereIsCompleted(true);
                                })->sum('total_amount');
                
        $jun_overall_earning = RequestBill::whereHas('requestDetail', function ($query) {
                                $query->companyKey()->whereMonth('trip_start_time', 6)->whereIsCompleted(true);
                                })->sum('total_amount');
                
        $jul_overall_earning = RequestBill::whereHas('requestDetail', function ($query) {
                                $query->companyKey()->whereMonth('trip_start_time', 7)->whereIsCompleted(true);
                                })->sum('total_amount');
                

        // dd($jan_overall_earning);



        $overall_earning_commision = RequestBill::whereHas('requestDetail', function ($query) {
                        $query->companyKey()->whereIsCompleted(true);
                        })->sum('admin_commision_with_tax');
        $overall_earning_driver_commision = RequestBill::whereHas('requestDetail', function ($query) {
                        $query->companyKey()->whereIsCompleted(true);
                        })->sum('driver_commision'); 
        
         if ($total_overall_earnings > 0) {
        $overall_earning_cash_percent = ($overall_earning_cash/$total_overall_earnings) * 100;
        $overall_earning_card_percent = ($overall_earning_card/$total_overall_earnings) * 100;
        $overall_earning_wallet_percent = ($overall_earning_wallet/$total_overall_earnings) * 100;
        } else {
         $overall_earning_cash_percent =0;
         $overall_earning_card_percent =0;
         $overall_earning_wallet_percent =0;
        }

        $currency = get_settings('currency_symbol');
        

     

        return view('admin.index', compact('page', 'main_menu', 'sub_menu', 'total_drivers', 'driver_approval', 'driver_approval_waiting', 'total_users','today_completedTrips','today_cancelledTrips','today_scheduledTrips','today_earnings','today_earning_cash','today_earning_card','today_earning_wallet','today_cash_percent','today_card_percent','today_wallet_percent','data','req_can_automatic','req_can_user','req_can_driver','total_req_can','overall_earning_card','overall_earning_wallet','overall_earning_cash','total_overall_earnings','overall_earning_cash_percent','overall_earning_card_percent','overall_earning_wallet_percent','today_earning_commision','today_earning_driver_commision','overall_earning_commision','overall_earning_driver_commision','jan_overall_earning','feb_overall_earning','mar_overall_earning','apr_overall_earning','may_overall_earning','jun_overall_earning','jul_overall_earning','currency','driver_approval_percent','driver_approval_waiting_percent','sub_menu_1'));
    }



    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        // $user = Socialite::driver('facebook')->user();
        $user = Socialite::driver($provider)->stateless()->user();

        return $this->respondSuccess($user);
    }

    public function changeLocale($lang)
    {
        Session::put('applocale', $lang);

        return redirect()->back();
    }

    public function trackTripDetails(Requests $request)
    {
        return view('track-request', compact('request'));
    }
    public function viewServices()
    {
        $page = trans('pages_names.dashboard');

        $main_menu = 'dashboard';

        $sub_menu = null;
        $sub_menu_1 = '';

        return view('admin.admin.services', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));
    }

//Forgot Password 
  /**
     * Redirect to admin forgot password
     */
    public function forgotPassword()
    {
        
        return view('admin.forgot-password');
    }
    public function sendLink(Request $request)
    {
        $mail = DB::table('password_resets')->where('email', $request->email)->value('email');
        if($mail != null)
        {
             return view('admin.mail-sended');
        }
        $request->validate([
            'email' => 'required|email|exists:users',   
        ]);

        $token = Str::random(64);

         DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
          ]);

          $details = DB::table('password_resets')->where('email', $request->email)->get();
         

        dispatch(new ForgotPassword($details));

        return view('admin.mail-sended');
    }

          /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) 
      { 
        $check_data_expires = User::where('reset_token',$token) ->first(); 
        if(!$check_data_expires)
        {
            return view('admin.linkExpired', ['token' => $token]);
        }
        return view('admin.reset-password',compact('token')); 
        // $token = DB::table('password_resets')->where('token', $token)->value('token');

        // if($token != null)
        // {
        // return view('admin.forgetPasswordLink', ['token' => $token]);
        // }
        // return view('admin.linkExpired', ['token' => $token]);

      }
 
    /**
      * Write code on Method
      *
      * @return response()
      */
      public function submitResetPasswordForm(Request $request)
      {
 
        //   $request->validate([
        //      'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
        //      'password_confirmation' => 'min:8'
        //   ]);
  
        //  $updatePassword = DB::table('password_resets')
        //                       ->where([
        //                      //    'email' => $request->email, 
        //                         'token' => $request->oldtoken
        //                       ])
        //                       ->first();
        $user_data = User::where('reset_token',$request->token)->first();
          $user = User::where('email',  $user_data->email)
                      ->update(['password' => Hash::make($request->new_password)]);
         // $token = DB::table('password_resets')
         //         ->where('token','=',$request->oldtoken)
         //         ->where('created_at','>',Carbon::now()->subMinute(2))
         //         ->first();
 
        //   DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
        //   return view('admin.password-changed');
        $response = [
            "status"=>true,
            "message"=>"Email exists"
        ];
        return response()->json($response);
 
      }    
     /**
     * Redirect to dispatcher login
     * @hideFromAPIDocumentation
     */
    public function viewDispatchLogin()
    {    
        $recaptcha_enabled = get_settings('enable_recaptcha') ?? false; 
        
        return view('dispatch-new.login',compact('recaptcha_enabled'));
    }

 }
 