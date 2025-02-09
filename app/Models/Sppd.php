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

    public static function generateDomesticNumber()
    {
        $year = date('Y');
        $month = date('m');
        
        $lastNumber = self::where('type', 'domestic')
            ->where('year', $year)
            ->where('month', $month)
            ->max('auto_number');
            
        $newNumber = ($lastNumber ?? 0) + 1;
        
        return [
            'nomor_sppd' => "100.3.5.4/{$newNumber}/DD/BH/{$month}/{$year}",
            'auto_number' => $newNumber,
            'month' => $month,
            'year' => $year
        ];
    }

    public static function generateForeignNumber()
    {
        $year = date('Y');
        $month = date('m');
        
        $lastNumber = self::where('type', 'foreign')
            ->where('year', $year)
            ->where('month', $month)
            ->max('auto_number');
            
        $newNumber = ($lastNumber ?? 0) + 1;
        
        return [
            'nomor_sppd' => "000.1.2.3/{$newNumber}/LD/BH/{$month}/{$year}",
            'auto_number' => $newNumber,
            'month' => $month,
            'year' => $year
        ];
    }
} 