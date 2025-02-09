<?php

namespace App\Exports;

use App\Models\Letter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IncomingLetterExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Letter::where('type', 'incoming')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Surat',
            'Pengirim',
            'Tanggal Surat',
            'Tanggal Diterima',
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
            $letter->reference_number,
            $letter->sender,
            $letter->letter_date->format('d/m/Y'),
            $letter->received_date->format('d/m/Y'),
            $letter->description,
            $letter->attachments->count() . ' file'
        ];
    }
} 