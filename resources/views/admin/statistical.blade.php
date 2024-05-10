@extends('layouts.adminlayout')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="/admin">
                    <div class="form-group">
                        <label for="from_date">Từ ngày:</label>
                        <input type="date" class="form-control" id="from_date" name="from_date"
                               value="{{ request('from_date', \Carbon\Carbon::now()->subDays(7)->toDateString()) }}">
                    </div>
                    <div class="form-group">
                        <label for="to_date">Đến ngày:</label>
                        <input type="date" class="form-control" id="to_date" name="to_date"
                               value="{{ request('to_date', \Carbon\Carbon::now()->toDateString()) }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Lọc</button>
                </form>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Thống kê số lượng sản phẩm</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="quantityChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Thống kê doanh thu</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <script>
        var quantityLabels = @json($quantityStats->pluck('product_name'));
        var quantityData = @json($quantityStats->pluck('quantity'));

        // Biểu đồ hình cột: Thống kê số lượng sản phẩm nhé he
        var quantityChart = document.getElementById('quantityChart').getContext('2d');
        var myQuantityChart = new Chart(quantityChart, {
            type: 'pie',
            data: {
                labels: quantityLabels,
                datasets: [{
                    label: 'Số lượng',
                    data: quantityData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ]
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var revenueLabels = @json($revenueStats->pluck('product_name'));
        var revenueData = @json($revenueStats->pluck('revenue'));

        // Biểu đồ hình cột Thống kê doanh thu nha
        var revenueChart = document.getElementById('revenueChart').getContext('2d');
        var myRevenueChart = new Chart(revenueChart, {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Doanh thu',
                    data: revenueData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
