<?php

namespace App\Http\Controllers\Web\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Country;
use App\Jobs\NotifyViaMqtt;
use App\Models\Admin\Driver;
use App\Models\Request\DriverRejectedRequest;
use Illuminate\Http\Request;
use App\Jobs\NotifyViaSocket;
use App\Models\Admin\Company;
use App\Models\Master\CarMake;
use App\Models\Master\CarModel;
use App\Base\Constants\Auth\Role;
use App\Models\Admin\VehicleType;
use App\Models\Admin\ServiceLocation;
use App\Http\Controllers\ApiController;
use App\Base\Filters\Admin\DriverFilter;
use App\Base\Constants\Masters\PushEnums;
use App\Models\Admin\DriverNeededDocument;
use App\Http\Controllers\Web\BaseController;
use App\Base\Constants\Auth\Role as RoleSlug;
use App\Transformers\Driver\DriverTransformer;
use App\Base\Filters\Master\CommonMasterFilter;
use App\Jobs\Notifications\AndroidPushNotification;
use App\Base\Libraries\QueryFilter\QueryFilterContract;
use App\Http\Requests\Admin\Driver\CreateDriverRequest;
use App\Http\Requests\Admin\Driver\UpdateDriverRequest;
use App\Base\Services\ImageUploader\ImageUploaderContract;
use App\Models\Request\Request as RequestRequest;
use App\Models\Request\RequestRating;
use App\Base\Filters\Admin\RequestFilter;
use App\Models\Payment\DriverWalletHistory;
use App\Models\Payment\DriverWallet;
use App\Http\Requests\Admin\Driver\AddDriverMoneyToWalletRequest;
use App\Transformers\Payment\DriverWalletHistoryTransformer;
use App\Base\Constants\Masters\WalletRemarks;
use Illuminate\Support\Str;
use App\Models\Payment\WalletWithdrawalRequest;
use App\Base\Constants\Setting\Settings;
use Kreait\Firebase\Contract\Database;
use App\Jobs\Notifications\SendPushNotification;
use App\Imports\DriversImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\RegisteredDriver;
use App\Exports\RegisteredDriverExport;
use App\Base\Filters\Admin\UserFilter;
use App\Models\Admin\DriverInvoice;
use App\Models\Payment\DriverSubscription;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

use Spatie\Browsershot\Browsershot;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Admin\Promo;
use PDF;

/**
 * @resource Driver
 *
 * vechicle types Apis
 */
class DriverController extends BaseController
{
    /**
     * The Driver model instance.
     *
     * @var \App\Models\Admin\Driver
     */
    protected $driver;

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

    protected $gateway;

    protected $country;

    // protected $callable_gateway_class;

    /**
     * DriverController constructor.
     *
     * @param \App\Models\Admin\Driver $driver
     */
    public function __construct(Driver $driver, ImageUploaderContract $imageUploader, User $user,Country $country,Database $database)
    {
        $this->driver = $driver;
        $this->imageUploader = $imageUploader;
        $this->user = $user;
        $this->country = $country;
        $this->database = $database;

        $this->gateway = env('PAYMENT_GATEWAY');
        // $this->callable_gateway_class = app(config('base.payment_gateway.'.$this->gateway.'.class'));
    }

    /**
    * Get all drivers
    * @return \Illuminate\Http\JsonResponse
    */
    public function index()
    {
        $page = trans('pages_names.drivers');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = 'driver_details';
        $services = ServiceLocation::whereActive(true)->companyKey()->get();
        $approved = Driver::where('approve', true)->where('owner_id', null)->get();
        // dd($approved);
        return view('admin.drivers.index', compact('page', 'main_menu', 'sub_menu','services', 'approved','sub_menu_1'));
    }

    /**
    * Fetch approved drivers
    */
    public function getApprovedDrivers(QueryFilterContract $queryFilter)
    {
        if (access()->hasRole(RoleSlug::SUPER_ADMIN)) {
                $query = Driver::where('approve', true)->where('owner_id', null)->orderBy('created_at', 'desc');
                if (env('APP_FOR')=='demo') {
                    $query = Driver::where('approve', true)->where('owner_id', null)->whereHas('user', function ($query) {
                        $query->whereCompanyKey(auth()->user()->company_key);
                    })->orderBy('created_at', 'desc');
                }
            } else {
                $this->validateAdmin();
                $query = $this->driver->where('approve', true)->where('owner_id', null)->orderBy('created_at', 'desc');
            }
            $results = $queryFilter->builder($query)->customFilter(new DriverFilter)->paginate();

            return view('admin.drivers._drivers', compact('results'))->render();

    }
    public function searchAllDrivers(QueryFilterContract $queryFilter)
    {
        if (access()->hasRole(RoleSlug::SUPER_ADMIN)) {
                $query = Driver::where('owner_id', null)->orderBy('created_at', 'desc');
                if (env('APP_FOR')=='demo') {
                    $query = Driver::where('owner_id', null)->whereHas('user', function ($query) {
                        $query->whereCompanyKey(auth()->user()->company_key);
                    })->orderBy('created_at', 'desc');
                }
            } else {
                $this->validateAdmin();
                $query = $this->driver->where('owner_id', null)->orderBy('created_at', 'desc');
            }
            $results = $queryFilter->builder($query)->customFilter(new DriverFilter)->paginate();

            return view('admin.drivers._drivers1', compact('results'))->render();

    }


    public function approvalPending()
    {
        $page = trans('pages_names.drivers');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = 'driver_approval_pending';
        $services = ServiceLocation::whereActive(true)->companyKey()->get();
        return view('admin.drivers.pending-for-approval', compact('page', 'main_menu', 'sub_menu','services','sub_menu_1'));
    }
    public function getApprovalPendingDrivers(QueryFilterContract $queryFilter)
    {
         if (access()->hasRole(RoleSlug::SUPER_ADMIN)) {
                $query = Driver::where('drivers.approve', 2)
                    ->where('drivers.owner_id', null)
                    ->where('drivers.is_deleted', false)
                    ->whereNull('reason')
                    ->orderBy('drivers.created_at', 'desc');

            } else {
                $this->validateAdmin();
                $query = $this->driver
                    ->where('approve', 2)
                    ->where('owner_id', null)
                    ->where('is_deleted', false)
                    ->whereNull('reason')
                    ->orderBy('created_at', 'desc');
            }
            $results = $queryFilter->builder($query)
                ->customFilter(new DriverFilter)
                ->paginate();

            return view('admin.drivers._drivers_unapproved', compact('results'))->render();

    }
    /**
    * Get all drivers
    * @return \Illuminate\Http\JsonResponse
    */
    public function registerdDrivers()
    {
        $page = trans('pages_names.drivers');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = 'registered_drivers';
        $drivers = RegisteredDriver::where('status',1)->get();
        // dd($drivers);
        return view('admin.drivers.registered', compact('page', 'main_menu', 'sub_menu','drivers','sub_menu_1'));
    }

