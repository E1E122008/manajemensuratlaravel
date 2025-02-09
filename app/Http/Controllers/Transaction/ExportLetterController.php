<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncomingLetterExport;
use App\Exports\OutgoingLetterExport;

class ExportLetterController extends Controller
{
    public function exportIncoming()
    {
        return Excel::download(new IncomingLetterExport, 'surat-masuk-' . date('Y-m-d') . '.xlsx');
    }

    public function exportOutgoing()
    {
        return Excel::download(new OutgoingLetterExport, 'surat-keluar-' . date('Y-m-d') . '.xlsx');
    }
} 