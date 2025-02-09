<?php

namespace App\Exports;

use App\Models\Letter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OutgoingLetterExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Letter::where('type', 'outgoing')
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
            'Lampiran'
        ];
    }

    public function map($letter): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $letter->letter_number,
            $letter->letter_date->format('d/m/Y'),
            $letter->description,
            $letter->attachments->count() . ' file'
        ];
    }
} 