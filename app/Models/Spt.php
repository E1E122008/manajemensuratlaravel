<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spt extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['tanggal', 'created_at', 'updated_at'];

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
            'nomor_spt' => "100.3.5.4/{$newNumber}/DD/BH/{$month}/{$year}",
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
            'nomor_spt' => "100.2.10/{$newNumber}/LD/BH/{$month}/{$year}",
            'auto_number' => $newNumber,
            'month' => $month,
            'year' => $year
        ];
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'pegawai_id');
    }
}