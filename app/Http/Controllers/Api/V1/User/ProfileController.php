<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Requests\Dispatcher\UpdateDispatcherProfileRequest;
use App\Transformers\Dispatcher\UserForDispatcherRideTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\User\UserTransformer;
use App\Transformers\Driver\DriverTransformer;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\UpdateDriverProfileRequest;
use App\Base\Services\ImageUploader\ImageUploaderContract;
use App\Base\Constants\Auth\Role;
use App\Models\User;
use App\Models\Request\FavouriteLocation;
use App\Models\Payment\UserBankInfo;
use Kreait\Firebase\Contract\Database;
use Carbon\Carbon;
use App\Transformers\Payment\UserCancellationFeeTransformer;
use App\Transformers\Payment\DriverCancellationFeeTransformer;
use App\Models\Admin\DriverCancellationFee;
use App\Models\Admin\UserCancellationFee;
use Illuminate\Support\Facades\Log;

/**
 * @group Profile-Management
 *
 * APIs for Profile-Management
 */
class ProfileController extends ApiController
{
    /**
     * ImageUploader instance.
     *
     * @var ImageUploaderContract
     */
    protected $imageUploader;

    protected $user;


    /**
     * ProfileController constructor.
     *
     * @param ImageUploaderContract $imageUploader
     */
    public function __construct(ImageUploaderContract $imageUploader,User $user,Database $database)
    {
        $this->imageUploader = $imageUploader;

        $this->user = $user;

        $this->database = $database;

    }

    /**
     * Update user profile.
     *
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @response
     * {
     *"success": true,
     *"message": "success"
     *}
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $data = $request->only(['name', 'email', 'last_name','mobile']);

        if ($uploadedFile = $this->getValidatedUpload('profile_picture', $request)) {
            $data['profile_picture'] = $this->imageUploader->file($uploadedFile)
                ->saveProfilePicture();
        }
        $user = auth()->user();

        $mobile = $request->mobile;

        if($mobile){
             $validate_exists_mobile = $this->user->belongsTorole(Role::USER)->where('mobile', $mobile)->where('id','!=',$user->id)->exists();

        if ($validate_exists_mobile) {
            $this->throwCustomException('Provided mobile has already been taken');
        }

        }


        $user->update($data);
        $user = fractal($user->fresh(), new UserTransformer);

        return $this->respondSuccess($user);
    }

    /**
    * Update Driver Profile
    *
    */
    public function updateDriverProfile(UpdateDriverProfileRequest $request)
    {
        $user_params = $request->only(['name', 'email', 'last_name','mobile']);


        $user = auth()->user();

        $owner = $user->owner()->exists();

        $mobile = $request->mobile;

        if($mobile){
             $validate_exists_mobile = $this->user->belongsTorole(Role::DRIVER)->where('mobile', $mobile)->where('id','!=',$user->id)->exists();

        if ($validate_exists_mobile) {
            $this->throwCustomException('Provided mobile has already been taken');
        }

        }

        $driver_params = $request->only(['vehicle_type','car_make','car_model','car_color','car_number','name','email','vehicle_year']);


         $driver_params['approve'] = false;

         if(!$owner){
         $driver_params['reason'] = 'profile-info-updated';
         }


        if ($uploadedFile = $this->getValidatedUpload('profile_picture', $request)) {
            $user_params['profile_picture'] = $this->imageUploader->file($uploadedFile)
                ->saveProfilePicture();
        }

        if ($uploadedFile = $this->getValidatedUpload('profile_pic', $request)) {
            $user_params['profile_picture'] = $this->imageUploader->file($uploadedFile)
                ->saveProfilePicture();

            $driver_params['approve'] = false;

            if(!$owner){
                $driver_params['reason'] = 'profile-info-updated';
            }

        }

        $user->update($user_params);



        if($request->has('vehicle_type') && $request->vehicle_type){

            $driver_params['approve'] = false;

            $driver_params['reason'] = 'vehicle-info-updated';


        }



        if($driver_params['approve']==false){

            $status=0;


            if(!$owner){
              $this->database->getReference('drivers/driver_'.$user->driver->id)->update(['approve'=>(int)$status,'updated_at'=> Database::SERVER_TIMESTAMP]);
            }else{

                $driver_params['approve']=true;
            }

        }

        if(!$owner){
            $user->driver()->update($driver_params);

        }else{
            $user->owner()->update($driver_params);

        }

        $driver_details = $user->driver;

        $result = fractal($driver_details, new DriverTransformer)->parseIncludes(['onTripRequest.userDetail','onTripRequest.requestBill','metaRequest.userDetail']);

        return $this->respondOk($result);
    }

