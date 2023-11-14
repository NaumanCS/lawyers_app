@extends('layouts.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Pay Now</h3>
                    </div>
                    <div class="col-auto text-end">
                        {{-- <a href="{{ route('admin.transaction.form', $update_id = 0) }}"
                            class="btn btn-primary add-button ms-3">
                            <i class="fas fa-plus"></i>
                        </a> --}}
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

                                            <th>Order Id</th>
                                            <th>User</th>
                                            <th>Jazzcash Account</th>
                                            <th>Bank Account</th>
                                            <th>Total Amount</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payNow as $key => $val)
                                            <tr>
                                                <td>{{ $val->id }}</td>
                                                <td>{{ $val->lawyer->name }}</td>
                                                <td>
                                                    <div>Title : {{ $val->lawyer->accountDetail->jazzcash_title }}</div>
                                                    <div>Account Number : {{ $val->lawyer->accountDetail->jazzcash_number }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>Title : {{ $val->lawyer->accountDetail->bank_account_title }}</div>
                                                    <div>Account Number :
                                                        {{ $val->lawyer->accountDetail->bank_account_number }} </div>
                                                    <div>Bank Name : {{ $val->lawyer->accountDetail->bank_name }}
                                                    </div>
                                                </td>
                                                <td>{{ $val->total_amount - $val->total_amount * 0.2 }}</td>
                                                <td>
                                                    <form action="{{ route('send.payment') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="lawyer_id"
                                                            value="{{ $val->lawyer->id }}">
                                                        <button type="sumbit" class="btn btn-sm bg-success-light me-2"><i
                                                                class="far fa-edit me-1"></i>Pay</button>
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
@endsection
