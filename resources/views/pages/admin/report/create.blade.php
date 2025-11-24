@extends('layouts.admin')
@section('title', 'Create Laporan')
@section('content')

    <!-- Page Heading -->
    <a href="{{ route('admin.report.index') }}" class="btn btn-danger mb-3">Kembali</a>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Laporan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.report.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="code">Kode</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" value="AUTO" disabled>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="resident">Pelapor/Masyarakat</label>
                    <select name="resident_id" id="resident_id" class="form-control @error('resident_id') is-invalid @enderror">
                        @foreach ($residents as $resident)
                            <option value="{{ $resident->id }}" @if (old('resident_id') == $resident->id ) selected @endif>{{ $resident->user->name }} - {{ $resident->user->email }}</option>
                        @endforeach 
                    </select>
                    @error('resident_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category">Kategori Laporan</label>
                    <select name="report_category_id" id="report_category_id" class="form-control @error('report_category_id') is-invalid @enderror">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if (old('report_category_id') == $category->id ) selected @endif>{{ $category->name }}</option>
                        @endforeach 
                    </select>
                    @error('report_category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="title">Judul Laporan</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea 
                        class="form-control @error('description') is-invalid @enderror" 
                        id="description" 
                        name="description" 
                        rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                    <img id="image-preview" 
                        src="#" 
                        alt="Preview" 
                        class="mt-3"
                        style="display:none; width:150px; border-radius:8px;">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude') }}">
                    @error('latitude')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude') }}">
                    @error('longitude')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea 
                        class="form-control @error('address') is-invalid @enderror" 
                        id="address" 
                        name="address" 
                        rows="4">{{ old('address') }}</textarea>
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
    function previewImage(event) {
        const image = document.getElementById('image-preview');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.style.display = 'block';
    }
</script>
@endpush


@endsection
