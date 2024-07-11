<?php

namespace App\Models\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Master\CarMake;
use App\Models\Master\CarModel;
use App\Models\Request\Request;
use App\Models\Traits\HasActive;
use App\Models\Payment\DriverWallet;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\DriverAvailability;
use App\Models\Payment\DriverWalletHistory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use App\Models\Payment\WalletWithdrawalRequest;
use App\Models\Payment\DriverSubscription;
use App\Models\Request\DriverRejectedRequest;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class RegisteredDriver extends Model
{
    use HasActive,SearchableTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'registerd_drivers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'name','mobile','refferal_code'
    ];


    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'registerd_drivers.name' => 20,
            'registerd_drivers.mobile' => 20,
        ],

    ];
    /**
     * The attributes that can be used for sorting with query string filtering.
     *
     * @var array
     */
    public $sortable = [
        'created_at', 'updated_at',
    ];


    public function getTimezoneAttribute()
    {
        return $this->user->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
    }

    /**
    * Get formated and converted timezone of user's created at.
    *
    * @param string $value
    * @return string
    */
    public function getConvertedCreatedAtAttribute()
    {
        if ($this->created_at==null||!auth()->user()->exists()) {
            return null;
        }
        $timezone = auth()->user()->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
        
        return Carbon::parse($this->created_at)->setTimezone($timezone)->format('jS M h:i A');
    }
    /**
    * Get formated and converted timezone of user's created at.
    *
    * @param string $value
    * @return string
    */
    public function getConvertedUpdatedAtAttribute()
    {
        if ($this->updated_at==null||!auth()->user()->exists()) {
            return null;
        }
        $timezone = auth()->user()->timezone?:env('SYSTEM_DEFAULT_TIMEZONE');
        return Carbon::parse($this->updated_at)->setTimezone($timezone)->format('jS M Y');
    }


}
