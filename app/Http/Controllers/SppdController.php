<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sppd;
use App\Models\Employee;
use App\Exports\SppdExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ForeignSppd;
use App\Exports\ForeignSppdExport;


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
        try {
            // Log request data untuk debugging
            \Log::info('SPPD store request:', $request->all());

            $validated = $request->validate([
                'tanggal' => 'required|date',
                'nama_yang_bertugas' => 'nullable',
                'tujuan' => 'required|string',
                'perihal' => 'nullable',
                'tanggal_berangkat' => 'required|date',
                'tanggal_kembali' => 'required|date|after_or_equal:tanggal_berangkat',
                'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            ], [
                'nama_yang_bertugas.nullable' => 'Kolom nama yang bertugas tidak perlu diisi.',
            ]);

            // Generate nomor SPPD
            $tahun = date('Y');
            $lastNumber = Sppd::whereYear('created_at', $tahun)->max('id') ?? 0;
            $newNumber = $lastNumber + 1;
            $nomor_sppd = sprintf("%03d/SPPD/%s", $newNumber, $tahun);

            // Log data sebelum create
            \Log::info('Data yang akan disimpan:', [
                'nomor_sppd' => $nomor_sppd,
                'validated_data' => $validated
            ]);

            $sppd = Sppd::create([
                'nomor_sppd' => $nomor_sppd,
                'tanggal' => $validated['tanggal'],
                'tujuan' => $validated['tujuan'],
                'perihal' => $validated['perihal'],
                'tanggal_berangkat' => $validated['tanggal_berangkat'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'type' => 'domestic',
                'status' => 'draft'
            ]);

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('sppd-attachments', 'public');
                    $sppd->attachments()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName()
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'SPPD berhasil ditambahkan'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error:', [
                'errors' => $e->errors(),
                'message' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error validasi: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error creating SPPD: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan SPPD: ' . $e->getMessage()
            ], 500);
        }
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
        $sppds = Sppd::where('type', 'domestic')->latest()->get();
        $employees = Employee::select('id', 'nama')->orderBy('nama')->get();
        
        return view('sppd.in.domestic', compact('sppds', 'employees'));
    }

    /**
     * Display foreign SPPD page
     */
    public function foreign()
    {
        $sppds = ForeignSppd::latest()->get();
        return view('sppd.foreign', compact('sppds'));
    }

    public function foreignStore(Request $request)
    {
        try {
            $validated = $request->validate([
                'tanggal' => 'required|date',
                'perihal' => 'required|string',
                'nomor_spt' => 'required|string',
                'nama_yang_bertugas' => 'required|string',
                'tanggal_berangkat' => 'required|date',
                'tanggal_kembali' => 'required|date|after_or_equal:tanggal_berangkat',
                'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
            ]);

            // Generate nomor SPPD
            $tahun = date('Y');
            $lastNumber = ForeignSppd::whereYear('created_at', $tahun)->max('id') ?? 0;
            $newNumber = $lastNumber + 1;
            $nomor_sppd = sprintf("%03d/SPPD-LN/%s", $newNumber, $tahun);

            $sppd = ForeignSppd::create([
                'nomor_sppd' => $nomor_sppd,
                'tanggal' => $validated['tanggal'],
                'perihal' => $validated['perihal'],
                'nomor_spt' => $validated['nomor_spt'],
                'nama_yang_bertugas' => $validated['nama_yang_bertugas'],
                'tanggal_berangkat' => $validated['tanggal_berangkat'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'status' => 'draft'
            ]);

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('foreign-sppd-attachments', 'public');
                    $sppd->attachments()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName()
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'SPPD Luar Daerah berhasil ditambahkan'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error creating foreign SPPD: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan SPPD: ' . $e->getMessage()
            ], 500);
        }
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
        try {
            $sppd = Sppd::findOrFail($id);
            $sppd->delete();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function export()
    {
        return Excel::download(new SppdExport, 'sppd-' . date('Y-m-d') . '.xlsx');
    }

    public function foreignExport()
    {
        return Excel::download(new ForeignSppdExport, 'sppd-luar-daerah-' . date('Y-m-d') . '.xlsx');
    }
}
