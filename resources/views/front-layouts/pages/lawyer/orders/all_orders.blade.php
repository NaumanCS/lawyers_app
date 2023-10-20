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
        <div class="col-md-12 d-flex">
            <!-- Payments -->
            <div class="card card-table flex-fill boxShadowClass">
                <div class="card-header">
                    <h4 class="card-title">{{$card_heading}}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Booking Date</th>
                                    <th>Order Status</th>
                                    <th>Payment Status</th>
                                    <th>Lawyer status</th>
                                    <th>Customer Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $row->category->title ?? 'N/A' }}</td>
                                        <td>{{ $row->amount }}</td>
                                        <td>{{ $row->created_at }}</td>
                                        <td>{{ $row->status == '1' ? 'Approved' : 'Pending' }}</td>
                                        <td>{{ $row->payment_status ?? 'pending' }}</td>
                                       
                                        <td>
                                            <form id="my-form" action="{{ route('lawyer.order.status') }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="order_id"
                                                    value="{{ $row->id }}">
                                                <select id="status-select" class="form-control select"
                                                    name="status">
                                                    <option>{!! $row->lawyer_status ?? 'Status' !!}</option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="Completed">Completed</option>
                                                </select>
                                            </form>

                                        </td>
                                        <td>
                                            <span class="text-danger">{!! $row->customer_status ?? 'pending' !!}</span>
                                        </td>
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
