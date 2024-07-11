<?php

namespace App\Http\Controllers\Web\Admin;

use Carbon\Carbon;
use App\Models\User;
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
use App\Models\Tariff;
use App\Models\PartyTariff;
use App\Models\MembershipTariff;
use App\Models\SportsTariff;
/**
 * @resource Vechicle-Types
 *
 * vechicle types Apis
 */
class TariffController extends BaseController
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
    public function __construct(VehicleType $vehicle_type, ImageUploaderContract $imageUploader)
    {
        $this->vehicle_type = $vehicle_type;
        $this->imageUploader = $imageUploader;
    }

    /**
    * Get all vehicle types
    * @return \Illuminate\Http\JsonResponse
    */
    public function index()
    { 
        $page = trans('pages_names.types');
        $main_menu = 'tariff';
        $sub_menu = 'tariff';
        $sub_menu_1 = '';
        $tariff = Tariff::get();
        $party_tariff = PartyTariff::get();
        $membership_tariff = MembershipTariff::get();
        $sports_tariff = SportsTariff::get(); 
        return view('admin.tariff.index', compact('page', 'main_menu', 'sub_menu','sub_menu_1','tariff','party_tariff','membership_tariff','sports_tariff'))->render();
    }

     
    public function store(Request $request)
    { 
        // dd($request->all());
        if (auth()->user()->hasRole(!(Role::SUPER_ADMIN))) {

                if (env('APP_FOR')=='demo') {
                $message = trans('succes_messages.you_are_not_authorised');

                return redirect('tariff')->with('warning', $message);
            }
        } 
        
        if($request->membership)
        {
            // dd($request->membership);
            foreach($request->membership as $key=>$value)
            { 
                
                if(isset($value['life_time']))
                {
                    $price = $value['life_time'];
                }
                else{
                    $price = $value['associate'];
                }
                $membership_tariff = MembershipTariff::find($key);
                $membership_tariff->price = $price;
                $membership_tariff->save();
            }
        }
        if($request->tariff)
        {
            foreach($request->tariff as $key=>$value)
            {

            $tariff = Tariff::find($key);
            $tariff->rent_for_officers_family = $value['rent_for_officers_family'];
            $tariff->rent_for_others = $value['rent_for_others'];
            $tariff->total_rooms = $request->total_rooms;
            $tariff->save();
            }
        }
        if($request->party_tariff)
        {
            
            foreach($request->party_tariff as $key=>$value)
            {
                // dd($value);
            $party_tariff = PartyTariff::find($key);
            $party_tariff->price = $value;
            $party_tariff->save();
            }
        }
        if($request->sports_tariff)
        {
            foreach($request->sports_tariff as $key=>$value)
            {
            $sports_tariff = SportsTariff::find($key);
            $sports_tariff->daily_tariff = $value['daily_tariff'];
            $sports_tariff->mothly_tariff = $value['mothly_tariff'];
            $sports_tariff->yearly_tariff = $value['yearly_tariff'];
            $sports_tariff->save();
            }
        }

        $message = "Tariff Price Updated Successfully";

        return redirect('tariff')->with('success', $message);
    } 
}
