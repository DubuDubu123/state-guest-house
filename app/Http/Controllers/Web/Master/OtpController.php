<?php

namespace App\Http\Controllers\Web\Master;

use App\Base\Filters\Master\CommonMasterFilter;
use App\Base\Libraries\QueryFilter\QueryFilterContract;
use App\Http\Controllers\Web\BaseController;
use App\Models\MobileOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class OtpController extends BaseController
{
    
    protected $mobileOtp;

    /**
     * DriverNeededDocumentController constructor.
     *
     * @param \App\Models\Admin\DriverNeededDocument $neededDoc
     */
    public function __construct(MobileOtp $mobileOtp)
    {
        $this->mobileOtp = $mobileOtp;
    }

    public function index()
    {
        $page = trans('pages_names.otp');

        $main_menu = 'master';
        $sub_menu = 'otp';
        $sub_menu_1 = '';

        // $currentTimeInIST = Carbon::now('Asia/Kolkata');
        // dd(Carbon::now()->format('l'));

        return view('admin.master.otp.index', compact('page', 'main_menu', 'sub_menu', 'sub_menu_1'));
    }

    public function fetch(QueryFilterContract $queryFilter)
    {
        $query = $this->mobileOtp->query();//->active()
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();

        return view('admin.master.otp._otp', compact('results'));
    }

  
}