     /**
    * Get all drivers
    * @return \Illuminate\Http\JsonResponse
    */
    public function ListNotes(Request $request)
    { 
        // dd($request->all());
        $notes = RegisteredDriver::where('id',$request->data_id)->first(); 
        
        if($notes->notes != NULL)
        {
            $notes_data = json_decode($notes->notes);
            // dd($notes_data);
            $html_data = "";
            foreach($notes_data as $k=>$value)
            {
                if(isset($value->decline))
                {
                    $html_data.= '<div>
                    <p><strong>'.$value->name.'(SENT BACK) </strong>: <span>'.$value->comments.'</span><span style="color: grey;float: right;font-size: 12px;"> '.$value->date.'</span><p>
                    </div>';
                }
                else{
                    $html_data.= '<div>
                    <p><strong>'.$value->name.' </strong>: <span>'.$value->comments.'</span><span style="color: grey;float: right;font-size: 12px;"> '.$value->date.'</span><p>
                    </div>';
                }
               
            }
            $html_data.= '<div><h4>Notes: </h4><p><textarea name="textbox2" id="textbox2" rows="4" cols="37"></textarea>
            </p> <div role="group" aria-label="Save and Cancel Buttons" style="
    /* text-align: center !important; */
    float: right;
">
            <button type="submit" class="btn btn-primary save_notes" style="
    /* float: right; */
" data-val="'.$notes->id.'">Save</button>
            <button type="button" class="btn btn-secondary close1" style="
    /* float: right; */
    background-color: white;
">Cancel</button>
          </div></div>';
            $data = ['status'=>"success","message"=>$html_data];
            return response()->json($data);
        }
        else{
            $data = ['status'=>"success","message"=>'<div><h4>Notes: </h4><p><textarea name="textbox2" id="textbox2" rows="4" cols="37"></textarea>
            </p> <div role="group" aria-label="Save and Cancel Buttons" style="
    /* text-align: center !important; */
    float: right;
">
            <button type="submit" class="btn btn-primary save_notes" style="
    /* float: right; */
" data-val="'.$notes->id.'">Save</button>
            <button type="button" class="btn btn-secondary close1" style="
    /* float: right; */
    background-color: white;
">Cancel</button>
          </div></div>'];
            return response()->json($data);
        }
        
    } 
      /**
    * Get all drivers
    * @return \Illuminate\Http\JsonResponse
    */
    public function ListNote(Request $request)
    { 
        // dd($request->all());
        $notes = Driver::where('id',$request->data_id)->first(); 
        
        if($notes->notes_data != NULL)
        {
            $notes_data = json_decode($notes->notes_data);
            // dd($notes_data);
            $html_data = "";
            foreach($notes_data as $k=>$value)
            {
                if(isset($value->decline))
                {
                    $html_data.= '<div>
                    <p><strong>'.$value->name.'(SENT BACK) </strong>: <span>'.$value->comments.'</span><span style="color: grey;float: right;font-size: 12px;"> '.$value->date.'</span><p>
                    </div>';
                }
                else{
                    $html_data.= '<div>
                    <p><strong>'.$value->name.' </strong>: <span>'.$value->comments.'</span><span style="color: grey;float: right;font-size: 12px;"> '.$value->date.'</span><p>
                    </div>';
                }
               
            }
            $html_data.= '<div><h4>Notes: </h4><p><textarea name="textbox2" id="textbox2" rows="4" cols="37"></textarea>
            </p> <div role="group" aria-label="Save and Cancel Buttons" style="
    /* text-align: center !important; */
    float: right;
">
            <button type="submit" class="btn btn-primary save_notes" style="
    /* float: right; */
" data-val="'.$notes->id.'">Save</button>
            <button type="button" class="btn btn-secondary close1" style="
    /* float: right; */
    background-color: white;
">Cancel</button>
          </div></div>';
            $data = ['status'=>"success","message"=>$html_data];
            return response()->json($data);
        }
        else{
            $data = ['status'=>"success","message"=>'<div><h4>Notes: </h4><p><textarea name="textbox2" id="textbox2" rows="4" cols="37"></textarea>
            </p> <div role="group" aria-label="Save and Cancel Buttons" style="
    /* text-align: center !important; */
    float: right;
">
            <button type="submit" class="btn btn-primary save_notes" style="
    /* float: right; */
" data-val="'.$notes->id.'">Save</button>
            <button type="button" class="btn btn-secondary close1" style="
    /* float: right; */
    background-color: white;
">Cancel</button>
          </div></div>'];
            return response()->json($data);
        }
        
    } 
    public function AddNotes(Request $request)
    { 
        $notes = RegisteredDriver::where('id',$request->data_value)->first(); 
        $date = Carbon::now();
        $user = User::find(auth()->user()->id); 
        $notes_data1[0]['name'] = $user->name;
        $notes_data1[0]['comments'] = $request->value;  
        $notes_data1[0]['date'] = $date->format('jS F h:i A'); 
        if($notes->assign_to != NULL && $notes->notes != NULL)
        { 
            $notes_data = json_decode($notes->notes, true); // Decode JSON to associative array 
            // Merge arrays
            $datas = array_merge($notes_data, $notes_data1);
            RegisteredDriver::where('id',$request->data_value)->update(['notes'=>json_encode($datas)]);
            
            $data = ['status'=>"success"];
            return response()->json($data);
        }
        else{ 
            RegisteredDriver::where('id',$request->data_value)->update(['notes'=>json_encode($notes_data1)]);
            $data = ['status'=>"success"];
            return response()->json($data);
        }
    }
    public function AddNote(Request $request)
    { 
        $notes = Driver::where('id',$request->data_value)->first(); 
        $date = Carbon::now();
        $user = User::find(auth()->user()->id); 
        $notes_data1[0]['name'] = $user->name;
        $notes_data1[0]['comments'] = $request->value;  
        $notes_data1[0]['date'] = $date->format('jS F h:i A'); 
        if($notes->notes_data != NULL)
        { 
            $notes_data = json_decode($notes->notes_data, true); // Decode JSON to associative array 
            // Merge arrays
            $datas = array_merge($notes_data, $notes_data1);
            Driver::where('id',$request->data_value)->update(['notes_data'=>json_encode($datas)]); 
            $data = ['status'=>"success"];
            return response()->json($data);
        }
        else{
            Driver::where('id',$request->data_value)->update(['notes_data'=>json_encode($notes_data1)]);
            $data = ['status'=>"success"];
            return response()->json($data);
        }
    }
    public function AssignEmployees(Request $request)
    { 
        $notes = RegisteredDriver::where('id',$request->data_value)->first();  
        RegisteredDriver::where('id',$request->data_value)->update(['assign_to'=>$request->data_id]);
        $data = ['status'=>"success"];
        return response()->json($data);

    }
    public function AddDecomposition(Request $request)
    { 
        $notes = RegisteredDriver::where('id',$request->data_value)->first();  
        RegisteredDriver::where('id',$request->data_value)->update(['decomposition'=>$request->value]);
        $data = ['status'=>"success"];
        return response()->json($data); 
    }
    public function AddDecomposition1(Request $request)
    { 
        $notes = Driver::where('id',$request->data_value)->first();  
        Driver::where('id',$request->data_value)->update(['comments_status'=>$request->value]);
        $data = ['status'=>"success"];   
        return response()->json($data); 
    }
    /**
    * Fetch approved drivers
    */
    public function getRegistered(QueryFilterContract $queryFilter)
    { 
           if (auth()->user()->hasRole(Role::SUPER_ADMIN)) {
            $role = "admin";
            $query = RegisteredDriver::where('status',1); 
            } else if (auth()->user()->hasRole(Role::EMPLOYEE)) {
                $role = "employee";
                $query = RegisteredDriver::where('assign_to',auth()->user()->id)->where('status',1); 
            }else{
                $role = "employee";
            } 
           
           $results = $queryFilter->builder($query)->customFilter(new DriverFilter)->paginate();
           $employee_details = User::companyKey()->belongsToRole([RoleSlug::EMPLOYEE])->get();

            return view('admin.drivers._registered', compact('results','employee_details','role'))->render();

    }
    public function registeredDelete(RegisteredDriver $driver)
    {
        if(env('APP_FOR')=='demo'){

        return $message = 'you cannot delete the driver. this is demo version';


        }
        $driver->delete();

        $message = trans('succes_messages.driver_deleted_succesfully');

        return redirect('drivers/registered')->with('success', $message);
    }

    public function deletedDrivers()
    {
        $page = trans('pages_names.drivers');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = 'deleted_drivers';
        return view('admin.drivers.deleted', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));
    }

    public function getDeletedDrivers(QueryFilterContract $queryFilter)
    {
             $query = $this->driver->where('is_deleted', true)->where('owner_id', null)->orderBy('created_at', 'desc');

            $results = $queryFilter->builder($query)->customFilter(new DriverFilter)->paginate();

            return view('admin.drivers._deleted', compact('results'))->render();

    }
    public function restrictedDrivers()
    {
        $page = trans('pages_names.drivers');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = 'restricted_drivers';
        return view('admin.drivers.restricted', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));
    }

