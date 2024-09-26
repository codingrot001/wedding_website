@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="card bg-info text-white mb-3">
                <div class="card-header">Total Uploads</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalUploads }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white mb-3">
                <div class="card-header">New Users</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $newUsers }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white mb-3">
                <div class="card-header">Total Views</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalViews }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart (example using Chart.js) -->
    <div class="row">
        <div class="col-md-12">
            <canvas id="uploadChart"></canvas>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('uploadChart').getContext('2d');
    const uploadChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Uploads Over Time',
                data: {!! json_encode($chartData) !!},
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endsection
