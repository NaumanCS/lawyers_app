@extends('layouts.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-12">
                        <h3 class="page-title">Welcome Admin!</h3>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-primary">
                                    <i class="far fa-user"></i>
                                </span>
                                <div class="dash-widget-info">
                                    <h3>{{ $countAllUsers ?? '0' }}</h3>
                                    <h6 class="text-muted">Users</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-primary">
                                    <i class="fas fa-user-shield"></i>
                                </span>
                                <div class="dash-widget-info">
                                    <h3>{{ $countAllOrders ?? 0 }}</h3>
                                    <h6 class="text-muted">Orders</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-primary">
                                    <i class="fas fa-qrcode"></i>
                                </span>
                                <div class="dash-widget-info">
                                    <h3>{{ $totalPayment ?? '0' }}</h3>
                                    <h6 class="text-muted">Total Payment</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-primary">
                                    <i class="far fa-credit-card"></i>
                                </span>
                                <div class="dash-widget-info">
                                    <h3>{{ $adminProfit ?? '0' }}</h3>
                                    <h6 class="text-muted">Admin 20%</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 d-flex">

                    <!-- Payments -->
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title">Payments</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-center">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>User</th>
                                            <th>Provider</th>
                                            <th>Service</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>15 Sep 2020</td>
                                            <td>
                                                <span class="table-avatar">
                                                    <a href="#" class="avatar avatar-xs me-2">
                                                        <img class="avatar-img rounded-circle" alt=""
                                                            src="{{ asset('admin') }}/assets/img/customer/user-02.jpg">
                                                    </a>
                                                    <a href="javascript:void(0);">Nancy Olson</a>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="table-avatar">
                                                    <a href="#" class="avatar avatar-xs me-2">
                                                        <img class="avatar-img rounded-circle" alt=""
                                                            src="{{ asset('admin') }}/assets/img/provider/provider-02.jpg">
                                                    </a>
                                                    <a href="javascript:void(0);">Matthew Garcia</a>
                                                </span>
                                            </td>
                                            <td>Car Repair Services</td>
                                            <td>$50</td>
                                            <td>
                                                <span class="badge badge-dark">Pending</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>14 Sep 2020</td>
                                            <td>
                                                <span class="table-avatar">
                                                    <a href="#" class="avatar avatar-xs me-2">
                                                        <img class="avatar-img rounded-circle" alt=""
                                                            src="{{ asset('admin') }}/assets/img/customer/user-03.jpg">
                                                    </a>
                                                    <a href="javascript:void(0);">Ramona Kingsley</a>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="table-avatar">
                                                    <a href="#" class="avatar avatar-xs me-2">
                                                        <img class="avatar-img rounded-circle" alt=""
                                                            src="{{ asset('admin') }}/assets/img/provider/provider-03.jpg">
                                                    </a>
                                                    <a href="javascript:void(0);">Yolanda Potter</a>
                                                </span>
                                            </td>
                                            <td>Electric Panel Repairing Service</td>
                                            <td>$45</td>
                                            <td>
                                                <span class="badge badge-dark">Pending</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>13 Sep 2020</td>
                                            <td>
                                                <span class="table-avatar">
                                                    <a href="#" class="avatar avatar-xs me-2">
                                                        <img class="avatar-img rounded-circle" alt=""
                                                            src="assets/img/customer/user-04.jpg">
                                                    </a>
                                                    <a href="javascript:void(0);">Ricardo Lung</a>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="table-avatar">
                                                    <a href="#" class="avatar avatar-xs me-2">
                                                        <img class="avatar-img rounded-circle" alt=""
                                                            src="assets/img/provider/provider-04.jpg">
                                                    </a>
                                                    <a href="javascript:void(0);">Ricardo Flemings</a>
                                                </span>
                                            </td>
                                            <td>Steam Car Wash</td>
                                            <td>$14</td>
                                            <td>
                                                <span class="badge badge-dark">Pending</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>12 Sep 2020</td>
                                            <td>
                                                <span class="table-avatar">
                                                    <a href="#" class="avatar avatar-xs me-2">
                                                        <img class="avatar-img rounded-circle" alt=""
                                                            src="assets/img/customer/user-05.jpg">
                                                    </a>
                                                    <a href="javascript:void(0);">Annette Silva</a>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="table-avatar">
                                                    <a href="#" class="avatar avatar-xs me-2">
                                                        <img class="avatar-img rounded-circle" alt=""
                                                            src="assets/img/provider/provider-05.jpg">
                                                    </a>
                                                    <a href="javascript:void(0);">Maritza Wasson</a>
                                                </span>
                                            </td>
                                            <td>House Cleaning Services</td>
                                            <td>$100</td>
                                            <td>
                                                <span class="badge badge-dark">Pending</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>11 Sep 2020</td>
                                            <td>
                                                <span class="table-avatar">
                                                    <a href="#" class="avatar avatar-xs me-2">
                                                        <img class="avatar-img rounded-circle" alt=""
                                                            src="assets/img/customer/user-06.jpg">
                                                    </a>
                                                    <a href="javascript:void(0);">Stephen Wilson</a>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="table-avatar">
                                                    <a href="#" class="avatar avatar-xs me-2">
                                                        <img class="avatar-img rounded-circle" alt=""
                                                            src="assets/img/provider/provider-06.jpg">
                                                    </a>
                                                    <a href="javascript:void(0);">Marya Ruiz</a>
                                                </span>
                                            </td>
                                            <td>Computer & Server AMC Service</td>
                                            <td>$80</td>
                                            <td>
                                                <span class="badge badge-info">Inprogress</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Payments -->
                </div>
            </div>
        </div>
    </div>
@endsection
