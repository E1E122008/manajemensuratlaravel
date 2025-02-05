<?php

namespace App\Exports;

use App\Models\ForeignSppd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ForeignSppdExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return ForeignSppd::latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor SPPD',
            'Tanggal',
            'Perihal',
            'Nomor SPT',
            'Nama Yang Bertugas',
            'Tanggal Berangkat',
            'Tanggal Kembali',
            'Status'
        ];
    }

    public function map($sppd): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $sppd->nomor_sppd,
            $sppd->tanggal->format('d/m/Y'),
            $sppd->perihal,
            $sppd->nomor_spt,
            $sppd->nama_yang_bertugas,
            $sppd->tanggal_berangkat->format('d/m/Y'),
            $sppd->tanggal_kembali->format('d/m/Y'),
            $sppd->status
        ];
    }
} 