<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\IncomingLetter;
use App\Models\Classification;
use Illuminate\Http\Request;
use App\Models\Letter;

class IncomingLetterController extends Controller
{
    public function create()
    {
        $classifications = Classification::all();
        return view('pages.transaction.incoming.create', compact('classifications'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference_number' => 'required',
            'sender' => 'required',
            'letter_date' => 'required|date',
            'received_date' => 'required|date',
            'description' => 'required',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        $letter = Letter::create([
            'type' => 'incoming',
            'reference_number' => $validated['reference_number'],
            'sender' => $validated['sender'],
            'letter_date' => $validated['letter_date'],
            'received_date' => $validated['received_date'],
            'description' => $validated['description'],
            'user_id' => auth()->id()
        ]);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments/incoming');
                $letter->attachments()->create([
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('transaction.incoming.index')
            ->with('success', __('messages.created'));
    }

    public function index()
    {
        $incomingLetters = Letter::where('type', 'incoming')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('pages.transaction.incoming.index', compact('incomingLetters'));
    }
} 