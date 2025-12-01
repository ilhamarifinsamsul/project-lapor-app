@extends('layouts.app')
@section('title', 'Home Page')
@section('content')

    <h6 class="greeting">Hi, {{ Auth::check() ? Auth::user()->name : 'User' }} 👋</h6>
    <h4 class="home-headline">
        Laporkan masalahmu dan kami segera atasi itu
    </h4>

    <div class="d-flex align-items-center flex-wrap justify-content-between gap-4 py-3 overflow-auto" id="category"
        style="white-space: nowrap">
        @foreach ($categories as $category)
            <a href="{{ route('report.index', ['category' => $category->name]) }}" class="category d-inline-block">
                <div class="icon">
                    <img src="{{ asset('storage/' . $category->image) }}" alt="icon" />
                </div>
                <p>{{ $category->name }}</p>
            </a>
        @endforeach
    </div>

    <div class="py-3" id="reports">
        <div class="d-flex justify-content-between align-items-center">
            <h6>Pengaduan terbaru</h6>
            <a href="{{route('report.index')}}" class="text-primary text-decoration-none show-more">
                Lihat semua
            </a>
        </div>

        <div class="d-flex flex-column gap-3 mt-3">
            <div class="card card-report border-0 shadow-none">
                @foreach ($reports as $report)
                    <a href="{{ route('report.show', $report->code) }}" class="text-decoration-none text-dark">
                        <div class="card-body p-0">
                            <div class="card-report-image position-relative mb-2">
                                <img src="{{ asset('storage/' . $report->image) }}" alt="Image" />
                                @php
                                    $status = $report->reportStatuses->isNotEmpty()
                                        ? $report->reportStatuses->last()->status
                                        : 'pending';

                                    $statusColor =
                                        [
                                            'pending' => 'bg-secondary',
                                            'in_progress' => 'bg-warning',
                                            'completed' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                        ][$status] ?? 'bg-secondary';
                                @endphp

                                <div class="badge-status {{ $statusColor }}">
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-end mb-2">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('assets/app/images/icons/MapPin.png') }}" alt="map pin"
                                        class="icon me-2" />
                                    <p class="text-primary city">{{ \Str::substr($report->address, 0, 20) }}...</p>
                                </div>

                                <p class="text-secondary date">{{ \Carbon\Carbon::parse($report->created_at)->format('d M Y') }}</p>
                            </div>

                            <h1 class="card-title">{{ Str::limit($report->title, 30) }}</h1>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

@endsection
