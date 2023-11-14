@extends('front-layouts.master-user-layout')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
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

    <div class="col-xl-9 col-md-8">
        <h4 class="widget-title">Pay Now</h4>
        <?php
        $update_id = 0;
        
        if (isset($obj->id) && !empty($obj->id)) {
            $update_id = $obj->id;
        }
        ?>
        <form action="{{ route('order.store', $update_id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

                <div class="col-lg-5">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="{{ asset('front/assets/img/payment/jazzcash.png') }}"
                            alt="Card image cap" style="height: 200px">
                        <div class="card-body">
                            <h5 class="card-title">JazzCash Account</h5>
                            <p class="card-text">Title : Account Title</p>
                            <p class="card-text">Account number : 03087167360</p>
                            <span class="text-warning ">Please upload your payment slip.</span>
                            <br>
                            <label for="slip-upload-jazzcash" class="btn btn-primary">Upload Your Slip</label>
                            <input type="file" name="jazzcash_slip" id="slip-upload-jazzcash" style="display: none;">
                            <div id="file-name-jazzcash"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="{{ asset('front/assets/img/payment/bank.jpg') }}"
                            alt="Card image cap" style="height: 200px">
                        <div class="card-body">
                            <h5 class="card-title">Meezan</h5>
                            <p class="card-text">Title : Account Title</p>
                            <p class="card-text">Account number : 004567654678767</p>
                            <span class="text-warning ">Please upload your payment slip.</span>
                            <br>
                            <label for="slip-upload" class="btn btn-primary">Upload Your Slip</label>
                            <input type="file" name="bank_slip" id="slip-upload" style="display: none;">
                            <div id="file-name-bank"></div>


                        </div>
                    </div>
                </div>
                <div class="col-lg-5 my-3">
                    <span class="text-danger">Note : You can upload this payment slip latter on Orders Table</span>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <!-- Pagination Links -->

            </div>

    </div>
    </form>
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer"> <a href="javascript:;" class="btn btn-success si_accept_confirm">Yes</a>
                    <button type="button" class="btn btn-danger si_accept_cancel" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteNotConfirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="acc_title">Inactive Service?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Service is Booked and Inprogress..</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger si_accept_cancel" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const fileInput = document.getElementById("slip-upload");
        const fileNameDisplay = document.getElementById("file-name-bank");

        const fileInputJazzCash = document.getElementById("slip-upload-jazzcash");
        const fileNameDisplayJazzCash = document.getElementById("file-name-jazzcash");

        fileInput.addEventListener("change", function() {
            if (fileInput.files.length > 0) {
                fileNameDisplay.textContent = "Selected file: " + fileInput.files[0].name;
            } else {
                fileNameDisplay.textContent = "";
            }
        });

        fileInputJazzCash.addEventListener("change", function() {
            if (fileInputJazzCash.files.length > 0) {
                fileNameDisplayJazzCash.textContent = "Selected file: " + fileInputJazzCash.files[0].name;
            } else {
                fileNameDisplayJazzCash.textContent = "";
            }
        });
    </script>
@endsection
