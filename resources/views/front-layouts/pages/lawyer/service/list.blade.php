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
                    <h4 class="card-title">All Services</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-center" id="dataTableId">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Location</th>
                                    <th>Starting Day</th>
                                    <th>Ending Day</th>
                                    <th>Starting Time</th>
                                    <th>Ending Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td style="width: 10%;"><img src="{{ $row->cover_image }}" class="w-100"
                                                alt="Service Image"></td>
                                        <td>{{ $row->title }}</td>
                                        <td>{{ $row->category->title ?? "" }}</td>
                                        <td>{{ $row->amount }}</td>
                                        <td>{{ $row->location }}</td>
                                        <td>{{ $row->start_day }}</td>
                                        <td>{{ $row->end_day }}</td>
                                        <td>{{ $row->start_time }}</td>
                                        <td>{{ $row->end_time }}</td>

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
