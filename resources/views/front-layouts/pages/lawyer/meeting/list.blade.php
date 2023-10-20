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
                    <h4 class="card-title">All Meeting</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-center" id="dataTableId">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Room name</th>
                                    <th>Created By</th>
                                    <th>Created at Date</th>
                                    <th>Date</th>

                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->meeting_link }}</td>
                                        <td>{{ $row->createdByUser->name }}</td>
                                        <td>{{ $row->created_at }}</td>
                                        <td>{{ $row->date }}</td>

                                        <td>{{ $row->spanTime->time_spans }}</td> 
                                        <td>
                                            <a class="text-success" href="{{ route('video.call.lawyer',$row->meeting_link) }}">Meet</a>
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
