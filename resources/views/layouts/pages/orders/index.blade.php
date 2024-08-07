@extends('layouts.mainlayout')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <style>
        .rejection-modal-content {
            background: url('{{ asset('admin/assets/img/al-wakeel-logo.png') }}') no-repeat center center;
            background-size: contain;
            color: white;
        }

        .rejection-modal-content .modal-header,
        .rejection-modal-content .modal-footer {
            border: none;
            background: rgba(0, 0, 0, 0.5);
            /* Optional: To make the header and footer stand out */
        }

        .rejection-modal-content .modal-body {
            background: rgba(0, 0, 0, 0.5);
            /* Optional: To make the body content stand out */
        }

        .rejection-modal-content .form-control {
            background: rgba(255, 255, 255, 0.8);
            /* Making the textarea background slightly transparent */
            color: black;
            /* Changing text color to black for readability */
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if (session('message'))
            toastr.success('{{ session('message') }}');
        @endif
    </script>
    <script>
        @if (session('error'))
            toastr.error('{{ session('error') }}');
        @endif
    </script>
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">All Orders</h3>
                    </div>
                    <div class="col-auto text-end">
                        <a href="{{ route('admin.order.form', $update_id = 0) }}" class="btn btn-primary add-button ms-3">
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
                                    <label>Order</label>
                                    <select class="form-control select">
                                        <option>Select admin.order</option>
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
                            <div class="table-responsive" style="min-height: 400px;">
                                <table class="table table-hover table-center mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Payment Slip</th>
                                            <th>Lawyer id</th>
                                            <th>Customer id</th>
                                            <th>Amount</th>
                                            <th>Transaction Id</th>
                                            <th>status</th>

                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($obj as $key => $val)
                                            <tr>
                                                <td>
                                                    {{-- <a href="{{ $val->payment_slip ?? '' }}" target="_blank" download>
                                                        <img class="rounded service-img me-1" src="{{ $val->payment_slip }}"
                                                            alt="nav logo">
                                                    </a> --}}
                                                    <a href="{{ $val->payment_slip ?? '' }}" data-lightbox="image-gallery">
                                                        <img class="img-fluid" src="{{ $val->payment_slip ?? '' }}"
                                                            alt="Payment Slip">
                                                    </a>
                                                </td>
                                                <td>{{ $val->lawyer->name ?? '' }}</td>
                                                <td>{{ $val->customer->name ?? '' }}</td>

                                                <td>{{ $val->amount - $val->amount * 0.2 ?? '' }}</td>
                                                <td>
                                                    @if ($val->transaction_id == null)
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#addTransactionId_{{ $val->id }}"
                                                            data-driver-id="{{ $val->id ?? '' }}"
                                                            class="btn btn-sm bg-success-light me-2">
                                                            <i class="far fa-edit" style="color: black;margin:5px">Add</i>
                                                            {{ $val->id ?? '' }}
                                                        </a>
                                                    @else
                                                        {{ $val->transaction_id ?? '' }}
                                                    @endif


                                                </td>

                                                <td>
                                                    <!-- Example single danger button -->
                                                    
                                                    <div class="btn-group" @if ($val->status == 'completed' || $val->status == 'rejected') style="pointer-events: none; opacity: 0.5;" @endif>
                                                        @if ($val->status == 'completed')
                                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                Completed
                                                            </button>
                                                        @elseif ($val->status == 'approved')
                                                            <button type="button" class="btn btn-info dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                Approved
                                                            </button>
                                                        @elseif($val->status == 'rejected')
                                                            <button type="button" class="btn btn-danger dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                Rejected
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-warning dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                Pending
                                                            </button>
                                                        @endif

                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item"
                                                                href="{{ route('admin.order.status', ['status' => 'pending', 'orderId' => $val->id]) }}">Pending</a>
                                                        </li>
                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('admin.order.status', ['status' => 'approved', 'orderId' => $val->id]) }}">Approved</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('admin.order.status', ['status' => 'completed', 'orderId' => $val->id]) }}">Completed</a>
                                                            </li>

                                                            <li><a class="dropdown-item" href="#"
                                                                    data-bs-toggle="modal" data-bs-target="#rejectionModal"
                                                                    data-order-id="{{ $val->id }}">Rejected</a></li>

                                                        </ul>
                                                    </div>
                                                </td>

                                                <td class="text-end">
                                                    <a href="{{ route('admin.order.form', $val->id) }}"
                                                        class="btn btn-sm bg-success-light me-2"> <i
                                                            class="far fa-edit me-1"></i> Edit</a>
                                                    {{-- <a href="{{ route('admin.order.details', $val->id) }}"
                                                        class="btn btn-sm bg-success-light me-2"> <i
                                                            class="far fa-eye me-1"></i> View</a> --}}
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="addTransactionId_{{ $val->id }}"
                                                tabindex="-1" aria-labelledby="exampleModalthreeLabel" aria-hidden="true"
                                                data-driver-id="{{ $val->id ?? '' }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content p-3">
                                                        <div class="modal-header border-0">
                                                            <h1 class="modal-title poppins font-32 fw-bold"
                                                                id="exampleModalthreeLabel">Add Transaction Id
                                                                {{ $val->id ?? '' }}
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form
                                                            action="{{ route('admin.add.transaction.id', $val->id ?? '') }}"
                                                            method="POST">
                                                            @csrf

                                                            <div class="modal-body">
                                                                <div class="row DISPATCH">
                                                                    <div class="col-12">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label poppins fw-semibold">Transaction
                                                                                Id:</label>
                                                                            <input type="text" name="transaction_id"
                                                                                class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="modal-footer d-flex justify-content-between border-0">
                                                                <button type="button" class="btn btn-secondary"
                                                                    style="padding: 6px 30px;"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary"><i
                                                                        class='bx bxs-badge-check'></i>
                                                                    Add</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
    <!-- Rejection Modal -->
    <div class="modal fade" id="rejectionModal" tabindex="-1" aria-labelledby="rejectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rejection-modal-content">
                <form id="rejectionForm" action="{{ route('admin.order.reject') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" id="order_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectionModalLabel">Rejection Reason</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="rejection_reason">Reason</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var rejectionModal = document.getElementById('rejectionModal');
            rejectionModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var orderId = button.getAttribute('data-order-id');
                var modalOrderInput = rejectionModal.querySelector('#order_id');
                modalOrderInput.value = orderId;
            });
        });
    </script>
@endsection
