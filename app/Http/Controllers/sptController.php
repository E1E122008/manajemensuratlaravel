<?php

namespace App\Http\Controllers;

use App\Models\Spt;
use App\Models\Employee;
use Illuminate\Http\Request;

class SptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spts = Spt::with('employee')->latest()->get();
        $employees = Employee::all();
        
        return view('spt.index', compact('spts', 'employees'));
    }
    

    /**
     * Display domestic SPT page
     */
    public function domestic()
    {
        $spts = Spt::with('employee')
            ->where('type', 'domestic')
            ->latest()
            ->get();
        $employees = Employee::all();
        
        return view('spt.in.domestic', compact('spts', 'employees'));
    }

    /**
     * Display foreign SPT page
     */
    public function foreign()
    {
        $spts = Spt::with('employee')
            ->where('type', 'foreign')
            ->latest()
            ->get();
        $employees = Employee::all();
        
        return view('spt.outg.foreign', compact('spts', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeDomestic(Request $request)
    {
        $validated = $request->validate([
            'nomor_spt' => 'required|unique:spts',
            'tanggal' => 'required|date',
            'pegawai_id' => 'required|exists:employees,id',
            'tujuan' => 'required',
            'keperluan' => 'required',
        ]);

        $validated['type'] = 'domestic';

        Spt::create($validated);

        return redirect()->route('spt.domestic')
            ->with('success', 'SPT Dalam Daerah berhasil dibuat');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeForeign(Request $request)
    {
        $validated = $request->validate([
            'nomor_spt' => 'required|unique:spts',
            'tanggal' => 'required|date',
            'pegawai_id' => 'required|exists:employees,id',
            'tujuan' => 'required',
            'keperluan' => 'required',
        ]);

        $validated['type'] = 'foreign';

        Spt::create($validated);

        return redirect()->route('spt.foreign')
            ->with('success', 'SPT Luar Daerah berhasil dibuat');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Spt $spt)
    {
        $validated = $request->validate([
            'nomor_spt' => 'required|unique:spts,nomor_spt,' . $spt->id,
            'tanggal' => 'required|date',
            'pegawai_id' => 'required|exists:employees,id',
            'tujuan' => 'required',
            'keperluan' => 'required',
        ]);

        $spt->update($validated);

        return redirect()->back()
            ->with('success', 'SPT berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spt $spt)
    {
        $spt->delete();

        return redirect()->back()
            ->with('success', 'SPT berhasil dihapus');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_urut' => 'required|integer',
            'tanggal' => 'required|date',
            'perihal' => 'required|string',
            'nama_yang_bertugas' => 'required|string',
            'attachments.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048', // Adjust as needed
        ]);

        $spt = new Spt();
        $spt->nomor_urut = $request->nomor_urut;
        $spt->tanggal = $request->tanggal;
        $spt->perihal = $request->perihal;
        $spt->nama_yang_bertugas = $request->nama_yang_bertugas;

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                $spt->attachments()->create(['path' => $path]);
            }
        }

        $spt->save();

        return redirect()->route('spt.domestic.index')->with('success', 'SPT created successfully.');
    }

    public function foreignIndex()
    {
        $spts = Spt::where('type', 'foreign')->get(); // Adjust the query as necessary
        return view('spt.outg.foreign', compact('spts')); // Ensure this line references 'spt.outg.foreign'
    }
}
