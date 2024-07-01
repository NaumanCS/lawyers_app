@extends('layouts.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Verifications</h3>
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
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Joined At</th>
                                            <th>Status</th>
                                            <th>Block</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($obj as $key => $val)
                                            <tr>
                                                <td>
                                                    <img class="rounded service-img me-1" src="<?= $val->image ?>"
                                                        alt="Category Image">
                                                </td>
                                                <td>{{ $val->name ?? "Null" }}</td>
                                                <td>{{ $val->created_at ?? "Null" }}</td>
                                                <td>{{ $val->document_status ?? "Null" }}</td>
                                                <td>{{ $val->is_blocked == 0 ? "No" : "Yes" }}</td>

                                                <td>
                                                    <a href="{{ route('admin.lawyer.view.details', $val->id) }}"
                                                        class="btn btn-sm bg-success-light me-2"> <i
                                                            class="far fa-eye me-1"></i> View Documents</a>
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
