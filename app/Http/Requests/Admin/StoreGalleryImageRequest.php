<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'images'          => ['required', 'array', 'min:1'],
            'images.*'        => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'captions'        => ['nullable', 'array'],
            'captions.*'      => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'images.required'    => 'Pilih minimal satu gambar.',
            'images.*.image'     => 'Setiap file harus berupa gambar.',
            'images.*.mimes'     => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'images.*.max'       => 'Ukuran setiap gambar maksimal 2MB.',
        ];
    }
}