    public function getRestrictedDrivers(QueryFilterContract $queryFilter)
    {
         $query = $this->driver->where('is_deleted', false)->where('owner_id', null)->where('approve', false)->whereNotNull('reason')->orderBy('created_at', 'desc');

        $results = $queryFilter->builder($query)->customFilter(new DriverFilter)->paginate();

        return view('admin.drivers._restricted', compact('results'))->render();
    }
    /**
    * Create Driver View
    *
    */
    public function create(Request $request)
    {
        $page = trans('pages_names.add_driver'); 
        $services = ServiceLocation::companyKey()->whereActive(true)->get();
        $types = VehicleType::whereActive(true)->get();
        $countries = Country::all();
        $carmake = CarMake::active()->get(); 
        $companies = Company::active()->get(); 
        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = ''; 
        $driver_data = RegisteredDriver::find($request->value);
        return view('admin.drivers.create', compact('services', 'types', 'page', 'countries', 'main_menu', 'sub_menu', 'companies', 'carmake','sub_menu_1','driver_data'));
    }

    /**
     * Create Driver.
     *
     * @param \App\Http\Requests\Admin\Driver\CreateDriverRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
  public function store(CreateDriverRequest $request)
    {


        $created_params = $request->only(['service_location_id', 'name','mobile','email','address','gender','vehicle_type','car_make','car_model','car_color','car_number','aadhar_number','driving_license_number','vehicle_insurence_number','rc_number','vehicle_year']);

         $validate_exists_mobile = $this->user->belongsTorole(Role::DRIVER)->where('mobile', $request->mobile)->exists();
        if ($validate_exists_mobile) {
            return redirect()->back()->withErrors(['mobile'=>'Provided mobile hs already been taken'])->withInput();
        }
        $created_params['vehicle_type'] = $request->input('type');
        // $created_params['postal_code'] = $request->postal_code;
        $created_params['uuid'] = driver_uuid();
        $created_params['owner_id'] = null;
        $created_params['created_by'] = auth()->user()->id;


        $service_location = ServiceLocation::find($request->service_location_id);

        $country_id = $service_location->country;

/*UserName*/
$lastUsername = User::orderBy('username', 'DESC')->pluck('username')->first();
    if (!$lastUsername) {
        $username = '1001';
    } else {
        $lastNumber = intval(substr($lastUsername, 4));
        $username = $lastUsername + 1;
    }

/*UserName*/

        $new_refferal_code = Str::lower(Str::random(6));


