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
                        <div id="map" style="height: 400px;"></div>
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
