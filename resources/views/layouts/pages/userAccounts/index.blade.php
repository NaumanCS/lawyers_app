@extends('layouts.mainlayout')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if (session('message'))
        toastr.success('{{ session('message') }}');
    @endif
</script>
<script>
    @if (session('error'))
        toastr.error('{{ session('error') }}');
    @endif
</script>
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">All Users Accounts</h3>
                    </div>
                    <div class="col-auto text-end">
                        <a href="{{ route('pay.now', $update_id = 0) }}" class="btn btn-primary add-button ms-3">
                            <i class="fas fa-money">Pay Now</i>
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
                                            
                                            <th>User name</th>
                                            <th>User Type</th>
                                            <th>Account Type</th>
                                            <th>Bank Account Title</th>
                                            <th>Bank Account number</th>
                                            <th>Jazzcash Account Title</th>
                                            <th>Jazzcash Account number</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($obj as $key => $val)
                                            <tr>
                                               
                                                <td>{{ $val->user->name ?? '' }}</td>
                                                <td>{{ $val->user_type ?? '' }}</td>
                                                @if ($val->bank_account == '1')
                                                <td>Bank Account</td>
                                                @else
                                                <td>Jazzcash Account</td>

                                                @endif
                                               
                                                <td>{{ $val->bank_account_title ?? 'Not Provided' }}</td>
                                                <td>{{ $val->bank_account_number ?? 'Not Provided' }}</td>
                                                <td>{{ $val->jazzcash_account_title ?? 'Not Provided' }}</td>
                                                <td>{{ $val->jazzcash_account_number ?? 'Not Provided' }}</td>
                                               

                                                <td class="text-end">
                                                   
                                                    <a href="{{ route('admin.user.accounts.details', $val->id) }}"
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
