<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\Driver;
use App\Models\Request\RequestRating;

class FirebaseUpdatDriverStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firbase:drivers_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Drivers TripCount and details in Firebase for Dispatcher';

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
     * @return int
     */
        public function handle()
        {
            $driversSnapshot = $this->database->getReference('drivers')->getValue();

                foreach ($driversSnapshot as $key => $driver_array) {
                    // Find the driver record from your relational database using the driver ID
                // dd($driver_array['id']);
                    
                    $driver = Driver::find($driver_array['id']);
                    // dd($driver);
                    // Calculate the rating
                    $ratingValue = RequestRating::where('driver_id', $driver_array['id'])->where('user_rating', 1)->avg('rating');
                    $roundedRating = round($ratingValue, 2) ?? 0; // Round the rating to the nearest whole number or set to 0 if null

                    // Update the 'today_request_count', 'rating', and 'updated_at' fields in Firebase
                    $this->database->getReference('drivers/driver_' . $driver_array['id'])->update([
                        'today_request_count' => 0,
                        'rating' => $roundedRating,
                        'driver_id' => $driver->user->username,
                        'updated_at' => Database::SERVER_TIMESTAMP
                    ]);
                }


            // Optionally, return a success message or handle the completion as needed

        $this->info('Today request count updated for all drivers');

        }
}
