<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'name'        => ['required','string','max:100', Rule::unique('categories','name')->ignore($this->route('category'))],
            'cover_image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ];
    }
    public function messages(): array {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah digunakan.',
            'cover_image.image' => 'File harus berupa gambar.',
            'cover_image.mimes' => 'Format gambar: jpg, jpeg, png, webp.',
            'cover_image.max'   => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
