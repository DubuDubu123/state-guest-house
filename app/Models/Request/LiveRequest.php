<?php

namespace App\Models\Request;

use Carbon\Carbon;
use App\Models\User;
use App\Base\Uuid\UuidModel;
use App\Models\Admin\Driver;
use App\Models\Admin\ServiceLocation;
use App\Models\Admin\ZoneType;
use App\Models\Admin\UserDetails;
use App\Models\Request\AdHocUser;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasActiveCompanyKey;
use Nicolaslopezj\Searchable\SearchableTrait;
use App\Models\Admin\CancellationReason;
use App\Models\Master\PackageType;
use App\Models\Admin\Owner;

class LiveRequest extends Model
{
    use UuidModel,SearchableTrait,HasActiveCompanyKey;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'live_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['request_id','user_mobile','driver_mobile'];

 
    public function requestDetail()
    {
        return $this->hasOne(Request::class, 'request_id', 'id');
    } 
 
}
