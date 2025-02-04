<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spt extends Model
{
    protected $fillable = [
        'nomor_spt',
        'tanggal',
        'pegawai_id',
        'tujuan',
        'keperluan',
        'type'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'pegawai_id');
    }
}