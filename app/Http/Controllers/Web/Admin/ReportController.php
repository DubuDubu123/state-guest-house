<?php

namespace App\Http\Controllers\Web\Admin;

use App\Models\User;
use App\Exports\UsersExport;
use App\Models\Admin\Driver;
use Illuminate\Http\Request;
use App\Exports\DriverExport;
use App\Exports\TravelExport;
use App\Exports\BookingReport;
use App\Base\Constants\Auth\Role;
use App\Models\Admin\VehicleType;
use Illuminate\Support\Facades\DB;
use App\Exports\DriverDutiesExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Base\Filters\Admin\UserFilter;
use App\Base\Filters\Admin\DriverFilter;
use App\Base\Filters\Admin\RequestFilter;
use App\Base\Constants\Masters\DateOptions;
use App\Base\Filters\Master\CommonMasterFilter;
use App\Models\Request\Request as RequestRequest;
use App\Base\Libraries\QueryFilter\QueryFilterContract;
use Carbon\Carbon;
use App\Models\Admin\Owner;
use App\Exports\OwnerExport;
use App\Base\Filters\Admin\OwnerFilter;
use App\Models\Request\DriverRejectedRequest;
use App\Exports\DriverRejectedExport;
use App\Exports\DriverSubscriptionExport;
use App\Base\Filters\Admin\RejectedRequestFilter;
use App\Models\Payment\DriverSubscription;
use App\Models\Admin\DriverInvoice;
use App\Models\Admin\UserCancellationfee;
use App\Exports\DriverInvoiceExport;
use App\Exports\BlockedUsersExport;
use App\Base\Constants\Setting\Settings;
use App\Exports\DriverSubscriptionInvoiceExport;
use App\Models\RoomBooking; 
use App\Models\PartyBooking;
use App\Models\SportsBooking;
use PDF;

class ReportController extends Controller
{
    protected $format = ['xlsx','xls','csv','pdf'];

    public function userReport()
    {
        $page = trans('pages_names.user_report');

        $main_menu = 'report';
        $sub_menu = 'user';
        $sub_menu_1 = 'user';
        
        $formats = $this->format;

        return view('admin.reports.user_report', compact('page', 'main_menu', 'sub_menu', 'formats','sub_menu_1'));
    }

    public function driverReport()
    {
        $page = trans('pages_names.driver_report');
        $main_menu = 'others';
        $sub_menu = 'reports';
        $sub_menu_1 = 'driver_report';

        $formats = $this->format;
        $vehicletype = VehicleType::active()->get();

        return view('admin.reports.driver_report', compact('page', 'main_menu', 'sub_menu', 'formats', 'vehicletype','sub_menu_1'));
    }
    public function ownerReport()
    {
        $page = trans('pages_names.owner_report');
        $main_menu = 'others';
        $sub_menu = 'reports';
        $sub_menu_1 = 'reports';

        $formats = $this->format;
        $vehicletype = VehicleType::active()->get();

        return view('admin.reports.owner_report', compact('page', 'main_menu', 'sub_menu', 'formats', 'vehicletype','sub_menu_1'));
    }

    public function driverDutiesReport()
    {
        $page = trans('pages_names.driver_duties_report');
        $main_menu = 'others';
        $sub_menu = 'reports';
        $sub_menu_1 = 'reports';

        $formats = $this->format;
        $drivers = Driver::get();

        return view('admin.reports.driver_duties', compact('page', 'main_menu', 'sub_menu', 'formats', 'drivers','sub_menu_1'));
    }

