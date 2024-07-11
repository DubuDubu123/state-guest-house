<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Payment\DriverSubscription;
use App\Jobs\Notifications\AndroidPushNotification;
use App\Jobs\NotifyViaMqtt;
use App\Base\Constants\Masters\PushEnums;

class ExpireSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire subscriptions';

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
     * @return mixed
     */
    public function handle()
    {

        $today_with_time = Carbon::now('Asia/Kolkata')->toDateTimeString();
        // dd($today_with_time);
        $expired_subscriptions = DriverSubscription::where('expired_at', '<=', $today_with_time)
            ->where('active', true)
            ->get();

        foreach ($expired_subscriptions as $key => $subscription) {

            DriverSubscription::where('id',$subscription->id)->update(['active'=>false]);

            // Make Offline the driver
            $driver = $subscription->driver;

            $driver->active = false;

            $driver->save();

            // Notify Driver
            $notifiable_driver = $driver->user;

            $title = trans('push_notifications.expired_your_subscription_title',[],$notifable_driver->lang);
            $body = trans('push_notifications.expired_your_subscription_body',[],$notifable_driver->lang);

            $notifiable_driver->notify(new AndroidPushNotification($title, $body));

        }

        $this->info('expired-subscriptions');
    }
}