@extends('layouts.admin')
@section('title','Edit Kategori')
@section('page-title','Edit Kategori')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="adm-card">
            <div class="adm-card-header"><i class="bi bi-pencil me-2" style="color:var(--ac)"></i>Edit Kategori</div>
            <div style="padding:1.5rem">
                <form action="{{ route('admin.categories.update',$category) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span style="color:#dc2626">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name',$category->name) }}">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Cover Image</label>
                        @if($category->cover_image)
                        <div style="margin-bottom:.6rem">
                            <img src="{{ img_url($category->cover_image) }}"
                                 style="height:70px;border-radius:var(--radius);object-fit:cover" alt="">
                            <div class="form-text">Upload baru untuk mengganti gambar.</div>
                        </div>
                        @endif
                        <input type="file" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp" onchange="previewImg(this,'prev')">
                        <div class="form-text">Format: jpg, jpeg, png, webp. Maks 2MB.</div>
                        @error('cover_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div id="prev" style="margin-top:.75rem;display:none">
                            <img id="prevImg" src="" style="max-height:140px;border-radius:var(--radius);object-fit:cover" alt="">
                        </div>
                    </div>
                    <div style="display:flex;gap:.6rem">
                        <button type="submit" class="btn-ac btn-ac-primary"><i class="bi bi-save me-1"></i>Perbarui</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn-ac btn-ac-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>function previewImg(input,wrapId){if(input.files&&input.files[0]){const r=new FileReader();r.onload=e=>{document.getElementById('prevImg').src=e.target.result;document.getElementById(wrapId).style.display='block';};r.readAsDataURL(input.files[0]);}}</script>
@endpush
