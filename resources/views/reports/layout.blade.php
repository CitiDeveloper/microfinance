@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Report Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-0 text-primary">
                                <i class="fas fa-chart-bar me-2"></i>@yield('report-title')
                            </h4>
                            <p class="text-muted mb-0">@yield('report-description')</p>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-download me-2"></i>Export
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="exportReport('csv')">CSV</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="exportReport('pdf')">PDF</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="exportReport('excel')">Excel</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-filter me-2"></i>Filters
                    </h6>
                </div>
                <div class="card-body">
                    @yield('filters')
                </div>
            </div>
        </div>
    </div>

    <!-- Report Content -->
    <div class="row">
        <div class="col-12">
            @yield('report-content')
        </div>
    </div>
</div>

@push('scripts')
<script>
function exportReport(format) {
    const currentUrl = window.location.href;
    const exportUrl = '{{ route("reports.export", ":type") }}'.replace(':type', '{{ $reportType ?? "loan-portfolio" }}');
    
    // Add current filters to export URL
    const url = new URL(exportUrl);
    const currentParams = new URLSearchParams(window.location.search);
    
    currentParams.forEach((value, key) => {
        url.searchParams.append(key, value);
    });
    
    window.location.href = url.toString();
}
</script>
@endpush
@endsection