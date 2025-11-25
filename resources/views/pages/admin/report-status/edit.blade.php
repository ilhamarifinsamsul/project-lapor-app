@extends('layouts.admin')
@section('title', 'Edit Progress Laporan')
@section('content')

    <!-- Page Heading -->
    <a href="{{ route('admin.report.show', $status->report->id) }}" class="btn btn-danger mb-3">Kembali</a>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Progress Laporan {{ $status->report->code }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.report-status.update', $status->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="report_id" value="{{ $status->report_id }}">

                <div class="form-group">
                    <label for="image">Gambar</label>
                    <div class="mb-3">
                        @if($status->image)
                            <img src="{{ asset('storage/' . $status->image) }}" 
                                 alt="Current Image" 
                                 class="img-fluid rounded shadow-sm mb-2" 
                                 style="max-height: 200px;">
                        @endif
                    </div>
                    <input type="file" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image" 
                           accept="image/*" 
                           onchange="previewImage(event)">
                    <img id="image-preview" 
                         src="#" 
                         alt="Preview" 
                         class="mt-3"
                         style="display:none; max-width: 100%; max-height: 200px; border-radius:8px;">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="pending" {{ old('status', $status->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $status->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status', $status->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="rejected" {{ old('status', $status->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" 
                              id="description" 
                              class="form-control @error('description') is-invalid @enderror" 
                              rows="5">{{ old('description', $status->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const image = document.getElementById('image-preview');
        if (event.target.files.length > 0) {
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }
    }
</script>
@endpush