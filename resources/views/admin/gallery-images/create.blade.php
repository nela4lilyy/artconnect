@extends('layouts.admin')
@section('title','Upload Foto')
@section('page-title','Upload Foto Galeri')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        {{-- Gallery header --}}
        <div class="adm-card mb-3">
            <div style="padding:1rem 1.25rem;display:flex;align-items:center;gap:.85rem">
                @if($gallery->cover_image)
                <img src="{{ img_url($gallery->cover_image) }}"
                     style="width:48px;height:48px;object-fit:cover;border-radius:var(--radius);flex-shrink:0" alt="">
                @else
                <div style="width:48px;height:48px;background:var(--ac-lt);border-radius:var(--radius);display:flex;align-items:center;justify-content:center;color:var(--ac);flex-shrink:0">
                    <i class="bi bi-images"></i>
                </div>
                @endif
                <div>
                    <div style="font-weight:700;font-size:.92rem">{{ $gallery->title }}</div>
                    <div style="font-size:.76rem;color:var(--muted)">{{ $gallery->images()->count() }} foto tersimpan</div>
                </div>
            </div>
        </div>

        <div class="adm-card">
            <div class="adm-card-header">
                <div><i class="bi bi-cloud-upload me-2" style="color:var(--ac)"></i>Upload Foto Baru</div>
            </div>
            <div style="padding:1.5rem">
                <form action="{{ route('admin.gallery-images.store',$gallery) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Pilih Foto <span style="color:#dc2626">*</span></label>
                        <div id="dropZone"
                             style="border:2px dashed var(--ac);border-radius:var(--radius);padding:2.5rem 1.5rem;text-align:center;cursor:pointer;background:var(--ac-lt);transition:.2s"
                             onmouseover="this.style.background='var(--ac-mid)'" onmouseout="this.style.background='var(--ac-lt)'">
                            <i class="bi bi-cloud-upload" style="font-size:2.2rem;color:var(--ac);display:block;margin-bottom:.5rem"></i>
                            <div style="font-weight:600;font-size:.92rem;color:var(--ac)">Klik atau seret file ke sini</div>
                            <div style="font-size:.77rem;color:var(--muted);margin-top:.35rem">JPG, JPEG, PNG, WEBP &bull; Maks 2MB per file &bull; Bisa banyak file</div>
                            <input type="file" name="images[]" id="imageFiles" multiple
                                   accept="image/jpg,image/jpeg,image/png,image/webp"
                                   style="display:none" onchange="handleFiles(this)">
                        </div>
                        @error('images')<div style="color:#dc2626;font-size:.76rem;margin-top:.3rem">{{ $message }}</div>@enderror
                        @error('images.*')<div style="color:#dc2626;font-size:.76rem;margin-top:.3rem">{{ $message }}</div>@enderror
                    </div>

                    {{-- Preview grid --}}
                    <div id="previewGrid" style="display:none;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:.6rem;margin-bottom:1.25rem"></div>

                    {{-- Captions --}}
                    <div id="captionsWrap" style="display:none;margin-bottom:1.25rem">
                        <label class="form-label">Keterangan Foto (opsional)</label>
                        <div id="captionInputs"></div>
                    </div>

                    <div style="display:flex;gap:.6rem;flex-wrap:wrap">
                        <button type="submit" id="submitBtn" class="btn-ac btn-ac-primary" disabled>
                            <i class="bi bi-cloud-upload me-1"></i>Upload Foto
                        </button>
                        <a href="{{ route('admin.galleries.show',$gallery) }}" class="btn-ac btn-ac-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const dropZone     = document.getElementById('dropZone');
const fileInput    = document.getElementById('imageFiles');
const previewGrid  = document.getElementById('previewGrid');
const captionsWrap = document.getElementById('captionsWrap');
const captionInputs= document.getElementById('captionInputs');
const submitBtn    = document.getElementById('submitBtn');

dropZone.addEventListener('click', () => fileInput.click());
dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.style.background='#d6c8f5'; });
dropZone.addEventListener('dragleave', () => dropZone.style.background='var(--ac-lt)');
dropZone.addEventListener('drop', e => {
    e.preventDefault(); dropZone.style.background='var(--ac-lt)';
    fileInput.files = e.dataTransfer.files; handleFiles(fileInput);
});

function handleFiles(input) {
    if (!input.files.length) return;
    previewGrid.innerHTML = ''; captionInputs.innerHTML = '';
    previewGrid.style.display = 'grid';
    captionsWrap.style.display = 'block';
    submitBtn.disabled = false;

    Array.from(input.files).forEach((file, idx) => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.style.cssText = 'border-radius:var(--radius);overflow:hidden';
            div.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100px;object-fit:cover;display:block">
                             <div style="font-size:.68rem;color:var(--muted);padding:.2rem .3rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${file.name}</div>`;
            previewGrid.appendChild(div);
        };
        reader.readAsDataURL(file);

        const inp = document.createElement('div');
        inp.style.marginBottom = '.4rem';
        inp.innerHTML = `<input type="text" name="captions[]" class="form-control form-control-sm"
                                placeholder="Keterangan foto ${idx+1} (opsional)">`;
        captionInputs.appendChild(inp);
    });
}
</script>
@endpush
