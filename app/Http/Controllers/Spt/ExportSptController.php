<?php

namespace App\Http\Controllers\Spt;

use App\Http\Controllers\Controller;
use App\Models\Spt;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DomesticSptExport;
use App\Exports\ForeignSptExport;

class ExportSptController extends Controller
{
    public function exportDomestic()
    {
        return Excel::download(new DomesticSptExport, 'spt-dalam-daerah-' . date('Y-m-d') . '.xlsx');
    }

    public function exportForeign()
    {
        return Excel::download(new ForeignSptExport, 'spt-luar-daerah-' . date('Y-m-d') . '.xlsx');
    }
} 