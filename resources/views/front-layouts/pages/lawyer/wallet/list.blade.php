@extends('front-layouts.master-lawyer-layout')
@section('injected-css')
    <style>
        .boxShadowClass {
            box-shadow: 0 0 5px 2px rgba(0, 0, 0, 0.3);
            transition: box-shadow 0.3s ease-in-out;
        }

        .boxShadowClass:hover {
            box-shadow: 0 2px 5px 2px rgba(0, 0, 0, 0.3);
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="row">
            <div class="col-lg-4 ">
                <a href="" class="dash-widget dash-bg-2">
                    <span class="dash-widget-icon">{{ $totalPayment - $totalPayment *0.2 ?? '' }}</span>
                    <div class="dash-widget-info">
                        <span>Total Payment</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="" class="dash-widget dash-bg-2">
                    <span class="dash-widget-icon">{{ $completedPayment - $completedPayment *0.2 ?? '' }}</span>
                    <div class="dash-widget-info">
                        <span>Completed Payment</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="" class="dash-widget dash-bg-2">
                    <span class="dash-widget-icon">{{ $pendingPayment - $pendingPayment *0.2 ?? '' }}</span>
                    <div class="dash-widget-info">
                        <span>Pending Payment</span>
                    </div>
                </a>
            </div>
        </div>
        <P>Note : 20 percent is detected as a service fee from your payment.</P>
        <div class="col-md-12 d-flex">
            <!-- Payments -->
            <div class="card card-table flex-fill boxShadowClass">
                <div class="card-header">
                    <h4 class="card-title">Lawyer Wallet</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                            <table class="table table-center" id="dataTableId">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Amount</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wallet as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->amount -$row->amount *0.2 }}</td>
                                        <td>{{ $row->payment_status ?? 'pending' }}</td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Payments -->
        </div>
    </div>
@endsection
