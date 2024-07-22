<?php

namespace App\Http\Controllers\Web\Admin\Tripta;

use Socialite;
use Carbon\Carbon;
use App\Models\User;   
use App\http\Controller\Web\Admin\Tripta\EditController;   
use App\Models\BranchImages;   
use App\Http\Controllers\Web\BaseController;
use App\Models\Payment\DriverWallet;
use Kreait\Firebase\Contract\Database;
use App\Base\Constants\Setting\Settings;
use Illuminate\Http\Request;
use Mail; 
use Hash;
use DB; 
use Illuminate\Support\Str;
use App\Jobs\ForgotPassword; 
use App\Base\Libraries\QueryFilter\QueryFilterContract;
use App\Base\Services\ImageUploader\ImageUploaderContract;
use App\Base\Filters\Master\CommonMasterFilter;


class EditController extends BaseController
{
    public function __construct(ImageUploaderContract $imageUploader)
    { 
        $this->imageUploader = $imageUploader; 
    }

    public function index(Request $request)
    { 
       
        $page = trans('pages_names.types');
        $main_menu = 'masters';
        $sub_menu = 'branch';
        
        $branch = Branch::get(); 
        $sub_menu_1 = '';  
        return view('admin.branch.index', compact('page', 'main_menu', 'sub_menu','sub_menu_1','branch'))->render();
    }


    public function fetch(QueryFilterContract $queryFilter,Request $request)
    {  
        $page = trans('pages_names.types');
        $main_menu = 'masters';
        $sub_menu = 'branch';
         
        $sub_menu_1 = '';  
        $query = Branch::query();  
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();
        return view('admin.branch._types', compact('results'))->render(); 
    }

 }
 