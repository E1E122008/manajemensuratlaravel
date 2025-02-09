<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutgoingLetterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'letter_date' => 'required|date',
            'description' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'letter_date.required' => 'Tanggal surat wajib diisi',
            'description.required' => 'Perihal wajib diisi',
            'attachments.*.mimes' => 'Lampiran harus berformat pdf, doc, docx, jpg, jpeg, atau png',
            'attachments.*.max' => 'Ukuran lampiran maksimal 2MB'
        ];
    }
} 