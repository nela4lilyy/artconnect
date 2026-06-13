@extends('layouts.admin')
@section('title','Tambah Galeri')
@section('page-title','Tambah Galeri')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="adm-card">
            <div class="adm-card-header"><i class="bi bi-plus-circle me-2" style="color:var(--ac)"></i>Tambah Galeri Baru</div>
            <div style="padding:1.5rem">
                <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Judul Galeri <span style="color:#dc2626">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}" placeholder="Masukkan judul galeri...">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="4" placeholder="Deskripsi singkat galeri...">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Cover Image</label>
                        <input type="file" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp" onchange="previewImg(this,'prev')">
                        <div class="form-text">JPG, PNG, WEBP &bull; Maks 2MB</div>
                        @error('cover_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div id="prev" style="margin-top:.7rem;display:none">
                            <img id="prevImg" src="" style="max-height:160px;border-radius:var(--radius);object-fit:cover" alt="">
                        </div>
                    </div>
                    <div style="display:flex;gap:.6rem;flex-wrap:wrap">
                        <button type="submit" class="btn-ac btn-ac-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                        <a href="{{ route('admin.galleries.index') }}" class="btn-ac btn-ac-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>function previewImg(input,id){if(input.files&&input.files[0]){const r=new FileReader();r.onload=e=>{document.getElementById('prevImg').src=e.target.result;document.getElementById(id).style.display='block';};r.readAsDataURL(input.files[0]);}}</script>
@endpush
