<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'pangkat',
        'golongan',
        'unit_kerja',
        'created_by',
        'updated_by'
    ];

    // Relasi dengan user
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pengubah()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function sppds()
    {
        return $this->hasMany(Sppd::class, 'pegawai_id');
    }

    public function spts()
    {
        return $this->hasMany(Spt::class, 'pegawai_id');
    }
}
