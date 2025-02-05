<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppdAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sppd_id',
        'file_path',
        'file_name'
    ];

    public function sppd()
    {
        return $this->belongsTo(Sppd::class);
    }
} 