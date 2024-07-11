<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\ChangeDriversToTrips;
use App\Console\Commands\OfflineUnAvailableDrivers;
use App\Console\Commands\NotifyDriverDocumentExpiry;
use App\Console\Commands\AssignDriversForScheduledRides;
use App\Console\Commands\AssignDriversForRegularRides;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ClearDemoDatabase;
use App\Console\Commands\ClearRequestTable;
use App\Console\Commands\ClearWorkerLogs;
use App\Console\Commands\removeOtps;
use App\Console\Commands\ExpireSubscriptions;
use App\Console\Commands\SubscriptionExpiryNotification;
use App\Console\Commands\FirebaseUpdatDriverStatus;



class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ChangeDriversToTrips::class,         
        OfflineUnAvailableDrivers::class,
        AssignDriversForRegularRides::class,
        SubscriptionExpiryNotification::class,
        FirebaseUpdatDriverStatus::class,
        // NotifyDriverDocumentExpiry::class,
        // AssignDriversForScheduledRides::class,
        // ClearDemoDatabase::class,
        // ClearRequestTable::class,
        // ClearWorkerLogs::class,
        // ExpireSubscriptions::class, 
        // removeOtps::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('assign_drivers:for_regular_rides')
                 ->everyMinute();
        $schedule->command('offline:drivers')
                 ->everyMinute();
        $schedule->command('notify:expired')
                 ->everyTwoMinutes();  
        $schedule->command('firbase:drivers_status')
                 ->timezone('Asia/Kolkata')
                 ->dailyAt('00:01'); 
         // $schedule->command('clear:otp')
         //         ->everyFiveMinutes();
         // $schedule->command('expire:subscriptions')
         //         ->everyFiveMinutes();
        // $schedule->command('clear:database')
        //          ->daily();
        // $schedule->command('assign_drivers:for_schedule_rides')
        //          ->everyFiveMinutes();
        // $schedule->command('notify:document:expires')
        //          ->daily();
        // $schedule->command('logs:clear')->everyFourHours();
        $schedule->command('drivers:totrip')
                 ->everyMinute();                 
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
