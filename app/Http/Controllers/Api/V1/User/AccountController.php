<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Models\User;
use App\Models\Admin\Driver;
use App\Base\Constants\Auth\Role;
use App\Http\Controllers\ApiController;
use App\Transformers\User\UserTransformer;
use App\Transformers\Driver\DriverProfileTransformer;
use App\Transformers\Owner\OwnerProfileTransformer;
use App\Transformers\Dispatcher\DispatcherTransformer;
use Log;

class AccountController extends ApiController
{
    /**
     * Get the current logged in user.
     * @group User-Management
     * @return \Illuminate\Http\JsonResponse
    * @responseFile responses/auth/authenticated_driver.json
    * @responseFile responses/auth/authenticated_user.json
     */
    public function me()
    {

        $user = auth()->user();

        if (auth()->user()->hasRole(Role::DRIVER)) {

            $driver_details = $user->driver;

            $user = fractal($driver_details, new DriverProfileTransformer)->parseIncludes(['onTripRequest.userDetail','onTripRequest.requestBill','metaRequest.userDetail']);

        } else if(auth()->user()->hasRole(Role::USER)) {

            $user = fractal($user, new UserTransformer)->parseIncludes(['onTripRequest.driverDetail','onTripRequest.requestBill','metaRequest.driverDetail','favouriteLocations','laterMetaRequest.driverDetail']);
        }else{

            $owner_details = $user->owner;

            $user = fractal($owner_details, new OwnerProfileTransformer);
        }

        if(auth()->user()->hasRole(Role::DISPATCHER)){

            $user = User::where('id',auth()->user()->id)->first();

            // dd($user->Admin->serviceLocationDetail);

            $user = fractal($user, new DispatcherTransformer)->parseIncludes(['serviceLocation','zone', 'airport','vehicleType','dispatcherList']);

        }
        // Log::info($user);
        // Log::info("Paramsssssssssssssss ");   
        return $this->respondOk($user);
    }
}