    public function roomReport()
    {
        $page = "Room Booking Report";
        $main_menu = 'report';
        $sub_menu = 'room-booking';
        $sub_menu_1 = 'finance_report';

        $formats = $this->format;
        $user = User::belongstoRole('user')->where('is_approve',1)->get();

        return view('admin.reports.room_report', compact('page', 'main_menu', 'sub_menu', 'formats', 'user','sub_menu_1'));
    }
    public function partyReport()
    {
        $page = "Party Booking Report";
        $main_menu = 'report';
        $sub_menu = 'party-booking';
        $sub_menu_1 = 'finance_report';

        $formats = $this->format;
        $user = User::belongstoRole('user')->where('is_approve',1)->get();

        return view('admin.reports.party_report', compact('page', 'main_menu', 'sub_menu', 'formats', 'user','sub_menu_1'));
    }
    public function sportsReport()
    {
        $page = "Sports Booking Report";
        $main_menu = 'report';
        $sub_menu = 'sports-booking';
        $sub_menu_1 = 'finance_report';

        $formats = $this->format;
        $user = User::belongstoRole('user')->where('is_approve',1)->get();

        return view('admin.reports.sports_report', compact('page', 'main_menu', 'sub_menu', 'formats', 'user','sub_menu_1'));
    }

    public function downloadReport(Request $request, QueryFilterContract $queryFilter)
    {
        // dd($request->all());
        $method = "download".$request->model."Report";   
        $filename = $this->$method($request, $queryFilter); 
        $file = url('storage/'.$filename); 
        return $file;
    }

    public function downloadUserReport(Request $request, QueryFilterContract $queryFilter)
    {
        $format = $request->format;

        $query = User::companyKey()->belongsToRole(Role::USER);

        $data = $queryFilter->builder($query)->customFilter(new UserFilter)->defaultSort('-date')->get();
        
        $filename = "$request->model Report-".date('ymdis').'.'.$format;
        // dd($filename);
        Excel::store(new UsersExport($data), $filename, 'local');
        // dd("assdasasd");
        return $filename;
    }

    public function downloadDriverReport(Request $request, QueryFilterContract $queryFilter)
    {
        $format = $request->format;
        $vehicleTypes = $request->input('vehicle_type', []); // Retrieve selected vehicle types as an array

        $query = Driver::query();
        if (env('APP_FOR') == 'demo') {
            $query = Driver::whereHas('user', function ($query) {
                $query->where('company_key', auth()->user()->company_key);
            });
        }

        if (!empty($vehicleTypes)) {
            $query->whereHas('vehicleType', function ($q) use ($vehicleTypes) {
                $q->whereIn('id', $vehicleTypes);
            });
        }

        // $data = $query->get();

        $data = $queryFilter->builder($query)->customFilter(new DriverFilter)->defaultSort('-date')->get();
        

        $filename = "$request->model Report-" . date('ymdis') . '.' . $format;

        Excel::store(new DriverExport($data), $filename, 'local');

        return $filename;
    }


    /**
    * Download Driver Duties Report
    *
    */
    public function downloadDriverDutiesReport(Request $request)
    {
        $format = $request->format;
        $date_option = $request->date_option;
        $current_date = Carbon::now();
        $driver = $request->driver;

        if ($date_option == DateOptions::TODAY) {
            $date_array = [$current_date->format("Y-m-d"),$current_date->format("Y-m-d"),$driver];
        } elseif ($date_option == DateOptions::YESTERDAY) {
            $yesterday_date = Carbon::yesterday()->format('Y-m-d');
            $date_array = [$yesterday_date,$yesterday_date,$driver];
        } elseif ($date_option == DateOptions::CURRENT_WEEK) {
            $date_array = [$current_date->startOfWeek()->toDateString(),$current_date->endOfWeek()->toDateString(),$driver];
        } elseif ($date_option == DateOptions::LAST_WEEK) {
            $date_array = [$current_date->subWeek()->toDateString(), $current_date->startOfWeek()->toDateString(),$driver];
        } elseif ($date_option == DateOptions::CURRENT_MONTH) {
            $date_array = [$current_date->startOfMonth()->toDateString(), $current_date->endOfMonth()->toDateString(),$driver];
        } elseif ($date_option == DateOptions::PREVIOUS_MONTH) {
            $date_array = [$current_date->startOfMonth()->toDateString(), $current_date->endOfMonth()->toDateString(),$driver];
        } elseif ($date_option == DateOptions::CURRENT_YEAR) {
            $date_array = [$current_date->startOfYear()->toDateString(), $current_date->endOfYear()->toDateString(),$driver];
        } else {
            $date_array = [];
        }

        // $date_array =['2020-11-11','2020-11-20',6];

        $data = DB::select('CALL get_driver_duration_report(?,?,?)', $date_array);
        if (count($data)==1) {
            $data = (object) array();
        }
        $filename = "$request->model Report-".date('ymdis').'.'.$format;

        Excel::store(new DriverDutiesExport($data), $filename, 'local');

        return $filename;

    }

