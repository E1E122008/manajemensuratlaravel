<?php

namespace App\Exports;

use App\Models\Spt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ForeignSptExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Spt::where('type', 'foreign')
            ->with('employee')
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
            'Tanggal Dibuat'
        ];
    }

    public function map($spt): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $spt->nomor_spt,
            $spt->tanggal->format('d/m/Y'),
            $spt->perihal,
            $spt->employee->nama,
            $spt->created_at->format('d/m/Y')
        ];
    }
} 