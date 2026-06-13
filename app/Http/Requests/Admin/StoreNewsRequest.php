<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:255'],
            'category_id'  => ['required', 'exists:categories,id'],
            'content'      => ['required', 'string'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'publish_date' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'        => 'Judul berita wajib diisi.',
            'category_id.required'  => 'Kategori wajib dipilih.',
            'category_id.exists'    => 'Kategori tidak valid.',
            'content.required'      => 'Isi berita wajib diisi.',
            'image.image'           => 'File harus berupa gambar.',
            'image.mimes'           => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'image.max'             => 'Ukuran gambar maksimal 2MB.',
            'publish_date.required' => 'Tanggal terbit wajib diisi.',
            'publish_date.date'     => 'Format tanggal tidak valid.',
        ];
    }
}
