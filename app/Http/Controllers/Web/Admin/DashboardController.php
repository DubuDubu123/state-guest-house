<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Web\BaseController;
use App\Models\Admin\Driver;
use App\Models\Request\Request;
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

class DashboardController extends BaseController
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
    public function dashboard()
    {

        if(!Session::get('applocale')){
            Session::put('applocale', 'en');
        }
    // if (auth()->user()->hasRole(['employee', 'supervisor', 'manager'])) 
    // {
    //     $user = auth()->user();

    //     $today = Carbon::today();

    //     $employee_status = EmployeeStatus::where('user_id', $user->id)->exists();

    //     if (!$employee_status) 
    //     {

    //     EmployeeStatus::create(['user_id' => $user->id, 'login_at' => Carbon::now()]);
    //     }else{
    //         $employee_status_today = EmployeeStatus::where('user_id', $user->id)->whereDate('login_at', $today)->exists();
    //         if(!$employee_status_today){
    //         EmployeeStatus::where('user_id', $user->id)->update(['login_at' => Carbon::now()]);
    //          }
    //     }
   
    // }

 // Session::put('applocale', 'en');

        $ownerId = null;
        if (auth()->user()->hasRole('owner')) {
            $ownerId = auth()->user()->owner->id;
        }

        $page = trans('pages_names.dashboard');
        $main_menu = 'dashboard';
        $sub_menu = null;
        $sub_menu_1 = '';

        $today = date('Y-m-d');

        $total_drivers = Driver::selectRaw('
                                        IFNULL(SUM(CASE WHEN approve=1 THEN 1 ELSE 0 END),0) AS approved,
                                        IFNULL((SUM(CASE WHEN approve=1 THEN 1 ELSE 0 END) / count(*)),0) * 100 AS approve_percentage,
                                        IFNULL((SUM(CASE WHEN approve=0 THEN 1 ELSE 0 END) / count(*)),0) * 100 AS decline_percentage,
                                        IFNULL(SUM(CASE WHEN approve=0 THEN 1 ELSE 0 END),0) AS declined,
                                        count(*) AS total
                                    ')
                                ->whereHas('user', function ($query) {
                                    $query->companyKey();
                                });

           $regitered_drivers =  RegisteredDriver::get()->count();                               
// dd($regitered_drivers);
        if($ownerId != null){
            $total_drivers = $total_drivers->whereOwnerId($ownerId);
        }

        $total_drivers = $total_drivers->get();

        $total_users = User::belongsToRole('user')->companyKey()->count();

        $deleted_users = User::where("is_deleted", true)->count();

        $active_users = $total_users-$deleted_users;

        $deleted_drivers = Driver::where("is_deleted", true)->count();



//trips
        if($ownerId != null){
        $trips = Request::companyKey()->selectRaw('
                    IFNULL(SUM(CASE WHEN is_completed=1 THEN 1 ELSE 0 END),0) AS today_completed,
                    IFNULL(SUM(CASE WHEN is_cancelled=1 THEN 1 ELSE 0 END),0) AS today_cancelled,
                    IFNULL(SUM(CASE WHEN is_completed=0 AND is_cancelled=0 THEN 1 ELSE 0 END),0) AS today_scheduled,
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) AS auto_cancelled,
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) AS user_cancelled,
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0) AS driver_cancelled,
                    (IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) +
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) +
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0)) AS total_cancelled
                ')
                ->whereDate('trip_start_time',$today)
                ->where('requests.owner_id',$ownerId)
                ->get();
        }else{
            $trips = Request::companyKey()->selectRaw('
                IFNULL(SUM(CASE WHEN is_completed=1 THEN 1 ELSE 0 END),0) AS today_completed,
                IFNULL(SUM(CASE WHEN is_cancelled=1 THEN 1 ELSE 0 END),0) AS today_cancelled,
                IFNULL(SUM(CASE WHEN is_completed=0 AND is_cancelled=0 THEN 1 ELSE 0 END),0) AS today_scheduled,
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) AS auto_cancelled,
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) AS user_cancelled,
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0) AS driver_cancelled,
                (IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) +
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) +
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0)) AS total_cancelled
            ')
            ->whereDate('trip_start_time',$today)
            ->get();
        }
        $upiEarningsQuery = "IFNULL(SUM(IF(requests.payment_opt=4,request_bills.total_amount,0)),0)";        
        $cardEarningsQuery = "IFNULL(SUM(IF(requests.payment_opt=0,request_bills.total_amount,0)),0)";
        $cashEarningsQuery = "IFNULL(SUM(IF(requests.payment_opt=1,request_bills.total_amount,0)),0)";
        $walletEarningsQuery = "IFNULL(SUM(IF(requests.payment_opt=2,request_bills.total_amount,0)),0)";
        $adminCommissionQuery = "IFNULL(SUM(request_bills.admin_commision_with_tax),0)";
        $driverCommissionQuery = "IFNULL(SUM(request_bills.driver_commision),0)";
        $totalEarningsQuery = "$cardEarningsQuery + $cashEarningsQuery + $walletEarningsQuery + $upiEarningsQuery";

