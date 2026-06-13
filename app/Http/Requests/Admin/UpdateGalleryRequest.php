<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'    => 'Judul galeri wajib diisi.',
            'cover_image.image' => 'Cover harus berupa gambar.',
            'cover_image.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'cover_image.max'   => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
