<?php

namespace App\Http\Controllers\Sppd;

use App\Http\Controllers\Controller;
use App\Models\Sppd;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DomesticSppdExport;
use App\Exports\ForeignSppdExport;

class ExportSppdController extends Controller
{
    public function exportDomestic()
    {
        return Excel::download(new DomesticSppdExport, 'sppd-dalam-daerah-' . date('Y-m-d') . '.xlsx');
    }

    public function exportForeign()
    {
        return Excel::download(new ForeignSppdExport, 'sppd-luar-daerah-' . date('Y-m-d') . '.xlsx');
    }
} 