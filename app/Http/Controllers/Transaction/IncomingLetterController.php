<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\IncomingLetter;
use App\Models\Classification;
use Illuminate\Http\Request;

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
            'reference_number' => 'required|string|max:255',
            'from' => 'required|string|max:255',
            'agenda_number' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'received_date' => 'required|date',
            'description' => 'required|string',
            'classification_code' => 'required|exists:classifications,code',
            'note' => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        IncomingLetter::create($validated);

        return redirect()->route('transaction.incoming.index')
            ->with('success', 'Surat masuk berhasil ditambahkan');
    }

    public function index(Request $request)
    {
        $search = $request->input('search'); // Get the search input
        
        $incomingLetters = IncomingLetter::with('classification')
            ->when($search, function ($query) use ($search) {
                return $query->where('reference_number', 'like', "%{$search}%")
                             ->orWhere('from', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        // Retrieve classifications
        $classifications = Classification::all();

        return view('pages.transaction.incoming.index', compact('incomingLetters', 'search', 'classifications'));
    }
} 