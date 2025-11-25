@extends('layouts.admin')
@section('title', 'Create Progress Laporan')
@section('content')

    <!-- Page Heading -->
    <a href="{{ route('admin.report.index') }}" class="btn btn-danger mb-3">Kembali</a>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Progress Laporan {{ $report->code }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.report-status.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="report_id" value="{{ $report->id }}">

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
                {{-- status --}}
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="pending" @if(old('status') == 'pending') selected @endif>Pending</option>
                        <option value="in_progress" @if(old('status') == 'in_progress') selected @endif>In Progress</option>
                        <option value="completed" @if(old('status') == 'completed') selected @endif>Completed</option>
                        <option value="rejected" @if(old('status') == 'rejected') selected @endif>Rejected</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- deskripsi --}}
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                    @error('description')
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
