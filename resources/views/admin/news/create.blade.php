@extends('layouts.admin')
@section('title','Tambah Berita')
@section('page-title','Tambah Berita')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="adm-card">
            <div class="adm-card-header"><i class="bi bi-plus-circle me-2" style="color:var(--ac)"></i>Tambah Berita Baru</div>
            <div style="padding:1.5rem">
                <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Judul Berita <span style="color:#dc2626">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" placeholder="Masukkan judul berita...">
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kategori <span style="color:#dc2626">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Terbit <span style="color:#dc2626">*</span></label>
                            <input type="date" name="publish_date" class="form-control @error('publish_date') is-invalid @enderror"
                                   value="{{ old('publish_date', date('Y-m-d')) }}">
                            @error('publish_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gambar Sampul</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                   accept="image/jpg,image/jpeg,image/png,image/webp" onchange="previewImg(this,'imgPrev')">
                            <div class="form-text">JPG, PNG, WEBP · Maks 2MB</div>
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div id="imgPrev" style="margin-bottom:1rem;display:none">
                        <img id="imgPrevSrc" src="" style="max-height:180px;border-radius:var(--radius);object-fit:cover" alt="">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Isi Berita <span style="color:#dc2626">*</span></label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                  rows="11" placeholder="Tulis isi berita...">{{ old('content') }}</textarea>
                        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div style="display:flex;gap:.6rem;flex-wrap:wrap">
                        <button type="submit" class="btn-ac btn-ac-primary"><i class="bi bi-save me-1"></i>Simpan Berita</button>
                        <a href="{{ route('admin.news.index') }}" class="btn-ac btn-ac-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>function previewImg(input,wrapId){if(input.files&&input.files[0]){const r=new FileReader();r.onload=e=>{document.getElementById('imgPrevSrc').src=e.target.result;document.getElementById(wrapId).style.display='block';};r.readAsDataURL(input.files[0]);}}</script>
@endpush
