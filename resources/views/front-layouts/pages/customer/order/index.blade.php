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
                                                <th>Payment Slip</th>
                                                <th>Upload Slip</th>
                                                <th>Lawyer id</th>
                                                <th>Lawyer Location</th>
                                                <th>Amount</th>
                                                <th>Booking Date</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($obj as $key => $val)
                                                <tr>
                                                    <td>
                                                        {{ $val->id }}
                                                    </td>
                                                    <td>
                                                      
                                                        <img class="w-25 h-25" src="{{ $val->payment_slip }}" alt="Payment Slip">
                                                    </td>
                                                    <td>
                                                      
                                                        <a class="btn btn-primary text-white" href="{{ route('upload.payment.slip',$val->id) }}">Upload</a>
                                                    </td>
                                                    <td>{{ $val->lawyer_id }}</td>
                                                    <td>{{ $val->lawyer_location }}</td>
                                                    <td>{{ $val->amount }}</td>
                                                    <td>{{ $val->booking_date }}</td>
                                                   
                                                    {{-- <td>
                                                        <form class="my-form" action="{{ route('order.status') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="order_id" value="{{ $val->id }}">
                                                            <select class="form-control select" name="status">
                                                                <option>{!! $val->customer_status ?? 'Status' !!}</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="completed">Completed</option>
                                                            </select>
                                                        </form>

                                                    </td> --}}

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
    {{-- <script>
        $(document).ready(function() {
            $('#status-select').on('change', function() {
                $('#my-form').submit();
            });
        });
    </script> --}}
    <script>
        // Add an event listener to all select elements with the class "my-form"
        document.querySelectorAll(".my-form select").forEach(function(selectElement) {
            selectElement.addEventListener("change", function () {
                // Find the form element that contains this select and submit it
                const form = this.closest(".my-form");
                form.submit();
            });
        });
    </script>
    <script>
        toastr.success('Order placed successfully');
    </script>
@endsection
