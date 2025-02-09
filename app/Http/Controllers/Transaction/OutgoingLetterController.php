<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;

class OutgoingLetterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required',
            'letter_date' => 'required|date',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        // Generate nomor surat otomatis
        $letterNumber = Letter::generateOutgoingNumber();
        
        $letter = Letter::create([
            'type' => 'outgoing',
            'reference_number' => $letterNumber['letter_number'],
            'letter_number' => $letterNumber['letter_number'],
            'auto_number' => $letterNumber['auto_number'],
            'month' => $letterNumber['month'],
            'year' => $letterNumber['year'],
            'letter_date' => $validated['letter_date'],
            'description' => $validated['description'],
            'user_id' => auth()->id()
        ]);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments/outgoing');
                $letter->attachments()->create([
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('transaction.outgoing.index')
            ->with('success', __('messages.created'));
    }
} 