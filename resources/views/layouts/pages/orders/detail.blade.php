@extends('layouts.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">




            <div class="row">
                <div class="col-md-12 d-flex">

                    <!-- Payments -->
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title">All Users</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-center">
                                    <thead>
                                        <tr>
                                            <th>User Name</th>
                                            <th>User Type</th>
                                            <th>Bank Account Title</th>
                                            <th>Bank Name</th>
                                            <th>Bank Account Number</th>
                                            <th>Jazzcash Account Title</th>
                                            <th>Jazzcash Account Number</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>{{ $userAccountDetail->user->name }}</td>
                                            <td>{{ $userAccountDetail->user_type ?? '' }}</td>
                                            <td>{{ $userAccountDetail->bank_account_title ?? '' }}</td>
                                            <td>{{ $userAccountDetail->bank_name ?? '' }}</td>

                                            <td>{{ $userAccountDetail->bank_account_number ?? '' }}</td>

                                            <td>{{ $userAccountDetail->jazzcash_account_title ?? '' }}</td>
                                            <td>{{ $userAccountDetail->jazzcash_account_number ?? '' }}</td>


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
