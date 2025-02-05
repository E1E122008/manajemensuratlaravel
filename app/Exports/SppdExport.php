<?php

namespace App\Exports;

use App\Models\Sppd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SppdExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Sppd::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Perihal',
            'Nomor Surat',
            'Nama yang Bertugas',
            'Tanggal Berangkat',
            'Tanggal Kembali'
        ];
    }

    public function map($sppd): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $sppd->tanggal->format('d/m/Y'),
            $sppd->perihal,
            $sppd->nomor_spt,
            $sppd->nama_yang_bertugas,
            $sppd->tanggal_berangkat->format('d/m/Y'),
            $sppd->tanggal_kembali->format('d/m/Y')
        ];
    }
} 