@extends('front-layouts.master-user-layout')
@section('content')



    <div class="col-xl-9 col-md-8">

        <div class="page-wrapper">
            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col">
                            <h3 class="page-title">Orders</h3>
                        </div>
                        <div class="col-auto text-end">
                            <a href="{{ route('category.form', $update_id = 0) }}" class="btn btn-primary add-button ms-3">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Search Filter -->
                <div class="card filter-card" id="filter_inputs">
                    <div class="card-body pb-0">
                        <form action="#" method="post">
                            <div class="row filter-row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control select">
                                            <option>Select category</option>
                                            <option>Automobile</option>
                                            <option>Construction</option>
                                            <option>Interior</option>
                                            <option>Cleaning</option>
                                            <option>Electrical</option>
                                            <option>Carpentry</option>
                                            <option>Computer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 d-flex align-items-end">
                                    <div class="form-group w-100">
                                        <button class="btn btn-primary btn-block w-100" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Search Filter -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center table-responsive mb-0 datatable">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Lawyer id</th>
                                                <th>Lawyer Location</th>
                                                <th>Amount</th>
                                                <th>Booking Date</th>
                                                <th>Lawyer status</th>
                                                <th>Customer Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($obj as $key => $val)
                                                <tr>
                                                    <td>
                                                        {{ $val->id }}
                                                    </td>
                                                    <td>{{ $val->lawyer_id }}</td>
                                                    <td>{{ $val->lawyer_location }}</td>
                                                    <td>{{ $val->amount }}</td>
                                                    <td>{{ $val->booking_date }}</td>
                                                    <td>
                                                        <span class="text-danger">{!! $val->lawyer_status ?? 'pending' !!}</span>
                                                    </td>
                                                    <td>
                                                        <form id="my-form" action="{{ route('order.status') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="order_id"
                                                                value="{{ $val->id }}">
                                                            <select id="status-select" class="form-control select"
                                                                name="status">
                                                                <option>{!! $val->customer_status ?? 'Status' !!}</option>
                                                                <option value="Pending">Pending</option>
                                                                <option value="Completed">Completed</option>
                                                            </select>
                                                        </form>

                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#status-select').on('change', function() {
                $('#my-form').submit();
            });
        });
    </script>

    <script>
        toastr.success('Order placed successfully');
    </script>
@endsection
