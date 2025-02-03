<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sppd;
use App\Models\Employee;


class SppdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sppds = Sppd::with('employee')->latest()->get();
        $employees = Employee::all();
        
        return view('sppd.domestic', compact('sppds', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_sppd' => 'required|unique:sppds',
            'tanggal' => 'required|date',
            'pegawai_id' => 'required|exists:employees,id',
            'tujuan' => 'required',
            'keperluan' => 'required',
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_berangkat',
        ]);

        Sppd::create($validated);

        return redirect()->route('sppd.index')
            ->with('success', 'SPPD berhasil dibuat');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sppd $sppd)
    {
        $validated = $request->validate([
            'nomor_sppd' => 'required|unique:sppds,nomor_sppd,' . $sppd->id,
            'tanggal' => 'required|date',
            'pegawai_id' => 'required|exists:employees,id',
            'tujuan' => 'required',
            'keperluan' => 'required',
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_berangkat',
        ]);

        $sppd->update($validated);

        return redirect()->route('sppd.index')
            ->with('success', 'SPPD berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sppd $sppd)
    {
        $sppd->delete();

        return redirect()->route('sppd.index')
            ->with('success', 'SPPD berhasil dihapus');
    }

    /**
     * Display domestic SPPD page
     */
    public function domestic()
    {
        $sppds = Sppd::where('type', 'domestic')->get();
        $employees = Employee::all();
        return view('sppd.domestic', compact('sppds', 'employees'));
    }

    /**
     * Display foreign SPPD page
     */
    public function foreign()
    {
        $sppds = Sppd::with('employee')
            ->where('type', 'foreign')
            ->latest()
            ->get();
        $employees = Employee::all();
        
        return view('sppd.foreign', compact('sppds', 'employees'));
    }

    public function foreignStore(Request $request)
    {
        $validated = $request->validate([
            'nomor_urut' => 'required|integer',
            'tanggal' => 'required|date',
            'perihal' => 'required|string',
            'nomor_spt' => 'required|string',
            'nama_petugas' => 'required|string',
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_berangkat',
        ]);

        Sppd::create($validated);

        return redirect()->route('sppd.foreign')->with('success', 'SPPD berhasil dibuat');
    }

    public function domesticStore(Request $request)
    {
        $validated = $request->validate([
            'nomor_urut' => 'required|integer',
            'tanggal' => 'required|date',
            'perihal' => 'required|string',
            'nomor_spt' => 'required|string',
            'nama_petugas' => 'required|string',
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_berangkat',
        ]);

        $validated['type'] = 'domestic';
        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        Sppd::create($validated);

        return redirect()->route('sppd.domestic')->with('success', 'SPPD berhasil dibuat');
    }

    public function domesticUpdate(Request $request, $id)
    {
        // Implementasi update
    }

    public function domesticDestroy($id)
    {
        // Implementasi delete
    }
}
