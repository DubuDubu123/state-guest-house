<?php

namespace App\Http\Controllers\Web\Admin\Tripta;

use Socialite;
use Carbon\Carbon;
use App\Models\User;   
use App\Models\Branch;   
use App\Models\BranchImages;   
use App\Http\Controllers\Web\BaseController;
use App\Models\Payment\DriverWallet;
use App\Http\Controller\Web\Admin\store;
use App\Http\Controller\Web\Admin\Role;
use Kreait\Firebase\Contract\Database;
use App\Base\Constants\Auth\Role as RoleSlug;
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


class BranchController extends BaseController
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
    /**
    * Create Admins View
    *
    */
    public function create()
    {
        $page = trans('pages_names.add_admin'); 

        $page = trans('pages_names.types');
        $main_menu = 'masters';
        $sub_menu = 'branch';
        $sub_menu_1 = '';  
        return view('admin.branch.create', compact( 'page', 'main_menu', 'sub_menu','sub_menu_1'));
    } 



    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'branch_name' => 'required',
            'address' => 'required'
        ]);

        // Create a new instance of YourModel
        $data = new branch();

        // Assign the validated data to the model properties
        $data->title = $request->branch_name;
        $data->location = $request->address;
        $data->save();

        // Optionally, you can return a response or redirect
        $message ="Data stored successfully";
        return redirect('branch');
    }


    public function edit($id)
    {
        $page = trans('pages_names.types');
        $main_menu = 'masters';
        $sub_menu = 'branch';
        
        $branch = Branch::where('id',$id)->get(); 
        $sub_menu_1 = '';  
        return view('admin.branch.edit', compact('page', 'main_menu', 'sub_menu','sub_menu_1','branch'));
    }


    public function update(Request $request)
    {
        $data = Branch::find($request ->id);

        // Assign the validated data to the model properties
        $data->title = $request->branch_name;
        $data->location = $request->address;
        $data->save(); 
        $message ="Data stored successfully";
        return redirect('branch');
    }
    public function delete(Request $request)
    {
        $data = Branch::findOrFail($request ->id);

        // Assign the validated data to the model properties
        $data->title = $request->branch_name;
        $data->location = $request->address;
        $data->delete(); 
        $message ="Data Deleted successfully";
        return redirect('branch');
    }


    public function InActive($id)
    {
        $page = trans('pages_names.types');
        $main_menu = 'masters';
        $sub_menu = 'branch';
        
        $branch = Branch::where('id',$id)->get(); 
        $sub_menu_1 = '';  
        return view('admin.branch.InActive', compact('page', 'main_menu', 'sub_menu','sub_menu_1','branch'));
    }










 }





 