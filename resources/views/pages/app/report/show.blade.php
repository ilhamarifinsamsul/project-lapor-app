@extends('layouts.app')

@section('title', 'Detail Laporan - ' . $report->code)

@section('content')


    <div class="report-header">
        <a href="{{ route('home') }}" class="back-button">
            <img src="{{ asset('assets/app/images/icons/ArrowLeft.svg') }}" alt="Kembali" width="16">
        </a>
        <img src="{{ asset('storage/' . $report->image) }}" alt="{{ $report->title }}">
        <div class="report-header-overlay">
            <h4 class="mb-1">{{ $report->title }}</h4>
            <p class="mb-0">#{{ $report->code }}</p>
        </div>
    </div>

    <div class="info-card">
        <div class="info-card-header">
            <i class="fas fa-info-circle me-2"></i>Informasi Laporan
        </div>
        <div class="info-item">
            <div class="info-label">Tanggal</div>
            <div class="info-value">
                <i class="far fa-calendar-alt me-2 text-muted"></i>
                {{ \Carbon\Carbon::parse($report->created_at)->format('d F Y') }}
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">Kategori</div>
            <div class="info-value">
                <i class="fas fa-tag me-2 text-muted"></i>
                {{ $report->reportCategory->name }}
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">Lokasi</div>
            <div class="info-value">
                <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                {{ $report->address }}
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">Status</div>
            <div class="info-value">
                @php
                    $latestStatus = $report->reportStatuses->isNotEmpty()
                        ? $report->reportStatuses->last()
                        : null;
                    
                    $status = $latestStatus ? $latestStatus->status : 'pending';
                    $statusText = ucfirst(str_replace('_', ' ', $status));
                    
                    $statusColor = [
                        'pending' => 'bg-secondary',
                        'in progress' => 'bg-warning',
                        'completed' => 'bg-success',
                        'rejected' => 'bg-danger',
                    ][strtolower($statusText)] ?? 'bg-secondary';
                @endphp
                <span class="status-badge {{ $statusColor }}">
                    @if($status === 'in_progress')
                        <i class="fas fa-spinner fa-spin me-1"></i>
                    @elseif($status === 'completed')
                        <i class="fas fa-check-circle me-1"></i>
                    @elseif($status === 'rejected')
                        <i class="fas fa-times-circle me-1"></i>
                    @else
                        <i class="far fa-clock me-1"></i>
                    @endif
                    {{ $statusText }}
                </span>
            </div>
        </div>
    </div>

    <h5 class="section-title">
        <i class="fas fa-history me-2"></i>Riwayat Perkembangan
    </h5>
    
    @if($report->reportStatuses->isNotEmpty())
        <ul class="timeline">
            @foreach($report->reportStatuses->sortBy('created_at') as $status)
                <li class="timeline-item">
                    <div class="timeline-content">
                        <span class="timeline-date">
                            <i class="far fa-clock me-1"></i>
                            {{ \Carbon\Carbon::parse($status->created_at)->format('d M Y H:i') }}
                        </span>
                        <p class="mb-0">{{ $status->description }}</p>
                        @if($status->image)
                            <img src="{{ asset('storage/' . $status->image) }}" 
                                 alt="Bukti" 
                                 class="timeline-image img-thumbnail mt-2" 
                                 style="max-height: 200px; width: auto;">
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-center py-4 text-muted">
            <i class="fas fa-inbox fa-2x mb-2"></i>
            <p class="mb-0">Belum ada riwayat perkembangan</p>
        </div>
    @endif

    @if($report->description)
        <h5 class="section-title">
            <i class="fas fa-align-left me-2"></i>Deskripsi
        </h5>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <p class="mb-0">{{ $report->description }}</p>
            </div>
        </div>
    @endif


@endsection
