<?php

namespace App\Http\Controllers\Web\Master;

use App\Base\Filters\Master\CommonMasterFilter;
use App\Base\Libraries\QueryFilter\QueryFilterContract;
use App\Http\Controllers\Web\BaseController;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Base\Services\ImageUploader\ImageUploaderContract;



class CountryController extends BaseController
{
    protected $country;

    /**
     * CarMakeController constructor.
     *
     * @param \App\Models\Admin\Country $country
     */
    public function __construct(Country $country, ImageUploaderContract $imageUploader)
    {
        $this->country = $country;
        $this->imageUploader = $imageUploader;
    }

    public function index()
    {

      
        $page = trans('pages_names.view_country');

        $main_menu = 'master';
        $sub_menu = 'country';
        $sub_menu_1 = '';

        return view('admin.master.country.index', compact('page', 'main_menu', 'sub_menu', 'sub_menu_1'));
    }

    public function fetch(QueryFilterContract $queryFilter)
    {
        $query = $this->country->query();//->active()
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();

        return view('admin.master.country._country', compact('results'));
    }

    public function create()
    {
        $page = trans('pages_names.add_country');

        $main_menu = 'master';
        $sub_menu = 'country';
        $sub_menu_1 = '';

        return view('admin.master.country.create', compact('page', 'main_menu', 'sub_menu', 'sub_menu_1'));
    }

    public function store(Request $request)
    {
        if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('country')->with('warning', $message);
        }

        Validator::country($request->all(), [
            'name' => 'required|unique:country,name'
        ])->validate();

        $created_params = $request->only(['name']);
        $created_params['active'] = 1;

        // $created_params['company_key'] = auth()->user()->company_key;

        $this->country->create($created_params);

        $message = trans('succes_messages.country_added_succesfully');

        return redirect('country')->with('success', $message);
    }

    public function getById(Country $country)
    {

        // dd($country);
        $page = trans('pages_names.edit_country');

        $main_menu = 'master';
        $sub_menu = 'country';
        $sub_menu_1 = '';
        $item = $country;

        return view('admin.master.country.update', compact('item', 'page', 'main_menu', 'sub_menu', 'sub_menu_1'));
    }

       public function rules()
    {
        return [
            'flag'=>$this->saveCountryFlagImage(),
        ];
    }

    public function update(Request $request, Country $country)
    {
        if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('country')->with('warning', $message);
        }
        

        Validator::make($request->all(), [
            'name' => 'required',
            'currency_code' => 'required',
            'currency_symbol' => 'required',
            // 'flag'=> 'required',
            // 'flag' => 'required | mimes:jpeg,jpg,png',


        ])->validate();

        // dd($request->all());
     
        $updated_params = $request->all();

        if ($uploadedFile = $this->getValidatedUpload('flag', $request)) {
            $updated_params['flag'] = $this->imageUploader->file($uploadedFile)
                ->saveCountryFlagImage();
        }


        // $request->$updated_params['flag'];
        $country->update($updated_params);
        $message = trans('succes_messages.country_updated_succesfully');
        return redirect('country')->with('success', $message);
    }

    public function toggleStatus(Country $country)
    {
        $status = $country->isActive() ? false: true;
        $country->update(['active' => $status]);

        $message = trans('succes_messages.country_status_changed_succesfully');
        return redirect('country')->with('success', $message);
    }

    public function delete(Country $country)
    {
        if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('country')->with('warning', $message);
        }
        $country->delete();

        $message = trans('succes_messages.country_deleted_succesfully');
        return redirect('country')->with('success', $message);
    }
}
