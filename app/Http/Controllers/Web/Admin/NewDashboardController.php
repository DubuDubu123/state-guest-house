<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Web\BaseController;
use App\Models\Admin\Driver;
use App\Models\Request\Request;
use App\Models\RoomBooking; 
use App\Models\PartyBooking;
use App\Models\SportsBooking;
use App\Models\Request\RequestBill;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Base\Constants\Setting\Settings;
use App\Models\Admin\DriverAvailability;
use App\Models\Admin\Complaint;
use DB;
use App\Models\Request\EmployeeStatus;
use App\Models\Admin\RegisteredDriver;
use App\Base\Constants\Auth\Role;
use Kreait\Firebase\Contract\Database;
use App\Models\Request\RentalRequest;
use  App\Models\Admin\DriverInvoice;
use App\Models\Payment\DriverSubscription;
use Illuminate\Http\Request as httpRequest;
use App\Base\Constants\Auth\Role as RoleSlug;
use App\Models\RoomBookingPrice;
use App\Models\RoomBookingGuest;
use App\Models\Tariff;
use App\Models\Invoice;
use PDF;

class NewDashboardController extends BaseController
{

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function dashboard(httpRequest $request)
    {
        // dd("testttt");
        if(!Session::get('applocale')){
            Session::put('applocale', 'en');
        }

 // Session::put('applocale', 'en');

        $ownerId = null;
        // if (auth()->user()->hasRole('owner')) {
        //     $ownerId = auth()->user()->owner->id;
        // }
        // dd("SDfdfsfdf");

        $page = trans('pages_names.dashboard');
        $main_menu = 'dashboard';
        $sub_menu = null;
        $sub_menu_1 = '';
        $today = Carbon::today('Asia/Kolkata');
        // $today = date('Y-m-d'); //get Today
        $month = date('m'); // get the current month
        $year = date('Y'); // get the current year
        $lastMonth = Carbon::now('Asia/Kolkata')->subMonth(); // get the Last month 
        $query = RoomBooking::query();
        $checkin_query = RoomBooking::query();
        $party_query = PartyBooking::query();
        $sports_query = SportsBooking::query();
        $fromDate = Carbon::now('Asia/Kolkata')->startOfDay();
        $toDate = Carbon::now('Asia/Kolkata')->endOfDay();
        if($request->date_value)
        { 
            $date_value = $request->date_value; 
            switch ($date_value) {
                case 1:
                    $fromDate = Carbon::createFromFormat('Y-m-d', $request->input('from_date'))->startOfDay();
                    $toDate = Carbon::createFromFormat('Y-m-d', $request->input('to_date'))->endOfDay();
                    $checkin_query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    $query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    $party_query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    $sports_query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    break;
                case 2:
                    
                    $fromDate = Carbon::today('Asia/Kolkata'); 
                    $checkin_query->whereDate('checkin_date', $fromDate);
                    $query->whereDate('checkin_date', $fromDate);
                    $party_query->whereDate('checkin_date', $fromDate);
                    $sports_query->whereDate('checkin_date', $fromDate);
                    break;
                case 3:
                    $fromDate = Carbon::now('Asia/Kolkata')->startOfWeek();
                    $toDate = Carbon::now('Asia/Kolkata')->endOfWeek(); 
                    $checkin_query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    $query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    $party_query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    $sports_query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    break;
                case 4:
                    $fromDate = Carbon::now('Asia/Kolkata')->startOfMonth();
                    $toDate = Carbon::now('Asia/Kolkata')->endOfMonth();
                    $checkin_query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    $query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    $party_query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    $sports_query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    break;
                case 5:
                    $fromDate = Carbon::now('Asia/Kolkata')->startOfYear();
                    $toDate = Carbon::now('Asia/Kolkata')->endOfYear(); 
                    $checkin_query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    $query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    $party_query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    $sports_query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    break; 
            }
        }
        else{
            // dd($today);
            $query->whereDate('checkin_date', $today);
            $checkin_query->whereDate('checkin_date', $today);
            $party_query->whereDate('checkin_date', $today);
            $sports_query->whereDate('checkin_date', $today);
        } 
        // echo $fromDate;
        // echo $toDate;
        // exit;
        if(auth()->user()->hasRole("user"))
        {
            $month_earnings[] = DB::table('room_booking as rb') 
            ->where('rb.checkin_date', '>=', $fromDate)
            ->where('rb.checkout_date', '<', $toDate)
            ->where('rb.user_id',auth()->user()->id)->count();
            $month_earnings[] = DB::table('party_booking') 
                                ->where('party_booking.checkin_date', '>=', $fromDate) 
                                ->where('party_booking.checkin_date', '<=', $toDate) 
                                ->where('party_booking.user_id',auth()->user()->id)
                                ->count();
            $month_earnings[] = DB::table('sports_booking') 
                                ->where('sports_booking.checkin_date', '>=', $fromDate) 
                                ->where('sports_booking.checkin_date', '<=', $toDate) 
                                ->where('sports_booking.user_id',auth()->user()->id)
                                ->count();
        }
        else{
            $month_earnings[] = DB::table('room_booking as rb')
            ->join('room_booking_price as rbp', 'rb.id', '=', 'rbp.booking_id')
            ->where('rb.checkin_date', '>=', $fromDate)
            ->where('rb.checkout_date', '<', $toDate)
            ->where('rb.is_paid',1)
            ->sum('rbp.total_price');
            $month_earnings[] = DB::table('party_booking') 
                        ->where('party_booking.checkin_date', '>=', $fromDate) 
                        ->where('party_booking.checkin_date', '<=', $toDate) 
                        ->where('party_booking.is_paid',1)
                        ->sum('party_booking.tariff');
            $month_earnings[] = DB::table('sports_booking') 
                        ->where('sports_booking.checkin_date', '>=', $fromDate) 
                        ->where('sports_booking.checkin_date', '<=', $toDate) 
                        ->where('sports_booking.is_paid',1)
                        ->sum('sports_booking.tariff');
        }
        $status = 1;
        if ($month_earnings[0] === 0 && $month_earnings[1] === 0 && $month_earnings[2] === 0) {
            // Update status to 1
            $status = 0;
        } 
        // dd($month_earnings);
        if(auth()->user()->hasRole('user'))
        {
            $check_in_count = $checkin_query->where('user_id',auth()->user()->id)->count();
            $room_count = $query->where('user_id',auth()->user()->id)->count();
            $party_count = $party_query->where('user_id',auth()->user()->id)->count();
            $sports_count = $sports_query->where('user_id',auth()->user()->id)->count();
        }
        else{
            $check_in_count = $checkin_query->count();
            $room_count = $query->count();
            $party_count = $party_query->count();
            $sports_count = $sports_query->count();
        }
        // dd($room_count);
      
        $pending_users = User::where('is_deleted', false)->where('is_approve', 0)->belongsToRole(RoleSlug::USER)->count(); 
        $recent_booking_datas = RoomBooking::orderBy('created_at','DESC')->limit(10);
        $recent_booking_party = PartyBooking::orderBy('created_at','DESC')->limit(10);
        $recent_booking_sports = SportsBooking::orderBy('created_at','DESC')->limit(10);
        $complaint = Complaint::all(); 
       
        //User status Ends Here  

        $startDate = Carbon::now('Asia/Kolkata')->startOfMonth()->subMonths(11);
        $endDate = Carbon::now('Asia/Kolkata');
        $data=[];
        while ($startDate->lte($endDate))
            {  
            $from = Carbon::parse($startDate)->startOfMonth();
            $to = Carbon::parse($startDate)->endOfMonth();
            $shortName = $startDate->shortEnglishMonth;
            $monthName = $startDate->monthName;
            $data['label'][] = $monthName;
            $data['room_price'][] = DB::table('room_booking as rb')
            ->join('room_booking_price as rbp', 'rb.id', '=', 'rbp.booking_id')
            ->where('rb.checkin_date', '>=', $from)
            ->where('rb.checkout_date', '<', $to)
            ->where('rb.is_paid',1)
            ->sum('rbp.total_price');
            $data['party_price'][] = DB::table('party_booking') 
            ->where('party_booking.checkin_date', '>=', $from) 
            ->where('party_booking.checkin_date', '<=', $to) 
            ->where('party_booking.is_paid',1)
            ->sum('party_booking.tariff');
            $data['sports_price'][] = DB::table('sports_booking') 
            ->where('sports_booking.checkin_date', '>=', $from) 
            ->where('sports_booking.checkin_date', '<=', $to) 
            ->where('sports_booking.is_paid',1)
            ->sum('sports_booking.tariff'); 
            $startDate->addMonth();
        }  
//currency symbol
        if (auth()->user()->countryDetail) {
            $currency = auth()->user()->countryDetail->currency_symbol;
        } else {
            $currency = get_settings(Settings::CURRENCY_SYMBOL);
        }
        $currency = get_settings('currency_symbol');
         if($request->type)
         {
            $data_array = [
                "status"=>true,
                "room_count"=>$room_count,
                "party_count"=>$party_count,
                "sports_count"=>$sports_count,
                "pending_users"=>$pending_users,
                "recent_booking_datas"=>$recent_booking_datas,
                "recent_booking_party"=>$recent_booking_party,
                "recent_booking_sports"=>$recent_booking_sports,
                "month_earnings"=>$month_earnings,
                "status"=>$status,
                "check_in_count"=>$check_in_count,
            ];
            return response()->json($data_array);
         }
         else{
            // dd($check_in_count);
            return view('admin.new_dashboard', compact('page', 'main_menu','currency', 'sub_menu','data', 'complaint','sub_menu_1','room_count','party_count','sports_count','pending_users','recent_booking_datas','recent_booking_party','recent_booking_sports','month_earnings','status','check_in_count'));
         }
      
   }
     
