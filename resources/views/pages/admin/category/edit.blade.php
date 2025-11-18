@extends('layouts.admin')
@section('title', 'Edit Category')
@section('content')

    <!-- Page Heading -->
    <a href="{{ route('admin.report-category.index') }}" class="btn btn-danger mb-3">Kembali</a>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.report-category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="image" class="form-label fw-semibold mb-2">Gambar Kategori</label>
                    <div class="d-flex flex-column gap-3">
                        <div class="border rounded p-3 text-center" style="max-width: 200px;">
                            <img src="{{ asset('storage/' . $category->image) }}" 
                                 alt="{{ $category->name }}" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-height: 150px; object-fit: contain;">
                        </div>
                        <div>
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*"
                                   onchange="previewImage(this)">
                            <div class="form-text text-muted">Ukuran gambar maksimal 2MB. Format: JPG, JPEG, PNG</div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(input) {
            const preview = input.previousElementSibling.querySelector('img');
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onloadend = function() {
                preview.src = reader.result;
            }
            
            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "{{ asset('storage/' . $category->image) }}";
            }
        }
    </script>
    @endpush

@endsection
