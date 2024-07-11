<?php

namespace App\Http\Controllers\Web\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Country;
use App\Models\Admin\Driver;
use App\Models\MembershipTariff;
use App\Models\Admin\Company;
use App\Base\Constants\Auth\Role;
use App\Models\Admin\UserDetails;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Web\BaseController;
use App\Base\Constants\Auth\Role as RoleSlug;
use App\Base\Filters\Master\CommonMasterFilter;
use App\Http\Requests\Admin\User\CreateUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Base\Libraries\QueryFilter\QueryFilterContract;
use App\Base\Services\ImageUploader\ImageUploaderContract;
use App\Models\Request\Request as RequestRequest;
use App\Base\Filters\Admin\RequestFilter;
use App\Models\Payment\UserWalletHistory;
use App\Models\Payment\UserWallet;
use App\Http\Requests\Admin\User\AddUserMoneyToWalletRequest;
use App\Base\Constants\Setting\Settings;
use Illuminate\Support\Str;
use App\Base\Constants\Masters\WalletRemarks;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\Notifications\SendPushNotification;
use Mail;
use Illuminate\Http\Request;
use App\Models\UsersMembership;
use App\Jobs\Notifications\Auth\Registration\UserNotification;

class UserController extends BaseController
{
    /**
     * The User Details model instance.
     *
     * @var \App\Models\Admin\UserDetails
     */
    protected $user_details ;

    /**
     * The User model instance.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * The
     *
     * @var App\Base\Services\ImageUploader\ImageUploaderContract
     */
    protected $imageUploader;


    /**
     * User Details Controller constructor.
     *
     * @param \App\Models\Admin\UserDetails $user_details
     */
    public function __construct(UserDetails $user_details, ImageUploaderContract $imageUploader, User $user)
    {
        $this->user_details = $user_details;
        $this->imageUploader = $imageUploader;
        $this->user = $user;
    }

    /**
    * Get all users
    * @return \Illuminate\Http\JsonResponse
    */
    public function index()
    {
        $page = trans('pages_names.users');

        $main_menu = 'users';
        $sub_menu = 'user_details';
        $sub_menu_1 = 'active_user';

        return view('admin.users.index', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));
    }

    /**
    * Get all users
    * @return \Illuminate\Http\JsonResponse
    */
    public function view(User $user)
    {
        $page = trans('pages_names.users'); 
        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = 'active_user';
        $membership_tariff = MembershipTariff::get(); 
        return view('admin.users.view', compact('page', 'main_menu', 'sub_menu','sub_menu_1','user','membership_tariff'));
    }

    public function getAllUser(QueryFilterContract $queryFilter)
    {
        $url = request()->fullUrl(); //get full url

        $query = User::where('active', true)->where('is_deleted', false)->where('is_approve', 0)->belongsToRole(RoleSlug::USER);
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();

        return view('admin.users._user', compact('results'));
    }
//searchUser
    public function searchUser(QueryFilterContract $queryFilter)
    {
        $url = request()->fullUrl(); //get full url

        $query = User::belongsToRole(RoleSlug::USER);
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();

        return view('admin.users._user', compact('results'));
    }


    public function indexDeleted()
    {
        $page = trans('pages_names.users');

        $main_menu = 'users';
        $sub_menu = 'deceased';
        $sub_menu_1 = 'deceased';

        return view('admin.users.deleted-index', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));
    }

    public function getAllDeletedUser(QueryFilterContract $queryFilter)
    {
        $url = request()->fullUrl(); //get full url

        $query = User::where('is_deleted', true)->belongsToRole(RoleSlug::USER);
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();

        return view('admin.users._deleted-user', compact('results'));
    }


/*inactive Users*/
    public function indexInactive()
    {
        $page = trans('pages_names.users');

        $main_menu = 'users';
        $sub_menu = 'approved';
        $sub_menu_1 = 'in_active_user';

        return view('admin.users.inactive-index', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));
    }

    public function getAllInactiveUser(QueryFilterContract $queryFilter)
    {
        $url = request()->fullUrl(); //get full url

        $query = User::where('is_deleted', false)->where('is_approve', 1)->belongsToRole(RoleSlug::USER);
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();

        return view('admin.users._inactive_user', compact('results'));
    }
