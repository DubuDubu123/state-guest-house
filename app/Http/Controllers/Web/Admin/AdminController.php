<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Web\BaseController;
use App\Http\Requests\Admin\Driver\CreateDriverRequest;
use App\Http\Requests\Admin\Driver\UpdateDriverRequest;
use App\Base\Services\ImageUploader\ImageUploaderContract;
use App\Models\Admin\AdminDetail;
use App\Base\Constants\Auth\Role as RoleSlug;
use App\Models\User;
use App\Models\Admin\Driver;
use App\Base\Libraries\QueryFilter\QueryFilterContract;
use App\Base\Filters\Master\CommonMasterFilter;
use App\Http\Requests\Admin\AdminDetail\CreateAdminRequest;
use App\Http\Requests\Admin\AdminDetail\UpdateAdminRequest;
use App\Http\Requests\Admin\AdminDetail\UpdateProfileRequest;
use App\Models\Admin\Company;
use App\Models\Country;
use App\Models\UsersMembership; 
use App\Models\Access\Role;
use App\Models\Admin\ServiceLocation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Imports\DriversImport;
use Maatwebsite\Excel\Facades\Excel;

/**
 * @resource Driver
 *
 * vechicle types Apis
 */
class AdminController extends BaseController
{
    /**
     * The Driver model instance.
     *
     * @var \App\Models\Admin\AdminDetail
     */
    protected $admin_detail;

    /**
     * The User model instance.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * The
     *
     * @var App\Base\Services\ImageUploader\ImageUploaderContract
     */
    protected $imageUploader;


    /**
     * DriverController constructor.
     *
     * @param \App\Models\Admin\AdminDetail $admin_detail
     */
    public function __construct(AdminDetail $admin_detail, ImageUploaderContract $imageUploader, User $user)
    {
        $this->admin_detail = $admin_detail;
        $this->imageUploader = $imageUploader;
        $this->user = $user;
    }

