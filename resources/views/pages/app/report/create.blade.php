@extends('layouts.no-nav')
@section('title', 'Tambah Laporan')
@section('content')
    <h3 class="mb-3">Laporkan segera masalahmu di sini!</h3>

    <p class="text-description">Isi form dibawah ini dengan baik dan benar sehingga kami dapat memvalidasi dan
        menangani
        laporan anda
        secepatnya</p>

    <form action="{{ route('report.store') }}" method="POST" class="mt-4" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="lat" name="lat">
        <input type="hidden" id="lng" name="lng">

        <div class="mb-3">
            <label for="title" class="form-label">Judul Laporan</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                value="{{ old('title') }}">
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="report_category_id" class="form-label">Kategori Laporan</label>
            <select name="report_category_id" id="report_category_id"
                class="form-control @error('report_category_id') is-invalid @enderror">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if (old('report_category_id') == $category->id) selected @endif>
                        {{ $category->name }}</option>
                @endforeach
            </select>
            @error('report_category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Bukti Laporan</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                style="display: none;">
            <img src="" alt="image" id="image-preview" class="img-fluid rounded-2 mb-3 border">
            @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Ceritakan Laporan Kamu</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                rows="4">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        {{-- latitude --}}
        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude"
                value="{{ old('latitude') }}">
            @error('latitude')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Longitude --}}
        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude"
                value="{{ old('longitude') }}">
            @error('longitude')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="map" class="form-label">Lokasi Laporan</label>
            <div id="map" style="height: 300px; border-radius: 8px; margin-bottom: 15px;"></div>
            <small class="text-muted d-block mb-2">Klik pada peta untuk memilih lokasi laporan</small>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Alamat Lengkap</label>
            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="4">{{ old('address') }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary w-100 mt-2" type="submit" color="primary">
            Laporkan
        </button>
    </form>
    @push('scripts')
        <script>
            // Ambil base64 dari localStorage
            var imageBase64 = localStorage.getItem('image');

            // Mengubah base64 menjadi binary Blob
            function base64ToBlob(base64, mime) {
                var byteString = atob(base64.split(',')[1]);
                var ab = new ArrayBuffer(byteString.length);
                var ia = new Uint8Array(ab);
                for (var i = 0; i < byteString.length; i++) {
                    ia[i] = byteString.charCodeAt(i);
                }
                return new Blob([ab], {
                    type: mime
                });
            }

            // Fungsi untuk membuat objek file dan set ke input file
            function setFileInputFromBase64(base64) {
                // Mengubah base64 menjadi Blob
                var blob = base64ToBlob(base64, 'image/jpeg'); // Ganti dengan tipe mime sesuai gambar Anda
                var file = new File([blob], 'image.jpg', {
                    type: 'image/jpeg'
                }); // Nama file dan tipe MIME

                // Set file ke input file
                var imageInput = document.getElementById('image');
                var dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                imageInput.files = dataTransfer.files;

                // Menampilkan preview gambar
                var imagePreview = document.getElementById('image-preview');
                imagePreview.src = URL.createObjectURL(file);
            }

            // Set nilai input file dan preview gambar
            setFileInputFromBase64(imageBase64);
        </script>
    @endpush

    @push('map-scripts')
    <script>
        // Initialize map
        var map = L.map('map').setView([-7.797068, 110.370529], 13); // Default center at Yogyakarta

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add a marker
        var marker = null;

        // Function to update marker position and form fields
        function updateMarker(latlng) {
            if (marker) {
                marker.setLatLng(latlng);
            } else {
                marker = L.marker(latlng, {draggable: true}).addTo(map);
                
                // Update position on marker drag
                marker.on('dragend', function(e) {
                    updateFormFields(marker.getLatLng());
                });
            }
            updateFormFields(latlng);
        }

        // Function to update form fields with coordinates
        function updateFormFields(latlng) {
            document.getElementById('latitude').value = latlng.lat.toFixed(6);
            document.getElementById('longitude').value = latlng.lng.toFixed(6);
            document.getElementById('lat').value = latlng.lat;
            document.getElementById('lng').value = latlng.lng;
            
            // Reverse geocoding to get address
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latlng.lat}&lon=${latlng.lng}&zoom=18&addressdetails=1`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('address').value = data.display_name || '';
                })
                .catch(error => {
                    console.error('Error getting address:', error);
                });
        }

        // Handle map click
        map.on('click', function(e) {
            updateMarker(e.latlng);
        });

        // Try to get user's current location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLatLng = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                
                // Update map view to user's location
                map.setView(userLatLng, 15);
                
                // Add marker at user's location
                updateMarker(userLatLng);
                
            }, function(error) {
                console.error('Error getting location:', error);
                // Default to a known location if geolocation fails
                var defaultLatLng = { lat: -7.797068, lng: 110.370529 }; // Yogyakarta
                updateMarker(defaultLatLng);
            });
        } else {
            // Browser doesn't support geolocation
            var defaultLatLng = { lat: -7.797068, lng: 110.370529 }; // Yogyakarta
            updateMarker(defaultLatLng);
        }

        // Initialize with any existing values
        document.addEventListener('DOMContentLoaded', function() {
            var lat = parseFloat(document.getElementById('latitude').value) || -7.797068;
            var lng = parseFloat(document.getElementById('longitude').value) || 110.370529;
            
            if (!isNaN(lat) && !isNaN(lng)) {
                var latLng = { lat: lat, lng: lng };
                map.setView(latLng, 15);
                updateMarker(latLng);
            }
        });
    </script>
    @endpush
@endsection
