<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AttachmentService
{
    public function store($letter, $attachments)
    {
        if (!is_array($attachments)) {
            $attachments = [$attachments];
        }

        foreach ($attachments as $file) {
            if ($file instanceof UploadedFile) {
                $path = $file->store('attachments/' . $letter->type);
                $letter->attachments()->create([
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path
                ]);
            }
        }
    }

    public function destroy($attachment)
    {
        if (Storage::exists($attachment->path)) {
            Storage::delete($attachment->path);
        }
        
        return $attachment->delete();
    }
} 