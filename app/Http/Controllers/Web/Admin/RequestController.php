<?php

namespace App\Http\Controllers\Web\Admin;

use App\Base\Filters\Admin\RequestFilter;
use App\Base\Filters\Master\CommonMasterFilter;
use App\Base\Libraries\QueryFilter\QueryFilterContract;
use App\Http\Controllers\Controller;
use App\Models\Request\Request as RequestRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Request\DriverRejectedRequest;

class RequestController extends Controller
{
    public function index()
    {
//        dd($created_request);
        $page = trans('pages_names.request');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'trip-request';
        $sub_menu_1 = 'request'; 
        return view('admin.request.index', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));
    }

    public function getAllRequest(QueryFilterContract $queryFilter)
    {
//        dd(Carbon::now());
        $query = RequestRequest::companyKey()->whereIsCompleted(true);

        $results = $queryFilter->builder($query)->customFilter(new RequestFilter)->defaultSort('-created_at')->paginate();

        return view('admin.request._request', compact('results'));
    }

    public function retrieveSingleRequest(RequestRequest $request){
        $item = $request;

        return view('admin.request._singlerequest', compact('item'));
    }

    public function getSingleRequest(RequestRequest $request)
    {
        $page = trans('pages_names.request');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'trip-request';
        $sub_menu_1 = '';
        

        $item = $request;

        return view('admin.request.requestview', compact('page', 'main_menu', 'sub_menu', 'item','sub_menu_1'));
    }

    public function fetchSingleRequest(RequestRequest $request){
        return $request;
    }

     public function requestDetailedView(RequestRequest $request){
        $item = $request;
        $page = trans('pages_names.request');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'trip-request';
        $sub_menu_1 = '';

        return view('admin.request.trip-request',compact('item','page', 'main_menu', 'sub_menu','sub_menu_1'));
    }

     public function indexScheduled()
    {
        $page = trans('pages_names.request');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'trip-request';
        $sub_menu_1 = 'scheduled-rides';

        return view('admin.scheduled-rides.index', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));
    }

     public function getAllScheduledRequest(QueryFilterContract $queryFilter)
    {
        $query = RequestRequest::companyKey()->whereIsCompleted(false)->whereIsCancelled(false)->whereIsLater(true);
        $results = $queryFilter->builder($query)->customFilter(new RequestFilter)->defaultSort('-created_at')->paginate();

        return view('admin.scheduled-rides._scheduled', compact('results'));
    }

    /**
     * View Invoice
     *
     * */
    public function viewCustomerInvoice(RequestRequest $request_detail){

        $data = $request_detail;

        return view('email.invoice',compact('data'));

    }
    /**
     * View Invoice
     *
     * */
    public function viewDriverInvoice(RequestRequest $request_detail){

        $data = $request_detail;

        return view('email.driver_invoice',compact('data'));

    }
    public function getCancelledRequest(RequestRequest $request)
    {
        $page = trans('pages_names.request');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'trip-request';
        $sub_menu_1 = 'cancellation-rides';

        $item = $request;

        return view('admin.request.Cancelledview', compact('page', 'main_menu', 'sub_menu', 'item','sub_menu_1'));
    }

    public function delete(RequestRequest $request)
    {
        if(env('APP_FOR')=='demo'){

        return $message = 'you cannot delete the request. this is demo version';

        }
        // dd($request);
        $request->delete();

        $message = trans('succes_messages.trip_request_deleted_succesfully');

        return redirect('requests')->with('success', $message);
    }
    public function trackRequest(RequestRequest $request)
    {
        $page = trans('pages_names.request');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'trip-request';
        $sub_menu_1 = 'trip-request';

        // $trackRequests = DriverRejectedRequest::where('request_id', $request->id)->paginate(10);
        $trackRequests = DriverRejectedRequest::where('request_id', $request->id)
            ->orderBy('created_at', 'asc') // Change 'asc' to 'desc' if you want descending order
            ->paginate(10);


        return view('admin.request.reqest_timeline', compact('page', 'main_menu', 'sub_menu', 'trackRequests','sub_menu_1','request'));

    }
    public function dispatcherIndex()
    {
        //dd($created_request);
        $page = trans('pages_names.request');
        $main_menu = 'drivers_and_users';
        $sub_menu = 'trip-request';
        $sub_menu_1 = 'dispatcher-request';

        return view('admin.request.dispatcherIndex', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));
    }

    public function getAllDispatcherRequest(QueryFilterContract $queryFilter)
    {
        //dd(Carbon::now());
        $query = RequestRequest::where('if_dispatch', true);

        $results = $queryFilter->builder($query)->customFilter(new RequestFilter)->defaultSort('-created_at')->paginate();

        return view('admin.request._dispatcher_request', compact('results'));
    }

}
