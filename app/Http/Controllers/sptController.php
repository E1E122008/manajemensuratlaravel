<?php

namespace App\Http\Controllers;

use App\Models\Spt;
use App\Models\Employee;
use App\Models\ForeignSpt;
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
        $spts = ForeignSpt::with('employee')->latest()->get();
        $employees = Employee::all();
        
        return view('spt.outg.foreign', compact('spts', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug: Log data yang diterima
        \Log::info('Data SPT yang diterima:', $request->all());

        $validated = $request->validate([
            'nomor_spt' => 'required|unique:spts,nomor_spt',
            'tanggal' => 'required|date',
            'pegawai_id' => 'required|exists:employees,id',
            'tujuan' => 'required',
            'keperluan' => 'required',
            'type' => 'required|in:domestic,foreign'
        ]);

        try {
            // Debug: Log data yang akan disimpan
            \Log::info('Data SPT yang akan disimpan:', $validated);
            
            $spt = Spt::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'SPT berhasil dibuat',
                'data' => $spt
            ]);
        } catch (\Exception $e) {
            \Log::error('Error saat menyimpan SPT: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a foreign SPT
     */
    public function storeForeign(Request $request)
    {
        $validated = $request->validate([
            'nomor_spt' => 'required|unique:foreign_spts,nomor_spt',
            'tanggal' => 'required|date',
            'pegawai_id' => 'required|exists:employees,id',
            'tujuan' => 'required',
            'keperluan' => 'required',
            'lama_tugas' => 'required|integer|min:1'
        ]);

        try {
            $spt = ForeignSpt::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'SPT Luar Daerah berhasil dibuat',
                'data' => $spt
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
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

        try {
            $spt->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'SPT berhasil diperbarui',
                'data' => $spt
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spt $spt)
    {
        try {
            $spt->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'SPT berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyForeign($id)
    {
        try {
            $spt = ForeignSpt::findOrFail($id);
            $spt->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'SPT Luar Daerah berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function foreignIndex()
    {
        $spts = Spt::where('type', 'foreign')->get(); // Adjust the query as necessary
        return view('spt.outg.foreign', compact('spts')); // Ensure this line references 'spt.outg.foreign'
    }
}


