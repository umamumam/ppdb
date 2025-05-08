@extends('layouts1.app')

@section('content')

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Home</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<!-- [ Main Content ] start -->
<div class="row">
    <!-- [ sample-page ] start -->
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Total Peserta Naik Tingkat</h6>
                    <h3 class="mb-3">
                        {{ $naikTingkat }}
                        <span class="badge bg-light-primary border border-primary"><i class="ti ti-school"></i></span>
                    </h3>
                    <p class="mb-0 text-muted text-sm">Peserta MTs yang melanjutkan</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Total Peserta Baru</h6>
                    <h3 class="mb-3">
                        {{ $pesertaBaru }}
                        <span class="badge bg-light-success border border-success"><i class="ti ti-users"></i></span>
                    </h3>
                    <p class="mb-0 text-muted text-sm">Peserta baru mendaftar tahun ini</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Total Alumni</h6>
                    <h3 class="mb-3">{{ $totalAlumni }}
                        <span class="badge bg-light-warning border border-warning"><i
                                class="ti ti-user-check"></i></span></h3>
                    <p class="mb-0 text-muted text-sm">Total alumni yang terdaftar</p>
                </div>
            </div>
        </div>

        <!-- Total Petugas Pendaftar -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Total Petugas Pendaftar</h6>
                    <h3 class="mb-3">{{ $totalPetugas }}
                        <span class="badge bg-light-danger border border-danger"><i
                                class="ti ti-users"></i></span></h3>
                    <p class="mb-0 text-muted text-sm">Total petugas pendaftaran</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-8">
        <h5 class="mb-3">Grafik PPDB</h5>
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Statistik Pendaftar</h6>
                <div id="sales-report-chart1"></div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var options = {
                            chart: {
                                type: 'bar',
                                height: 430,
                                toolbar: {
                                    show: false
                                }
                            },
                            plotOptions: {
                                bar: {
                                    columnWidth: '30%',
                                    borderRadius: 4
                                }
                            },
                            stroke: {
                                show: true,
                                width: 8,
                                colors: ['transparent']
                            },
                            dataLabels: {
                                enabled: false
                            },
                            legend: {
                                position: 'top',
                                horizontalAlign: 'right',
                                show: true,
                                fontFamily: `'Public Sans', sans-serif`,
                                offsetX: 10,
                                offsetY: 10,
                                labels: {
                                    useSeriesColors: false
                                },
                                markers: {
                                    width: 10,
                                    height: 10,
                                    radius: '50%',
                                    offsetX: 2,
                                    offsetY: 2
                                },
                                itemMargin: {
                                    horizontal: 15,
                                    vertical: 5
                                }
                            },
                            colors: ['#faad14', '#1890ff'],
                            series: [{
                                name: 'Laki-laki',
                                data: [
                                    {{ $chartData['naikTingkat']['Laki-laki'] }},
                                    {{ $chartData['pesertaBaru']['Laki-laki'] }},
                                    {{ $chartData['alumni']['Laki-laki'] }}
                                ]
                            }, {
                                name: 'Perempuan',
                                data: [
                                    {{ $chartData['naikTingkat']['Perempuan'] }},
                                    {{ $chartData['pesertaBaru']['Perempuan'] }},
                                    {{ $chartData['alumni']['Perempuan'] }}
                                ]
                            }],
                            xaxis: {
                                categories: ['Naik Tingkat', 'Peserta Baru', 'Alumni']
                            },
                            tooltip: {
                                y: {
                                    formatter: function (val) {
                                        return val + " orang";
                                    }
                                }
                            }
                        };

                        var chart = new ApexCharts(document.querySelector('#sales-report-chart1'), options);
                        chart.render();
                    });
                </script>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-12 col-xl-8">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="mb-0">Unique Visitor</h5>
            <ul class="nav nav-pills justify-content-end mb-0" id="chart-tab-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="chart-tab-home-tab" data-bs-toggle="pill"
                        data-bs-target="#chart-tab-home" type="button" role="tab" aria-controls="chart-tab-home"
                        aria-selected="true">Month</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="chart-tab-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#chart-tab-profile" type="button" role="tab" aria-controls="chart-tab-profile"
                        aria-selected="false">Week</button>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="chart-tab-tabContent">
                    <div class="tab-pane" id="chart-tab-home" role="tabpanel" aria-labelledby="chart-tab-home-tab"
                        tabindex="0">
                        <div id="visitor-chart-1"></div>
                    </div>
                    <div class="tab-pane show active" id="chart-tab-profile" role="tabpanel"
                        aria-labelledby="chart-tab-profile-tab" tabindex="0">
                        <div id="visitor-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-md-12 col-xl-4">
        <h5 class="mb-3">Statistik PPDB</h5>
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Total Pendaftar</h6>
                <h3 class="mb-3">{{ $totalPendaftar }} Orang</h3>
                <h6 class="mb-2 f-w-400 text-muted">Total Calon Siswa</h6>
                <h3 class="mb-3">{{ $totalAlumni }} Orang</h3>
                <div id="income-overview-chart1"></div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var options = {
                            chart: {
                                type: 'donut',
                                height: 300,
                                toolbar: {
                                    show: false
                                }
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '65%'
                                    }
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            legend: {
                                position: 'bottom',
                                show: true,
                                fontFamily: `'Public Sans', sans-serif`
                            },
                            colors: ['#1890ff', '#faad14', '#52c41a'],
                            series: [
                                {{ $naikTingkat }},
                                {{ $pesertaBaru }},
                                {{ $totalAlumni }}
                            ],
                            labels: ['Naik Tingkat', 'Peserta Baru', 'Alumni'],
                            tooltip: {
                                y: {
                                    formatter: function (val) {
                                        return val + " orang";
                                    }
                                }
                            }
                        };

                        var chart = new ApexCharts(document.querySelector('#income-overview-chart1'), options);
                        chart.render();
                    });
                </script>
            </div>
        </div>
    </div>

    {{-- <div class="col-md-12 col-xl-8">
        <h5 class="mb-3">Recent Orders</h5>
        <div class="card tbl-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>TRACKING NO.</th>
                                <th>PRODUCT NAME</th>
                                <th>TOTAL ORDER</th>
                                <th>STATUS</th>
                                <th class="text-end">TOTAL AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="#" class="text-muted">84564564</a></td>
                                <td>Camera Lens</td>
                                <td>40</td>
                                <td><span class="d-flex align-items-center gap-2"><i
                                            class="fas fa-circle text-danger f-10 m-r-5"></i>Rejected</span>
                                </td>
                                <td class="text-end">$40,570</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="text-muted">84564564</a></td>
                                <td>Laptop</td>
                                <td>300</td>
                                <td><span class="d-flex align-items-center gap-2"><i
                                            class="fas fa-circle text-warning f-10 m-r-5"></i>Pending</span>
                                </td>
                                <td class="text-end">$180,139</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="text-muted">84564564</a></td>
                                <td>Mobile</td>
                                <td>355</td>
                                <td><span class="d-flex align-items-center gap-2"><i
                                            class="fas fa-circle text-success f-10 m-r-5"></i>Approved</span>
                                </td>
                                <td class="text-end">$180,139</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="text-muted">84564564</a></td>
                                <td>Camera Lens</td>
                                <td>40</td>
                                <td><span class="d-flex align-items-center gap-2"><i
                                            class="fas fa-circle text-danger f-10 m-r-5"></i>Rejected</span>
                                </td>
                                <td class="text-end">$40,570</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="text-muted">84564564</a></td>
                                <td>Laptop</td>
                                <td>300</td>
                                <td><span class="d-flex align-items-center gap-2"><i
                                            class="fas fa-circle text-warning f-10 m-r-5"></i>Pending</span>
                                </td>
                                <td class="text-end">$180,139</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="text-muted">84564564</a></td>
                                <td>Mobile</td>
                                <td>355</td>
                                <td><span class="d-flex align-items-center gap-2"><i
                                            class="fas fa-circle text-success f-10 m-r-5"></i>Approved</span>
                                </td>
                                <td class="text-end">$180,139</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="text-muted">84564564</a></td>
                                <td>Camera Lens</td>
                                <td>40</td>
                                <td><span class="d-flex align-items-center gap-2"><i
                                            class="fas fa-circle text-danger f-10 m-r-5"></i>Rejected</span>
                                </td>
                                <td class="text-end">$40,570</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="text-muted">84564564</a></td>
                                <td>Laptop</td>
                                <td>300</td>
                                <td><span class="d-flex align-items-center gap-2"><i
                                            class="fas fa-circle text-warning f-10 m-r-5"></i>Pending</span>
                                </td>
                                <td class="text-end">$180,139</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="text-muted">84564564</a></td>
                                <td>Mobile</td>
                                <td>355</td>
                                <td><span class="d-flex align-items-center gap-2"><i
                                            class="fas fa-circle text-success f-10 m-r-5"></i>Approved</span>
                                </td>
                                <td class="text-end">$180,139</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="text-muted">84564564</a></td>
                                <td>Mobile</td>
                                <td>355</td>
                                <td><span class="d-flex align-items-center gap-2"><i
                                            class="fas fa-circle text-success f-10 m-r-5"></i>Approved</span>
                                </td>
                                <td class="text-end">$180,139</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-4">
        <h5 class="mb-3">Analytics Report</h5>
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="#"
                    class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">Company
                    Finance Growth<span class="h5 mb-0">+45.14%</span></a>
                <a href="#"
                    class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">Company
                    Expenses Ratio<span class="h5 mb-0">0.58%</span></a>
                <a href="#"
                    class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">Business
                    Risk Cases<span class="h5 mb-0">Low</span></a>
            </div>
            <div class="card-body px-2">
                <div id="analytics-report-chart"></div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-xl-8">
        <h5 class="mb-3">Sales Report</h5>
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">This Week Statistics</h6>
                <h3 class="mb-0">$7,650</h3>
                <div id="sales-report-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-4">
        <h5 class="mb-3">Transaction History</h5>
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s rounded-circle text-success bg-light-success">
                                <i class="ti ti-gift f-18"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Order #002434</h6>
                            <p class="mb-0 text-muted">Today, 2:00 AM</P>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <h6 class="mb-1">+ $1,430</h6>
                            <p class="mb-0 text-muted">78%</P>
                        </div>
                    </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s rounded-circle text-primary bg-light-primary">
                                <i class="ti ti-message-circle f-18"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Order #984947</h6>
                            <p class="mb-0 text-muted">5 August, 1:45 PM</P>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <h6 class="mb-1">- $302</h6>
                            <p class="mb-0 text-muted">8%</P>
                        </div>
                    </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s rounded-circle text-danger bg-light-danger">
                                <i class="ti ti-settings f-18"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Order #988784</h6>
                            <p class="mb-0 text-muted">7 hours ago</P>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <h6 class="mb-1">- $682</h6>
                            <p class="mb-0 text-muted">16%</P>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div> --}}
</div>
@endsection
