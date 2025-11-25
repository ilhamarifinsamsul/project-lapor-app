@extends('layouts.admin')
@section('title', 'Detail Progress Laporan')
@section('content')

    <!-- Page Heading -->
    <a href="{{ route('admin.report.show', $status->report_id) }}" class="btn btn-danger mb-3">Kembali</a>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Progress Laporan {{ $status->report->code }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Status</label>
                        <p>
                            @switch($status->status)
                                @case('pending')
                                    <span class="badge badge-warning">Pending</span>
                                    @break
                                @case('in_progress')
                                    <span class="badge badge-info">In Progress</span>
                                    @break
                                @case('completed')
                                    <span class="badge badge-success">Completed</span>
                                    @break
                                @case('rejected')
                                    <span class="badge badge-danger">Rejected</span>
                                    @break
                            @endswitch
                        </p>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Dibuat Pada</label>
                        <p>{{ $status->created_at->format('d F Y H:i') }}</p>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Diperbarui Pada</label>
                        <p>{{ $status->updated_at->format('d F Y H:i') }}</p>
                    </div>
                </div>

                @if($status->image)
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Gambar</label>
                        <div>
                            <img src="{{ asset('storage/' . $status->image) }}" 
                                 alt="Status Image" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-height: 300px;">
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="form-group">
                <label class="font-weight-bold">Deskripsi</label>
                <div class="border rounded p-3 bg-light">
                    {!! nl2br(e($status->description)) !!}
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.report-status.edit', $status->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.report-status.destroy', $status->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
