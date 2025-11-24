@extends('layouts.admin')
@section('title', 'Edit Laporan')
@section('content')

    <!-- Page Heading -->
    <a href="{{ route('admin.report.index') }}" class="btn btn-danger mb-3">Kembali</a>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.report.update', $report->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="code">Kode</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" value="{{ $report->code }}" disabled>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="resident_id">Pelapor</label>
                    <select name="resident_id" id="resident_id" class="form-control @error('resident_id') is-invalid @enderror">
                        <option value="">Pilih Pelapor</option>
                        @foreach ($residents as $resident)
                            <option value="{{ $resident->id }}" {{ $resident->id == $report->resident_id ? 'selected' : '' }}>
                                {{ $resident->user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('resident_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="report_category_id">Kategori Laporan</label>
                    <select name="report_category_id" id="report_category_id" class="form-control @error('report_category_id') is-invalid @enderror">
                        <option value="">Pilih Kategori Laporan</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $report->report_category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('report_category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- title --}}
                <div class="form-group">
                    <label for="title">Judul Laporan</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $report->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- description --}}
                <div class="form-group">
                    <label for="description">Deskripsi Laporan</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $report->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="image" class="form-label fw-semibold mb-2">Gambar Laporan</label>
                    <div class="d-flex flex-column gap-3">
                        <div class="border rounded p-3 text-center" style="max-width: 200px;">
                            <img src="{{ asset('storage/' . $report->image) }}" 
                                 alt="{{ $report->name }}" 
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
                {{-- latitude --}}
                <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude', $report->latitude) }}">
                    @error('latitude')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- longitude --}}
                <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude', $report->longitude) }}">
                    @error('longitude')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- address --}}
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $report->address) }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                preview.src = "{{ asset('storage/' . $report->image) }}";
            }
        }
    </script>
    @endpush

@endsection
