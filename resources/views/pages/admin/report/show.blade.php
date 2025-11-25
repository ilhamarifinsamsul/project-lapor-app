@extends('layouts.admin')
@section('title', 'Detail Laporan')
@section('content')

    <!-- Page Heading -->
    <a href="{{ route('admin.report.index') }}" class="btn btn-danger mb-3">Kembali</a>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Laporan</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td>Kode</td>
                    <td>{{ $report->code }}</td>
                </tr>
                <tr>
                    <td>Pelapor</td>
                    <td>{{ $report->resident->user->name }}</td>
                </tr>
                <tr>
                    <td>Kategori Laporan</td>
                    <td>{{ $report->reportCategory->name }}</td>
                </tr>
                <tr>
                    <td>Judul Laporan</td>
                    <td>{{ $report->title }}</td>
                </tr>
                <tr>
                    <td>Deskripsi Laporan</td>
                    <td>{{ $report->description }}</td>
                </tr>
                <tr>
                    <td>Image</td>
                    <td><img src="{{ asset('storage/' . $report->image) }}" alt="Image" width="280"></td>
                </tr>
                <tr>
                    <td>Latitude</td>
                    <td>{{ $report->latitude }}</td>
                </tr>
                <tr>
                    <td>Lokasi</td>
                    <td>
                        <div id="map" style="height: 300px;"></div>
                    </td>
                </tr>
                <tr>
                    <td>Longitude</td>
                    <td>{{ $report->longitude }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>{{ $report->address }}</td>
                </tr>
            </table>
        </div>
    </div>

        {{-- card untuk report status --}}
    <div class="card shadow mb-5">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Progress Laporan</h6>
            <a href="{{ route('admin.report-status.create') }}" class="btn btn-primary">Tambah Progress</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bukti</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($report->ReportStatuses as $status)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            
                            <td><img src="{{ asset('storage/' . $status->image) }}" alt="Icon" width="100"></td>
                            <td>
                                <a href="{{ route('admin.report-status.edit', $status->id) }}" class="btn btn-warning">Edit</a>

                                <a href="{{ route('admin.report-status.show', $status->id) }}" class="btn btn-info">Show</a>

                                <form action="{{ route('admin.report-status.destroy', $status->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirmDelete(this.form);">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // script untuk menampilkan lokasi pakai leaflet
        var map = L.map('map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        L.marker([{{ $report->latitude }}, {{ $report->longitude }}]).addTo(map)
            .bindPopup('<b>Laporan ini terletak di</b><br /> {{ $report->address }}')
            .openPopup();
    </script>
    @endpush
@endsection
