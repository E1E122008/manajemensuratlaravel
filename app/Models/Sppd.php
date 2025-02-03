<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sppd extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_urut',           // nomor urut
        'tanggal',              // tanggal
        'perihal',              // perihal
        'nomor_spt',            // nomor spt
        'nama_petugas',         // nama yang ditugaskan
        'tanggal_berangkat',    // tanggal berangkat
        'tanggal_kembali',      // tanggal kembali
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'tanggal_berangkat' => 'datetime',
        'tanggal_kembali' => 'datetime',
    ];

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pengubah()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
} 