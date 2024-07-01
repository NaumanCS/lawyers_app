@extends('layouts.mainlayout')
@section('content')
   <!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/dist/toastr.min.css">
<!-- Toastr JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/dist/toastr.min.js"></script>
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        // ... other options
    };
</script>

    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Setting</h3>
                    </div>
                    <div class="col-auto text-end">
                        <a href="{{ route('admin.setting.form', $update_id = 0) }}"
                            class="btn btn-primary add-button ms-3">
                            <i class="fas fa-plus"></i>
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
                                    <label>Category</label>
                                    <select class="form-control select">
                                        <option>Select category</option>
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

                                            <th>Id</th>
                                            <th>About us</th>
                                            <th>Term and Condition</th>
                                            <th>Privacy and Policy</th>

                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($obj as $key => $val)
                                            <tr>
                                                <td>{{ $val->id }}</td>
                                                <td>{{ Illuminate\Support\Str::limit($val->about_us, 30) }}</td>
                                                <td>{{ Illuminate\Support\Str::limit($val->term_and_condition, 30) }}</td>
                                                <td>{{ Illuminate\Support\Str::limit($val->privacy_and_policy, 30) }}</td>
                                                
                                                <td class="text-end">
                                                    <a href="{{ route('admin.setting.form', $val->id) }}"
                                                        class="btn btn-sm bg-success-light"> <i
                                                            class="far fa-edit me-1"></i> Edit</a>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.setting.details', $val->id) }}"
                                                        class="btn btn-sm bg-success-light"> <i class="far fa-eye me-1"></i>
                                                        View</a>
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm bg-success-light delete-location"
                                                        data-url="{{ route('admin.setting.delete', $val->id) }}">
                                                        <i class="far fa-bin me-1"></i> Delete
                                                    </a>
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

    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
       document.querySelectorAll('.delete-location').forEach(function (button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                var deleteUrl = button.getAttribute('data-url');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send an AJAX request to delete the location
                        fetch(deleteUrl, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Success', data.message, 'success');
                                    location.reload();
                                } else {
                                    // Show SweetAlert2 error notification
                                    Swal.fire('Error', data.message, 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                // Show Toastr error notification in case of an error
                                Toastr.error('An error occurred while deleting the location.');
                            });
                    }
                });
            });
        });
    </script>
@endsection