//cancell trip count
        if($ownerId != null){
        $cancelledTrips = Request::companyKey()->selectRaw('
                    IFNULL(SUM(CASE WHEN is_completed=1 THEN 1 ELSE 0 END),0) AS today_completed,
                    IFNULL(SUM(CASE WHEN is_cancelled=1 THEN 1 ELSE 0 END),0) AS today_cancelled,
                    IFNULL(SUM(CASE WHEN is_completed=0 AND is_cancelled=0 THEN 1 ELSE 0 END),0) AS today_scheduled,
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) AS auto_cancelled,
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) AS user_cancelled,
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0) AS driver_cancelled,
                    (IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) +
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) +
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0)) AS total_cancelled
                ')
                // ->whereDate('trip_start_time',$today)
                ->where('requests.owner_id',$ownerId)
                ->get();
        }else{
            $cancelledTrips = Request::companyKey()->selectRaw('
                IFNULL(SUM(CASE WHEN is_completed=1 THEN 1 ELSE 0 END),0) AS today_completed,
                IFNULL(SUM(CASE WHEN is_cancelled=1 THEN 1 ELSE 0 END),0) AS today_cancelled,
                IFNULL(SUM(CASE WHEN is_completed=0 AND is_cancelled=0 THEN 1 ELSE 0 END),0) AS today_scheduled,
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) AS auto_cancelled,
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) AS user_cancelled,
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0) AS driver_cancelled,
                (IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) +
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) +
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0)) AS total_cancelled
            ')
            // ->whereDate('trip_start_time',$today)
            ->get();
        }


        // Today earnings
        if($ownerId != null){
            $todayEarnings =Request::leftJoin('request_bills','requests.id','request_bills.request_id')
                                        ->selectRaw("
                                        {$upiEarningsQuery} AS upi,
                                        {$cardEarningsQuery} AS card,
                                        {$cashEarningsQuery} AS cash,
                                        {$walletEarningsQuery} AS wallet,
                                        {$totalEarningsQuery} AS total,
                                        {$adminCommissionQuery} as admin_commision,
                                        {$driverCommissionQuery} as driver_commision,
                                        IFNULL(({$upiEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS upi_percentage,
                                        IFNULL(({$cardEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS card_percentage,
                                        IFNULL(({$cashEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS cash_percentage,
                                        IFNULL(({$walletEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS wallet_percentage
                                    ")
                                    ->companyKey()
                                    ->where('requests.is_completed',true)
                                    ->where('requests.owner_id',$ownerId)
                                    ->whereDate('requests.trip_start_time',date('Y-m-d'))
                                    ->get();
        }else{
        $todayEarnings = Request::leftJoin('request_bills','requests.id','request_bills.request_id')
                                        ->selectRaw("
                                        {$upiEarningsQuery} AS upi,
                                        {$cardEarningsQuery} AS card,
                                        {$cashEarningsQuery} AS cash,
                                        {$walletEarningsQuery} AS wallet,
                                        {$totalEarningsQuery} AS total,
                                        {$adminCommissionQuery} as admin_commision,
                                        {$driverCommissionQuery} as driver_commision,
                                        IFNULL(({$upiEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS upi_percentage,
                                        IFNULL(({$cardEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS card_percentage,
                                        IFNULL(({$cashEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS cash_percentage,
                                        IFNULL(({$walletEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS wallet_percentage
                                    ")
                                    ->companyKey()
                                    ->where('requests.is_completed',true)
                                    ->whereDate('requests.trip_start_time',date('Y-m-d'))
                                    ->get();
        }
        //Overall Earnings
        $overallEarnings = Request::leftJoin('request_bills','requests.id','request_bills.request_id')
                                    ->selectRaw("
                                    {$upiEarningsQuery} AS upi,                                        
                                    {$cardEarningsQuery} AS card,
                                    {$cashEarningsQuery} AS cash,
                                    {$walletEarningsQuery} AS wallet,
                                    {$totalEarningsQuery} AS total,
                                    {$adminCommissionQuery} as admin_commision,
                                    {$driverCommissionQuery} as driver_commision,
                                    IFNULL(({$upiEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS upi_percentage,
                                    IFNULL(({$cardEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS card_percentage,
                                    IFNULL(({$cashEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS cash_percentage,
                                    IFNULL(({$walletEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS wallet_percentage
                                ")
                                ->companyKey()
                                ->where('requests.is_completed',true)
                                ->get();
        if($ownerId != null){
                    $overallEarnings = Request::leftJoin('request_bills','requests.id','request_bills.request_id')
                                    ->selectRaw("
                                    {$upiEarningsQuery} AS upi,                                                                                
                                    {$cardEarningsQuery} AS card,
                                    {$cashEarningsQuery} AS cash,
                                    {$walletEarningsQuery} AS wallet,
                                    {$totalEarningsQuery} AS total,
                                    {$adminCommissionQuery} as admin_commision,
                                    {$driverCommissionQuery} as driver_commision,
                                    IFNULL(({$upiEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS upi_percentage,
                                    IFNULL(({$cardEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS card_percentage,
                                    IFNULL(({$cashEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS cash_percentage,
                                    IFNULL(({$walletEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS wallet_percentage
                                ")
                                ->companyKey()
                                ->where('requests.is_completed',true)
                                ->where('requests.owner_id',$ownerId)
                                ->get();
        }
        //cancellation chart
             $startDate = Carbon::now()->startOfMonth()->subMonths(6);
             $endDate = Carbon::now();
             $data=[];
    if($ownerId != null){
        while ($startDate->lte($endDate)){

        $from = Carbon::parse($startDate)->startOfMonth();
        $to = Carbon::parse($startDate)->endOfMonth();
        $shortName = $startDate->shortEnglishMonth;
                $monthName = $startDate->monthName;
                $data['cancel'][] = [
                    'y' => $shortName,
                    'a' => Request::companyKey()->whereBetween('created_at', [$from,$to])->where('cancel_method','0')->whereIsCancelled(true)->whereOwnerId($ownerId)->count(),
                    'u' => Request::companyKey()->whereBetween('created_at', [$from,$to])->where('cancel_method','1')->whereIsCancelled(true)->whereOwnerId($ownerId)->count(),
                    'd' => Request::companyKey()->whereBetween('created_at', [$from,$to])->where('cancel_method','2')->whereIsCancelled(true)->whereOwnerId($ownerId)->count()
                ];
                $data['earnings']['months'][] = $monthName;
                $data['earnings']['values'][] = RequestBill::whereHas('requestDetail', function ($query) use ($from,$to,$ownerId) {
                                                            $query->companyKey()->whereBetween('trip_start_time', [$from,$to])->whereIsCompleted(true)->where('owner_id', $ownerId);
                                                        })->sum('total_amount');

                  $startDate->addMonth();
                }

     }else{
    while ($startDate->lte($endDate)){

        $from = Carbon::parse($startDate)->startOfMonth();
        $to = Carbon::parse($startDate)->endOfMonth();
        $shortName = $startDate->shortEnglishMonth;
                $monthName = $startDate->monthName;
                $data['cancel'][] = [
                    'y' => $shortName,
                    'a' => Request::companyKey()->whereBetween('created_at', [$from,$to])->where('cancel_method','0')->whereIsCancelled(true)->count(),
                    'u' => Request::companyKey()->whereBetween('created_at', [$from,$to])->where('cancel_method','1')->whereIsCancelled(true)->count(),
                    'd' => Request::companyKey()->whereBetween('created_at', [$from,$to])->where('cancel_method','2')->whereIsCancelled(true)->count()
                ];
                $data['earnings']['months'][] = $monthName;
                $data['earnings']['values'][] = RequestBill::whereHas('requestDetail', function ($query) use ($from,$to) {
                                                            $query->companyKey()->whereBetween('trip_start_time', [$from,$to])->whereIsCompleted(true);
                                                        })->sum('total_amount');

                  $startDate->addMonth();
                }
      }
// dd($data);
        if (auth()->user()->countryDetail) {
            $currency = auth()->user()->countryDetail->currency_symbol;
        } else {
            $currency = get_settings(Settings::CURRENCY);
        }
        // $currency = auth()->user()->countryDetail->currency_code ?: env('SYSTEM_DEFAULT_CURRENCY');
        $currency = get_settings('currency_code');

/*Online Off Line*/
        $drivers = Driver::where('approve',true)->get();

        // $drivers_online = DriverAvailability::where('is_online', true)->whereDate('online_at', $today)->whereNull('offline_at')->groupBy('driver_id')->count();
       
        if (env('APP_FOR')=='live')
        {
          $firbase_drivers_online = $this->database->getReference('drivers')->orderByChild('is_active')->equalTo(1)->getValue();
          $drivers_online = count($firbase_drivers_online);

        }else{
          $drivers_online = 0;

        }

        
        $drivers_offline = (($drivers->count()) - $drivers_online);

// dd("Drivers Online : ",$drivers_online," Drivers offfLine : ",$drivers_offline,"Drivers: ",$drivers->count());


        $month = date('m'); // get the current month
        $year = date('Y'); // get the current year
        $lastMonth = Carbon::now()->subMonth(); // get the Last month
// driver
        $current_month_drivers = Driver::whereMonth('created_at', $month)
                  ->whereYear('created_at', $year)
                  ->count();

        $last_month_drivers = Driver::whereMonth('created_at', $lastMonth->month)
                  ->whereYear('created_at', $lastMonth->year)
                  ->count();
       
        $today_drivers = Driver::whereDate('created_at', Carbon::now()->toDateString())
                      ->count();

// user
        $current_month_users = User::belongsTorole(Role::USER)->whereMonth('created_at', $month)
                  ->whereYear('created_at', $year)
                  ->count();

        $last_month_users = User::belongsTorole(Role::USER)->whereMonth('created_at', $lastMonth->month)
                  ->whereYear('created_at', $lastMonth->year)
                  ->count();
       
        $today_users = User::belongsTorole(Role::USER)->whereDate('created_at', $today)->count();
        
        $complaint = Complaint::all();

/*user Reqiester Count*/

// Calculate the date 5 days ago
$last_5th_date = now()->subDays(5)->format('Y-m-d');

// Fetch user counts grouped by date for the last 7 days
$userCounts = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
                  ->where('created_at', '>=', $last_5th_date)
                  ->groupBy('date')
                  ->get();

// Generate an array of the last 7 days dates
$dates_7 = [];
for ($i = 0; $i < 7; $i++) {
    $dates_7[] = now()->subDays($i)->format('Y-m-d');
}

// Map user counts to respective dates
$registeredInfo = collect($dates_7)->map(function ($date) use ($userCounts) {
    $match = $userCounts->firstWhere('date', $date);
    return [
        'date' => $date,
        'total' => $match ? $match->total : 0
    ];
});
    $complaintCounts = Complaint::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
                      ->where('created_at', '>=', $last_5th_date)
                      ->groupBy('date')
                      ->get();

        $dates_5 = [];
        for ($i = 0; $i < 7; $i++) {
            $dates_5[] = now()->subDays($i)->format('Y-m-d');
        }

    $complaintInfo = collect($dates_5)->map(function ($dates_5) use ($complaintCounts) {
        $match = $complaintCounts->firstWhere('date', $dates_5);
        return [
            'date' => $dates_5,
            'total' => $match ? $match->total : 0
                ];
            }); 

//cancelled_trips
        if($ownerId != null){
        $cancelled_trips = Request::companyKey()->selectRaw('
                    IFNULL(SUM(CASE WHEN is_cancelled=1 THEN 1 ELSE 0 END),0) AS today_cancelled,
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) AS auto_cancelled,
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) AS user_cancelled,
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0) AS driver_cancelled,
                    (IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) +
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) +
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0)) AS total_cancelled
                ')
                ->where('requests.owner_id',$ownerId)
                ->get();
        }else{
            $cancelled_trips = Request::companyKey()->selectRaw('
                IFNULL(SUM(CASE WHEN is_cancelled = 1 AND cancel_method = 0 THEN 1 ELSE 0 END), 0) AS auto_cancelled,
                IFNULL(SUM(CASE WHEN is_cancelled = 1 AND cancel_method = 1 THEN 1 ELSE 0 END), 0) AS user_cancelled,
                IFNULL(SUM(CASE WHEN is_cancelled = 1 AND cancel_method = 2 THEN 1 ELSE 0 END), 0) AS driver_cancelled,
                IFNULL(SUM(CASE WHEN is_cancelled = 1 AND cancel_method = 3 THEN 1 ELSE 0 END), 0) AS dispatcher_cancelled,
                IFNULL(SUM(CASE WHEN is_cancelled = 1 THEN 1 ELSE 0 END), 0) AS total_cancelled
            ')->get();


        $cancelled_trip_array = DB::table('requests')
            ->selectRaw('cancel_method, COUNT(*) as total_cancelled')
            ->where('is_cancelled', 1)
            ->groupBy('cancel_method')
            ->get()
            ->transform(function ($request) {
                switch ($request->cancel_method) {
                    case 0:
                        $request->cancel_method_name = 'Automatic';
                        break;
                    case 1:
                        $request->cancel_method_name = 'User';
                        break;
                    case 2:
                        $request->cancel_method_name = 'Driver';
                        break;
                    case 3:
                        $request->cancel_method_name = 'Dispatcher';
                        break;
                }

                return $request;
            })
            ->sortBy('cancel_method'); // Sort the collection by cancel_method

        // Create an array to hold all cancel methods
        $allCancelMethods = [
            ['cancel_method' => 0, 'cancel_method_name' => 'Automatic'],
            ['cancel_method' => 1, 'cancel_method_name' => 'User'],
            ['cancel_method' => 2, 'cancel_method_name' => 'Driver'],
            ['cancel_method' => 3, 'cancel_method_name' => 'Dispatcher'],
        ];

        // Check and append missing cancel methods with a count of 0
        $cancelled_trip_array = collect($allCancelMethods)
            ->map(function ($method) use ($cancelled_trip_array) {
                $foundMethod = $cancelled_trip_array->where('cancel_method', $method['cancel_method'])->first();

                return $foundMethod ?: (object)['cancel_method' => $method['cancel_method'], 'cancel_method_name' => $method['cancel_method_name'], 'total_cancelled' => 0];
            })
            ->values(); // Re-index the collection

// dd($cancelled_trip_array);
        }
// dd($overallEarnings);

        return view('admin.dashboard', compact('page', 'main_menu','currency', 'sub_menu','total_drivers','active_users','trips','todayEarnings','overallEarnings','data','drivers_online','drivers_offline', 'current_month_drivers', 'last_month_drivers', 'today_drivers','current_month_users','last_month_users','today_users', 'registeredInfo', 'complaint', 'complaintInfo','cancelledTrips','regitered_drivers','cancelled_trips','cancelled_trip_array','sub_menu_1','drivers','deleted_users','deleted_drivers'));
    }
}