    public function downloadTravelReport(Request $request, QueryFilterContract $queryFilter)
    {
        $format = $request->format;

        $query = RequestRequest::companyKey();

        $data = $queryFilter->builder($query)->customFilter(new RequestFilter)->defaultSort('created_at')->get();

        $filename = "$request->model Report-".date('ymdis').'.'.$format;

        Excel::store(new TravelExport($data), $filename, 'local');

        return $filename;
    }
    public function downloadOwnerReport(Request $request, QueryFilterContract $queryFilter)
    {
     
     $format = $request->format;

        $query = Owner::query();
        if (env('APP_FOR')=='demo') {
            $query = Owner::whereHas('owner_id', function ($query) {
                $query->where('active', $request->status);
            });
        }

        $data = $queryFilter->builder($query)->customFilter(new OwnerFilter)->defaultSort('-date')->get();

        $filename = "$request->model Report-".date('ymdis').'.'.$format;

        Excel::store(new OwnerExport($data), $filename, 'local');

        return $filename;
    }
    public function driverRejectedReport()
    {
        $page = trans('pages_names.rejected_report');
        $main_menu = 'others';
        $sub_menu = 'reports';
        $sub_menu_1 = 'rejected_report';
        $formats = $this->format;
        $drivers = Driver::get();

        return view('admin.reports.rejected_report', compact('page', 'main_menu', 'sub_menu','sub_menu_1', 'formats', 'drivers'));
    }
    public function subscriptionReport()
    {
        $page = trans('pages_names.subscription_status_report');
        $main_menu = 'others';
        $sub_menu = 'reports';
        $sub_menu_1 = 'subscription_report';
        $formats = $this->format;

        return view('admin.reports.subscription_report', compact('page', 'main_menu', 'sub_menu','sub_menu_1', 'formats'));
    }    
    public function subscriptionStatusReport()
    {
        $page = trans('pages_names.subscription_report');
        $main_menu = 'others';
        $sub_menu = 'reports';
        $sub_menu_1 = 'subscription_status_report';
        $formats = $this->format;

        return view('admin.reports.subscription_status_report', compact('page', 'main_menu', 'sub_menu','sub_menu_1', 'formats'));
    }        
    public function invoiceReport()
    {
        $page = trans('pages_names.invoice_report');
        $main_menu = 'others';
        $sub_menu = 'reports';
        $sub_menu_1 = 'invoice_report';
        $formats = $this->format;

        return view('admin.reports.invoice_report', compact('page', 'main_menu', 'sub_menu','sub_menu_1', 'formats'));
    }    
    public function driverWiseInvoiceReport()
    {
        $page = trans('pages_names.driver_wise_invoice_report');
        $main_menu = 'others';
        $sub_menu = 'reports';
        $sub_menu_1 = 'driver_wise_invoice_report';
        $formats = $this->format;
        $drivers = Driver::get();

        return view('admin.reports.driver_wise_invoice_report', compact('page', 'main_menu', 'sub_menu','sub_menu_1', 'formats', 'drivers'));
    }   
    public function accountBlockedReport()
    {
        $page = trans('pages_names.account_blocked_report');
        $main_menu = 'others';
        $sub_menu = 'reports';
        $sub_menu_1 = 'account_blocked_report';
        $formats = $this->format;

        return view('admin.reports.account_blocked_report', compact('page', 'main_menu', 'sub_menu','sub_menu_1', 'formats'));
    }         
    public function downloadDriverRejectedReport(Request $request, QueryFilterContract $queryFilter)
    {
        $format = $request->format;
        $date_option = $request->date_option;
        $current_date = Carbon::now();

        $data = DriverRejectedRequest::where('driver_id', $request->driver_id);

        if ($date_option == 'today') {
            $data->whereDate('created_at',  $current_date->format("Y-m-d"));
        } elseif ($date_option == 'week') {
            $data->whereBetween('created_at', [
                $current_date->startOfWeek()->toDateString(),
                $current_date->endOfWeek()->toDateString()
            ]);
        } elseif ($date_option == 'month') { 
            $data->whereBetween('created_at', [
                $current_date->startOfMonth()->toDateString(),
                $current_date->endOfMonth()->toDateString()
            ]);
        } elseif ($date_option == 'year') {
            $data->whereBetween('created_at', [
                $current_date->startOfYear()->toDateString(),
                $current_date->endOfYear()->toDateString()
            ]);
        } elseif ($date_option == 'date') {
            $from = Carbon::parse($request->from)->startOfDay()->toDateString();
            $to = Carbon::parse($request->to)->endOfDay()->toDateString();

            $data->whereBetween('created_at', [$from, $to]);
        }

        $filteredData = $queryFilter->builder($data)->customFilter(new RejectedRequestFilter)->defaultSort('created_at')->get();

        $filename = "$request->model Report-" . date('ymdis') . '.' . $format;

        Excel::store(new DriverRejectedExport($filteredData), $filename, 'local');

        return $filename;
    }
    public function downloadDriverSubscriptionReport(Request $request, QueryFilterContract $queryFilter)
    {
        $format = $request->format;

        if($request->status=="1")
        {
        
          $driver_active_subscription = DriverSubscription::where('active', true)->pluck('driver_id')->toArray();

          $data = Driver::whereIn('id', $driver_active_subscription)->where('is_free_trial', false)->get();

        }elseif($request->status=="0")
        {
          $driver_active_subscription = DriverSubscription::where('active', true)->pluck('driver_id')->toArray();

          $data = Driver::whereNotIn('id', $driver_active_subscription)->where('is_free_trial', false)->get();

        }elseif($request->status=="2")
        {

          $data = Driver::where('is_free_trial', true)->get();


        }

// dd($data);

        $filename = "$request->model Report-".date('ymdis').'.'.$format;

        Excel::store(new DriverSubscriptionExport($data), $filename, 'local');

        return $filename;
    }
    public function downloadDriverSubscriptionStatusReport(Request $request, QueryFilterContract $queryFilter)
    {
        $format = $request->format;
        $date_option = $request->date_option;
        $current_date = Carbon::now();

        $query = DriverInvoice::where('is_subscription_invoice', true);


        if ($date_option == 'today') {
            $query->whereDate('created_at',  $current_date->format("Y-m-d"));
        } elseif ($date_option == 'week') {
            $query->whereBetween('created_at', [
                $current_date->startOfWeek()->toDateString(),
                $current_date->endOfWeek()->toDateString()
            ]);
        } elseif ($date_option == 'month') { 
            $query->whereBetween('created_at', [
                $current_date->startOfMonth()->toDateString(),
                $current_date->endOfMonth()->toDateString()
            ]);
        } elseif ($date_option == 'year') {
            $query->whereBetween('created_at', [
                $current_date->startOfYear()->toDateString(),
                $current_date->endOfYear()->toDateString()
            ]);
        } elseif ($date_option == 'date') {
            $from = Carbon::parse($request->from)->startOfDay()->toDateString();
            $to = Carbon::parse($request->to)->endOfDay()->toDateString();

            $query->whereBetween('created_at', [$from, $to]);
        }

            $data = $query->get();
// dd($data);

        $filename = "$request->model Report-".date('ymdis').'.'.$format;

        Excel::store(new DriverSubscriptionInvoiceExport($data), $filename, 'local');

        return $filename;
    }