    /**
     * Update user Dispatcherprofile.
     *
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @response
     * {
     *"success": true,
     *"message": "success"
     *}
     */
    public function updateDispatcherProfile(UpdateDispatcherProfileRequest $request)
    {

        $data = $request->only(['name', 'email','mobile']);

        if ($uploadedFile = $this->getValidatedUpload('profile_picture', $request)) {
            $data['profile_picture'] = $this->imageUploader->file($uploadedFile)
                ->saveProfilePicture();
        }

        $user = auth()->user();

        $mobile = $request->mobile;
//        dd($mobile);


        if($mobile){
            $validate_exists_mobile = $this->user->belongsTorole(Role::DISPATCHER)->where('mobile', $mobile)->where('id','!=',$user->id)->exists();

            if ($validate_exists_mobile) {
                $this->throwCustomException('Provided mobile has already been taken');
            }

        }

        if($request->has('password')){

            $data = [];

            $data['password'] = bcrypt($request->input('password'));
        }


        $user->update($data);

        $data = $request->only(['email', 'last_name','mobile']);

        $data['first_name'] = $request->name;

        $user->admin()->update($data);

        $user = fractal($user->fresh(), new UserForDispatcherRideTransformer());

        return $this->respondSuccess($user);
    }

    /**
     * Update user password.
     * @bodyParam old_password password required old_password provided user
     * @bodyParam password password required password provided user
     * @bodyParam password_confirmation password required  confirmed password provided user
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @response
     * {
     *"success": true,
     *"message": "success"
     *}
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        $oldPassword = $request->input('old_password');
        $password = $request->input('password');

        $user = auth()->user();

        if (!hash_check($oldPassword, $user->password)) {
            $this->throwCustomValidationException('Invalid old password entered.', 'old_password');
        }

        $user->forceFill(['password' => bcrypt($password)])->save();

        return $this->respondSuccess();
    }

    /**
    * Update My Language
    * @bodyParam lang string required language provided user
     * @return \Illuminate\Http\JsonResponse
     * @response
     * {
     *"success": true,
     *"message": "success"
     *}
    */
    public function updateMyLanguage(Request $request)
    {
        // Validate Request id
        $request->validate([
        'lang' => 'required',
        ]);
        $user = auth()->user();
        $user->forceFill(['lang' => $request->lang])->save();
        return $this->respondSuccess();
    }
    /**
    * Update My Language
    * @bodyParam lang string required language provided user
     * @return \Illuminate\Http\JsonResponse
     * @response
     * {
     *"success": true,
     *"message": "success"
     *}
    */
    public function updateLocation(Request $request)
    {
        // Validate Request id
        $request->validate([
        'current_lat' => 'required',
        'current_lng' => 'required',
        ]);
        // Log::info($request);
        // Log::info("location update");

        auth()->user()->update(['current_lat'=>$request->current_lat, 'current_lng'=>$request->current_lng]);


        return $this->respondSuccess();
    }
    /**
    * Add favourite location
    * @bodyParam pick_lat double required pikup lat of the user
    * @bodyParam pick_lng double required pikup lng of the user
    * @bodyParam drop_lat double optional drop lat of the user
    * @bodyParam drop_lng double optional drop lng of the user
    * @bodyParam pick_address string required pickup address of the favourite location
    * @bodyParam drop_address string optional drop address of the favourite location
    * @bodyParam address_name string required address name of the favourite location
    * @bodyParam landmark string optional drop address of the favourite location
    * @responseauth()->user()->
     * {
     *"success": true,
     *"message": "address added successfully"
     *}
    */
    public function addFavouriteLocation(Request $request){

        // Validate Request id
        $request->validate([
            'pick_lat'  => 'required',
            'pick_lng'  => 'required',
            'pick_address'=>'required',
            'drop_lat'  =>'sometimes|required',
            'drop_lng'  =>'sometimes|required',
            'drop_address'=>'sometimes|required',
            'address_name'=>'required',
        ]);

        $created_params = $request->all();

        $created_params['user_id'] = auth()->user()->id;

        $locations = FavouriteLocation::where('user_id',auth()->user()->id)->get()->count();

        if($locations==4){
            $this->throwCustomException('You have reached your limits');
        }
        FavouriteLocation::create($created_params);

        return $this->respondSuccess(null,'address added successfully');



    }

