<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomingLetterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'reference_number' => 'required|string|max:100',
            'sender' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'received_date' => 'required|date',
            'description' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'reference_number.required' => 'Nomor surat wajib diisi',
            'sender.required' => 'Pengirim wajib diisi',
            'letter_date.required' => 'Tanggal surat wajib diisi',
            'received_date.required' => 'Tanggal diterima wajib diisi',
            'description.required' => 'Perihal wajib diisi',
            'attachments.*.mimes' => 'Lampiran harus berformat pdf, doc, docx, jpg, jpeg, atau png',
            'attachments.*.max' => 'Ukuran lampiran maksimal 2MB'
        ];
    }
} 