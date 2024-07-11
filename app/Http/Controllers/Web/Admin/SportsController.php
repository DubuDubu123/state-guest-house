<?php

namespace App\Http\Controllers\Web\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\SportsBooking;
use App\Models\SportsTariff;
use App\Models\SportsTariffBooking; 
use Illuminate\Http\Request;
use App\Models\Admin\VehicleType;
use App\Models\Admin\ServiceLocation;
use App\Http\Controllers\ApiController;
use App\Base\Constants\Auth\Role as RoleSlug;
use App\Base\Filters\Master\CommonMasterFilter;
use App\Http\Controllers\Api\V1\BaseController;
use App\Base\Libraries\QueryFilter\QueryFilterContract;
use App\Base\Services\ImageUploader\ImageUploaderContract;
use App\Http\Requests\Admin\VehicleTypes\CreateVehicleTypeRequest;
use App\Http\Requests\Admin\VehicleTypes\UpdateVehicleTypeRequest;
use App\Base\Constants\Auth\Role; 
use App\Models\Invoice;

/**
 * @resource Vechicle-Types
 *
 * vechicle types Apis
 */
class SportsController extends BaseController
{
    /**
     * The VehicleType model instance.
     *
     * @var \App\Models\Admin\VehicleType
     */
    protected $vehicle_type;

    /**
     * VehicleTypeController constructor.
     *
     * @param \App\Models\Admin\VehicleType $vehicle_type
     */
    public function __construct(VehicleType $vehicle_type, ImageUploaderContract $imageUploader,User $user)
    {
        $this->vehicle_type = $vehicle_type;
        $this->imageUploader = $imageUploader;
        $this->user = $user;
    }

    /**
    * Get all vehicle types
    * @return \Illuminate\Http\JsonResponse
    */
    public function index()
    {
        // dd(request()->url());
        $page = trans('pages_names.types');
        $main_menu = 'master';
        $sub_menu = 'sports';
        $sub_menu_1 = '';
        $sports_tariff = SportsTariff::get();
        $user = $this->user->belongsTorole(Role::USER)->get(); 
        return view('admin.sports.index', compact('page', 'main_menu', 'sub_menu','sub_menu_1','sports_tariff','user'))->render();
    }
    public function view(Request $request,QueryFilterContract $queryFilter,SportsBooking $booking)
    { 
         
        $page = trans('pages_names.types');
        $main_menu = 'master';
        $sub_menu = 'sports';
        $sub_menu_1 = ''; 
        $checkinDate = Carbon::parse($booking->checkin_date); 
        // Get the current date
        $currentDate = Carbon::now('Asia/kolkata'); 
        // Calculate the difference in days between the current date and the check-in date
        $daysDifference = $currentDate->diffInDays($checkinDate);
       $date_diff = $checkinDate->day - $currentDate->day;
    //    dd($date_diff);
    //    dd($booking->details[0]->tariff); 
        return view('admin.sports.view', compact('page', 'main_menu', 'sub_menu','sub_menu_1','booking','date_diff'))->render();
    }

    public function book_now(Request $request)
    {
           dd($request->all());
           $user_id = auth()->user()->id;
           if(isset($request->user))
           { 
               $user_id = $request->user;
           }
           $checkinDatetime = Carbon::createFromFormat('Y-m-d', $request->from_date, 'Asia/Kolkata')->startOfDay()->format('Y-m-d H:i:s');
           $checkoutDatetime = Carbon::createFromFormat('Y-m-d', $request->to_date, 'Asia/Kolkata')->endOfDay()->format('Y-m-d H:i:s');
           $bookings =  new SportsBooking(); 
           $bookings->booking_id = time();
           $bookings->checkin_date = $checkinDatetime;
           $bookings->checkout_date = $checkoutDatetime; 
           $bookings->guest_type = $request->guest_type;     
           $bookings->subscription_type = $request->subscription_type;     
           $bookings->tariff = $request->total_amount;
           $bookings->user_id = $user_id;
           $bookings->booked_by = auth()->user()->id;
           $bookings->save();

           foreach($request->name as $key=>$value)
           {
            $sports_tariff_booking =  new SportsTariffBooking(); 
            $sports_tariff_booking->booking_id = $bookings->id;
            $sports_tariff_booking->tariff_id = $value; 
            $sports_tariff_booking->save();
           }
           $response = [
               "status" => true,
               "message" => "Booking Confirmed Successfully"
           ];
           return response()->json($response);
    }
    

