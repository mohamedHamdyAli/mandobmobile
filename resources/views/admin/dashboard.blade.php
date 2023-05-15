@extends('admin.index')
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img
                                src="{{asset('admin/assets/img/icons/unicons/chart-success.png')}}"
                                alt="chart success"
                                class="rounded"
                                />
                            </div>
                        </div>
                        <h3 class="card-title mb-2">{{$users}}</h3>
                        <span class="fw-semibold d-block mb-1">Total Users</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img
                                src="{{asset('admin/assets/img/icons/unicons/chart.png')}}"
                                alt="chart success"
                                class="rounded"
                                />
                            </div>
                        </div>
                        <h3 class="card-title mb-2">{{$drivers}}</h3>
                        <span class="fw-semibold d-block mb-1">Total Drivers</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img
                                src="{{asset('admin/assets/img/icons/unicons/chart.png')}}"
                                alt="chart success"
                                class="rounded"
                                />
                            </div>
                        </div>
                        <h3 class="card-title mb-2">{{$orders}}</h3>
                        <span class="fw-semibold d-block mb-1">Total Orders</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img
                                src="{{asset('admin/assets/img/icons/unicons/chart-success.png')}}"
                                alt="chart success"
                                class="rounded"
                                />
                            </div>
                        </div>
                        <h3 class="card-title mb-2">{{$activities}}</h3>
                        <span class="fw-semibold d-block mb-1">Total Activities</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        <!-- Transactions -->
        <div class="col-md-6 col-lg-4 order-2 mb-4">
            <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="col-8">
                    <h5 class="card-title m-0 me-2">Users</h5>
                </div>
                <div class="col-4">
                    <a href="{{route('user.index')}}" class="btn btn-primary small">See All</a>
                </div>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    @foreach ($user_info as $user_in)
                        <li class="d-flex mb-4 pb-1">
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">{{$user_in->username}}</h6>
                                <small class="text-muted d-block mb-1">{{$user_in->phone}}</small>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                                <h6 class="mb-0">{{$user_in->user_type}}</h6>
                            </div>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 order-2 mb-4">
            <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="col-8">
                    <h5 class="card-title m-0 me-2">Orders</h5>
                </div>
                <div class="col-4">
                    <a href="{{route('order.index')}}" class="btn btn-primary small">See All</a>
                </div>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    @foreach ($orders_info as $orders_in)
                        <li class="d-flex mb-4 pb-1">
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">{{$orders_in->user->username}}</h6>
                                <small class="text-muted d-block mb-1">{{$orders_in->address_from}}</small>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                                <h6 class="mb-0">{{$orders_in->status}}</h6>
                            </div>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 order-2 mb-4">
            <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="col-8">
                    <h5 class="card-title m-0 me-2">Activity Type</h5>
                </div>
                <div class="col-4">
                    <a href="{{route('activity.index')}}" class="btn btn-primary small">See All</a>
                </div>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    @foreach ($activities_info as $activities_in)
                        <li class="d-flex mb-4 pb-1">
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">{{$activities_in->name_en}}</h6>
                            </div>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
            </div>
        </div>
        <!--/ Transactions -->

        </div>
    </div>
@endsection
