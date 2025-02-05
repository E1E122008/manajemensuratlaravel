<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForeignSppdAttachment extends Model
{
    protected $fillable = [
        'foreign_sppd_id',
        'file_path',
        'file_name'
    ];

    public function sppd()
    {
        return $this->belongsTo(ForeignSppd::class);
    }
} 