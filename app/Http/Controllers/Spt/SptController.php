<?php

namespace App\Http\Controllers\Spt;

use App\Http\Controllers\Controller;
use App\Models\Spt;
use App\Http\Requests\SptRequest;
use App\Services\SptService;
use Illuminate\Http\Request;

class SptController extends Controller
{
    protected $sptService;

    public function __construct(SptService $sptService)
    {
        $this->sptService = $sptService;
    }

    public function indexDomestic()
    {
        $spts = Spt::where('type', 'domestic')
            ->with('employee')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('spt.in.domestic', compact('spts'));
    }

    public function indexForeign()
    {
        $spts = Spt::where('type', 'foreign')
            ->with('employee')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('spt.outg.foreign', compact('spts'));
    }

    public function storeDomestic(SptRequest $request)
    {
        try {
            $this->sptService->create($request->validated(), 'domestic');
            return response()->json(['success' => true, 'message' => 'SPT berhasil dibuat']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function storeForeign(SptRequest $request)
    {
        try {
            $this->sptService->create($request->validated(), 'foreign');
            return response()->json(['success' => true, 'message' => 'SPT berhasil dibuat']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function editDomestic(Spt $spt)
    {
        return response()->json($spt->load('employee'));
    }

    public function editForeign(Spt $spt)
    {
        return response()->json($spt->load('employee'));
    }

    public function updateDomestic(SptRequest $request, Spt $spt)
    {
        try {
            $this->sptService->update($spt, $request->validated());
            return response()->json(['success' => true, 'message' => 'SPT berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updateForeign(SptRequest $request, Spt $spt)
    {
        try {
            $this->sptService->update($spt, $request->validated());
            return response()->json(['success' => true, 'message' => 'SPT berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function destroyDomestic(Spt $spt)
    {
        try {
            $this->sptService->delete($spt);
            return response()->json(['success' => true, 'message' => 'SPT berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function destroyForeign(Spt $spt)
    {
        try {
            $this->sptService->delete($spt);
            return response()->json(['success' => true, 'message' => 'SPT berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function printDomestic(Spt $spt)
    {
        return view('spt.in.print', compact('spt'));
    }

    public function printForeign(Spt $spt)
    {
        return view('spt.outg.print', compact('spt'));
    }
} 