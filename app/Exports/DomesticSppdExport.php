<?php

namespace App\Exports;

use App\Models\Sppd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DomesticSppdExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Sppd::where('type', 'domestic')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Surat',
            'Tanggal',
            'Perihal',
            'Nama yang Ditugaskan',
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
            $sppd->nomor_sppd,
            $sppd->tanggal->format('d/m/Y'),
            $sppd->perihal,
            $sppd->nama_yang_bertugas,
            $sppd->tanggal_berangkat->format('d/m/Y'),
            $sppd->tanggal_kembali->format('d/m/Y')
        ];
    }
} 