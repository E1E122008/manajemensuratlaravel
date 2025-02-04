<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingLetter extends Model
{
    protected $fillable = [
        'reference_number',
        'from',
        'agenda_number',
        'letter_date',
        'received_date',
        'description',
        'classification_code',
        'note'
    ];

    protected $casts = [
        'letter_date' => 'date',
        'received_date' => 'date',
    ];

    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_code', 'code');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
} 