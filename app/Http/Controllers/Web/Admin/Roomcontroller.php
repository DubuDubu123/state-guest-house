<?php

namespace App\Http\Controllers\Web\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\RoomBooking;
use App\Models\PartyBooking;
use App\Models\SportsBooking;
use App\Models\RoomBookingPrice;
use App\Models\RoomBookingGuest;
use App\Models\Tariff;
use App\Models\Invoice;
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
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Collection; 
use PDF;

    /**
     * @resource Vechicle-Types
     *
     * vechicle types Apis
     */
    class Roomcontroller extends BaseController
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
            $sub_menu = 'types';
            $sub_menu_1 = '';
            $user = $this->user->belongsTorole(Role::USER)->get();    
            return view('admin.types.index', compact('page', 'main_menu', 'sub_menu','sub_menu_1','user'))->render();
        }

        public function getAllTypes(QueryFilterContract $queryFilter)
        {
            if(auth()->user()->hasRole('super-user') || auth()->user()->hasRole('mess-manager'))
            {
                $query = RoomBooking::query();
            }
            else{
                $query = RoomBooking::where('user_id',auth()->user()->id);
            }  
            $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();
            return view('admin.types._types', compact('results'))->render();
        }

        /**
        * Get Types by admin for ajax
        *cancel_booking
        */
        public function view(Request $request,QueryFilterContract $queryFilter,RoomBooking $booking)
        { 
            $page = trans('pages_names.types');
            $main_menu = 'master';
            $sub_menu = 'types';
            $sub_menu_1 = '';
            $query = RoomBooking::where('booked_by',auth()->user()->id); 
            $checkinDate = Carbon::parse($booking->checkin_date);
            $checkout_date = Carbon::parse($booking->checkout_date);

            // Get the current date
            $currentDate = Carbon::now('Asia/kolkata');

            // Calculate the difference in days between the current date and the check-in date
            $daysDifference = $currentDate->diffInDays($checkinDate);
            $date_diff = $checkinDate->day - $currentDate->day;
            $date_diff1 = $checkout_date->day - $currentDate->day;
            
            // dd($daysDifference);
            $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();
            return view('admin.types.view', compact('page', 'main_menu', 'sub_menu','sub_menu_1','booking','date_diff'))->render();
        }
        /**
        * Get Types by admin for ajax
        *
        */
        public function book_now(Request $request)
        {
            // dd($request->all());
            $now = Carbon::now('Asia/Kolkata');
            // Get the start and end of the current month
            $startOfMonth = $now->startOfMonth()->format('Y-m-d H:i:s'); 
            $endOfMonth = $now->endOfMonth(); 
            $user_id = auth()->user()->id;
            if(isset($request->user))
            { 
                $user_id = $request->user;
            }
            // dd($request->user);
            // Query to get bookings that overlap with the current month
            if(isset($request->id))
            {
                $totalDaysBooked = RoomBooking::whereBetween('checkin_date', [$startOfMonth, $endOfMonth])
                ->where('user_id',$user_id)
                ->whereIn('status',[0,1,3])
                ->where('id', '!=',$request->id)
                ->get();
                
            }
            else{
                $totalDaysBooked = RoomBooking::whereBetween('checkin_date', [$startOfMonth, $endOfMonth])
                ->where('user_id',$user_id)
                ->whereIn('status',[0,1,3])
                ->get(); 
            }
            
            $booking_count = 0;
            foreach($totalDaysBooked as $key=>$value)
            {
                $checkin = Carbon::parse($value->checkin_date);
                $checkout = Carbon::parse($value->checkout_date);
                $month_differ = $checkout->month - $checkin->month;
                if($month_differ > 0)
                { 
                    $day_count = $endOfMonth->day - $checkin->day; 
                    if($day_count == 0)
                    {
                        $booking_count+=1;
                    }
                    else{
                        $booking_count+=$day_count;
                    }
                }
                else{
                        $booking_count+=$value->booking_count;
                }
            } 
            // dd($user_id);
            $checkinDatetime = Carbon::createFromFormat('Y-m-d', $request->from_date, 'Asia/Kolkata')->startOfDay()->format('Y-m-d H:i:s');
            $checkoutDatetime = Carbon::createFromFormat('Y-m-d', $request->to_date, 'Asia/Kolkata')->endOfDay()->format('Y-m-d H:i:s'); 

            $checkinDate = $request->input('from_date'); 
            $checkoutDate = $request->input('to_date'); 
            // Convert strings to Carbon instances
            $checkin = Carbon::createFromFormat('Y-m-d', $checkinDate);
            $checkout = Carbon::createFromFormat('Y-m-d', $checkoutDate);

            // Calculate the difference in days
            $differenceInDays = $checkin->diffInDays($checkout); 
            $booking_counts = $differenceInDays * $request->room;
            // if($booking_counts > 10)
            // {
            //     $response = [
            //         "status" => false,
            //         "message" => "Only you can able to make 10 bookings, Limit is reached"
            //     ];
            //     return response()->json($response);
            // } 
            
            if(isset($request->id))
            {
                $bookings =  RoomBooking::find($request->id); 
            }
            else{
                $bookings =  new RoomBooking(); 
            }
            // dd($user_id); 
            $bookings->booking_id = time();
            $bookings->checkin_date = $checkinDatetime;
            $bookings->checkout_date = $checkoutDatetime;
            $bookings->no_of_rooms = $request->room;
            $bookings->no_of_guests = $request->guest;
            $bookings->no_of_days = $differenceInDays;
            // $bookings->guest_type = $request->guest_type;
            $bookings->booking_count = $booking_counts;
            $starting_count = $booking_count + 1; 
            $end_count = $booking_counts + $booking_count;  
            $end_count1 = $differenceInDays + $booking_count;  
            $tariff = Tariff::get();
            $price = 0; 
            $bookings->tariff = $price;
            $bookings->user_id = $user_id;
            $bookings->booked_by = auth()->user()->id;
            if(isset($request->id))
            {  
                $bookings->modified_by = $user_id;
                $timezone = 'Asia/Kolkata'; 
                // Get the current date and time in the specified timezone
                $currentDateTime = Carbon::now($timezone); 
                $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
                $bookings->modified_on = $formattedDateTime;
            }
            if($end_count > 5)
            {
                $bookings->is_admin_approve = 0;
                // if(isset($request->id))
                // {  
                    if(auth()->user()->hasRole("super-user"))
                    {
                        $bookings->is_admin_approve = 1;
                    }
                // }   
            }
            
            $bookings->save();
            
            $room_price_details = new \stdClass();
            
            $counts = 0;
            $per_day_price = 0;
            $per_day_price_guest = 0;
            for($i=1;$i<=$differenceInDays;$i++)
            {  
                for($k=1;$k<=$request->room;$k++)
                { 
                    $room_price_details->pricing_details[$counts] =  new \stdClass();
                    if($starting_count > 5)
                    {
                        $tariff = Tariff::where('day',6)->first();
                    }
                    else{
                        $tariff = Tariff::where('day',$starting_count)->first();
                    }
                    
                    $room_price_details->pricing_details[$counts]->days_count = $starting_count;
                    if($request->guest_type[$k] == "guest")
                    { 
                        
                        $room_price_details->pricing_details[$counts]->price = $tariff->rent_for_others;
                        $per_day_price+=$tariff->rent_for_others;
                        $price+=$tariff->rent_for_others;
                        $roombooking_price[$k]['price'] = $per_day_price;
                        $roombooking_price[$k]['guest_type'] = $request->guest_type[$k];

                    }
                    else{ 
                        $room_price_details->pricing_details[$counts]->price = $tariff->rent_for_officers_family;
                        $per_day_price_guest+=$tariff->rent_for_officers_family;
                        $price+=$tariff->rent_for_officers_family;
                        $roombooking_price[$k]['price'] = $per_day_price_guest;
                        $roombooking_price[$k]['guest_type'] = $request->guest_type[$k];
                    } 
                    $room_price_details->pricing_details[$counts]->guest_type = $request->guest_type[$k];
                    $starting_count++;
                    $counts++; 
                } 

            } 
        
            $k = 1;
            if(isset($request->id))
            {
            RoomBookingGuest::where('booking_id',$bookings->id)->delete();
            }
            // dd($roombooking_price);
            foreach($roombooking_price as $key=>$value)
            {
                // dd($value);
                $room_booking_guest = new RoomBookingGuest();  
                $room_booking_guest->booking_id = $bookings->id;
                $room_booking_guest->room = $k;
                $room_booking_guest->per_day_price = $value['price'];
                $room_booking_guest->guest_type = $value['guest_type'];
                $room_booking_guest->save();
                $k++;
            }
            
            // dd($room_price_details);
            // foreach($tariff as $key=>$value)
            // {
            //     for($i=$starting_count;$i<=$end_count1;$i++)
            //     { 
            //         if($value->day == $i)
            //         {
            //             if($request->guest_type == "guest")
            //             { 
            //                 $price+=$value->rent_for_others;
            //             }
            //             else{ 
            //                 $price+=$value->rent_for_officers_family;
            //             }
            //         }
            //     }
            // } 
            if(isset($request->id))
            {
                $booking_price= RoomBookingPrice::where('booking_id',$request->id)->first();
            }

            else{
                $booking_price= new RoomBookingPrice();
            }
        
            $booking_price->booking_id = $bookings->id;
            $booking_price->room_price_details =json_encode($room_price_details); 
            $booking_price->total_price = $price;
            $booking_price->amount_need_to_paid = $price;
            $booking_price->save();
            //  dd("gdfgf");
            if($end_count > 5)
            {  
                $response = [
                        "status" => true,
                        "message" => "Booking confirmation request submitted for Admin approval. Updates will be sent to the registered mobile number and email at the earliest."
                    ];
                if(auth()->user()->hasRole("super-user"))
                {
                    $response = [
                    "status" => true,
                    "message" => "Booking Confirmed Successfully"
                ];
                
                } 
            }
            else{
                $response = [
                    "status"=> true,
                    "message" => "Booking Confirmed Successfully"
                ]; 
            } 
            return response()->json($response);

        }

        /**
        * Create Vehicle type
        *
        */
        public function check_availability(Request $request)
        {
            $user_id = auth()->user()->id;
            if(isset($request->user))
            { 
                $user_id = $request->user;
            } 
            // dd($request->id);
            if(isset($request->id))
            {
                $bookings = RoomBooking::where(function($query) use ($request) {
                    $query->whereBetween('checkin_date', [$request->from_date, $request->to_date])
                        ->orWhereBetween('checkout_date', [$request->from_date, $request->to_date]);
                }) 
                ->whereIn('status',[0,1]) 
                ->where('id', '!=',$request->id)
                ->get(); 
            }
            else{
                $bookings = RoomBooking::where(function($query) use ($request) {
                    $query->whereBetween('checkin_date', [$request->from_date, $request->to_date])
                        ->orWhereBetween('checkout_date', [$request->from_date, $request->to_date]);
                }) 
                ->whereIn('status',[0,1]) 
                                    ->get();
            } 
            // dd($bookings);
            // if(count($bookings) == 0)
            // {
                $checkinDate = $request->input('from_date'); // e.g., '2024-06-21'
                $checkoutDate = $request->input('to_date'); // e.g., '2024-06-22'
        
                // Convert strings to Carbon instances
                $checkin = Carbon::createFromFormat('Y-m-d', $checkinDate);
                $checkout = Carbon::createFromFormat('Y-m-d', $checkoutDate);
        
                // Calculate the difference in days
                $differenceInDays = $checkin->diffInDays($checkout); 
                $booking_count = 0;
                $requested_count = $differenceInDays * $request->room;
                $booking_count = $differenceInDays * $request->room;
                $dates = new Collection(); 
                $startDate = Carbon::parse($request->from_date);
                $endDate = Carbon::parse($request->to_date); 
            
    while ($startDate->lte($endDate)) {
        $dates->push(['date' => $startDate->format('Y-m-d'), 'room_count' => 0]);
        $startDate->addDay();
    }

    $room_available_status = 1;

    // Iterate over bookings
                foreach ($bookings as $booking) {
                    $checkinDate = Carbon::parse($booking->checkin_date);
                    $checkoutDate = Carbon::parse($booking->checkout_date);
                    
                    // Iterate over each date and check if it falls within the booking period
                    $dates = $dates->map(function ($date) use ($checkinDate, $checkoutDate, $booking) {
                        $checkDate = Carbon::createFromFormat('Y-m-d', $date['date']);
                        
                        if ($checkDate->between($checkinDate, $checkoutDate)) {
                            $date['room_count'] += $booking->no_of_rooms;
                        }
                        
                        return $date;
                    });
                }
                $room_tariff = Tariff::get();
                $room_count = $room_tariff[0]->total_rooms;
                //  dd($dates);
                foreach($dates as $key=>$value)
                {
                $reduce_count = $room_count - $value['room_count']; 
                if($reduce_count >= $request->room)
                {
                    $room_available_status = 1;
                }
                else{
                    $room_available_status = 0;
                    break;
                }
                }
                if(!$room_available_status) 
                {
                    $response = [
                                    "status" => false,
                                    "message" => "Rooms are unavailable for the requested date. Please check the room availability tab and proceed with your booking"
                                    ];
                                        return response()->json($response);
                }
                // exit;
    // dd($dates);
                // if($booking_count > 10)
                // {
                //     $response = [
                //         "status" => false,
                //         "message" => ""
                //     ];
                //     return response()->json($response);
                // }
                // else{ 
                    $count = 0;
                    $now = Carbon::now('Asia/Kolkata');
                    $startOfMonth = $now->startOfMonth()->format('Y-m-d H:i:s'); 
                    $endOfMonth = $now->endOfMonth();
                    if(isset($request->id))
                    {
                        $totalDaysBooked = RoomBooking::whereBetween('checkin_date', [$startOfMonth, $endOfMonth])
                        ->where('user_id',$user_id)
                        ->whereIn('status',[0,1,3])
                        ->where('id', '!=',$request->id)
                        ->get(); 
                    }
                    else{
                        $totalDaysBooked = RoomBooking::whereBetween('checkin_date', [$startOfMonth, $endOfMonth])
                        ->where('user_id',$user_id)
                        ->whereIn('status',[0,1,3])
                        ->get(); 
                    } 
                    $booked_count = 0;
                    foreach($totalDaysBooked as $key=>$value)
                    {
                        $checkin = Carbon::parse($value->checkin_date);
                        $checkout = Carbon::parse($value->checkout_date);
                        $month_differ = $checkout->month - $checkin->month;
                        if($month_differ > 0)
                        { 
                        $day_count = $endOfMonth->day - $checkin->day; 
                        if($day_count == 0)
                        {
                        $booked_count+=1;
                        }
                        else{
                        $booked_count+=$day_count;
                        }
                        }
                        else{
                        $booked_count+=$value->booking_count;
                        }
                    } 
                    if($booked_count >= 5)
                    {
                        $response = [
                                "status" => true,
                                "message" => "Monthly quota of 5 days/rooms exceeded. Booking requires Admin approval."
                            ];
                            return response()->json($response);
                    }
                    $req_booked_count = $requested_count + $booked_count;
                    // if($booked_count == 10)
                    // {
                    //     $response = [
                    //         "status" => false,
                    //         "message" => "Booking limit Exceeded for the month. Remaining days available: 0"
                    //     ];
                    //     return response()->json($response);
                    // }
                
                //    dd($req_booked_count);
                    if($req_booked_count > 5)
                    {
                        $response = [
                                "status" => true,
                                "message" => "Please note, that this month's quota of 5 days/rooms has been completed. Booking will require Admin approval"
                            ];
                            return response()->json($response);

                    }
                    else{
                        $response = [
                                "status" => true,
                                "message" => "Room is Available. Please Proceed!"
                            ];
                            return response()->json($response);
                    }
                    $count = 0;
                    // dd($bookings);
                    foreach($bookings as $key=>$value)
                    {   
                        $count+=$value->no_of_rooms;
                    } 
                
                
                    // dd($count);
                    if($count < $room_count)
                    { 
                        $reduce_count = $room_count - $count;
                        
                        if($request->room <= $reduce_count)
                        {
                            $response = [
                                "status" => true,
                                "message" => "Room is Available. Please Proceed!"
                            ];
                            return response()->json($response);
                        }
                        else{

                            // dd("test");
                            // dd("gfdgfd");
                            $response = [
                                "status" => false,
                                "message" => "Rooms are unavailable for the requested date. Please check the room availability tab and proceed with your booking"
                            ];
                            return response()->json($response);
                        }
                    }
                    else{
                        $response = [
                            "status" => false,
                            "message" => "Rooms are unavailable for the requested date. Please check the room availability tab and proceed with your booking"
                        ];
                        return response()->json($response);
                    } 
                // }
            
            
            // } 
            return response()->json($response);
        }


        public function availability_view()
        { 
            $page = trans('pages_names.types');
            $main_menu = 'availabilty-view';
            $sub_menu = 'types';
            $sub_menu_1 = '';
            $user = $this->user->belongsTorole(Role::USER)->get(); 
            return view('admin.types.availability_view', compact('page', 'main_menu', 'sub_menu','sub_menu_1','user'))->render(); 
        }
        public function availability_view_fetch(QueryFilterContract $queryFilter,Request $request)
        { 
            $start_ite = 0;
            $end_ite = 9;
            if($request->date_value)
            {
                $date_value = $request->date_value;
                switch ($date_value) {
                    case 1:
                        $fromDate = Carbon::createFromFormat('Y-m-d', $request->input('from_date'))->startOfDay();
                        $toDate = Carbon::createFromFormat('Y-m-d', $request->input('to_date'))->endOfDay(); 
                        $end_ite = 0;
                        break;
                    case 2:
                        
                        $fromDate = Carbon::today('Asia/Kolkata')->startOfDay();
                        $toDate = Carbon::today('Asia/Kolkata')->endOfDay(); 
                        $end_ite = 0;
                        break;
                    case 3:
                        $fromDate = Carbon::now('Asia/Kolkata')->startOfWeek();
                        $toDate = Carbon::now('Asia/Kolkata')->endOfWeek();  
                        $end_ite = 6;
                        break;
                    case 4:
                        $fromDate = Carbon::now('Asia/Kolkata')->startOfMonth();
                        $toDate = Carbon::now('Asia/Kolkata')->endOfMonth(); 
                        break;
                    case 5:
                        $fromDate = Carbon::now('Asia/Kolkata')->startOfYear();
                        $toDate = Carbon::now('Asia/Kolkata')->endOfYear();  
                        break;
                
                }
                if(isset($request->type) && $request->type > 1)
                {
                    $type = $request->type;
                    $next_page = ($request->type - 1) * 10;
                    $now = Carbon::now('Asia/Kolkata')->addDays($next_page); // Format the current date as Y-m-d
                    $currentDate = $now->format('Y-m-d H:i:s'); 
                }
                else{
                    $type = 1;
                    $now = Carbon::now('Asia/Kolkata');
                    $currentDate = $now->format('Y-m-d');
                } 
            } 
            else{
                if(isset($request->type) && $request->type > 1)
                {
                    $type = $request->type;
                    $next_page = ($request->type - 1) * 10;
                    $now = Carbon::now('Asia/Kolkata')->addDays($next_page); // Format the current date as Y-m-d
                    $currentDate = $now->format('Y-m-d H:i:s'); 
                }
                else{
                    $type = 1;
                    $now = Carbon::now('Asia/Kolkata');
                    $currentDate = $now->format('Y-m-d');
                } 
            }
            
            $nextnine_days = $now->copy()->addDays(9)->format('Y-m-d H:i:s');  
            $tariff = Tariff::get();
            $room_count = $tariff[0]->total_rooms;
            $data_content = ' <div class="box-body no-padding"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>Date</th>';
            for($i=1;$i<=$room_count;$i++)
            {
                $data_content.=' <th>Room '.$i.'</th>';
            }
            $data_content.= '</thead><tbody>';

        
            for($i=0;$i<=9;$i++)
            { 
                $nextDay = $now->copy()->addDays($i)->format('Y-m-d'); 
                $total_booking_count = RoomBooking::where(function($query) use ($nextDay) {
                    $query->whereDate('checkin_date', '<=', $nextDay)
                        ->whereDate('checkout_date', '>=', $nextDay);
                })
                ->whereIn('status', [0, 1]) 
                ->selectRaw('SUM(no_of_rooms) as total_booking_count')
                ->first();  
                $date_format = $now->copy()->addDays($i)->format('d-M-Y');
                $tr_content = '<tr>';
                $tr_content.='<td style=" background-color: #a7a7ff;color: white;"> '.$date_format.'</td>';
                for($k=1;$k<=$room_count;$k++)
                { 
                    if($total_booking_count->total_booking_count != null)
                    {
                        if($k <= $total_booking_count->total_booking_count)
                        { 
                            $tr_content.='<td style=" background-color: red;color: white;"> Reserved</td>';
                        }
                        else{  
                            $tr_content.='<td style="background-color: green;color: white; "> Available</td>';
                        }
                    }
                    else{  
                        $tr_content.='<td style="background-color: green;color: white; "> Available</td>';
                    } 
                }
                $tr_content.="</tr>"; 
                $data_content.=$tr_content;
            } 



            $data_content.='</tbody></table><div class="text-right"><span style="float:right"><nav><ul class="pagination">';
            // dd($data_content);
            $nextnine_days = $now->copy()->addDays(9)->format('Y-m-d');
            $endOfYear = $now->copy()->addYear()->format('Y-m-d');
            $daysDifference = $now->diffInDays($endOfYear); 
            $count = ceil($daysDifference / 10); 
            // Pagination logics
            $current_page = $type;
            $first_page = 1;
            $last_page = $count;
            $total_pagination_length = 11;
            $double_date_possiblity =  ceil($total_pagination_length / 2) + 1; 
            $front_dot_validity = $double_date_possiblity;
            $back_dot_validity = $last_page - $double_date_possiblity; 
            $center_view = 7;
                    
            // Previous button
            if ($current_page == $first_page) {
                $data_content .= '<li class="page-item disabled"><span class="page-link" aria-hidden="true">&lsaquo;</span></li>';
            } else {
                $data_content .= '<li class="page-item"><span class="page-link" aria-hidden="true">&lsaquo;</span></li>';
            }
            $min = 1;
            // Front dots
            if ($type > $first_page + 5) { // Adjusted to +2 for showing two pages before dots
                $min = $type - 2;
                $data_content .= '<li class="page-item"><a class="page-link" href="'.url('/').'/types/availability-view/fetch">1</a></li>';
                $data_content .= '<li class="page-item"><a class="page-link" href="'.url('/').'/types/availability-view/fetch?type=2">2</a></li>'; // Added the second page
                $data_content .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }  
            $content = "";
            // Back dots
            if ($type < $last_page - 5) { // Adjusted to -2 for showing two pages after dots
                if ($type > $first_page + 5) {
                    $max = $type + 2;
                }
                else{
                    $max = $first_page + $center_view;
                } 
                $content .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
                $content .= '<li class="page-item"><a class="page-link" href="'.url('/').'/types/availability-view/fetch?type='. ($last_page - 1) .'">' . ($last_page - 1) . '</a></li>'; // Added the second to last page
                $content .= '<li class="page-item"><a class="page-link" href="'.url('/').'/types/availability-view/fetch?type='.$last_page.'">'.$last_page.'</a></li>';
            } else{
                $min = $last_page - $center_view; 
                $max =  $last_page; 
            } 
            for ($i = $min; $i <= $max; $i++) {
                if ($i == $type) {
                    $data_content .= '<li class="page-item active"><span class="page-link">'.$i.'</span></li>';
                } else {
                    $data_content .= '<li class="page-item"><a class="page-link" href="'.url('/').'/types/availability-view/fetch?type='.$i.'">'.$i.'</a></li>';
                }
            } 
            $data_content .=$content; 
            // Next button
            if ($type == $last_page) {
                $data_content .= '<li class="page-item disabled"><span class="page-link" aria-hidden="true">&rsaquo;</span></li>';
            } else {
                $data_content .= '<li class="page-item"><a class="page-link" href="'.url('/').'/types/availability-view/fetch?type='.($type+1).'">&rsaquo;</a></li>';
            } 
            $data_content.='</ul></nav></span></div></div></div>';   
            // dd($results->links());
            return view('admin.types.availability_view_types', compact('data_content'))->render(); 
        }
    
        /**
        * Edit Vehicle type view
        *
        */
        public function edit(RoomBooking $booking)
        {   
            // dd($booking);
            $page = trans('pages_names.edit_type'); 
            // dd($type->is_taxi);
            // $admins = User::doesNotBelongToRole(RoleSlug::SUPER_ADMIN)->get();
            // $services = ServiceLocation::whereActive(true)->get();
            $main_menu = 'master';
            $sub_menu = 'types';
            $sub_menu_1 = '';
            // dd($booking->booking_guest_details);
            $user = $this->user->belongsTorole(Role::USER)->get(); 
            return view('admin.types.update', compact('page','main_menu', 'sub_menu','sub_menu_1','user','booking'));
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

                return redirect('types')->with('warning', $message);
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
            return redirect('types')->with('success', $message);
        }
        public function toggleStatus(VehicleType $vehicle_type)
        {
            if (env('APP_FOR')=='demo') {
                $message = trans('succes_messages.you_are_not_authorised');

                return redirect('types')->with('warning', $message);
            }
            
            $status = $vehicle_type->active == 1 ? 0 : 1;
            $vehicle_type->update([
                'active' => $status
            ]);

            $message = trans('succes_messages.type_status_changed_succesfully');
            return redirect('types')->with('success', $message);
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

                return redirect('types')->with('warning', $message);
            }

            $vehicle_type->delete();

            $message = trans('succes_messages.vehicle_type_deleted_succesfully');
            return $message;
        }
        public function cancel_booking(RoomBooking $booking)
        {
            $booking = RoomBooking::find($booking->id);
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
        public function approve_booking(RoomBooking $booking)
        {
            $booking = RoomBooking::find($booking->id);
            $booking->is_admin_approve = 1;   
            $booking->save();
            $message = [
                "status" => true,
                "message" => "Booking Confirmed Successfully",
            ];
            return response()->json($message);
        }
        public function export(RoomBooking $booking)
        {  
            
            $room_booking_price = RoomBookingPrice::where('booking_id',$booking->id)->first();
            $booking_guest_details = RoomBookingGuest::where('booking_id',$booking->id)->get();
            // dd($booking_guest_details);
            $invoice = Invoice::where('booking_id',$booking->id)->first();
            $user_details = User::where('id',$booking->user_id)->first();
            // dd($booking);
            $data = [
                'booking' => $booking->toArray(),
                'invoice' => $invoice->toArray(),
                'booking_guest_details' => $booking_guest_details->toArray(),
                'room_booking_price' => $room_booking_price->toArray(),
                'user_details' => $user_details->toArray()
            ];
            // print_r($data);
            // exit;
            $pdf = PDF::loadView('pdf.user', $data);  
            return $pdf->download('invoice_'.time().'.pdf');
        }
        public function confirm_checkin(RoomBooking $booking,Request $request)
        { 
            // dd($request->all());
        
            // dd($request->all());
            $now = Carbon::now('Asia/Kolkata');
            // Get the start and end of the current month
            $checkin_times = $now->format('Y-m-d H:i:s'); 
            $startOfMonth = $now->startOfMonth()->format('Y-m-d H:i:s'); 
            $endOfMonth = $now->endOfMonth();
        if(isset($request->id))
            {
                $totalDaysBooked = RoomBooking::whereBetween('checkin_date', [$startOfMonth, $endOfMonth])
                ->where('user_id',$booking->user_id)
                ->whereIn('status',[0,1,3])
                ->where('id', '!=',$booking->id)
                ->get();
                
            }
            else{
                $totalDaysBooked = RoomBooking::whereBetween('checkin_date', [$startOfMonth, $endOfMonth])
                ->where('user_id',$booking->user_id)
                ->whereIn('status',[0,1,3])
                ->get(); 
            }
            
            $booking_count = 0;
            foreach($totalDaysBooked as $key=>$value)
            {
                $checkin = Carbon::parse($value->checkin_date);
                $checkout = Carbon::parse($value->checkout_date);
                $month_differ = $checkout->month - $checkin->month;
                if($month_differ > 0)
                { 
                    $day_count = $endOfMonth->day - $checkin->day; 
                    if($day_count == 0)
                    {
                        $booking_count+=1;
                    }
                    else{
                        $booking_count+=$day_count;
                    }
                }
                else{
                        $booking_count+=$value->booking_count;
                }
            }  
        

            $checkinDate = $request->input('date'); 
            $checkoutDate = $booking->checkout_date; 
            // Convert strings to Carbon instances
            
            $checkin = Carbon::createFromFormat('Y-m-d', $checkinDate)->startOfDay();
            $checkout = Carbon::createFromFormat('Y-m-d H:i:s', $checkoutDate)->startOfDay(); 
            
            // dd($booking);
            // Calculate the difference in days
            $differenceInDays = $checkin->diffInDays($checkout); 
            // dd($differenceInDays);
            $booking_counts = $differenceInDays * $booking->no_of_rooms;
            $room_price_details = new \stdClass(); 
            $counts = 0;
            $price = 0;
            $per_day_price = 0;
            $per_day_price_guest = 0;
            $starting_count = $booking_count + 1; 
            // dd($differenceInDays);
        for($i=1;$i<=$differenceInDays;$i++)
        {  
            for($k=1;$k<=$booking->no_of_rooms;$k++)
            {
                
                $room_price_details->pricing_details[$counts] =  new \stdClass();
                if($starting_count < 5)
                {
                    $tariff = Tariff::where('day',$starting_count)->first();
                }
                else{
                    $tariff = Tariff::where('day',6)->first();
                }
                
                $room_price_details->pricing_details[$counts]->days_count = $starting_count;
                if($request->guest_type[$k] == "guest")
                {  
                    $room_price_details->pricing_details[$counts]->price = $tariff->rent_for_others;
                    $per_day_price+=$tariff->rent_for_others;
                    $price+=$tariff->rent_for_others;
                    $roombooking_price[$k]['price'] = $per_day_price;
                    $roombooking_price[$k]['guest_type'] = $request->guest_type[$k];

                }
                else{ 
                    $room_price_details->pricing_details[$counts]->price = $tariff->rent_for_officers_family;
                    $per_day_price_guest+=$tariff->rent_for_officers_family;
                    $price+=$tariff->rent_for_officers_family;
                    $roombooking_price[$k]['price'] = $per_day_price_guest;
                    $roombooking_price[$k]['guest_type'] = $request->guest_type[$k];
                }
                
                
                $room_price_details->pricing_details[$counts]->guest_type = $request->guest_type[$k];
                $starting_count++;
                $counts++;
    
            } 
        } 
        if(isset($request->eta))
        { 
            $response = [
                "status" => true,
                "data" => $price,
                "message" => "Checkin Confirmed Successfully",
            ];
            return response()->json($response);

        } 
        $k = 1;
        if(isset($request->id))
        { 
        RoomBookingGuest::where('booking_id',$request->id)->delete();
        } 
        //    dd($roombooking_price);
        foreach($roombooking_price as $key=>$value)
        { 
            // dd($value);
            $room_booking_guest = new RoomBookingGuest();  
            $room_booking_guest->booking_id = $request->id;
            $room_booking_guest->room = $k;
            $room_booking_guest->per_day_price = $value['price'];
            $room_booking_guest->guest_type = $value['guest_type'];
            $room_booking_guest->save();
            $k++;
        }
        // dd($room_price_details);
        // foreach($tariff as $key=>$value)
        // {
        //     for($i=$starting_count;$i<=$end_count1;$i++)
        //     { 
        //         if($value->day == $i)
        //         {
        //             if($request->guest_type == "guest")
        //             { 
        //                 $price+=$value->rent_for_others;
        //             }
        //             else{ 
        //                 $price+=$value->rent_for_officers_family;
        //             }
        //         }
        //     }
        // } 
            // dd("dfgdgdg");
        
            if (isset($request->id)) {
                $booking_price = RoomBookingPrice::where('booking_id', $request->id)->first();
            } else {
                $booking_price = new RoomBookingPrice();
            }
        $booking_price->booking_id = $booking->id;
        $booking_price->room_price_details =json_encode($room_price_details); 
        $booking_price->total_price = $price; 
        $booking_price->amount_need_to_paid = $price; 
        
        $now = Carbon::now('Asia/Kolkata');
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
        $invoice->booking_id =  $request->id;
        $invoice->customer_id =  $booking->user_id;
        $invoice->issue_date =  $now->format("Y-m-d");
        $invoice->due_date =  $booking->checkout_date;
        $invoice->total_amount =  $price;  

        if($request->amount)
        { 
            $booking_price->initial_price = $request->price;
            $booking_price->initial_price_status = 1;
            $invoice->initial_price = $request->price;
            $invoice->initial_price_status = 1;
            $booking_price->amount_need_to_paid = $price - $request->price; 
            $invoice->amount_need_to_paid = $price - $request->price;  
        } 
        $invoice->status =  1;
        $booking_price->save();
        $invoice->save();

        $booking->actual_checkin_date =  $checkin_times;
        $booking->checkout_date =  $booking->checkout_date;
        $booking->status =  1;
        $booking->save(); 
        $response = [
            "status" => true,
            "message" => "Checkin Confirmed Successfully",
        ];
        return response()->json($response);
        }  
        public function confirm_checkout(RoomBooking $booking,Request $request)
        { 
            $now = Carbon::now('Asia/Kolkata');
            // Get the start and end of the current month
            $startOfMonth = $now->startOfMonth()->format('Y-m-d H:i:s'); 
            $endOfMonth = $now->endOfMonth(); 
            $totalDaysBooked = RoomBooking::whereBetween('checkin_date', [$startOfMonth, $endOfMonth])
            ->where('user_id',$booking->user_id)
            ->whereIn('status',[0,1,3])
            ->where('id', '!=',$booking->id)
            ->get();
            $booking_count = 0;
            foreach($totalDaysBooked as $key=>$value)
            {
                $checkin = Carbon::parse($value->checkin_date);
                $checkout = Carbon::parse($value->checkout_date);
                    $month_differ = $checkout->month - $checkin->month;
                    if($month_differ > 0)
                    { 
                    $day_count = $endOfMonth->day - $checkin->day; 
                    if($day_count == 0)
                    {
                        $booking_count+=1;
                    }
                    else{
                        $booking_count+=$day_count;
                    }
                    }
                    else{
                        $booking_count+=$value->booking_count;
                    }
            }  
            // dd($booking_count);
            $room_price_details = new \stdClass(); 
            $counts = 0;
            $price = 0;
            $per_day_price = 0;
            $per_day_price_guest = 0;
            $starting_count = $booking_count + 1;  
            $checkin_times = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s'); 
            $eta_checkout_time = Carbon::parse($booking->actual_checkin_date, 'Asia/Kolkata');
            
            // Calculate the difference in seconds
            $differenceInSeconds = $eta_checkout_time->diffInSeconds($checkin_times); 
            // Convert seconds to hours
            $differenceInHours = $differenceInSeconds / 3600; // 3600 seconds in an hour
            $differenceInMinutes = floor(($differenceInSeconds % 3600) / 60); 
            $differenceInHours = round($differenceInHours, 2);  
            $days = floor($differenceInHours / 24);
            $hours = $differenceInHours % 24; 
            $total_hours = $hours + $differenceInMinutes;
            if($total_hours >= 1)
            {
                $days++;
            } 
            $booking_prices = RoomBookingGuest::where('booking_id',$booking->id)->get();
           
            for($i=1;$i<=$days;$i++)
            {    
                $j = 0;
                for($k=1;$k<=$booking->no_of_rooms;$k++)
                {    
                    // print_r($booking_prices);
                    $room_price_details->pricing_details[$counts] =  new \stdClass();
                    if($starting_count < 5)
                    {
                        $tariff = Tariff::where('day',$starting_count)->first();
                    }
                    else{
                        $tariff = Tariff::where('day',6)->first();
                    }  
                    $room_price_details->pricing_details[$counts]->days_count = $starting_count;
                    if($booking_prices[$j]->guest_type == "guest")
                    {   
                        $room_price_details->pricing_details[$counts]->price = $tariff->rent_for_others;
                        $per_day_price+=$tariff->rent_for_others;
                        $price+=$tariff->rent_for_others;
                        $roombooking_price[$j]['price'] = $per_day_price;
                        $roombooking_price[$j]['guest_type'] = "guest"; 
                    }
                    else{  
                        $room_price_details->pricing_details[$counts]->price = $tariff->rent_for_officers_family;
                        $per_day_price_guest+=$tariff->rent_for_officers_family;
                        $price+=$tariff->rent_for_officers_family;
                        $roombooking_price[$j]['price'] = $per_day_price_guest;
                        $roombooking_price[$j]['guest_type'] = $booking_prices[$j]->guest_type;
                    } 
                    $room_price_details->pricing_details[$counts]->guest_type = $booking_prices[$j]->guest_type;
                    $starting_count++;
                    $counts++;
                    $j++;
        
                } 
            } 
            
            if(isset($booking->id))
            { 
            RoomBookingGuest::where('booking_id',$booking->id)->delete();
            } 
            //    dd($roombooking_price);
            foreach($roombooking_price as $key=>$value)
            { 
                // dd($value);
                $room_booking_guest = new RoomBookingGuest();  
                $room_booking_guest->booking_id = $booking->id;
                $room_booking_guest->room = $k;
                $room_booking_guest->per_day_price = $value['price'];
                $room_booking_guest->guest_type = $value['guest_type'];
                $room_booking_guest->save();
                $k++;
            } 
            $booking_price= RoomBookingPrice::where('booking_id',$booking->id)->first();  
            $booking_price->room_price_details =json_encode($room_price_details); 
            $booking_price->total_price = $price;
            if($booking_price->initial_price_status == 1)
            {
                $booking_price->amount_need_to_paid =  $price - $booking_price->initial_price;
            }    
            $booking_price->save();
            $invoice = Invoice::where('booking_id',$booking->id)->first();
            // Get the start and end of the current month
            $startOfMonth = $now->startOfMonth()->format('Y-m-d H:i:s');
            $invoice = Invoice::where('booking_id',$booking->id)->first();
            
            if($invoice->initial_price_status == 1)
            {
                $invoice->amount_need_to_paid =  $price - $invoice->initial_price;
            }     
            if($request->add_charge)
            {  
                $invoice->additional_charge = $request->price; 
                $price = $price + $request->price;  
            } 
            $invoice->total_amount =  $price;
            $invoice->save(); 
            $booking->actual_checkout_date =  $checkin_times;
            $booking->status =  3;
            $booking->is_paid =  1;
            $booking->save();
            $response = [
            "status" => true,
            "message" => "Checkout Confirmed Successfully",
            ];
            return response()->json($response);
        } 
        /**
        * Get Types by admin for ajax
        *cancel_booking
        */
        public function view_invoice(Request $request,QueryFilterContract $queryFilter,RoomBooking $booking)
        { 
            $page = trans('pages_names.types');
            $main_menu = 'master';
            $sub_menu = 'types';
            $sub_menu_1 = '';
            $query = RoomBooking::where('booked_by',auth()->user()->id); 
            $invoice = Invoice::where('booking_id',$booking->id)->first(); 
            $checkinDate = Carbon::parse($booking->checkin_date);

            // Get the current date
            $currentDate = Carbon::now('Asia/kolkata');

            // Calculate the difference in days between the current date and the check-in date
            $daysDifference = $currentDate->diffInDays($checkinDate);
        $date_diff = $checkinDate->day - $currentDate->day;
            
            // dd($daysDifference);
            $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();

            // dd($booking->booked_price);
            return view('admin.room_booking.invoice', compact('page', 'main_menu', 'sub_menu','sub_menu_1','booking','date_diff','invoice'))->render();
        }
    }
