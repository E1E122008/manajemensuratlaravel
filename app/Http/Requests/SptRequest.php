<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SptRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tanggal' => 'required|date',
            'perihal' => 'required|string',
            'employee_id' => 'required|exists:employees,id',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'tanggal.required' => 'Tanggal wajib diisi',
            'perihal.required' => 'Perihal wajib diisi',
            'employee_id.required' => 'Pegawai wajib dipilih',
            'employee_id.exists' => 'Pegawai tidak ditemukan',
            'attachments.*.mimes' => 'Lampiran harus berformat pdf, doc, docx, jpg, jpeg, atau png',
            'attachments.*.max' => 'Ukuran lampiran maksimal 2MB'
        ];
    }
} 