        $user = $this->user->create(['name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile'),
            'mobile_confirmed'=>true,
            'password' => bcrypt($username),
            'company_key'=>auth()->user()->company_key,
            'refferal_code'=> $new_refferal_code,
            'country'=>$country_id,
            'username'=>$username,
        ]);


        if ($uploadedFile = $this->getValidatedUpload('profile_pic', $request)) {
            $created_params['profile_pic'] = $this->imageUploader->file($uploadedFile)
                ->saveDriverProfilePicture();
        }

        $user->attachRole(RoleSlug::DRIVER);


        $created_params['active'] = false;
        $created_params['approve'] = 2;

        $driver = $user->driver()->create($created_params);
        $driver_data = $driver;
        
        $expired_at  = Carbon::yesterday('Asia/Kolkata')->toDateString();

            
        DriverSubscription::create(['driver_id'=>$driver->id, 'active'=>0, 'paid_amount'=>0, 'expired_at'=>$expired_at]);

        $driver_detail_data = $request->only(['is_company_driver','company']);

        $driver_detail = $driver->driverDetail()->create($driver_detail_data);

        // Create Empty Wallet to the driver
        $driver_wallet = $driver->driverWallet()->create(['amount_added'=>0]);

        $message = trans('succes_messages.driver_added_succesfully');

        cache()->tags('drivers_list')->flush();
        // dd($request);
        $registered_driver = RegisteredDriver::where('mobile', $request->input('mobile'))->exists();

        if($registered_driver==true) 
        {
            $registered_driver = RegisteredDriver::where('mobile', $request->input('mobile'))->first();
            Driver::whereId($request->id)->update([
                'assign_to' => $registered_driver->assign_to,
                'decomposition' => $registered_driver->decomposition,
                'notes' => $registered_driver->notes
            ]);

            $refferal_code = $registered_driver->refferal_code;
            // Validate Referral code
            if($refferal_code!=null)
            {
             $reffered_user_exists = User::belongsTorole(Role::USER)->where('refferal_code', $refferal_code)->exists();

            $reffered_driver_exists = User::belongsTorole(Role::DRIVER)->where('refferal_code', $refferal_code)->exists();

            if($reffered_driver_exists)
            {
                $reffered_driver = User::belongsTorole(Role::DRIVER)->where('refferal_code', $refferal_code)->first();
            // dd($reffered_driver)/;
                $user->update(['referred_by'=>$reffered_driver->id]);
            // Add referral commission to the referred user
            //driver walet
            $reffered_driver = $reffered_driver->driver;

            $driver_wallet = $reffered_driver->driverWallet;
            $referral_commision = get_settings('referral_commision_for_driver')?:0;

            $driver_wallet->amount_added += $referral_commision;
            $driver_wallet->amount_balance += $referral_commision;
            $driver_wallet->save();

            // Add the history
            $reffered_driver->driverWalletHistory()->create([
            'amount'=>$referral_commision,
            'transaction_id'=>str_random(6),
            'remarks'=>WalletRemarks::REFERRAL_COMMISION,
            'refferal_code'=>$reffered_driver->refferal_code,
            'is_credit'=>true]);

            // Notify user
            $title = trans('push_notifications.referral_earnings_notify_title');
            $body = trans('push_notifications.referral_earnings_notify_body');

            dispatch(new SendPushNotification($reffered_driver->user,$title,$body));

            }
            if($reffered_user_exists)
            {
             $reffered_user = User::belongsTorole(Role::USER)->where('refferal_code', $refferal_code)->first();
           // dd($reffered_user);
          
              $user->update(['referred_by'=>$reffered_user->id]);
//referal coupen       
            $userReferralCount = Promo::where('user_id', $reffered_user->id)->count();      
            $referenceCode = 'DDREF' . str_pad($userReferralCount + 1, 3, '0', STR_PAD_LEFT);

            $referral_commision = get_settings('referral_commision_for_user')?:0;
            //refferal amount convert to coupen code
            $created_params['code']=$referenceCode;
            $created_params['minimum_trip_amount']=$referral_commision;
            $created_params['maximum_discount_amount']=$referral_commision;
            $created_params['discount_percent']=0;
            $created_params['active']=1;
            $created_params['total_uses']=1;
            $created_params['uses_per_user']=1;
            $created_params['from'] = Carbon::now()->startOfDay()->toDateTimeString();
            $created_params['to'] = Carbon::now()->addYear()->endOfDay()->toDateTimeString();
            $created_params['service_location_id'] = null;
            $created_params['user_id'] = $reffered_user->id;
             
            $promo = Promo::create($created_params);
            Log::info($promo);
  

        // Notify user
        $title = trans('push_notifications.referral_promo_notify_title',[],$reffered_user->lang);
        $body = trans('push_notifications.referral_promo_notify_body',[],$reffered_user->lang);

        dispatch(new SendPushNotification($reffered_user,$title,$body));

         }


// dd($reffered_user);
            }
            
            RegisteredDriver::where('mobile', $request->input('mobile'))->update(['status'=>0]);
            // RegisteredDriver::where('mobile', $request->input('mobile'))->delete();
        }

        // dd($driver);
        // // Store records to firebase
        $this->database->getReference('drivers/'.'driver_'.$driver_data->id)->set(['id'=>$driver_data->id,'driver_id'=>$driver_data->user->username,'vehicle_type'=>$request->input('vehicle_type'),'active'=>1,'is_active'=>0,'distance'=>0,'rating'=>0,'today_request_count'=>0,'updated_at'=> Database::SERVER_TIMESTAMP]);

        // return redirect('drivers')->with('success', $message);
        return redirect('drivers/registered')->with('success', $message);
    }

    public function getById(Driver $driver)
    {
        $page = trans('pages_names.edit_driver');

        $services = ServiceLocation::whereActive(true)->get();
        $types = VehicleType::whereActive(true)->get();
        $countries = Country::all();
        $companies = Company::active()->get();
        $item = $driver;
        $carmake = CarMake::active()->get();
        $carmodel = CarModel::active()->whereMakeId($item->car_make)->get();
        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = '';

        return view('admin.drivers.update', compact('item', 'services', 'types', 'page', 'countries', 'main_menu', 'sub_menu', 'companies', 'carmake', 'carmodel','sub_menu_1'));
    }


      public function update(Driver $driver, UpdateDriverRequest $request)
    {
        $updatedParams = $request->only(['service_location_id', 'name','mobile','email','gender','vehicle_type','car_make','car_model','car_color','car_number','aadhar_number','driving_license_number','vehicle_insurence_number','rc_number','vehicle_year']);

        $updated_params['updated_by'] = auth()->user()->id;

        $user = $driver->user;


        $validate_exists_mobile = $this->user->belongsTorole(Role::DRIVER)->where('mobile', $request->mobile)->where('id', '!=', $user->id)->exists();

        if ($validate_exists_mobile) {
            return redirect()->back()->withErrors(['mobile'=>'Provided mobile hs already been taken'])->withInput();
        }


        $user_param = $request->only(['profile']);

        $user_param['profile']=null;
        
        if ($uploadedFile = $this->getValidatedUpload('profile_picture', $request)) {
            $user_param['profile'] = $this->imageUploader->file($uploadedFile)
                ->saveProfilePicture();
        }
        
        $driver->update(['name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile'),
            'car_make'=>$request->input('car_make'),
            'car_model'=>$request->input('car_model'),
            'car_color'=>$request->input('car_color'),
            'car_number'=>$request->input('car_number'),
            'vehicle_year'=>$request->input('vehicle_year'),
            'vehicle_type'=>$request->input('type'),
            'aadhar_number'=>$request->input('aadhar_number'),
            'driving_license_number'=>$request->input('driving_license_number'),
            'vehicle_insurence_number'=>$request->input('vehicle_insurence_number'),
            'rc_number'=>$request->input('rc_number'),
            'service_location_id'=>$request->service_location_id

        ]);

        $driver->user->update(['name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile'),
            'profile_picture'=>$user_param['profile']
        ]);

