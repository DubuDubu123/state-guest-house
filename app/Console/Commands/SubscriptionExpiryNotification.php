<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment\DriverSubscription;
use App\Jobs\Notifications\AndroidPushNotification;
use App\Jobs\NotifyViaMqtt;
use App\Base\Constants\Masters\PushEnums;
use Carbon\Carbon;
use App\Jobs\Notifications\SendPushNotification;
use App\Models\Admin\Notification;
use App\Jobs\UserDriverNotificationSaveJob;
use App\Models\Admin\UserDriverNotification;
use Log;
class SubscriptionExpiryNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify Expired Subscription';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now('Asia/Kolkata');
        $currentTime = $now->toDateTimeString();
        $oneHourFromNow = $now->copy()->addHour()->toDateTimeString();
        $oneDayFromNow = $now->copy()->addDay()->toDateTimeString();

        $subscriptionTypes = ['daily', 'weekly', 'monthly'];

        foreach ($subscriptionTypes as $subscriptionType) {
            if($subscriptionType == "daily")
            {
                $notified_mode = "hour_before_nofified";
                $subscriptions = DriverSubscription::where('expired_at', '>', $currentTime)
                ->where('expired_at', '<=', $subscriptionType === 'daily' ? $oneHourFromNow : $oneDayFromNow)
                ->where('active', true)
                ->where('hour_before_nofified', false)
                ->where('subscription_type', $subscriptionType)
                ->get();
                if (!$subscriptions->isEmpty()) {


                    foreach ($subscriptions as $subscription) {
                        DriverSubscription::where('id', $subscription->id)->update(['hour_before_nofified' => true]);
    
                        $driver = $subscription->driver;
    
                        $notifiable_driver = $driver->user;
    
                    $notificationTitle = trans("push_notifications.{$subscriptionType}_subscription_title",[],$notifiable_driver->lang);
                    $notificationBody = trans("push_notifications.{$subscriptionType}_subscription_body",[],$notifiable_driver->lang);
    
                    $notification = Notification::create([
                        'title' => $notificationTitle,
                        'push_enum' => PushEnums::GENERAL_NOTIFICATION,
                        'body' => $notificationBody,
                        'for_driver' => true,
                    ]);
    
    
                        $push_data = [
                            'title' => $notificationTitle,
                            'message' => $notificationBody,
                            'push_type' => 'general',
                        ];
    
                        UserDriverNotification::create(['notify_id' => $notification->id, 'driver_id' => $driver->id]);
    
                        dispatch(new SendPushNotification($notifiable_driver, $notificationTitle, $notificationBody, $push_data));
                    }
                }
            }
            if($subscriptionType == "weekly" || $subscriptionType == "monthly")
            {
                $notified_mode = "day_before_nofified";
                
                Log::info("sdfsssssssssssssss sdfffffffffff");
                $subscriptions = DriverSubscription::where('expired_at', '>', $currentTime)
                ->where('expired_at', '<=', $oneDayFromNow)
                ->where('active', true) 
                ->where('subscription_type', $subscriptionType)
                ->get();
                Log::info(json_encode($subscriptions));
                Log::info("Testing");
                Log::info($currentTime);
                Log::info($oneDayFromNow);
          
                if(!$subscriptions->isEmpty()) {  
                    foreach ($subscriptions as $subscription) { 
                        if($subscription->day_before_nofified)
                        {
                            Log::info(json_encode($subscription));
                            Log::info("sdfsssssssssssssss sdfffffffffff");
                            $subscriptions1 = DriverSubscription::where('expired_at', '>', $currentTime)
                            ->where('expired_at', '<=', $oneHourFromNow)
                            ->where('active', true) 
                            ->where('hour_before_nofified', false)
                            ->where('subscription_type', $subscriptionType)
                            ->get();
                            if(!$subscriptions1->isEmpty()) {  
                                    foreach ($subscriptions1 as $subscription1) { 
                                        DriverSubscription::where('id', $subscription1->id)->update(['hour_before_nofified' => true]);

                                        $driver = $subscription1->driver;
                    
                                        $notifiable_driver = $driver->user;
                    
                                    $notificationTitle = trans("push_notifications.{$subscriptionType}_hour_subscription_title",[],$notifiable_driver->lang);
                                    $notificationBody = trans("push_notifications.{$subscriptionType}_hour_subscription_body",[],$notifiable_driver->lang);
                    
                                    $notification = Notification::create([
                                        'title' => $notificationTitle,
                                        'push_enum' => PushEnums::GENERAL_NOTIFICATION,
                                        'body' => $notificationBody,
                                        'for_driver' => true,
                                    ]);
                    
                    
                                        $push_data = [
                                            'title' => $notificationTitle,
                                            'message' => $notificationBody,
                                            'push_type' => 'general',
                                        ];
                    
                                        UserDriverNotification::create(['notify_id' => $notification->id, 'driver_id' => $driver->id]);
                    
                                        dispatch(new SendPushNotification($notifiable_driver, $notificationTitle, $notificationBody, $push_data));
                                    }
                            }
                        }
                        else{
                            Log::info($subscription);
                                DriverSubscription::where('id', $subscription->id)->update(['day_before_nofified' => true]);

                                $driver = $subscription->driver;
            
                                $notifiable_driver = $driver->user;
            
                            $notificationTitle = trans("push_notifications.{$subscriptionType}_day_subscription_title",[],$notifiable_driver->lang);
                            $notificationBody = trans("push_notifications.{$subscriptionType}_day_subscription_body",[],$notifiable_driver->lang);
            
                            $notification = Notification::create([
                                'title' => $notificationTitle,
                                'push_enum' => PushEnums::GENERAL_NOTIFICATION,
                                'body' => $notificationBody,
                                'for_driver' => true,
                            ]);
            
            
                                $push_data = [
                                    'title' => $notificationTitle,
                                    'message' => $notificationBody,
                                    'push_type' => 'general',
                                ];
            
                                UserDriverNotification::create(['notify_id' => $notification->id, 'driver_id' => $driver->id]);
            
                                dispatch(new SendPushNotification($notifiable_driver, $notificationTitle, $notificationBody, $push_data));
                        }

                    }
                } 
            }

            // $hourBeforeField = $subscriptionType === 'daily' ? 'hour_before_nofified' : 'day_before_nofified';

          

          
        }
      
        $expiredSubscriptions = DriverSubscription::where('expired_at', '<=', $currentTime)
            ->where('active', true)
            ->get();

        if (!$expiredSubscriptions->isEmpty()) {
            foreach ($expiredSubscriptions as $subscription) {
                Log::info($subscription);
                DriverSubscription::where('id', $subscription->id)->update(['active' => false]);

                $driver = $subscription->driver;
                $driver->active = false;
                $driver->save();

                $notifiableDriver = $driver->user;

                $title = trans('push_notifications.expired_your_subscription_title',[],$notifiableDriver->lang);
                $body = trans('push_notifications.expired_your_subscription_body',[],$notifiableDriver->lang);

                $notifiableDriver->notify(new AndroidPushNotification($title, $body));
            }
        }

        $this->info('Subscription expiry Notified'); 

    }
}


    //     $now = Carbon::now('Asia/Kolkata');

    //     // Calculate the timestamp one hour from now
    //     $oneHourFromNow = $now->copy()->addHour()->toDateTimeString();

    //     // Calculate the timestamp now
    //     $currentTime = $now->toDateTimeString();

    //     // Daily subscriptions within the next hour of expiration
    //     $one_hour_before_daily_expired_subscriptions = DriverSubscription::where('expired_at', '>', $currentTime)
    //         ->where('expired_at', '<=', $oneHourFromNow)
    //         ->where('active', true)
    //         ->where('hour_before_nofified', false)
    //         ->where('subscription_type', 'daily')
    //         ->get();

    //     if ($one_hour_before_daily_expired_subscriptions) 
    //     {
    //     $created_params['title'] = trans('push_notifications.daily_subscription_title');
    //     $created_params['push_enum'] = PushEnums::GENERAL_NOTIFICATION;
    //     $created_params['body'] = trans('push_notifications.daily_subscription_body');
    //     $created_params['for_driver'] = true;
        
    //     $notification = Notification::create($created_params);

    //        foreach ($one_hour_before_daily_expired_subscriptions as $key => $subscription) 
    //        {
               
    //            DriverSubscription::where('id',$subscription->id)->update(['hour_before_nofified'=>true]);

    //             // Make Offline the driver
    //             $driver = $subscription->driver;

    //             // Notify Driver
    //             $title = $notification->title;
    //             $body = $notification->body;
    //             $push_data = ['title' => $notification->title,'message' => $notification->body,'push_type'=>'general'];

    //             UserDriverNotification::create(['notify_id'=>$notification->id,'driver_id'=>$driver->id]);

    //             dispatch(new SendPushNotification($driver->user,$title,$body,$push_data));

    //         }

    //    }



    //     // Weekly subscriptions within the next hour of expiration
    //     $one_hour_before_weekly_expired_subscriptions = DriverSubscription::where('expired_at', '>', $currentTime)
    //         ->where('expired_at', '<=', $oneHourFromNow)
    //         ->where('active', true)
    //         ->where('hour_before_nofified', false)
    //         ->where('subscription_type', 'weekly')
    //         ->get();
    //     if ($one_hour_before_weekly_expired_subscriptions) 
    //     {
    //     $created_params['title'] = trans('push_notifications.weekly_hour_subscription_title');
    //     $created_params['push_enum'] = PushEnums::GENERAL_NOTIFICATION;
    //     $created_params['body'] = trans('push_notifications.weekly_hour_subscription_body');
    //     $created_params['for_driver'] = true;
        
    //     $notification = Notification::create($created_params);

    //        foreach ($one_hour_before_weekly_expired_subscriptions as $key => $subscription) 
    //        {
               
    //            DriverSubscription::where('id',$subscription->id)->update(['hour_before_nofified'=>true]);

    //             // Make Offline the driver
    //             $driver = $subscription->driver;

    //             // Notify Driver
    //             $title = $notification->title;
    //             $body = $notification->body;
    //             $push_data = ['title' => $notification->title,'message' => $notification->body,'push_type'=>'general'];
    //             UserDriverNotification::create(['notify_id'=>$notification->id,'driver_id'=>$driver->id]);

    //             dispatch(new SendPushNotification($driver->user,$title,$body,$push_data));


    //         }

    //    }
    //     // Monthly subscriptions within the next hour of expiration
    //     $one_hour_before_monthly_expired_subscriptions = DriverSubscription::where('expired_at', '>', $currentTime)
    //         ->where('expired_at', '<=', $oneHourFromNow)
    //         ->where('active', true)
    //         ->where('hour_before_nofified', false)            
    //         ->where('subscription_type', 'monthly')
    //         ->get();
    //     if ($one_hour_before_monthly_expired_subscriptions) 
    //     {
    //     $created_params['title'] = trans('push_notifications.monthly_hour_subscription_title');
    //     $created_params['push_enum'] = PushEnums::GENERAL_NOTIFICATION;
    //     $created_params['body'] = trans('push_notifications.monthly_hour_subscription_body');
    //     $created_params['for_driver'] = true;

        
    //     $notification = Notification::create($created_params);

    //        foreach ($one_hour_before_monthly_expired_subscriptions as $key => $subscription) 
    //        {
               
    //            DriverSubscription::where('id',$subscription->id)->update(['hour_before_nofified'=>true]);

    //             // Make Offline the driver
    //             $driver = $subscription->driver;

    //             // Notify Driver
    //             $notifiable_driver = $driver->user;
    //             // Notify Driver
    //             $title = $notification->title;
    //             $body = $notification->body;
    //             $push_data = ['title' => $notification->title,'message' => $notification->body,'push_type'=>'general'];
    //             UserDriverNotification::create(['notify_id'=>$notification->id,'driver_id'=>$driver->id]);

    //             dispatch(new SendPushNotification($driver->user,$title,$body,$push_data));

    //         }

    //    }

    //     // Calculate the timestamp one day from now
    //     $oneDayFromNow = $now->copy()->addDay()->toDateTimeString();


    //     // Weekly subscriptions within the next day of expiration
    //     $one_day_before_weekly_expired_subscriptions = DriverSubscription::where('expired_at', '>', $currentTime)
    //         ->where('expired_at', '<=', $oneDayFromNow)
    //         ->where('active', true)
    //         ->where('day_before_nofified', false)            
    //         ->where('subscription_type', 'weekly')
    //         ->get();
    //     if ($one_day_before_weekly_expired_subscriptions) 
    //     {
    //     $created_params['title'] = trans('push_notifications.weekly_day_subscription_title');
    //     $created_params['push_enum'] = PushEnums::GENERAL_NOTIFICATION;
    //     $created_params['body'] = trans('push_notifications.weekly_day_subscription_body');
    //     $created_params['for_driver'] = true;
        
    //     $notification = Notification::create($created_params);

    //        foreach ($one_day_before_weekly_expired_subscriptions as $key => $subscription) 
    //        {
               
    //            DriverSubscription::where('id',$subscription->id)->update(['day_before_nofified'=>true]);

    //             // Make Offline the driver
    //             $driver = $subscription->driver;

    //             // Notify Driver
    //             $notifiable_driver = $driver->user;
    //             // Notify Driver
    //             $title = $notification->title;
    //             $body = $notification->body;
    //             $push_data = ['title' => $notification->title,'message' => $notification->body,'push_type'=>'general'];
    //             UserDriverNotification::create(['notify_id'=>$notification->id,'driver_id'=>$driver->id]);

    //             dispatch(new SendPushNotification($driver->user,$title,$body,$push_data));

    //         }

    //    }

    //     // Monthly subscriptions within the next day of expiration
    //     $one_day_before_monthly_expired_subscriptions = DriverSubscription::where('expired_at', '>', $currentTime)
    //         ->where('expired_at', '<=', $oneDayFromNow)
    //         ->where('active', true)
    //         ->where('day_before_nofified', false)            
    //         ->where('subscription_type', 'monthly')
    //         ->get();
        
    //     if ($one_day_before_monthly_expired_subscriptions) 
    //     {
    //     $created_params['title'] = trans('push_notifications.monthly_day_subscription_title');
    //     $created_params['push_enum'] = PushEnums::GENERAL_NOTIFICATION;
    //     $created_params['body'] = trans('push_notifications.monthly_day_subscription_body');
    //     $created_params['for_driver'] = true;
        
    //     $notification = Notification::create($created_params);

    //        foreach ($one_day_before_monthly_expired_subscriptions as $key => $subscription) 
    //        {
               
    //            DriverSubscription::where('id',$subscription->id)->update(['day_before_nofified'=>true]);

    //             // Make Offline the driver
    //             $driver = $subscription->driver;

    //             // Notify Driver
    //             $notifiable_driver = $driver->user;
            
    //             // Notify Driver
    //             $title = $notification->title;
    //             $body = $notification->body;
    //             $push_data = ['title' => $notification->title,'message' => $notification->body,'push_type'=>'general'];
              
    //             UserDriverNotification::create(['notify_id'=>$notification->id,'driver_id'=>$driver->id]);

    //             dispatch(new SendPushNotification($driver->user,$title,$body,$push_data));

    //         }

    //    }



    //     $today_with_time = Carbon::now('Asia/Kolkata')->toDateTimeString();
    //     // dd($today_with_time);
    //     $expired_subscriptions = DriverSubscription::where('expired_at', '<=', $today_with_time)
    //         ->where('active', true)
    //         ->get();
    // if (!$expired_subscriptions->isEmpty()) {
    //     foreach ($expired_subscriptions as $key => $subscription) {

    //         DriverSubscription::where('id',$subscription->id)->update(['active'=>false]);

    //         // Make Offline the driver
    //         $driver = $subscription->driver;

    //         $driver->active = false;

    //         $driver->save();

    //         // Notify Driver
    //         $notifiable_driver = $driver->user;

    //         $title = trans('push_notifications.expired_your_subscription_title');
    //         $body = trans('push_notifications.expired_your_subscription_body');

    //         $notifiable_driver->notify(new AndroidPushNotification($title, $body));

    //     }

    //  }


