<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sppd extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_sppd',
        'tanggal',
        'pegawai_id',
        'tujuan',
        'keperluan',
        'tanggal_berangkat',
        'tanggal_kembali',
        'type',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_berangkat' => 'date',
        'tanggal_kembali' => 'date'
    ];

    public function attachments()
    {
        return $this->hasMany(SppdAttachment::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Employee::class, 'pegawai_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
} 