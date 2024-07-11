<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Jobs\NotifyViaMqtt;
use App\Models\Admin\Driver;
use App\Jobs\NotifyViaSocket;
use App\Models\Request\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Request\RequestMeta;
use App\Jobs\NoDriverFoundNotifyJob;
use App\Base\Constants\Masters\PushEnums;
use App\Jobs\Notifications\AndroidPushNotification;
use App\Transformers\Requests\TripRequestTransformer;
use App\Transformers\Requests\CronTripRequestTransformer;
use App\Models\Request\DriverRejectedRequest;
use Sk\Geohash\Geohash;
use Kreait\Firebase\Contract\Database;
use App\Base\Constants\Setting\Settings;
use App\Jobs\Notifications\SendPushNotification;
use Illuminate\Support\Facades\Log;
use App\Helpers\Rides\FetchDriversFromFirebaseHelpers;
use App\Base\Constants\Masters\UserType;


class AssignDriversForScheduledRides extends Command
{
    use FetchDriversFromFirebaseHelpers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign_drivers:for_schedule_rides';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign Drivers for schdeulesd rides';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $current_date = Carbon::now()->format('Y-m-d H:i:s');

        $findable_duration = get_settings('minimum_time_for_search_drivers_for_schedule_ride');
        if(!$findable_duration){
            $findable_duration = 45;
        }
        $add_45_min = Carbon::now()->addMinutes($findable_duration)->format('Y-m-d H:i:s');
        // DB::enableQueryLog();
        $requests = Request::where('is_later', 1)
                    ->where('is_completed', 0)->where('is_cancelled', 0)->get();

        if ($requests->count()==0) {
            return $this->info('no-schedule-rides-found');
        }

        // dd(DB::getQueryLog());
        foreach ($requests as $key => $request) {
           
            $this->fetchDriversFromFirebase($request);
           
        }

        $request_cancel_time = $current_date->subMinutes(15)->format('Y-m-d H:i:s');



        $this->info('success');
    }
}
