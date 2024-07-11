<?php

namespace App\Http\Controllers\Api\V1\Auth\Registration;

use App\Models\User;
use Illuminate\Http\Request;
use App\Base\Constants\Auth\Role;
use App\Transformers\User\UserTransformer;
use App\Base\Constants\Masters\WalletRemarks;
use App\Transformers\User\ReferralTransformer;
use App\Http\Controllers\Api\V1\BaseController;
use App\Jobs\Notifications\AndroidPushNotification;
use App\Jobs\Notifications\SendPushNotification;
use App\Models\Admin\Promo;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**
 * @group SignUp-And-Otp-Validation
 *
 * APIs for User-Management
 */
class ReferralController extends BaseController
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
    * Get Referral code
    * @responseFile responses/auth/get-referral.json
    */
    public function index()
    {
        $user = fractal(auth()->user(), new ReferralTransformer);

        return $this->respondOk($user);
    }
   /**
    * Update Driver Referral code
    * @bodyParam refferal_code string required refferal_code of the another user
    * @response {"success":true,"message":"success"}
    */
    public function updateUserReferral(Request $request)
    {


        // Validate Referral code
        $referred_user = $this->user->where('refferal_code', $request->refferal_code)->first();

        if (!$referred_user || strcmp($referred_user->refferal_code, $request->refferal_code) !== 0) {
            // If $referred_user is null or the referral codes don't match (case-sensitive)
            $this->throwCustomException('Provided Referral code is not valid', 'refferal_code');
        }


        $refferal_code = $request->refferal_code;
        $reffered_user_exists = User::belongsTorole(Role::USER)->where('refferal_code', $refferal_code)->exists();
  
        $reffered_driver_exists = User::belongsTorole(Role::DRIVER)->where('refferal_code', $refferal_code)->exists();

        if($reffered_driver_exists)
        {
                $reffered_driver = User::belongsTorole(Role::DRIVER)->where('refferal_code', $refferal_code)->first();

           // dd($reffered_driver)/;
                auth()->user()->update(['referred_by'=>$reffered_driver->id]);
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
              
              auth()->user()->update(['referred_by'=>$reffered_user->id]);
            
              $referral_commision = get_settings('referral_commision_for_user')?:0;
            //refferal amount convert to coupen code

            $userReferralCount = Promo::where('user_id', $reffered_user->id)->count();

             $referenceCode = 'DDREF' . str_pad($userReferralCount + 1, 3, '0', STR_PAD_LEFT);

            $created_params['code']=$referenceCode;
            $created_params['minimum_trip_amount']=$referral_commision;
            $created_params['maximum_discount_amount']=$referral_commision;
            $created_params['discount_percent']=0;
            $created_params['total_uses']=1;
            $created_params['uses_per_user']=1;
            $created_params['from'] = Carbon::now()->startOfDay()->toDateTimeString();
            $created_params['to'] = Carbon::now()->addYear()->endOfDay()->toDateTimeString();
            $created_params['active']=1;
            $created_params['service_location_id'] = null;
            $created_params['user_id'] = $reffered_user->id;
             
            $promo = Promo::create($created_params);
            // Log::info($promo);
  

        // Notify user
        $title = trans('push_notifications.referral_promo_notify_title',[],$reffered_user->lang);
        $body = trans('push_notifications.referral_promo_notify_body',[],$reffered_user->lang);

        dispatch(new SendPushNotification($reffered_user,$title,$body));

        }


        return $this->respondSuccess();
    }
}