// dd($driver);
        $message = trans('succes_messages.driver_added_succesfully');
        cache()->tags('drivers_list')->flush();
        return redirect('drivers/registered')->with('success', $message);
        // return redirect('drivers')->with('success', $message);
    }

    public function toggleStatus(Driver $driver)
    {
        $user_id = auth()->user()->id;
        $status = $driver->active == 1 ? 0 : 1;
        $driver->update([
            'active' => $status,
            'updated_by' => $user_id,
        ]);

        $message = trans('succes_messages.driver_status_changed_succesfully');
        return redirect('drivers')->with('success', $message);
    }
    public function toggleApprove(Driver $driver, $approval_status,Request $request)
    {
        $user_id = auth()->user()->id;

        $status = $approval_status;
// dd($status);
        if($status==1)
        { 
            $driver->update([
                'approve' => $status,
                'updated_by' => $user_id,
                'is_deleted'=>false,
                'reason'=>null,
            ]);
            RegisteredDriver::where('mobile',$driver->mobile)->update(['status'=>0]); 

        }else{
            // dd($approval_status);
            // dd($request->all());
            if(isset($request->type))
            {
                $driver->update([
                    'approve' => 2,
                    'updated_by' => $user_id,
                    'is_deleted'=>false,
                    
                ]);
                RegisteredDriver::where('mobile',$driver->mobile)->update(['status'=>1]); 
            }
            else{ 
                $driver->update([
                    'approve' => $status,
                    'updated_by' => $user_id,
                    'is_deleted'=>false,
                    
                ]);
            }
          
            
        }

        
       $this->database->getReference('drivers/driver_'.$driver->id)->update(['approve'=>(int)$status,'updated_at'=> Database::SERVER_TIMESTAMP]);

        $message = trans('succes_messages.driver_approve_status_changed_succesfully');
        $user = User::find($driver->user_id);
        if ($status) {
            $title = trans('push_notifications.driver_approved',[],$user->lang);
            $body = trans('push_notifications.driver_approved_body',[],$user->lang);
            $push_data = ['notification_enum'=>PushEnums::DRIVER_ACCOUNT_APPROVED];
            $socket_success_message = PushEnums::DRIVER_ACCOUNT_APPROVED;
        } else {
            $title = trans('push_notifications.driver_declined_title',[],$user->lang);
            $body = trans('push_notifications.driver_declined_body',[],$user->lang);
            $push_data = ['notification_enum'=>PushEnums::DRIVER_ACCOUNT_DECLINED];
            $socket_success_message = PushEnums::DRIVER_ACCOUNT_DECLINED;
        } 

        $driver_details = $user->driver;
        $driver_result = fractal($driver_details, new DriverTransformer);
        $formated_driver = $this->formatResponseData($driver_result);
        // dd($formated_driver);
        $socket_params = $formated_driver['data'];
        $socket_data = new \stdClass();
        $socket_data->success = true;
        $socket_data->success_message  = $socket_success_message;
        $socket_data->data  = $socket_params;


        dispatch(new SendPushNotification($user,$title,$body));

        return redirect('drivers')->with('success', $message);
        // return redirect('drivers/registered')->with('success', $message);
    }
    public function toggleAvailable(Driver $driver)
    {
        $status = $driver->available == 1 ? 0 : 1;
        $driver->update([
            'available' => $status
        ]);

        $message = trans('succes_messages.driver_available_status_changed_succesfully');
        return redirect('drivers')->with('success', $message);
    }
    public function SendForapproval(Driver $driver)
    {
        RegisteredDriver::where('mobile',$driver->mobile)->update(['status'=>0]); 
        Driver::where('id',$driver->id)->update(['approve'=>2,'reason'=>NULL]); 
        return redirect('drivers')->with('success', "updated SUccessfully");
    }

    public function delete(Driver $driver)
    {
        if(env('APP_FOR')=='demo'){

        return $message = 'you cannot delete the driver. this is demo version';


        }

        if ($driver->is_deleted==true)
        {
    //delete from table as well as firebase            
        $driver->user()->delete();
        $this->database->getReference('drivers/driver_'.$driver->id)->remove();        
        }else{
    //update driver trying to delete         
        $driver->update(['is_deleted'=>true, 'approve'=>false]);
            
        }


        $message = trans('succes_messages.driver_deleted_succesfully');

        return redirect('drivers')->with('success', $message);
    }

    public function getCarModel()
    {
        $carModel = request()->car_make;

        // return CarModel::where('make_id',$carModel)->where('active','1')->get();
        return CarModel::active()->whereMakeId($carModel)->get();
    }

    public function UpdateDriverDeclineReason(Request $request)
    {
        $driver = Driver::whereId($request->id)->update([
            'reason' => $request->reason
        ]);
        $drivers = Driver::whereId($request->id)->first();
        $notes = RegisteredDriver::where('mobile',$drivers->mobile)->first(); 
        $user = User::find(auth()->user()->id); 
        $notes_data1[0]['name'] = $user->name;
        $notes_data1[0]['decline'] = true;
        $notes_data1[0]['comments'] = $request->reason; 
        $date = Carbon::now();
        $notes_data1[0]['date'] = $date->format('jS F h:i A'); 
        // dd($notes);
        if($notes)
        {
            if($notes->notes != NULL)
            { 
                $notes_data = json_decode($notes->notes, true); // Decode JSON to associative array 
                // Merge arrays
                $datas = array_merge($notes_data, $notes_data1);
                if($drivers->approve != 1)
                {
                    RegisteredDriver::where('id',$notes->id)->update(['notes'=>json_encode($datas),'status'=>1]); 
                } 
            } 
            else{
                RegisteredDriver::where('id',$notes->id)->update(['notes'=>json_encode($notes_data1)]);
            }
        }
       

        return 'success';
    }

   public function DriverTripRequestIndex(Driver $driver)
    {

        $completedTrips = RequestRequest::where('driver_id',$driver->id)->companyKey()->whereIsCompleted(true)->count();
        $cancelledTrips = RequestRequest::where('driver_id',$driver->id)->companyKey()->whereIsCancelled(true)->count();

        $card = [];
        $card['completed_trip'] = ['name' => 'trips_completed', 'display_name' => 'Completed Rides', 'count' => $completedTrips, 'icon' => 'fa fa-flag-checkered text-green'];
        $card['cancelled_trip'] = ['name' => 'trips_cancelled', 'display_name' => 'Cancelled Rides', 'count' => $cancelledTrips, 'icon' => 'fa fa-ban text-red'];

        $main_menu = 'drivers_and_users';
        $sub_menu = 'driver_details';
        $sub_menu_1 = '';
        $items = $driver->id;

        return view('admin.drivers.driver-request-list', compact('card','main_menu','sub_menu','items','sub_menu_1'));
    }
     public function DriverTripRequest(QueryFilterContract $queryFilter, Driver $driver)
        {
            $items = $driver->id;

             $query = RequestRequest::where('driver_id',$driver->id);
            $results = $queryFilter->builder($query)->customFilter(new RequestFilter)->defaultSort('-created_at')->paginate();

            return view('admin.drivers.driver-request-list-view', compact('results','items'));
        }

    public function DriverPaymentHistory(Driver $driver)
    {
        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = '';
        $item = $driver;
        // dd($item);

        $amount = DriverWallet::where('user_id',$driver->id)->first();
        
        if ($amount == null) {

         $card = [];
         $card['total_amount'] = ['name' => 'total_amount', 'display_name' => 'Total Amount ', 'count' => "0", 'icon' => 'fa fa-flag-checkered text-green'];
        $card['amount_spent'] = ['name' => 'amount_spent', 'display_name' => 'Spend Amount ', 'count' => "0", 'icon' => 'fa fa-ban text-red'];
        $card['balance_amount'] = ['name' => 'balance_amount', 'display_name' => 'Balance Amount', 'count' => "0", 'icon' => 'fa fa-ban text-red'];

         $history = UserWalletHistory::where('user_id',$user->id)->orderBy('created_at','desc')->paginate(10);
        }
        else{
         $card = [];
        $card['total_amount'] = ['name' => 'total_amount', 'display_name' => 'Total Amount ', 'count' => $amount->amount_added, 'icon' => 'fa fa-flag-checkered text-green'];
        $card['amount_spent'] = ['name' => 'amount_spent', 'display_name' => 'Spend Amount ', 'count' => $amount->amount_spent, 'icon' => 'fa fa-ban text-red'];
        $card['balance_amount'] = ['name' => 'balance_amount', 'display_name' => 'Balance Amount', 'count' => $amount->amount_balance, 'icon' => 'fa fa-ban text-red'];


         $history = DriverWalletHistory::where('user_id',$driver->id)->orderBy('created_at','desc')->paginate(10);

          }

        return view('admin.drivers.driver-payment-wallet', compact('card','main_menu','sub_menu','item','history','sub_menu_1'));
    }

    public function StoreDriverPaymentHistory(AddDriverMoneyToWalletRequest $request,Driver $driver)
    {

        $currency = get_settings(Settings::CURRENCY);

        // $converted_amount_array =  convert_currency_to_usd($user_currency_code, $request->input('amount'));

        // $converted_amount = $converted_amount_array['converted_amount'];
        // $converted_type = $converted_amount_array['converted_type'];
        // $conversion = $converted_type.':'.$request->amount.'-'.$converted_amount;
        $transaction_id = Str::random(6);


            $wallet_model = new DriverWallet();
            $wallet_add_history_model = new DriverWalletHistory();
            $user_id = $driver->id;


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

            $user = $driver->user;
            $title = trans('push_notifications.wallet_credited_title',[],$user->lang);
            $body = trans('push_notifications.wallet_credited_body',[],$user->lang);
            $push_data = ['notification_enum'=>PushEnums::WALLET_CREDITED];

            dispatch(new SendPushNotification($user,$title,$body));

         $message = "money_added_successfully";
        return redirect()->back()->with('success', $message);


    }

    public function DriverPaymentdelete(DriverWalletHistory $driver)
    {
        // dd($driver);

        if($driver->remarks == "Money Deposited By Admin")
        {
        $driver_id = $driver->user_id;

        $amount = $driver->amount;

        $driver_wallet = DriverWallet::where('user_id', $driver_id)->first();

        $driver_wallet->amount_balance -= $amount;

        $driver_wallet->amount_added -= $amount;
       
        $driver_wallet->save();

        $driver->delete();
      
        $message = "deleted_successfully";
        }

        $message = "this_amount_not_credited_by_admin";


        return redirect()->back()->with('success', $message);
    }


    public function driverRatings()
    {
        $page = trans('pages_names.drivers');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = 'driver_ratings';
       
        return view('admin.drivers.driver-ratings', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));

    }

    public function fetchDriverRatings(QueryFilterContract $queryFilter){

        $query = Driver::query();

        $results = $queryFilter->builder($query)->customFilter(new DriverFilter)->paginate();


        return view('admin.drivers._driver-ratings', compact('results'))->render();

    }

    public function driverRatingView(Driver $driver)
    {
        $page = trans('pages_names.drivers');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'driver_ratings';
        $sub_menu_1 = '';
        $trips = RequestRating::where('driver_id',$driver->id)->whereNotNull('user_id')->whereUserRating(true)->paginate(10);
        $item = $driver;
        // dd($trips);
         return view('admin.drivers.driver-rating-view', compact('page', 'main_menu', 'sub_menu','item','trips','sub_menu_1'));
    }

    /**
     * Withdrawal Requests List
     *
     * */
    public function withdrawalRequestsList()
    {
        $page = trans('pages_names.withdrawal_requests');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = 'withdrawal_requests';

            if (access()->hasRole(RoleSlug::SUPER_ADMIN)) {
                $history = WalletWithdrawalRequest::whereHas('driverDetail.user',function($query){
                $query->companyKey();
                })->orderBy('created_at','desc')->paginate(20);

            }else{
                $admin_data =auth()->user()->admin;

               $history = WalletWithdrawalRequest::whereHas('driverDetail.user',function($query){
                $query->companyKey();
                })->whereHas('driverDetail',function($query)use($admin_data){
                $query;
                })->orderBy('created_at','desc')->paginate(20);
            }


        return view('admin.drivers.driver-wallet-withdrawal-requests-list', compact('page', 'main_menu', 'sub_menu','sub_menu_1','history'));
    }

    /**
     * Wallet withdrawal Requests Detail
     *
     *
     * */
    public function withdrawalRequestDetail(Driver $driver){

        $page = trans('pages_names.withdrawal_requests');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = '';

        $bankInfo = $driver->user->bankInfo;

        $history = WalletWithdrawalRequest::whereHas('driverDetail.user',function($query){
            $query->companyKey();
        })->where('driver_id',$driver->id)->orderBy('created_at','desc')->paginate(20);

        $bankInfo = $driver->user->bankInfo;

        $amount = DriverWallet::where('user_id',$driver->id)->first();

         $card = [];

        $card['balance_amount'] = ['name' => 'balance_amount', 'display_name' => 'Balance Amount', 'count' => $amount->amount_balance, 'icon' => 'fa fa-ban text-red'];

        return view('admin.drivers.DriverWalletWithdrawalRequestDetail', compact('page', 'main_menu', 'sub_menu','history','card', 'bankInfo','sub_menu_1'));

    }

    /**
     * Approve Withdrawal Request
     *
     *
     * */
    public function approveWithdrawalRequest(WalletWithdrawalRequest $wallet_withdrawal_request){

        $driver_wallet = DriverWallet::firstOrCreate([
            'user_id'=>$wallet_withdrawal_request->driver_id]);
        $driver_wallet->amount_spent += $wallet_withdrawal_request->requested_amount;
        $driver_wallet->amount_balance -= $wallet_withdrawal_request->requested_amount;
        $driver_wallet->save();

         $driver_wallet_history = $wallet_withdrawal_request->driverDetail->driverWalletHistory()->create([
                'amount'=>$wallet_withdrawal_request->requested_amount,
                'transaction_id'=>str_random(6),
                'remarks'=>WalletRemarks::WITHDRAWN_FROM_WALLET,
                'is_credit'=>false
            ]);

         $wallet_withdrawal_request->status = 1;
         $wallet_withdrawal_request->save();

        $message = "Withdrawal request approved successfully";


            $user = $wallet_withdrawal_request->driverDetail->user;
            $title = trans('push_notifications.approved_withdrawal_request_title',[],$user->lang);
            $body = trans('push_notifications.approved_withdrawal_request_body',[],$user->lang);
            $push_data = ['notification_enum'=>PushEnums::WALLET_CREDITED];

            dispatch(new SendPushNotification($user,$title,$body));


        return redirect()->back()->with('success', $message);

    }

    /**
     * Decline Withdrawal Request
     *
     *
     * */
    public function declineWithdrawalRequest(WalletWithdrawalRequest $wallet_withdrawal_request){

        $wallet_withdrawal_request->status = 2;
        $wallet_withdrawal_request->save();

        $message = "Withdrawal request declined successfully";

            $user = $wallet_withdrawal_request->driverDetail->user;
            $title = trans('push_notifications.approved_withdrawal_request_title',[],$user->lang);
            $body = trans('push_notifications.declined_withdrawal_request_body',[],$user->lang);
            $push_data = ['notification_enum'=>PushEnums::WALLET_CREDITED];

            dispatch(new SendPushNotification($user,$title,$body));

        return redirect()->back()->with('success', $message);
    }

        /**
     * Negative Balance Drivers
     *
     *
     * */

    public function NeagtiveBalanceDrivers()
    {
        $page = trans('pages_names.negative_balance_drivers');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = 'negative_balance_drivers';

        $services = ServiceLocation::whereActive(true)->companyKey()->get();
        $approved = Driver::where('approve', true)->where('owner_id', null)->get();
        // dd($approved);
        return view('admin.drivers.negative-balance-drivers', compact('page', 'main_menu', 'sub_menu','sub_menu_1','services', 'approved'));
    }
    public function NegativeBalanceFetch(QueryFilterContract $queryFilter)
    {
         $url = request()->fullUrl(); //get full url

         $threshould_value = get_settings(Settings::DRIVER_WALLET_MINIMUM_AMOUNT_TO_GET_ORDER);
         // dd($threshould_value);
        return cache()->tags('drivers_list')->remember($url, Carbon::parse('10 minutes'), function () use ($queryFilter,$threshould_value) {
            if (access()->hasRole(RoleSlug::SUPER_ADMIN)) {
                $query = Driver::orderBy('created_at', 'desc')->where('owner_id', null)->whereHas('driverWallet',function($query)use($threshould_value){
                    $query->where('amount_balance','<=',$threshould_value);
                });

                if (env('APP_FOR')=='demo') {
                    $query = Driver::where('owner_id', null)->whereHas('user', function ($query) {
                        $query->whereCompanyKey(auth()->user()->company_key);
                    })->whereHas('driverWallet',function($query)use($threshould_value){
                    $query->where('amount_balance','<=',$threshould_value);
                })->orderBy('created_at', 'desc');
                }
                    // dd($query->get());

            } else {
                $this->validateAdmin();
                $query = $this->driver->whereHas('driverWallet',function($query)use($threshould_value){
                    $query->where('amount_balance','<=',$threshould_value);
                })->orderBy('created_at', 'desc');

            }
            $results = $queryFilter->builder($query)->customFilter(new DriverFilter)->paginate();


            return view('admin.drivers._drivers-negative-balance', compact('results'))->render();
        });
    }

    public function importDriver(){

        $page = trans('pages_names.drivers');

        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = '';


        Excel::import(new DriversImport, request()->file('file'));

             $message = trans('succes_messages.driver_import_succesfully');

        return redirect('admin.drivers')->with('success', $message);
    }

     public function downloadFile()
    {
        $sampleFile = public_path()."/assets/sample_file/sample_file.csv";

        $headers = array(
         'Content-Type : application/csv',
        );


        return response()->download($sampleFile);
    }
    public function reportDownload(QueryFilterContract $queryFilter)
    {

         $filename = 'registered_drivers.xlsx';

       return Excel::download(new RegisteredDriverExport, $filename);
    }

