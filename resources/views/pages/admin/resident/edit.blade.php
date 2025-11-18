@extends('layouts.admin')
@section('title', 'Edit Resident')
@section('content')

    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data Masyarakat</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.resident.update', $resident->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-4">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" 
                                   value="{{ old('name', $resident->user->name) }}"
                                   placeholder="Masukkan nama lengkap">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control bg-light" 
                                   id="email" 
                                   value="{{ old('email', $resident->user->email) }}" 
                                   readonly>
                            <input type="hidden" name="email" value="{{ $resident->user->email }}">
                        </div>

                        <div class="form-group mb-4">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password"
                                       placeholder="Kosongkan jika tidak ingin mengubah password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Minimal 6 karakter, mengandung huruf dan angka</small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label class="form-label fw-semibold d-block">Foto Profil</label>
                            <div class="text-center mb-3">
                                <div class="position-relative d-inline-block">
                                    <img src="{{ $resident->avatar ? asset('storage/' . $resident->avatar) : asset('assets/admin/img/undraw_profile.svg') }}" 
                                         alt="{{ $resident->user->name }}" 
                                         id="avatarPreview"
                                         class="img-thumbnail rounded-circle" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="file" 
                                       class="form-control @error('avatar') is-invalid @enderror" 
                                       id="avatar" 
                                       name="avatar"
                                       accept="image/*"
                                       onchange="previewAvatar(this)">
                                @error('avatar')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.resident.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times mr-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Preview avatar
        function previewAvatar(input) {
            const preview = document.getElementById('avatarPreview');
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onloadend = function() {
                preview.src = reader.result;
            }
            
            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "{{ $resident->avatar ? asset('storage/' . $resident->avatar) : asset('assets/admin/img/undraw_profile.svg') }}";
            }
        }

        // Toggle password visibility
        // document.getElementById('togglePassword').addEventListener('click', function() {
        //     const passwordInput = document.getElementById('password');
        //     const icon = this.querySelector('i');
            
        //     if (passwordInput.type === 'password') {
        //         passwordInput.type = 'text';
        //         icon.classList.remove('fa-eye');
        //         icon.classList.add('fa-eye-slash');
        //     } else {
        //         passwordInput.type = 'password';
        //         icon.classList.remove('fa-eye-slash');
        //         icon.classList.add('fa-eye');
        //     }
        // });
    </script>
    @endpush

@endsection
