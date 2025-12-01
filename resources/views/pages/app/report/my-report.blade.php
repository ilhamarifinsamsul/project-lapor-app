@extends('layouts.app')

@section('title', 'Laporan Saya')

@section('content')
    <ul class="nav nav-tabs" id="filter-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="{{ route('report.myreport', ['status' => 'pending']) }}"
                class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" id="diproses-tab" type="button">
                Pending
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('report.myreport', ['status' => 'in_progress']) }}"
                class="nav-link {{ request('status') == 'in_progress' ? 'active' : '' }}" id="diproses-tab" type="button">
                Diproses
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('report.myreport', ['status' => 'completed']) }}"
                class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}" id="selesai-tab" type="button">
                Selesai
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('report.myreport', ['status' => 'rejected']) }}"
                class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}" id="ditolak-tab" type="button">
                Ditolak
            </a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="terkirim-tab-pane" role="tabpanel" aria-labelledby="terkirim-tab"
            tabindex="0">
            <div class="d-flex flex-column gap-3 mt-3">
                @forelse ($reports as $report)
                    <a href="{{ route('report.show', $report->code) }}" class="text-decoration-none text-dark">
                        <div class="card-body p-0">
                            <div class="card-report-image position-relative mb-2">
                                <img class="rounded-3" src="{{ asset('storage/' . $report->image) }}"
                                    alt="{{ $report->title }}"/>
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

                                <p class="text-secondary date">
                                    {{ \Carbon\Carbon::parse($report->created_at)->format('d M Y') }}</p>
                            </div>

                            <h4 class="card-title">{{ Str::limit($report->title, 30) }}</h4>
                        </div>
                    </a>
                @empty
                    <div class="d-flex flex-column justify-content-center align-items-center" style="height: 75vh"
                        id="no-reports">
                        <div id="lottie"></div>
                        <h5 class="mt-3">Belum ada laporan</h5>
                        <a href="" class="btn btn-primary py-2 px-4 mt-3">
                            Buat Laporan
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="tab-pane fade" id="diproses-tab-pane" role="tabpanel" aria-labelledby="diproses-tab" tabindex="0">
            <div class="d-flex flex-column gap-3 mt-3">
                @forelse ($reports as $report)
                    <a href="{{ route('report.show', $report->code) }}" class="text-decoration-none text-dark">
                        <div class="card-body p-0">
                            <div class="card-report-image position-relative mb-2">
                                <img class="rounded-3" src="{{ asset('storage/' . $report->image) }}"
                                    alt="{{ $report->title }}"/>
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

                                <p class="text-secondary date">
                                    {{ \Carbon\Carbon::parse($report->created_at)->format('d M Y') }}</p>
                            </div>

                            <h4 class="card-title">{{ Str::limit($report->title, 30) }}</h4>
                        </div>
                    </a>
                @empty
                    <div class="d-flex flex-column justify-content-center align-items-center" style="height: 75vh"
                        id="no-reports">
                        <div id="lottie"></div>
                        <h5 class="mt-3">Belum ada laporan</h5>
                        <a href="" class="btn btn-primary py-2 px-4 mt-3">
                            Buat Laporan
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="tab-pane fade" id="selesai-tab-pane" role="tabpanel" aria-labelledby="selesai-tab" tabindex="0">
            <div class="d-flex flex-column gap-3 mt-3">
                @forelse ($reports as $report)
                    <a href="{{ route('report.show', $report->code) }}" class="text-decoration-none text-dark">
                        <div class="card-body p-0">
                            <div class="card-report-image position-relative mb-2">
                                <img class="rounded-3" src="{{ asset('storage/' . $report->image) }}"
                                    alt="{{ $report->title }}" />
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

                                <p class="text-secondary date">
                                    {{ \Carbon\Carbon::parse($report->created_at)->format('d M Y') }}</p>
                            </div>

                            <h4 class="card-title">{{ Str::limit($report->title, 30) }}</h4>
                        </div>
                    </a>
                @empty
                    <div class="d-flex flex-column justify-content-center align-items-center" style="height: 75vh"
                        id="no-reports">
                        <div id="lottie"></div>
                        <h5 class="mt-3">Belum ada laporan</h5>
                        <a href="" class="btn btn-primary py-2 px-4 mt-3">
                            Buat Laporan
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="tab-pane fade" id="ditolak-tab-pane" role="tabpanel" aria-labelledby="ditolak-tab" tabindex="0">
            <div class="d-flex flex-column gap-3 mt-3">
                @forelse ($reports as $report)
                    <a href="{{ route('report.show', $report->code) }}" class="text-decoration-none text-dark">
                        <div class="card-body p-0">
                            <div class="card-report-image position-relative mb-2">
                                <img class="rounded-3" src="{{ asset('storage/' . $report->image) }}"
                                    alt="{{ $report->title }}"/>
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

                                <p class="text-secondary date">
                                    {{ \Carbon\Carbon::parse($report->created_at)->format('d M Y') }}</p>
                            </div>

                            <h4 class="card-title">{{ Str::limit($report->title, 30) }}</h4>
                        </div>
                    </a>
                @empty
                    <div class="d-flex flex-column justify-content-center align-items-center" style="height: 75vh"
                        id="no-reports">
                        <div id="lottie"></div>
                        <h5 class="mt-3">Belum ada laporan</h5>
                        <a href="" class="btn btn-primary py-2 px-4 mt-3">
                            Buat Laporan
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
        <script>
            var animation = bodymovin.loadAnimation({
                container: document.getElementById('lottie'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: '{{ asset('assets/app/lottie/not-found.json') }}'
            })
        </script>
    @endpush
@endsection
