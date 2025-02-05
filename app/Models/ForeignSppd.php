<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForeignSppd extends Model
{
    protected $fillable = [
        'nomor_sppd',
        'tanggal',
        'perihal',
        'nomor_spt',
        'nama_yang_bertugas',
        'tanggal_berangkat',
        'tanggal_kembali',
        'status'
    ];

    protected $dates = [
        'tanggal',
        'tanggal_berangkat',
        'tanggal_kembali'
    ];

    public function attachments()
    {
        return $this->hasMany(ForeignSppdAttachment::class);
    }
} 