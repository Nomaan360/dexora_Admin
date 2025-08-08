@extends('include/layout')

@section('title', 'Home Page')

@section('content')
<!-- Hour chart  -->
<div class="card shadow-none border-0 mb-6">
    {{-- <div class="card-body row g-6">
        <div class="col-12 col-md-8 card-separator">
            <h5 class="mb-2">Welcome back,<span class="h4 fw-semibold"> Felecia 👋🏻</span></h5>
            <div class="col-12 col-lg-5">
            <p>Your progress this week is Awesome. let's keep it up and get a lot of points reward !</p>
            </div>
            <div class="d-flex justify-content-between flex-wrap gap-4 me-12">
            <div class="d-flex align-items-center gap-4 me-6 me-sm-0">
                <div class="avatar avatar-lg">
                <div class="avatar-initial bg-label-primary rounded-3">
                    <div>
                    <img src="{{ asset('svg/icons/laptop.svg') }}" alt="paypal" class="img-fluid">
                    </div>
                </div>
                </div>
                <div class="content-right">
                <p class="mb-1 fw-medium">Hours Spent</p>
                <span class="text-primary mb-0 h5">34h</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-4">
                <div class="avatar avatar-lg">
                <div class="avatar-initial bg-label-info rounded-3">
                    <div>
                    <img src="{{ asset('svg/icons/lightbulb.svg') }}" alt="Lightbulb" class="img-fluid">
                    </div>
                </div>
                </div>
                <div class="content-right">
                <p class="mb-1 fw-medium">Test Results</p>
                <span class="text-info mb-0 h5">82%</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-4">
                <div class="avatar avatar-lg">
                <div class="avatar-initial bg-label-warning rounded-3">
                    <div>
                    <img src="{{ asset('svg/icons/check.svg') }}" alt="Check" class="img-fluid">
                    </div>
                </div>
                </div>
                <div class="content-right">
                <p class="mb-1 fw-medium">Course Completed </p>
                <span class="text-warning mb-0 h5">14</span>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-md-4 ps-md-4 ps-lg-6">
            <div class="d-flex justify-content-between align-items-center">
            <div>
                <div>
                <h5 class="mb-1">Time Spendings</h5>
                <p class="mb-9">Weekly report</p>
                </div>
                <div class="time-spending-chart">
                <h5 class="mb-2">231<span class="text-body">h</span> 14<span class="text-body">m</span></h5>
                <span class="badge bg-label-success rounded-pill">+18.4%</span>
                </div>
            </div>
            <div id="leadsReportChart"></div>
            </div>
        </div>
    </div> --}}
</div>