    /**
    * Get all admins
    * @return \Illuminate\Http\JsonResponse
    */
    public function index()
    {
        $page = trans('pages_names.admins');

        $main_menu = 'settings';
        $sub_menu = 'admin';
        $sub_menu_1 = '';
        
        return view('admin.admin.index', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));
    }

    public function getAllAdmin(QueryFilterContract $queryFilter)
    {
        $url = request()->fullUrl(); //get full url

        if (access()->hasRole(RoleSlug::SUPER_ADMIN)) {
            $query = AdminDetail::query();
            if (env('APP_FOR')=='demo') {
                $query = AdminDetail::whereHas('user', function ($query) {
                    $query->where('company_key', auth()->user()->company_key);
                });
            }
        } else {
            $this->validateAdmin();
            $query = $this->admin_detail->where('created_by', $this->user->id);
        }

        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();
        // print_r($results);
        // exit;

        return view('admin.admin._admin', compact('results'));
    }

    /**
    * Create Admins View
    *
    */
    public function create()
    {
        $page = trans('pages_names.add_admin');
        $admins = User::companyKey()->doesNotBelongToRole(RoleSlug::SUPER_ADMIN)->get();

        if (access()->hasRole(RoleSlug::SUPER_ADMIN)) {
            $roles = Role::whereIn('slug', RoleSlug::adminRoles())->get();
        } else {
            $this->validateAdmin();
            $roles = Role::whereIn('slug', RoleSlug::exceptSuperAdminRoles())->get();
        }

        $countries = Country::active()->get();
        $services = ServiceLocation::companyKey()->active()->get();

        $main_menu = 'settings';
        $sub_menu = 'admin';
        $sub_menu_1 = '';

        return view('admin.admin.create', compact('admins', 'page', 'countries', 'main_menu', 'sub_menu','sub_menu_1', 'roles', 'services'));
    }

    /**
     * Store admin.
     *
     * @param \App\Http\Requests\Admin\Driver\CreateDriverRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // dd($request->all());

        // Excel::import(new DriversImport, request()->file('profile_picture'));


        // dd($request->all());
        if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('admins/edit/')->with('warning', $message);
        }
        
         if($request->role == "mess-manager")
        { 
            $admins = User::where('email',$request->email)->doesNotBelongToRole(RoleSlug::MESS_MANAGER)->get();
        }
        else{
            $admins = User::where('email',$request->email)->doesNotBelongToRole(RoleSlug::SUPER_ADMIN)->get(); 
        } 
        if(count($admins) > 0)
        {
              return redirect('admins/create')->with('warning', 'Email Address already Exist'); 
        }



        $created_params = $request->only([ 'first_name','email','city']); 
        $created_params['created_by'] = auth()->user()->id; 
         

        $user_params = ['name'=>$request->input('first_name'),
            'email'=>$request->input('email'),
            // 'mobile'=>$request->input('mobile'),
            'mobile_confirmed'=>true, 
            'password' => bcrypt($request->input('password'))      
        ];

        if (env('APP_FOR')=='demo') {
            $user_params['company_key'] = auth()->user()->company_key;
        }
         
        $user = $this->user->create($user_params);


        if ($uploadedFile = $this->getValidatedUpload('profile_picture', $request)) {
            $user->profile_picture = $this->imageUploader->file($uploadedFile)
                ->saveProfilePicture();
            $user->save();
        }

        $user->attachRole($request->role);

        $user->admin()->create($created_params);

        $message = trans('succes_messages.admin_added_succesfully');
        return redirect('admins')->with('success', $message);
    }


    public function getById(AdminDetail $admin)
    {
        

        $page = trans('pages_names.edit_admin');

        if (access()->hasRole(RoleSlug::SUPER_ADMIN)) {
            $roles = Role::whereIn('slug', RoleSlug::adminRoles())->get();
        } else {
            $this->validateAdmin();
            $roles = Role::whereIn('slug', RoleSlug::adminRoles())->get();
        }
        $services = ServiceLocation::active()->get(); 
        $item = $admin;
        $main_menu = 'settings';
        $sub_menu = 'admin';
        $sub_menu_1 = '';

        return view('admin.admin.update', compact('item', 'services', 'page', 'main_menu', 'sub_menu','sub_menu_1', 'roles'));
    }


    public function update(AdminDetail $admin, Request $request)
    {
        // dd("testt");
        // dd($request->all());   
        if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('admins')->with('warning', $message);
        } 
        if($request->role == "mess-manager")
        { 
            $admins = User::where('email',$request->email)->doesNotBelongToRole(RoleSlug::MESS_MANAGER)->get();
        }
        else{
            $admins = User::where('email',$request->email)->doesNotBelongToRole(RoleSlug::SUPER_ADMIN)->get(); 
        } 
        if(count($admins) > 0)
        {
              return redirect('admins/edit/'.$admin->id.'')->with('warning', 'Email Address already Exists'); 
        }
        $updatedParams = $request->only(['first_name','email','city']);
        $updatedParams['pincode'] = $request->postal_code;
       
        $updatedParams['updated_by'] = auth()->user()->id;

        $updated_user_params = ['name'=>$request->input('first_name'),
            'email'=>$request->input('email'), 
            'password' => bcrypt($request->input('password'))
        ]; 
       

        if ($uploadedFile = $this->getValidatedUpload('profile_picture', $request)) {
            $updated_user_params['profile_picture'] = $this->imageUploader->file($uploadedFile)
                ->saveProfilePicture();
        }

        $admin->user->update($updated_user_params);

        $admin->user->roles()->detach();

        $admin->user->attachRole($request->role);
        // dd($admin);
        $admin->update($updatedParams);

        $message = trans('succes_messages.admin_updated_succesfully');
        return redirect('admins')->with('success', $message);
    }
    public function toggleStatus(User $user)
    {
        if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('admins')->with('warning', $message);
        }
        
        $status = $user->isActive() ? false: true;
        $user->update(['active' => $status]);

        $message = trans('succes_messages.admin_status_changed_succesfully');
        return redirect('admins')->with('success', $message);
    }

    public function delete(User $user)
    {
        if(env('APP_FOR')=='demo'){

        $message = 'you cannot perform this action due to demo version';
        
        return $message;

        }
        $user->delete();

        $message = trans('succes_messages.admin_deleted_succesfully');

        return $message;
        // return redirect('admins')->with('success', $message);
    }

    public function viewProfile(User $user)
    {
        // dd($user);
        $page = trans('pages_names.admins');

        $main_menu = 'settings';
        $sub_menu = 'admin';
        $sub_menu_1 = '';
        $membership_data = UsersMembership::where('user_id',$user->id)->limit(1)->first();

        return view('admin.admin.profile', compact('page', 'main_menu', 'sub_menu', 'sub_menu_1', 'user','membership_data'));
    }

    public function updateProfile(UpdateProfileRequest $request, User $user)
    {
        if(env('APP_FOR')=='demo'){

        $message = 'you cannot update the profile due to demo version';
        
        return redirect('admins')->with('success', $message);

        }
        // dd($request->all());
        if ($request->action == 'password') {
            $updated_user_params['password'] = bcrypt($request->input('password'));
        } else {
            $updatedParams = $request->only(['first_name', 'last_name','mobile','email','address']);

            $updated_user_params = ['name'=>$request->input('first_name'),
                'email'=>$request->input('email'),
                'mobile'=>$request->input('mobile'),
                'address'=>$request->input('address')
            ];

            if ($uploadedFile = $this->getValidatedUpload('profile_picture', $request)) {
                $updated_user_params['profile_picture'] = $this->imageUploader->file($uploadedFile)
                    ->saveProfilePicture();
            }

            $user->admin->update($updatedParams);
        }

        $user->update($updated_user_params);

        $message = trans('succes_messages.admin_profile_updated_succesfully');
        return redirect('admins/profile/'.$user->id.'')->with('success', $message);
    }
}
