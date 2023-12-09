@extends('layouts.mainlayout')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify@1.0.4/dist/css/dropify.min.css">

    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-xl-8 offset-xl-2">

                    <?php
                    $update_id = 0;
                    
                    if (isset($obj->id) && !empty($obj->id)) {
                        $update_id = $obj->id;
                    }
                    ?>

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row">
                            <div class="col">
                                <h3 class="page-title">Add Order</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <div class="card">
                        <div class="card-body">

                            <!-- Form -->
                            <form class="" action="{{ route('admin.order.store', $update_id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Lawyer id</label>
                                    <input type="text" name="lawyer_id"
                                        value="<?= isset($obj->lawyer_id) && !empty($obj->lawyer_id) ? $obj->lawyer_id : '' ?>"
                                        class="form-control" required placeholder="Type something" />
                                </div>
                                <div class="form-group">
                                    <label>Customer id</label>
                                    <input type="text" name="customer_id"
                                        value="<?= isset($obj->customer_id) && !empty($obj->customer_id) ? $obj->customer_id : '' ?>"
                                        class="form-control" required placeholder="Type something" />
                                </div>
                                <div class="form-group">
                                    <label>Category id</label>
                                    <input type="text" name="category_id"
                                        value="<?= isset($obj->category_id) && !empty($obj->category_id) ? $obj->category_id : '' ?>"
                                        class="form-control" required placeholder="Type something" />
                                </div>
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="text" name="amount"
                                        value="<?= isset($obj->amount) && !empty($obj->amount) ? $obj->amount : '' ?>"
                                        class="form-control" required placeholder="Type something" />
                                </div>
                                <div class="form-group">
                                    <label>Transaction Id</label>
                                    <input type="text" name="transaction_id"
                                        value="<?= isset($obj->transaction_id) && !empty($obj->transaction_id) ? $obj->transaction_id : '' ?>"
                                        class="form-control" required placeholder="Type something" />
                                </div>
                                <div class="form-group">
                                    <label>Booking Date</label>
                                    <input type="date" name="booking_date"
                                        value="<?= isset($obj->booking_date) && !empty($obj->booking_date) ? $obj->booking_date : '' ?>"
                                        class="form-control" required placeholder="Type something" />
                                </div>
                                <div class="form-group">
                                    <label>Lawyer status</label>
                                    <input type="text" name="lawyer_status"
                                        value="<?= isset($obj->lawyer_status) && !empty($obj->lawyer_status) ? $obj->lawyer_status : '' ?>"
                                        class="form-control" required placeholder="Type something" />
                                </div>
                                <div class="form-group">
                                    <label>Customer status</label>
                                    <input type="text" name="customer_status"
                                        value="<?= isset($obj->customer_status) && !empty($obj->customer_status) ? $obj->customer_status : '' ?>"
                                        class="form-control" required placeholder="Type something" />
                                </div>
                                <div class="form-group">
                                    <label>Lawyer Location</label>
                                    <input type="text" name="lawyer_location"
                                        value="<?= isset($obj->lawyer_location) && !empty($obj->lawyer_location) ? $obj->lawyer_location : '' ?>"
                                        class="form-control" required placeholder="Type something" />
                                </div>
                                <div class="form-group">
                                    <label>Customer Location</label>
                                    <input type="text" name="customer_location"
                                        value="<?= isset($obj->customer_location) && !empty($obj->customer_location) ? $obj->customer_location : '' ?>"
                                        class="form-control" required placeholder="Type something" />
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-primary" type="submit">Add Order</button>
                                    <a href="categories.html" class="btn btn-link">Cancel</a>
                                </div>
                            </form>
                            <!-- Form -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dropify@1.0.4/dist/js/dropify.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>
@endsection
