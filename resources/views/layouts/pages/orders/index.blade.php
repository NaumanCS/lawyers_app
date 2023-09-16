@extends('layouts.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">All Orders</h3>
                    </div>
                    <div class="col-auto text-end">
                        <a href="{{ route('admin.order.form', $update_id = 0) }}" class="btn btn-primary add-button ms-3">
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
                                    <label>Order</label>
                                    <select class="form-control select">
                                        <option>Select admin.order</option>
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
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
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
                                <table class="table table-hover table-center mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Payment Slip</th>
                                            <th>Lawyer id</th>
                                            <th>Customer id</th>
                                            <th>Category id</th>
                                            <th>Amount</th>

                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($obj as $key => $val)
                                            <tr>
                                                <td>
                                                    <a href="{{ $val->payment_slip }}" target="_blank" download>
                                                        <img class="rounded service-img me-1" src="{{ $val->payment_slip }}" alt="nav logo">
                                                    </a>
                                                </td>
                                                <td>{{ $val->lawyer_id }}</td>
                                                <td>{{ $val->customer_id }}</td>
                                                <td>{{ $val->category_id }}</td>
                                                <td>{{ $val->amount }}</td>


                                                <td class="text-end">
                                                    <a href="{{ route('admin.order.form', $val->id) }}"
                                                        class="btn btn-sm bg-success-light me-2"> <i
                                                            class="far fa-edit me-1"></i> Edit</a>
                                                    <a href="{{ route('admin.order.details', $val->id) }}"
                                                        class="btn btn-sm bg-success-light me-2"> <i
                                                            class="far fa-eye me-1"></i> View</a>
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
@endsection
