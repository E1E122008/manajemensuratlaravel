<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Services\AttachmentService;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    protected $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function destroy(Request $request)
    {
        $attachment = Attachment::findOrFail($request->id);
        
        $this->attachmentService->destroy($attachment);

        return response()->json([
            'message' => 'Lampiran berhasil dihapus'
        ]);
    }
} 