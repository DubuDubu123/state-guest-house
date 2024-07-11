<?php

namespace App\Exports;

use App\Models\Admin\RegisteredDriver;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RegisteredDriverExport implements FromView
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view() : View
    {
        return view( 'admin.drivers.exports.registeredDriver', ['drivers' => RegisteredDriver::all()]);
    }



}
