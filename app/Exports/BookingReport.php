<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class BookingReport implements FromView, ShouldAutoSize
{
    use Exportable;
    /**
     *
     */
    public function __construct($result,$type) {
        $this->result = $result;
        $this->type = $type;
    }

    public function view(): View
    {
        // dd($this->result);
        if($this->type == "room")
        {
            return view('admin.reports.export.room', [
                'results' => $this->result,
                'type' => $this->type
            ]);
        }
        if($this->type == "party")
        {
            return view('admin.reports.export.party', [
                'results' => $this->result,
                'type' => $this->type
            ]);
        }
        if($this->type == "sports")
        {
            return view('admin.reports.export.sports', [
                'results' => $this->result,
                'type' => $this->type
            ]);
        }
        
    }
}
