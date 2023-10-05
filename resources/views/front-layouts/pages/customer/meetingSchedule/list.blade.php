@extends('front-layouts.master-user-layout')
@section('content')
<div class="col-xl-9 col-md-8">
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">All Meetings</h3>
                    </div>
                   
                </div>
            </div>
            <!-- /Page Header -->

          

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Meeting With</th>
                                            <th>Meeting Link</th>
                                            <th>Meeting Time</th>
                                            
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($obj as $key => $val)
                                            <tr>
                                                
                                                <td>{{ $val->user->name }}</td>
                                                <td>{{ $val->meeting_link }}</td>
                                                <td>{{ $val->spanTime->time_spans }}</td> 
                                               


                                                <td class="text-end">
                                                    <a href="{{ route('video.call',$val->meeting_link ) }}"
                                                        class="btn btn-sm bg-success-light me-2"> <i
                                                            class="fas fa-video me-1"></i> Join</a>
                                                   
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
</div>
@endsection
