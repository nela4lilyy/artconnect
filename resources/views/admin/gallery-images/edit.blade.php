@extends('layouts.admin')
@section('title','Edit Foto')
@section('page-title','Edit Foto Galeri')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="adm-card">
            <div class="adm-card-header"><i class="bi bi-pencil me-2" style="color:var(--ac)"></i>Edit Foto</div>
            <div style="padding:1.5rem">
                <div style="margin-bottom:1.25rem;text-align:center">
                    <img src="{{ asset('storage/'.$galleryImage->image) }}"
                         style="max-height:220px;max-width:100%;border-radius:var(--radius);object-fit:cover" alt="">
                </div>
                <form action="{{ route('admin.gallery-images.update',[$gallery,$galleryImage]) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Ganti Gambar</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp">
                        <div class="form-text">Kosongkan jika tidak ingin mengganti gambar.</div>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="caption" class="form-control @error('caption') is-invalid @enderror"
                               value="{{ old('caption',$galleryImage->caption) }}"
                               placeholder="Tambahkan keterangan foto...">
                        @error('caption')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div style="display:flex;gap:.6rem;flex-wrap:wrap">
                        <button type="submit" class="btn-ac btn-ac-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                        <a href="{{ route('admin.galleries.show',$gallery) }}" class="btn-ac btn-ac-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