public function getInvoice(Request $request)
{
    $driverId = $request->input('driverId');
    $phoneNumber = $request->input('phoneNumber');
    $enterAmount = $request->input('enterAmount');
    $totalAmount = $request->input('totalAmount');
    $driver_id = $request->input('driverNum');
    $from_date = $request->input('fromDateTime');
    $to_date = $request->input('toDateTime');
    $no_of_rides = $request->input('no_of_rides');

    $driver_exists = DriverInvoice::where('driver_id', $driverId)->where('is_paid', false)->first();

    if (!$driver_exists) 
    {
    $gstAmount = $request->input('gstAmount'); // Fix variable name
// dd($gstAmount);
    $driver = Driver::where('id', $driver_id)->first();

    // Get last request's request_number
    $invoice_number = DriverInvoice::orderBy('created_at', 'DESC')->pluck('invoice_number')->first();
    if ($invoice_number) {
        $invoice_number = explode('_', $invoice_number);
        $invoice_number = $invoice_number[1] ?: 000000;
    } else {
        $invoice_number = 000000;
    }
    // Generate request number
    // $invoice_number = ($invoice_number + 1);
    $invoice_number = 'TIN_'.sprintf("%06d", $invoice_number+1);


    DriverInvoice::create([
        'driver_id' => $driver_id,
        'amount' => $totalAmount,
        'is_paid' => false,
        'is_subscription_invoice' => false,
        'invoice_number' => $invoice_number,
        'invoice_amount' => $enterAmount,
        'from' => $from_date,
        'to' => $to_date,
        'no_of_rides'=>$no_of_rides,
        'gst' => $gstAmount // Correct variable name here
    ]);

    // Update database reference
    $this->database->getReference('drivers/driver_' . $driver->id)->update([
        'id' => $driver_id,
        'is_invoice' => true,
        'updated_at' => Database::SERVER_TIMESTAMP
    ]);

    $title = trans('push_notifications.invoice_by_dubu_dubu', [], $driver->user->lang);
    $body = trans('push_notifications.invoice_by_dubu_dubu_body', [], $driver->user->lang);

    dispatch(new SendPushNotification($driver->user, $title, $body));

    return response()->json(['success' => true]); // Return a proper response

    }else{

    return response()->json(['success' => false]); // Return a proper response
        
    }


}

   public function checkInvoiceExists(Request $request)
   {
        // dd($request);
    // Retrieve driver value from the request
    $driver = $request->driverId;

    $user = User::where('username', $driver)->first();



    // Perform your logic to check if driver value exists in the table
    $driverExists = DriverInvoice::where('driver_id', $user->driver->id)->where('is_paid', false)->exists();

    // Return response indicating whether driver exists
    return $driverExists;


   }



    public function listInvoice(Driver $driver)
    {
        // dd($driver->driverInvoice());

        $results = $driver->driverInvoice()->orderBy('created_at', 'desc')->paginate();
        // dd($results);

        $page = trans('pages_names.assign_types');

        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = '';

        return view('admin.drivers.invoice_list', compact('results', 'page', 'main_menu', 'sub_menu', 'driver','sub_menu_1'));

    }

    public function viewInvoice(DriverInvoice $driverInvoice)
    {
        // dd($driver->driverInvoice());

        $page = trans('pages_names.assign_types');

        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = '';

        return view('admin.drivers.invoice', compact('page', 'main_menu', 'sub_menu', 'driverInvoice','sub_menu_1'));

    }

    public function export()
    {
        

        $pdf = PDF::loadView('pdf.user')->setPaper('a4', 'landscape');
        return $pdf->download('user.pdf');

    }


    public function invoiceDelete(DriverInvoice $driver_invoice)
    {
        $driver_invoice->delete();

        $message = "Invoice Deleted successfully";

        return redirect()->back()->with('success', $message);     
    }
    public function welcomeCall(Request $request)
    {
        $driverId = $request->input('driver_id');
        $status = $request->input('status');

        $message = "Updated successfully";
        Driver::where('id', $driverId)->update(['is_welcome_call'=>$status]);
        return "success";    
    }
    public function freeTrail(Request $request)
    {
        $driverId = $request->input('driver_id');

        $status = $request->input('status');

        $driver_subscription = DriverSubscription::where('driver_id', $driverId)->where('active', true)->exists();

        if(!$driver_subscription)
        {
      
         $driver = Driver::where('id', $driverId)->first();

         $driver->update(['is_free_trial'=>$status]); 
        
         $this->database->getReference('drivers/driver_'.$driver->id)->update(['is_free_trial'=>$status,'updated_at'=> Database::SERVER_TIMESTAMP]);

        return "success";

        }else{

         $driver = Driver::where('id', $driverId)->first();

         $driver->update(['is_free_trial'=>0]); 
       
        $this->database->getReference('drivers/driver_'.$driver->id)->update(['is_free_trial'=>0,'updated_at'=> Database::SERVER_TIMESTAMP]);


        return "failure";

        }

    } 
    public function subscriptions(Driver $driver)
    {

        $results = $driver->subscriptions()->paginate();
        // dd($results);

        $page = trans('pages_names.assign_types');

        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = '';

        return view('admin.drivers.subscriptions', compact('results', 'page', 'main_menu', 'sub_menu', 'driver','sub_menu_1'));
    }  
    public function subscriptionInvoice(DriverSubscription $driverSubscription)
    {
        // dd($driverSubscription);

        $page = trans('pages_names.driver_subscription');

        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = '';

        return view('admin.drivers.subscription_invoice', compact('page', 'main_menu', 'sub_menu', 'driverSubscription','sub_menu_1'));

    }
    public function generatePDF(DriverSubscription $driverSubscription)
    {
        // Generate HTML content with the passed $driverSubscription data
        $html = view('admin.drivers.exports.subscription_invoice', compact('driverSubscription'))->render();

        // Create Dompdf instance
        $dompdf = new Dompdf();

        // Load HTML content into Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Get the generated PDF content
        $pdf = $dompdf->output();

        // Return the PDF as a response without forcing download
        return response($pdf)
            ->header('Content-Type', 'application/pdf');
    }
