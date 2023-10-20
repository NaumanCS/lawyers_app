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
                                            <th>Booking Date</th>
                                            <th>Lawyer Status</th>
                                            <th>Customer Status</th>
                                            <th>Lawyer location</th>
                                            <th>Customer location</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>{{ $orderDetail->booking_date }}</td>
                                            <td>{{ $orderDetail->lawyer_status ?? '' }}</td>
                                            <td>{{ $orderDetail->customer_status ?? '' }}</td>
                                            <td>{{ $orderDetail->lawyer_location ?? '' }}</td>
                                            <td>{{ $orderDetail->customer_location ?? '' }}</td>


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