    public function downloadDriverInvoiceReport(Request $request, QueryFilterContract $queryFilter)
    {
        $format = $request->format;

        $current_date = Carbon::now();


        if ($request->status == "0") {
            $data = DriverInvoice::where('is_paid', true)->where('is_subscription_invoice', false);
        } elseif ($request->status == "2") {
            $data = DriverInvoice::where('is_paid', false)->where('is_subscription_invoice', false);
        } elseif ($request->status == "1") {
            $data = DriverInvoice::where('is_subscription_invoice', false);
        }

        $date_option = $request->date_option;


      if ($date_option == 'today') {

          $query = $data->whereDate('created_at',  $current_date->format("Y-m-d"));

        } elseif ($date_option == 'week') {

          $query = $data->whereBetween('created_at', [
                $current_date->startOfWeek()->toDateString(),
                $current_date->endOfWeek()->toDateString()
            ]);

        } elseif ($date_option == 'month') { 

          $query = $data->whereBetween('created_at', [
                $current_date->startOfMonth()->toDateString(),
                $current_date->endOfMonth()->toDateString()
            ]);


        } elseif ($date_option == 'year') {

          $query = $data->whereBetween('created_at', [
                $current_date->startOfYear()->toDateString(),
                $current_date->endOfYear()->toDateString()
            ]);

        } elseif ($date_option == 'date') {

        $from = Carbon::parse($request->from)->toDateString();
        $to = Carbon::parse($request->to)->toDateString();
        // dd($from);
        $query = $data->whereDate('created_at', '>=', $from)
                      ->whereDate('created_at', '<=', $to);

        }

        // Execute the query and fetch the result
        $result = $query->get();

        // Check the contents of the result
        // dd($result);

        $filename = "$request->model Report-" . date('ymdis') . '.' . $format;

        // Export the filtered result, not $data
        Excel::store(new DriverInvoiceExport($result), $filename, 'local');

        return $filename;
    }
    public function downloadDriverWiseInvoiceReport(Request $request, QueryFilterContract $queryFilter)
    {
        $format = $request->format;

        if($request->invoice_type=="subscription")
        {
        
          $data = DriverInvoice::where('driver_id', $request->driver_id)->where('is_subscription_invoice', true);

        }elseif($request->invoice_type=="get")
        {
          $data = DriverInvoice::where('driver_id', $request->driver_id)->where('is_subscription_invoice', false);

        }elseif($request->invoice_type=="both")
        {

          $data = DriverInvoice::where('driver_id', $request->driver_id);

        }

        $from = Carbon::parse($request->from)->toDateString();
        $to = Carbon::parse($request->to)->toDateString();
        // dd($from);
        $query = $data->whereDate('created_at', '>=', $from)
                      ->whereDate('created_at', '<=', $to);
        // Print the SQL query for debugging
        // dd($query->toSql());

        // Execute the query and fetch the result
        $result = $query->get();

// dd($data);

        $filename = "$request->model Report-".date('ymdis').'.'.$format;

        Excel::store(new DriverInvoiceExport($result), $filename, 'local');

        return $filename;
    }
//AccountBlockedUser
    public function downloadAccountBlockedUserReport(Request $request, QueryFilterContract $queryFilter)
    {
        $format = $request->format;
        if($request->user_type=="user")
        {

        $user_cancellation_wallet_block = get_settings(Settings::USER_CANCELLATION_AMOUNT_TO_BLOCK_SCREEN);

        $users_with_unpaid_cancellation_fee = User::whereHas('userCancellationFee', function ($query) use ($user_cancellation_wallet_block) {
            $query->where('is_paid', false)
                  ->groupBy('user_id')
                  ->havingRaw('SUM(amount) >= ?', [$user_cancellation_wallet_block]);
        })->get();


       }else{
        $driver_cancellation_wallet_block = get_settings(Settings::DRIVER_CANCELLATION_AMOUNT_TO_BLOCK_SCREEN);


        $users_with_unpaid_cancellation_fee = Driver::whereHas('driverCancellationFee', function ($query) use ($driver_cancellation_wallet_block) {
            $query->where('is_paid', false)
                  ->groupBy('driver_id')
                  ->havingRaw('SUM(amount) >= ?', [$driver_cancellation_wallet_block]);
        })->whereHas('user', function ($query) {
              $query;
        })->get();

        }


// dd($users_with_unpaid_cancellation_fee);

        $filename = "$request->user_type AccountBlockedReport-".date('ymdis').'.'.$format;

        Excel::store(new BlockedUsersExport($users_with_unpaid_cancellation_fee), $filename, 'local');

        return $filename;
    }    
    public function export_pdf(Request $request)
    {
        // dd($request->all());
        $type= $request->type;
        if($type == "user")
        {
            $query = User::belongstoRole('user');
        } 
        if($request->status)
        {
            $status = $request->status; 
            // dd($status);
            switch ($status) {
                case 1: 
                    if($type == "user"){ 
                            $query->where('is_approve', 0)->where('is_deleted',false);   
                    }  
                    break;
                case 2:
                    $query->where('is_approve', 1)->where('is_deleted',false);  
                    break;
                case 3:
                    $query->where('is_deleted', true); 
                    break; 
                default: 
            }
        }
        
        $data = $query->orderBy('created_at','DESC')->get();  
        $value = [
            "data" => $data, 
           ];
        $pdf = PDF::loadView('pdf.reports.users.user', compact('value'));  
        $time = time();  
        return $pdf->download("overall_earinings_".$time.".pdf"); 
    }
    public function export_pdf1(Request $request)
    {
         
        if($request->model)
        { 
            $model = $request->model;
            if($model == "room")
            {
                $query = RoomBooking::query();
            }
            if($model == "party")
            {
                $query = PartyBooking::query();
            }
            if($model == "sports")
            {
                $query = SportsBooking::query();
            }
           
            if(isset($request->status))
            {
                $status = $request->status; 
                $query->where('status',$status);
            }
            
            if($request->date_option)
            {
               
            $date_value = $request->date_option;
            switch ($date_value) {
                case "date": 
                    $fromDate = Carbon::createFromFormat('Y-m-d', $request->input('from'))->startOfDay();
                     $toDate = Carbon::createFromFormat('Y-m-d', $request->input('to'))->endOfDay(); 
                    $query->whereBetween('checkin_date', [$fromDate, $toDate]); 
                    break;
                case "today": 
                    $today = Carbon::today('Asia/Kolkata'); 
                    $query->whereDate('checkin_date', $today);
                    break;
                case "week":
                    $startOfWeek = Carbon::now('Asia/Kolkata')->startOfWeek();
                    $endOfWeek = Carbon::now('Asia/Kolkata')->endOfWeek(); 
                    $query->whereBetween('checkin_date', [$startOfWeek, $endOfWeek]);
                    break;
                case "month":
                    $startOfMonth = Carbon::now('Asia/Kolkata')->startOfMonth();
                    $endOfMonth = Carbon::now('Asia/Kolkata')->endOfMonth();
                    $query->whereBetween('checkin_date', [$startOfMonth, $endOfMonth]);
                    break;
                case "year":
                    $startOfYear = Carbon::now('Asia/Kolkata')->startOfYear();
                    $endOfYear = Carbon::now('Asia/Kolkata')->endOfYear(); 
                    $query->whereBetween('checkin_date', [$startOfYear, $endOfYear]);
                    break;
               
            }
        }
        
        if(isset($request->user))
        {
            $user = $request->user; 
            $query->whereIn('user_id',$user);
        }
        // dd("Sdfsdfdsf");
        $results = $query->get();
        // dd($results);
        if($request->format == "pdf")
        { 
            $pdf = PDF::loadView('pdf.reports.'.$model.'.pdf', compact('results'))->setPaper('a4', 'landscape');
            return $pdf->download($model.'_'.time().'.pdf');
        }
        if($request->format == "xlsx")
        { 
            $filename = "$request->model Report-".date('ymdis').'.'.$request->format; 
            Excel::store(new BookingReport($results,$model), $filename, 'local'); 
            return $filename;
        }
        if($request->format == "xls")
        {
            $filename = "$request->model Report-".date('ymdis').'.'.$request->format; 
            Excel::store(new BookingReport($results,$model), $filename, 'local'); 
            return $filename;
        }
        if($request->format == "csv")
        {
            $filename = "$request->model Report-".date('ymdis').'.'.$request->format; 
            Excel::store(new BookingReport($results,$model), $filename, 'local'); 
            return $filename;
        }
        // dd($results);
        }

        
    }
}