    /**
    * List Favourite Locations
    *
    */
    public function FavouriteLocationList()
    {
        $user = auth()->user();

        $locations = FavouriteLocation::where('user_id',$user->id)->get();

        return $this->respondSuccess($locations,'address listed successfully');

    }

    /**
     * Delete Favourite Location
     *
     * @response
     * {
     * "success": true,
     * "message": "favorite location deleted successfully"
     * }
     * */
    public function deleteFavouriteLocation(FavouriteLocation $favourite_location){

        $favourite_location->delete();

        return $this->respondSuccess(null,'favorite location deleted successfully');


    }

    /**
     * Add/Update Bank Info
     * @bodyParam account_name string required name of the account
     * @bodyParam account_no integer required Number of the account
     * @bodyParam bank_code string required Bank code of the account
     * @bodyParam bank_name string required Bank name of the account
     *
     *
     * */
    public function updateBankinfo(Request $request)
    {
        $user = auth()->user();

        $bankInfo = $user->bankInfo;

        if($bankInfo){

           $user->bankInfo()->update($request->all());

        }else{
            $bankInfo = $user->bankInfo()->create($request->all());

        }

        return $this->respondSuccess(null,'bank info updated successfully');

    }

    /**
     * Get Bank info
     *
     *
     * */
    public function getBankInfo()
    {
        $user = auth()->user();

        $bankInfo = $user->bankInfo;

        return response()->json(['success'=>true,'message'=>'bank info listed successfully','data'=>$bankInfo]);


    }
    /**
     * user Account Delete
     *
     *
     * */
    public function userDeleteAccount()
    {
        $user = auth()->user();

        if (auth()->user()->hasRole(Role::DRIVER)) 
        {

         $deleted_at = Carbon::now()->toDateTimeString();

         $user->driver->update(['is_deleted'=>true, 'approve'=>false]);
         
         $this->database->getReference('drivers/driver_'.$user->driver->id)->update(['approve'=>0,'updated_at'=> Database::SERVER_TIMESTAMP]);            
        }else{

         $user->update(['is_deleted'=>true]);

        }


        return response()->json(['success'=>true,'message'=>'User Account deleted successfully']);

    }

    public function cancelationWallet()
    {
        $user = auth()->user();

       if (access()->hasRole(Role::USER)) {
            $query = UserCancellationFee::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc');
            // $result = fractal($query, new UserWalletHistoryTransformer);
            $result = filter($query, new UserCancellationFeeTransformer)->defaultSort('-created_at')->paginate();

            $currency_code = auth()->user()->countryDetail->currency_code;
            $currency_symbol = auth()->user()->countryDetail->currency_symbol;


        } else
        {
            $query = DriverCancellationFee::where('driver_id', $user->driver->id)->orderBy('created_at', 'desc');

            $result = filter($query, new DriverCancellationFeeTransformer)->defaultSort('-created_at')->paginate();

            $currency_code = auth()->user()->countryDetail->currency_code;
            $currency_symbol = auth()->user()->countryDetail->currency_symbol;
        }

        return response()->json(['success' => true, 'message' => 'cancellaion-fee-listed', 'cancellation_fee' => $result]);


    }


}
