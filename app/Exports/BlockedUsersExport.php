<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class BlockedUsersExport implements FromView, ShouldAutoSize
{
    use Exportable;
    /**
     *
     */
    public function __construct($result) {
        $this->result = $result;
    }

    public function view(): View
    {
        // dd($this->result);
        return view('admin.users.exports.blocked_users', [
            'results' => $this->result
        ]);
    }
}