    public function getAllTypes(QueryFilterContract $queryFilter)
    {
        // dd(auth()->user()->hasRole('mess-manager'));
        if(auth()->user()->hasRole('super-user') || auth()->user()->hasRole('mess-manager'))
        {
            $query = SportsBooking::orderBy('created_at','desc');
        }
        else{
            $query = SportsBooking::where('user_id',auth()->user()->id)->orderBy('created_at','desc');
        }
       
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();
        return view('admin.sports._types', compact('results'))->render();
    }

    /**
    * Get Types by admin for ajax
    *
    */
    public function byAdmin(Request $request)
    {
        $types = VehicleType::where('admin_id', $request->admin_id)->get();

        return $this->respondSuccess($types);
    }

    /**
    * Create Vehicle type
    *
    */
    public function create()
    {
        $page = trans('pages_names.add_type');
        // $services = ServiceLocation::whereActive(true)->get();
        $main_menu = 'master';
        $sub_menu = 'sports';
        $sub_menu_1 = '';
        return view('admin.sports.create', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));
    }

 
    /**
    * Edit Vehicle type view
    *
    */
    public function edit($id)
    {   
        $page = trans('pages_names.edit_type');
        $type = $this->vehicle_type->where('id', $id)->first();
        // dd($type->is_taxi);
        // $admins = User::doesNotBelongToRole(RoleSlug::SUPER_ADMIN)->get();
        // $services = ServiceLocation::whereActive(true)->get();
        $main_menu = 'master';
        $sub_menu = 'sports';
        $sub_menu_1 = '';
        return view('admin.sports.update', compact('page', 'type', 'main_menu', 'sub_menu','sub_menu_1'));
    }
 
    public function cancel_booking(SportsBooking $booking)
    {
         $booking = SportsBooking::find($booking->id);
         $booking->status = 2; 
         $booking->cancelled_by = auth()->user()->id;
         $timezone = 'Asia/Kolkata'; 
         // Get the current date and time in the specified timezone
         $currentDateTime = Carbon::now($timezone); 
         $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
         $booking->cancelled_on = $formattedDateTime;
         $booking->save();
         $message = [
            "status" => true,
            "message" => "Booking Cancelled Successfully",
         ];
         return response()->json($message);
    }
    public function confirm_booking(SportsBooking $booking)
    {
         $booking = SportsBooking::find($booking->id); 
         $booking->is_paid =  1;  
         $booking->status =  3;  
         $booking->save();
         $invoice = new Invoice();
         $invoice_number = Invoice::orderBy('created_at', 'DESC')->pluck('invoice_number')->first();
         if ($invoice_number) {
            // Extract the numeric part from the userid
            preg_match('/(\d+)$/', $invoice_number, $matches);
            $numberPart = isset($matches[1]) ? intval($matches[1]) + 1 : 500001; // Increment or default to 1001 if not found
            $invoice_number = str_pad($numberPart, 6, '0', STR_PAD_LEFT); // Ensure the number part is at least 4 digits
        } else {
            $invoice_number = "500001"; // Default userid
        } 
        $invoice->invoice_number =  $invoice_number;
        $invoice->booking_id =  $booking->id;
        $invoice->customer_id =  $booking->user_id;
        $now = Carbon::now('Asia/Kolkata');
        $invoice->issue_date =  $now->format("Y-m-d");
        $invoice->due_date =  $booking->checkin_date;
        $invoice->total_amount =  $booking->tariff; 
        $invoice->type =  2;
        $invoice->status =  1;
        $invoice->save(); 
         $message = [
            "status" => true,
            "message" => "Payment Done Successfully",
         ];
         return response()->json($message);
    }
    /**
    * Get Types by admin for ajax
    *cancel_booking
    */
    public function view_invoice(Request $request,QueryFilterContract $queryFilter,SportsBooking $booking)
    { 
        $page = trans('pages_names.types');
        $main_menu = 'master';
        $sub_menu = 'types';
        $sub_menu_1 = '';
        $query = SportsBooking::where('booked_by',auth()->user()->id); 
        $invoice = Invoice::where('booking_id',$booking->id)->first(); 
        $checkinDate = Carbon::parse($booking->checkin_date);

        // Get the current date
        $currentDate = Carbon::now('Asia/kolkata');

        // Calculate the difference in days between the current date and the check-in date
        $daysDifference = $currentDate->diffInDays($checkinDate);
       $date_diff = $checkinDate->day - $currentDate->day;
        
        // dd($daysDifference);
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();
        // dd($results->)
        // dd($booking->booked_price);
        return view('admin.sports_booking.invoice', compact('page', 'main_menu', 'sub_menu','sub_menu_1','booking','date_diff','invoice'))->render();
    }
}
