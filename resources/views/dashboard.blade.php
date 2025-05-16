@extends('layouts.main')

@section('container')
<!-- Main Content -->
<div id="content">

    @include('layouts.topbar')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        </div>

        <!-- Dashboard -->
        <div class="row">

            <!-- Evidence Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    User</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cnt_user }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Evidence Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Evidence</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cnt_evidence }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-fingerprint fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    hypothesis </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cnt_hypothesis }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-lightbulb fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Case </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cnt_case }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-search fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold">History Diagnosis</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Hypothesis</th>
                                        <th>Expert Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($diagnosis_data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->hypothesis->name }}</td>
                                        <td>{{ $item->value }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold">Chart Case Diagnosis</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2 text-center d-flex flex-row align-items-center justify-content-between">
                            <canvas id="myPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<!-- Page level custom scripts -->
<script src="{{ asset('assets/js/chart.js')}}"></script>
<script>
    const ctx = document.getElementById('myPieChart');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [
                @foreach ($hypothesis_data as $item)
                    "{{ $item->name }}", 
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach ($hypothesis_data as $item)
                        {{ $diagnosis_data->where('hypothesis_id',$item->id)->count() }}, 
                    @endforeach
                ],
                backgroundColor: [
                    '#0D96FF', 
                    '#00B9FF', 
                    '#00D4EB',
                    '#00E8BA',
                    '#94F489',
                    '#F9F871',
                ],
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                        legend: {
                        display: false
                    },
                    cutoutPercentage: 80,
                },
            }]
        }
    });
</script>
{{-- <script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [
                @foreach ($hypothesis_data as $item)
                    "{{ $item->name }}", 
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach ($hypothesis_data as $item)
                        {{ $diagnosis_data->where('hypothesis_id',$item->id)->count() }}, 
                    @endforeach
                ],
                backgroundColor: [
                    '#0D96FF', 
                    '#00B9FF', 
                    '#00D4EB',
                    '#00E8BA',
                    '#94F489',
                    '#F9F871',
                ],
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
                legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });

</script> --}}
@endsection