    public function export(httprequest $request)
    {
        // dd($request->all());
       if($request->label)
       {
        $type = $request->label;
        switch($type)
        {
            case 1:  
                $booking = RoomBooking::where('is_paid',1);
                $party = PartyBooking::where('is_paid',1);
                $sports = SportsBooking::where('is_paid',1);
                $query = $this->date_execution($request->all(),$booking); 
                $data = $query['query']->get(); 
                $party_query = $this->date_execution($request->all(),$party);
                $party_data = $party_query['query']->get(); 
                $sports_query = $this->date_execution($request->all(),$sports);  
                $sports_data = $sports_query['query']->get(); 
            break;
            case 2:
                $query = RoomBooking::where('is_paid',1);
                $startOfYear = Carbon::now('Asia/Kolkata')->startOfYear();
                $endOfYear = Carbon::now('Asia/Kolkata')->endOfYear(); 
                $query->whereBetween('checkin_date', [$startOfYear, $endOfYear]);
                $data = $query->get();
            break;
            case 3:
                $query = PartyBooking::where('is_paid',1);
                $startOfYear = Carbon::now('Asia/Kolkata')->startOfYear();
                $endOfYear = Carbon::now('Asia/Kolkata')->endOfYear(); 
                $query->whereBetween('checkin_date', [$startOfYear, $endOfYear]);
                $data = $query->get();
            break;
            case 4:
                $query = SportsBooking::where('is_paid',1);
                $startOfYear = Carbon::now('Asia/Kolkata')->startOfYear();
                $endOfYear = Carbon::now('Asia/Kolkata')->endOfYear(); 
                $query->whereBetween('checkin_date', [$startOfYear, $endOfYear]);
                $data = $query->get();
            break;
        }
       
       }   
       $value = [
        "data" => $data,
        "party_data" => $party_data,
        "sports_data" => $sports_data,
        "month_earnings" => $query['month_earnings']
       ];
        $pdf = PDF::loadView('pdf.overall_earinings', compact('value'));  
        $time = time();
        return $pdf->download("overall_earinings_".$time.".pdf");
    }
    public function sample(){
        return view('pdf.overall_earinings');
    }
    public function date_execution($request,$query)
    {
         
        $request = (object) $request; 
        $fromDate = Carbon::today('Asia/Kolkata')->startOfDay();
        $toDate = Carbon::today('Asia/Kolkata')->endOfDay(); 
        if(isset($request->date_value))
        { 
            $date_value = $request->date_value;
            switch ($date_value) {
                case 1: 
                     $query->whereBetween('checkin_date', [$fromDate, $toDate]); 
                    break;
                case 2: 
                    $today = Carbon::today('Asia/Kolkata');
                    // dd($today);
                    $query->whereDate('checkin_date', $today);
                    break;
                case 3:
                    $fromDate = Carbon::now('Asia/Kolkata')->startOfWeek();
                    $toDate = Carbon::now('Asia/Kolkata')->endOfWeek(); 
                    $query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    break;
                case 4:
                    $fromDate = Carbon::now('Asia/Kolkata')->startOfMonth();
                    $toDate = Carbon::now('Asia/Kolkata')->endOfMonth();
                    $query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    break;
                case 5:
                    $fromDate = Carbon::now('Asia/Kolkata')->startOfYear();
                    $toDate = Carbon::now('Asia/Kolkata')->endOfYear(); 
                    $query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    break;
               
            }
        }
        else{
            $today = Carbon::today('Asia/Kolkata'); 
            $query->whereDate('checkin_date', $today);
        }
        $month_earnings[] = DB::table('room_booking as rb')
        ->join('room_booking_price as rbp', 'rb.id', '=', 'rbp.booking_id')
        ->whereBetween('checkin_date', [$fromDate, $toDate])
        ->where('rb.is_paid',1)
        ->sum('rbp.total_price');
        $month_earnings[] = DB::table('party_booking') 
                    ->where('party_booking.checkin_date', '>=', $fromDate) 
                    ->where('party_booking.checkin_date', '<=', $toDate) 
                    ->where('party_booking.is_paid',1)
                    ->sum('party_booking.tariff');
        $month_earnings[] = DB::table('sports_booking') 
                    ->where('sports_booking.checkin_date', '>=', $fromDate) 
                    ->where('sports_booking.checkin_date', '<=', $toDate) 
                    ->where('sports_booking.is_paid',1)
                    ->sum('sports_booking.tariff');
        $query1 = $query->orderBy('created_at','DESC');
        $results = [
            "query" => $query,
            "month_earnings" => $month_earnings
        ];
        return $results;
    }
    
}

