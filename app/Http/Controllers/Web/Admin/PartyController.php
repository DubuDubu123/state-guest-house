<?php

namespace App\Http\Controllers\Web\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\PartyBooking;
use App\Models\Tariff;
use App\Models\PartyTariff;
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


/**
 * @resource Vechicle-Types
 *
 * vechicle types Apis
 */
class PartyController extends BaseController
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
        $sub_menu = 'party';
        $sub_menu_1 = '';
        $user = $this->user->belongsTorole(Role::USER)->get(); 
        return view('admin.party.index', compact('page', 'main_menu', 'sub_menu','sub_menu_1','user'))->render();
    }

    
    public function view(Request $request,QueryFilterContract $queryFilter,PartyBooking $booking)
    {  
        $page = trans('pages_names.types');
        $main_menu = 'master';
        $sub_menu = 'party';
        $sub_menu_1 = ''; 
        $checkinDate = Carbon::parse($booking->checkin_date); 
        // Get the current date
        $currentDate = Carbon::now('Asia/kolkata'); 
        // Calculate the difference in days between the current date and the check-in date
        $daysDifference = $currentDate->diffInDays($checkinDate);
       $date_diff = $checkinDate->day - $currentDate->day;
         
        return view('admin.party.view', compact('page', 'main_menu', 'sub_menu','sub_menu_1','booking','date_diff'))->render();
    }

     /**
    * Edit Vehicle type view
    *
    */
    public function edit(PartyBooking $booking)
    {   
        // dd($booking);
        $page = trans('pages_names.edit_type'); 
        // dd($type->is_taxi);
        // $admins = User::doesNotBelongToRole(RoleSlug::SUPER_ADMIN)->get();
        // $services = ServiceLocation::whereActive(true)->get();
        $main_menu = 'master';
        $sub_menu = 'party';
        $sub_menu_1 = '';
        $user = $this->user->belongsTorole(Role::USER)->get(); 
        return view('admin.party.update', compact('page','main_menu', 'sub_menu','sub_menu_1','user','booking'));
    }
    public function check_availability(Request $request)
    { 
        // dd(request()->all());
        $currentDate = Carbon::now()->toDateString(); 
      
            $user_id = auth()->user()->id;
            if(isset($request->user))
            { 
                $user_id = $request->user;
            } 
            // dd($request->id);
            if(isset($request->id))
            {
                $isBooked =PartyBooking::whereDate('checkin_date', $request->from_date)->where('id', '!=',$request->id)
                ->exists(); 
            }
            else{
                $isBooked =PartyBooking::whereDate('checkin_date', $request->from_date)
                ->exists();  
            }

        if ($isBooked) {
            $response = [
                "status" => false,
                "message" => "No Party is Available"
            ];
            return response()->json($response);
            // The current date is booked
            // Handle the booked scenario
        } else {
            $currentMonthStart = Carbon::now()->startOfMonth();
            $currentMonthEnd = Carbon::now()->endOfMonth();
            $user_id = auth()->user()->id;
            if(isset($request->user))
            { 
                $user_id = $request->user;
            }
            // Retrieve the count of bookings for the current month
            $bookingCount = PartyBooking::whereBetween('checkin_date', [$currentMonthStart, $currentMonthEnd])->where('user_id',$user_id)->count();
                if($bookingCount > 10)
                {
                    $response = [
                        "status" => false,
                        "message" => "You have reached Maximum no of Bookings"
                    ];
                    return response()->json($response);
                }
                else{
                    $response = [
                        "status" => true,
                        "message" => "Party Hall is Available"
                    ];
                    return response()->json($response);
                }
            // The current date is not booked
            // Handle the available scenario
        }
    }
    public function book_now(Request $request){
        // dd($request->all());
        if(isset($request->id))
        {
            $bookings =  PartyBooking::find($request->id); 
        }
        else{
            $bookings =  new PartyBooking(); 
        }   
        $bookings->booking_id = time();
        $bookings->checkin_date = $request->from_date;  
        $bookings->guest_type = $request->guest_type;
        // $bookings->booking_count = $booking_counts;
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        $user_id = auth()->user()->id;
        if(isset($request->user))
        { 
            $user_id = $request->user;
        }
        // Retrieve the count of bookings for the current month
        $bookingCount = PartyBooking::whereBetween('checkin_date', [$currentMonthStart, $currentMonthEnd])->where('user_id',$user_id)
            ->count();
        $starting_count = $bookingCount; 
        $end_count = $bookingCount + 1; 
        $tariff = Tariff::where('day',$end_count)->first();
        if($request->guest_type == "guest")
        { 
            $price =$tariff->rent_for_others;
        }
        else{ 
            $price =$tariff->rent_for_officers_family;
        }   
        $total_price = $price;
        $bookings->party_amount = $price;
        $bookings->is_lawn = 0;
        $bookings->lawn_amount = 0;
        if($request->lawn)
        {
            $bookings->is_lawn = 1;
            $bookings->lawn_amount = $price;
            $total_price = $price * 2;
        }

         
        $bookings->tariff = $price; 
        $bookings->tariff = $total_price;
        $bookings->user_id = $user_id;
        $bookings->booked_by = auth()->user()->id;
        $bookings->save();
        $response = [
            "status" => true,
            "message" => "Booking Confirmed Successfully"
        ];
        return response()->json($response);
    }
    public function getAllTypes(QueryFilterContract $queryFilter)
    {
        $query = PartyBooking::where('booked_by',auth()->user()->id)->orderBy('created_at','desc');
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();
        return view('admin.party._types', compact('results'))->render();
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
        $sub_menu = 'party';
        $sub_menu_1 = '';
        return view('admin.party.create', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));
    }


    /**
     * Store Vehicle type.
     *
     * @param \App\Http\Requests\Admin\VehicleTypes\CreateVehicleTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @response
     * {
     *"success": true,
     *"message": "success"
     *}
     */
    public function store(CreateVehicleTypeRequest $request)
    {
    if (auth()->user()->hasRole(!(Role::ADMIN))) {

         if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('party')->with('warning', $message);
        }
    }
        // dd($request->transport_type);
        $created_params = $request->only(['name', 'capacity','is_accept_share_ride','description','supported_vehicles','short_description', 'transport_type','icon_types_for']);

        if ($uploadedFile = $this->getValidatedUpload('icon', $request)) {
            $created_params['icon'] = $this->imageUploader->file($uploadedFile)
                ->saveVehicleTypeImage();
        }
        $created_params['active'] = true;
        $created_params['created_by'] = auth()->user()->id;


        $created_params['is_taxi'] = $request->transport_type;


        $this->vehicle_type->create($created_params);

        $message = trans('succes_messages.type_added_succesfully');

        return redirect('party')->with('success', $message);
    }

    

    /**
     * Update Vehicle type.
     *
     * @param \App\Http\Requests\Admin\VehicleTypes\CreateVehicleTypeRequest $request
     * @param App\Models\Admin\VehicleType $vehicle_type
     * @return \Illuminate\Http\JsonResponse
     * @response
     * {
     *"success": true,
     *"message": "success"
     *}
     */
    public function update(UpdateVehicleTypeRequest $request, VehicleType $vehicle_type)
    {
    if (auth()->user()->hasRole(!(Role::ADMIN))) {

        if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('party')->with('warning', $message);
        }
    }
        // dd($request->all());
        $this->validateAdmin();
        $created_params = $request->only(['name', 'capacity','is_accept_share_ride','description','supported_vehicles','short_description','transport_type','icon_types_for']);

        if ($uploadedFile = $this->getValidatedUpload('icon', $request)) {
            $created_params['icon'] = $this->imageUploader->file($uploadedFile)
                ->saveVehicleTypeImage();
        }

        $created_params['is_taxi'] = $request->transport_type;
       
        $created_params['updated_by'] = auth()->user()->id;

        $vehicle_type->update($created_params);

        $message = trans('succes_messages.type_updated_succesfully');
        // clear the cache
        cache()->tags('vehilce_types')->flush();
        return redirect('party')->with('success', $message);
    }
    public function toggleStatus(VehicleType $vehicle_type)
    {
        if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('party')->with('warning', $message);
        }
        
        $status = $vehicle_type->active == 1 ? 0 : 1;
        $vehicle_type->update([
            'active' => $status
        ]);

        $message = trans('succes_messages.type_status_changed_succesfully');
        return redirect('party')->with('success', $message);
    }
    /**
     * Delete Vehicle type.
     *
     * @param App\Models\Admin\VehicleType $vehicle_type
     * @return \Illuminate\Http\JsonResponse
     * @response
     * {
     *"success": true,
     *"message": "success"
     *}
     */

    public function delete(VehicleType $vehicle_type)
    {
        if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('party')->with('warning', $message);
        }

        $vehicle_type->delete();

        $message = trans('succes_messages.vehicle_type_deleted_succesfully');
        return $message;
    }

    public function cancel_booking(PartyBooking $booking)
    {
         $booking = PartyBooking::find($booking->id);
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
}
