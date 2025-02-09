<?php

namespace App\Services;

use App\Models\Spt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SptService
{
    public function create(array $data, string $type)
    {
        DB::beginTransaction();
        try {
            // Generate nomor SPT
            $numberData = $type === 'domestic' 
                ? Spt::generateDomesticNumber() 
                : Spt::generateForeignNumber();

            // Merge data
            $sptData = array_merge($data, [
                'type' => $type,
                'nomor_spt' => $numberData['nomor_spt'],
                'auto_number' => $numberData['auto_number'],
                'month' => $numberData['month'],
                'year' => $numberData['year']
            ]);

            // Create SPT
            $spt = Spt::create($sptData);

            // Handle attachments if any
            if (isset($data['attachments'])) {
                foreach ($data['attachments'] as $file) {
                    $path = $file->store('attachments/spt/' . $type);
                    $spt->attachments()->create([
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path
                    ]);
                }
            }

            DB::commit();
            return $spt;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(Spt $spt, array $data)
    {
        DB::beginTransaction();
        try {
            $spt->update($data);

            if (isset($data['attachments'])) {
                foreach ($data['attachments'] as $file) {
                    $path = $file->store('attachments/spt/' . $spt->type);
                    $spt->attachments()->create([
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path
                    ]);
                }
            }

            DB::commit();
            return $spt;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Spt $spt)
    {
        DB::beginTransaction();
        try {
            // Delete attachments
            foreach ($spt->attachments as $attachment) {
                if (Storage::exists($attachment->path)) {
                    Storage::delete($attachment->path);
                }
                $attachment->delete();
            }

            $spt->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
} 