// generateInvoicePDF
    public function generateInvoicePDF(DriverInvoice $driverInvoice)
    {
        // Generate HTML content with the passed $driverSubscription data
        $html = view('admin.drivers.exports.invoice', compact('driverInvoice'))->render();

        // Create Dompdf instance
        $dompdf = new Dompdf();

        // Load HTML content into Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Get the generated PDF content
        $pdf = $dompdf->output();

        // Return the PDF as a response without forcing download
        return response($pdf)
            ->header('Content-Type', 'application/pdf');
    }

    // generate Driver Details PDF
    public function generateDriverDetailsPDF(Driver $driver)
    {
        // dd($driver->profile_picture);

        $profile_picture = $driver->profile_picture;
        // Generate HTML content with the passed $driverSubscription data
        $html = view('admin.drivers.exports.driver-details', compact('driver','profile_picture'))->render();

        // Create Dompdf instance
        $dompdf = new Dompdf();

        // Load HTML content into Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Get the generated PDF content
        $pdf = $dompdf->output();

        // Return the PDF as a response without forcing download
        return response($pdf)
            ->header('Content-Type', 'application/pdf');
    }
    public function DriverCancelRequestIndex(Driver $driver)
    {

        $results = $driver->driverCancellationFee()->paginate();
        // dd($results);

        $page = trans('pages_names.assign_types');

        $main_menu = 'drivers_and_users';
        $sub_menu = 'drivers';
        $sub_menu_1 = '';

        return view('admin.drivers.cancellation', compact('results', 'page', 'main_menu', 'sub_menu', 'driver','sub_menu_1'));

    }
}


