<?php

namespace App\Models;

use App\Enums\Config as ConfigEnum;
use App\Enums\LetterType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_path',
        'file_name',
        'attachable_id',
        'attachable_type'
    ];

    protected $appends = [
        'path_url',
    ];

    /**
     * @return string
     */
    public function getPathUrlAttribute(): string {
        if (!is_null($this->file_path)) {
            return $this->file_path;
        }

        return asset('storage/attachments/' . $this->file_name);
    }

    public function scopeType($query, LetterType $type)
    {
        return $query->whereHas('letter', function ($query) use ($type) {
            return $query->where('type', $type->type());
        });
    }

    public function scopeIncoming($query)
    {
        return $this->scopeType($query, LetterType::INCOMING);
    }

    public function scopeOutgoing($query)
    {
        return $this->scopeType($query, LetterType::OUTGOING);
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function($query, $find) {
            return $query
                ->where('file_name', 'LIKE', '%' . $find . '%')
                ->orWhereHas('letter', function ($query) use ($find) {
                    return $query->where('reference_number', $find);
                });
        });
    }

    public function scopeRender($query, $search)
    {
        return $query
            ->with(['letter'])
            ->search($search)
            ->latest('created_at')
            ->paginate(Config::getValueByCode(ConfigEnum::PAGE_SIZE))
            ->appends([
                'search' => $search,
            ]);
    }

    /**
     * @return BelongsTo
     */
    public function letter(): BelongsTo
    {
        return $this->belongsTo(Letter::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attachable()
    {
        return $this->morphTo();
    }
}