<div class="row g-6">
    <!-- Sales Overview-->
    <div class="col-lg-3 col-sm-6">
        <div class="card h-100">
            <div class="row">
            <div class="col-6">
                <div class="card-body">
                <div class="card-info mb-5">
                    <h6 class="mb-2 text-nowrap">Total Users</h6>
                    {{-- <div class="badge bg-label-success rounded-pill lh-xs">Last Month</div> --}}
                </div>
                <div class="d-flex align-items-center">
                    <h4 class="mb-0 me-2">{{$data['user_count']}}</h4>
                    {{-- <p class="mb-0 text-danger ">-25.5%</p> --}}
                </div>
                </div>
            </div>
            <div class="col-6 text-end d-flex align-items-end">
                <div class="card-body pb-0 pt-7">
                <img src="{{asset('img/illustrations/card-session-illustration.png')}}" alt="Ratings" class="img-fluid" width="81">
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card h-100">
            <div class="row">
            <div class="col-6">
                <div class="card-body">
                <div class="card-info mb-5">
                    <h6 class="mb-2 text-nowrap">Today's Cipher</h6>
                    {{-- <div class="badge bg-label-success rounded-pill lh-xs">Last Month</div> --}}
                </div>
                <div class="d-flex align-items-center">
                @if ($data['cipher']!=null)
                    <h4 class="mb-0 me-2">{{$data['cipher']['cipher_code']}}</h4>
                @else
                    <h4 class="mb-0 me-2">0</h4>
                @endif
                    {{-- <h4 class="mb-0 me-2">{{$data['cipher']['cipher_code']}}</h4> --}}
                    {{-- <p class="mb-0 text-danger ">-25.5%</p> --}}
                </div>
                </div>
            </div>
            <div class="col-6 text-end d-flex align-items-end">
                <div class="card-body pb-0 pt-7">
                <img src="{{asset('img/illustrations/card-session-illustration.png')}}" alt="Ratings" class="img-fluid" width="81">
                </div>
            </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="mb-1">Sales Overview</h5>
                <div class="dropdown">
                <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1" type="button" id="salesOverview" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ri-more-2-line ri-20px"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesOverview">
                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                    <a class="dropdown-item" href="javascript:void(0);">Update</a>
                </div>
                </div>
            </div>
            <div class="d-flex align-items-center card-subtitle">
                <div class="me-2">Total 42.5k Sales</div>
                <div class="d-flex align-items-center text-success">
                <p class="mb-0 fw-medium">+18%</p>
                <i class="ri-arrow-up-s-line ri-20px"></i>
                </div>
            </div>
            </div>
            <div class="card-body d-flex justify-content-between flex-wrap gap-4">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar">
                <div class="avatar-initial bg-label-primary rounded">
                    <i class="ri-user-star-line ri-24px"></i>
                </div>
                </div>
                <div class="card-info">
                <h5 class="mb-0">8,458</h5>
                <p class="mb-0">New Customers</p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="avatar">
                <div class="avatar-initial bg-label-warning rounded">
                    <i class="ri-pie-chart-2-line ri-24px"></i>
                </div>
                </div>
                <div class="card-info">
                <h5 class="mb-0">$28.5k</h5>
                <p class="mb-0">Total Profit</p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="avatar">
                <div class="avatar-initial bg-label-info rounded">
                    <i class="ri-arrow-left-right-line ri-24px"></i>
                </div>
                </div>
                <div class="card-info">
                <h5 class="mb-0">2,450k</h5>
                <p class="mb-0">New Transactions</p>
                </div>
            </div>
            </div>
        </div>
    </div> --}}
    <!--/ Sales Overview-->

    <!-- Ratings -->
    {{-- <div class="col-lg-3 col-sm-6">
        <div class="card h-100">
            <div class="row">
            <div class="col-6">
                <div class="card-body">
                <div class="card-info mb-5">
                    <h6 class="mb-2 text-nowrap">Ratings</h6>
                    <div class="badge bg-label-primary rounded-pill lh-xs">Year of 2021</div>
                </div>
                <div class="d-flex align-items-center">
                    <h4 class="mb-0 me-2">8.14k</h4>
                    <p class="mb-0 text-success">+15.6%</p>
                </div>
                </div>
            </div>
            <div class="col-6 text-end d-flex align-items-end">
                <div class="card-body pb-0 pt-7">
                <img src="{{asset('img/illustrations/card-ratings-illustration.png')}}" alt="Ratings" class="img-fluid" width="95">
                </div>
            </div>
            </div>
        </div>
    </div> --}}
    <!--/ Ratings -->

    <!-- Sessions -->
    {{-- <div class="col-lg-3 col-sm-6">
        <div class="card h-100">
            <div class="row">
            <div class="col-6">
                <div class="card-body">
                <div class="card-info mb-5">
                    <h6 class="mb-2 text-nowrap">Sessions</h6>
                    <div class="badge bg-label-success rounded-pill lh-xs">Last Month</div>
                </div>
                <div class="d-flex align-items-center">
                    <h4 class="mb-0 me-2">12.2k</h4>
                    <p class="mb-0 text-danger ">-25.5%</p>
                </div>
                </div>
            </div>
            <div class="col-6 text-end d-flex align-items-end">
                <div class="card-body pb-0 pt-7">
                <img src="{{asset('img/illustrations/card-session-illustration.png')}}" alt="Ratings" class="img-fluid" width="81">
                </div>
            </div>
            </div>
        </div>
    </div> --}}

    <!--/ Sessions -->
</div>

@endsection

@section('customjs')
<script src="{{ asset('js/dashboards-analytics.js') }}"></script>
<script src="{{ asset('vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('js/app-academy-dashboard.js') }}"></script>
@endsection