/*end*/

    /**
    * Create User View
    *
    */
    public function create()
    {
        $page = trans('pages_names.add_user');

        $countries = Country::active()->get();

        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';

        return view('admin.users.create', compact('page', 'countries', 'main_menu', 'sub_menu','sub_menu_1'));
    }

    /**
     * Create User.
     *
     * @param \App\Http\Requests\Admin\User\CreateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserRequest $request)
    {
        $created_params = $request->only(['name','mobile','email','country','gender']);
        $created_params['mobile_confirmed'] = true;
        // $created_params['password'] = bcrypt($request->input('password'));

            $created_params['ride_otp'] = rand(1111, 9999);

        $validate_exists_email = $this->user->belongsTorole(Role::USER)->where('email', $request->email)->exists();

        $validate_exists_mobile = $this->user->belongsTorole(Role::USER)->where('mobile', $request->mobile)->exists();

        if ($validate_exists_email) {
            return redirect()->back()->withErrors(['email'=>'Provided email hs already been taken'])->withInput();
        }
        if ($validate_exists_mobile) {
            return redirect()->back()->withErrors(['mobile'=>'Provided mobile hs already been taken'])->withInput();
        }

        if ($uploadedFile = $this->getValidatedUpload('profile_picture', $request)) {
            $created_params['profile_picture'] = $this->imageUploader->file($uploadedFile)
                ->saveProfilePicture();
        }

        $created_params['company_key'] = auth()->user()->company_key;

        $created_params['refferal_code']= str_random(6);

        $created_params['created_by'] = auth()->user()->id;


        $user = $this->user->create($created_params);

        $user->attachRole(RoleSlug::USER);


        $message = trans('succes_messages.user_added_succesfully');

        return redirect('users')->with('success', $message);
    }

    public function getById(User $user)
    {
        $page = trans('pages_names.edit_user');


        $countries = Country::all();
        $results = $user->userDetails ?? $user;
        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';

        return view('admin.users.update', compact('page', 'countries', 'main_menu', 'results', 'sub_menu','sub_menu_1'));
    }


    public function update(User $user, UpdateUserRequest $request)
    {
        $updated_params = $request->only(['name','mobile','email','country','gender']);

        $updated_params['updated_by'] = auth()->user()->id;

        if ($uploadedFile = $this->getValidatedUpload('profile_picture', $request)) {
            $updated_params['profile_picture'] = $this->imageUploader->file($uploadedFile)
                ->saveProfilePicture();
        }

        $validate_exists_email = $this->user->belongsTorole(Role::USER)->where('email', $request->email)->where('id', '!=', $user->id)->exists();

        $validate_exists_mobile = $this->user->belongsTorole(Role::USER)->where('mobile', $request->mobile)->where('id', '!=', $user->id)->exists();

        if ($validate_exists_email) {
            return redirect()->back()->withErrors(['email'=>'Provided email hs already been taken'])->withInput();
        }
        if ($validate_exists_mobile) {
            return redirect()->back()->withErrors(['mobile'=>'Provided mobile hs already been taken'])->withInput();
        }

        $user->update($updated_params);

        $message = trans('succes_messages.user_updated_succesfully');

        return redirect('users')->with('success', $message);
    }

    public function toggleStatus(User $user)
    {
        $status = $user->active == 1 ? 0 : 1;

        if($status==1)
        {

            $user->update([
                'active' => $status,
                'is_deleted'=>false,
            ]);
        }else{

            $user->update([
                'active' => $status,
            ]);            
        }


        $message = trans('succes_messages.user_status_changed_succesfully');

            $title = trans('push_notifications.account_inactivated_title',[],$user->lang);
            $body = trans('push_notifications.account_inactivated_body',[],$user->lang);
            $push_data =  ['title' => 'account_inactivated','message' => 'account_inactivated','push_type'=>'account_inactivated'];

       dispatch(new SendPushNotification($user,$title,$body,$push_data));

        return redirect('users')->with('success', $message);
    }
    public function confirm(User $user,Request $request)
    {     
            $membership_data = MembershipTariff::find($request->data);
            $user->update([
                'is_paid_online' => 0,
                'is_payment_done' => 1,
                'payment_mode' => $request->payment_mode,
                'is_approve' => 1,
                'is_deleted'=>false,
                'membership_type'=>$request->data,
                'membership_amount'=>$membership_data->price
            ]);   
            $details = [
                'title' => "Mail from IAS Officers' App",
                'user_details' => $user,
                'type' => 'confirm_email'
            ]; 
            $member_ship_data = UsersMembership::where('user_id',$user->id)->first(); 
            $member_ship_data->membership_type = $request->input('data');
            $member_ship_data->payment_mode = $request->input('payment_mode');
            $member_ship_data->is_paid = 1; 
            $member_ship_data->amount = $membership_data->price; 
            $member_ship_data->date = Carbon::now('Asia/kolkata')->format("Y-m-d H:i:s");
            $member_ship_data->expiry_date = Carbon::now('Asia/Kolkata')->addYear()->format("Y-m-d H:i:s");
            $member_ship_data->is_lifetime_member = $membership_data->membership_type; 
            $member_ship_data->save(); 
            Mail::to($user->email)->send(new UserNotification($details)); 
            $sender_id = 'KTSHSC';
            $template_id = '1707168862643740857';
            $phone = $user->mobile;
            $msg = "Payment Done Successfully. Your UserId is ".$user->userid." and Password is ".$user->mobile."";
            $username = 'IndiaklabssOTP';
            $apikey = '4DE5A-8C990';
            $uri = 'https://powerstext.in/sms-panel/api/http/index.php';
            // dd($phone);
            // Construct the URL with query parameters
            $url = $uri . '?' . http_build_query(array(
                'username' => $username,
                'apikey' => $apikey,
                'apirequest' => 'Text',
                'sender' => $sender_id,
                'route' => 'OTP',
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
            
            $response = curl_exec($ch);
            
            // Check for errors
            if(curl_errno($ch)) {
                // echo 'Curl error: ' . curl_error($ch);
                $response = [
                    'status' => true,
                    'message' => curl_error($ch)
                ];
                return response()->json($response);
            } else {
                // Process the response
                // echo $response;
            }
            
            // Close the cURL handle
            curl_close($ch);
            $response = [
                'status' => true,
                'message' => 'Confirmed'
            ];
            return response()->json($response);
    }
    public function send_cred(User $user){
        if($user)
        {
            $details = [
                'title' => "Mail from IAS Officers' App",
                'user_details' => $user,
                'type' => 'send_cred'
            ]; 
            Mail::to($user->email)->send(new UserNotification($details)); 
            $response = [
                'status' => true,
                'message' => 'Confirmed'
            ];
            return response()->json($response);
        }
        
    }
    public function approve(User $user)
    {  
            $user->update([
                'is_approve' => 1,
                'is_deleted'=>false,
            ]);   
            $details = [
                'title' => 'Mail from Laravel App',
                'body' => 'This is a test email sent from a Laravel application.'
            ];
    
            // Mail::to('ranjith@dubudubu.in')->send(new UserNotification($details));
            $response = [
                'status' => true,
                'message' => 'Approved'
            ];
            return response()->json($response);
    }
    public function toggleApprove(User $user, $approval_status)
    {
        $user_id = auth()->user()->id;

        $status = (boolean)$approval_status;

        $user->update([
            'approve' => $status,
            'updated_by' => $user_id,
            'is_deleted'=>false,
            
        ]);
        
       $this->database->getReference('users/user_'.$driver->id)->update(['approve'=>(int)$status,'updated_at'=> Database::SERVER_TIMESTAMP]);

        $message = trans('succes_messages.user_approve_status_changed_succesfully');
        $user = User::find($user->user_id);
        if ($status) {
            $title = trans('push_notifications.user_approved',[],$user->lang);
            $body = trans('push_notifications.user_approved_body',[],$user->lang);
            $push_data = ['notification_enum'=>PushEnums::USER_ACCOUNT_APPROVED];
            $socket_success_message = PushEnums::USER_ACCOUNT_APPROVED;
        } else {
            $title = trans('push_notifications.user_declined_title',[],$user->lang);
            $body = trans('push_notifications.user_declined_body',[],$user->lang);
            $push_data = ['notification_enum'=>PushEnums::USER_ACCOUNT_DECLINED];
            $socket_success_message = PushEnums::USER_ACCOUNT_DECLINED;
        }

        $user_details = $user->user;
        $user_result = fractal($user_details, new UserTransformer);
        $formated_user = $this->formatResponseData($user_result);
        // dd($formated_user);
        $socket_params = $formated_user['data'];
        $socket_data = new \stdClass();
        $socket_data->success = true;
        $socket_data->success_message  = $socket_success_message;
        $socket_data->data  = $socket_params;


        dispatch(new SendPushNotification($user,$title,$body));

        return redirect('users')->with('success', $message);
    }
    public function toggleAvailable(User $user)
    {
        $status = $user->available == 1 ? 0 : 1;
        $user->update([
            'available' => $status
        ]);

        $message = trans('succes_messages.user_available_status_changed_succesfully');
        return redirect('users')->with('success', $message);
    }
    public function delete(User $user)
    {
        if(env('APP_FOR')=='demo'){

        $message = 'you cannot delete the user. this is demo version';

        return $message;

        }
        
        $user->update(['is_deleted'=>true, 'active'=>false]);  

        $message = trans('succes_messages.user_deleted_succesfully');

        return $message;
    }
   public function UserTripRequestIndex(User $user)
    {

        $completedTrips = RequestRequest::where('user_id',$user->id)->companyKey()->whereIsCompleted(true)->count();
        $cancelledTrips = RequestRequest::where('user_id',$user->id)->companyKey()->whereIsCancelled(true)->count();

        $card = [];
        $card['completed_trip'] = ['name' => 'trips_completed', 'display_name' => 'Completed Rides', 'count' => $completedTrips, 'icon' => 'fa fa-flag-checkered text-green'];
        $card['cancelled_trip'] = ['name' => 'trips_cancelled', 'display_name' => 'Cancelled Rides', 'count' => $cancelledTrips, 'icon' => 'fa fa-ban text-red'];

        $main_menu = 'users_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';
        $items = $user->id;

        return view('admin.users.user-request-list-new', compact('card','main_menu','sub_menu','items','sub_menu_1'));
    }
    public function UserTripRequestNew(QueryFilterContract $queryFilter, User $user)
    {
        $items = $user->id;
       
        $query = RequestRequest::where('requests.user_id', $user->id); // Specify 'requests.user_id' to resolve ambiguity
        
        $results = $queryFilter->builder($query)->customFilter(new RequestFilter)->defaultSort('-created_at')->paginate();

        return view('admin.users.user-request-list-view-new', compact('results', 'items'));
    }
    public function UserTripRequest(QueryFilterContract $queryFilter, User $user)
    {
       
        $completedTrips = RequestRequest::where('user_id',$user->id)->companyKey()->whereIsCompleted(true)->count();
        $cancelledTrips = RequestRequest::where('user_id',$user->id)->companyKey()->whereIsCancelled(true)->count();
        $upcomingTrips = RequestRequest::where('user_id',$user->id)->companyKey()->whereIsLater(true)->whereIsCompleted(false)->whereIsCancelled(false)->whereIsDriverStarted(false)->count();

        $card = [];
        $card['completed_trip'] = ['name' => 'trips_completed', 'display_name' => 'Completed Rides', 'count' => $completedTrips, 'icon' => 'fa fa-flag-checkered text-green'];
        $card['cancelled_trip'] = ['name' => 'trips_cancelled', 'display_name' => 'Cancelled Rides', 'count' => $cancelledTrips, 'icon' => 'fa fa-ban text-red'];
        $card['upcoiming_trip'] = ['name' => 'trips_cancelled', 'display_name' => 'Upcoming Rides', 'count' => $upcomingTrips, 'icon' => 'fa fa-calendar'];

        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';



         $query = RequestRequest::where('user_id',$user->id);
        $results = $queryFilter->builder($query)->customFilter(new RequestFilter)->defaultSort('-created_at')->paginate();


        return view('admin.users.user-request-list', compact('results','card','main_menu','sub_menu','sub_menu_1'));
    }
    public function UserTripRequestView(QueryFilterContract $queryFilter, User $user)
    {
        $items = $user->id;

        $query = RequestRequest::where('user_id',$user->id);
        $results = $queryFilter->builder($query)->customFilter(new RequestFilter)->defaultSort('-created_at')->paginate();

        return view('admin.users.user-request-list-view', compact('results','items'));
    }
    public function userPaymentHistory(User $user)
    {
        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';
        $item = $user;

        $amount = UserWallet::where('user_id',$user->id)->first();

    if ($amount == null) {
         $card = [];
         $card['total_amount'] = ['name' => 'total_amount', 'display_name' => 'Total Amount ', 'count' => "0", 'icon' => 'fa fa-flag-checkered text-green'];
        $card['amount_spent'] = ['name' => 'amount_spent', 'display_name' => 'Spend Amount ', 'count' => "0", 'icon' => 'fa fa-ban text-red'];
        $card['balance_amount'] = ['name' => 'balance_amount', 'display_name' => 'Balance Amount', 'count' => "0", 'icon' => 'fa fa-ban text-red'];

         $history = UserWalletHistory::where('user_id',$user->id)->orderBy('created_at','desc')->paginate(10);
        }else{

         $card = [];
        $card['total_amount'] = ['name' => 'total_amount', 'display_name' => 'Total Amount ', 'count' => $amount->amount_added, 'icon' => 'fa fa-flag-checkered text-green'];
        $card['amount_spent'] = ['name' => 'amount_spent', 'display_name' => 'Spend Amount ', 'count' => $amount->amount_spent, 'icon' => 'fa fa-ban text-red'];
        $card['balance_amount'] = ['name' => 'balance_amount', 'display_name' => 'Balance Amount', 'count' => $amount->amount_balance, 'icon' => 'fa fa-ban text-red'];

         $history = UserWalletHistory::where('user_id',$user->id)->orderBy('created_at','desc')->paginate(10);

        // dd($history);
        }
        return view('admin.users.user-payment-wallet', compact('card','main_menu','sub_menu','item','history','sub_menu_1'));
    }
     public function StoreUserPaymentHistory(AddUserMoneyToWalletRequest $request,User $user)
    {
// dd($request);

        $currency = get_settings(Settings::CURRENCY);

        // $converted_amount_array =  convert_currency_to_usd($user_currency_code, $request->input('amount'));

        // $converted_amount = $converted_amount_array['converted_amount'];
        // $converted_type = $converted_amount_array['converted_type'];
        // $conversion = $converted_type.':'.$request->amount.'-'.$converted_amount;
        $transaction_id = Str::random(6);


            $wallet_model = new UserWallet();
            $wallet_add_history_model = new UserWalletHistory();
            $user_id = $user->id;


        $user_wallet = $wallet_model::firstOrCreate([
            'user_id'=>$user_id]);
        $user_wallet->amount_added += $request->amount;
        $user_wallet->amount_balance += $request->amount;
        $user_wallet->save();

        $wallet_add_history_model::create([
            'user_id'=>$user_id,
            'card_id'=>null,
            'amount'=>$request->amount,
            'transaction_id'=>$transaction_id,
            'merchant'=>null,
            'remarks'=>WalletRemarks::MONEY_DEPOSITED_TO_E_WALLET_FROM_ADMIN,
            'is_credit'=>true]);


         $message = "money_added_successfully";
        return redirect()->back()->with('success', $message);


    }

    public function importUser(){

        $page = trans('pages_names.users');

        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';


        Excel::import(new UsersImport, request()->file('file'));

             $message = trans('succes_messages.user_import_succesfully');

        return redirect('users')->with('success', $message);

    }

     public function downloadFile()
    {
        $sampleFile = public_path()."/assets/sample_file/sample_file.csv";

        $headers = array(
         'Content-Type : application/csv',
        );


        return response()->download($sampleFile);
    }
    public function UserCancelRequestIndex(User $user)
    {

        $results = $user->userCancellationFee()->paginate();
        // dd($results);

        $page = trans('pages_names.assign_types');

        $main_menu = 'drivers_and_users';
        $sub_menu = 'users';
        $sub_menu_1 = '';

        return view('admin.users.cancellation', compact('results', 'page', 'main_menu', 'sub_menu', 'user','sub_menu_1'));

    }    
}
