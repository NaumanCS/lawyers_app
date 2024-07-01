<!-- jQuery -->
<script data-cfasync="false" src="{{ asset('front') }}/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js">
</script>
{{-- <script src="{{ asset('front') }}/assets/js/jquery-3.6.0.min.js"></script> --}}

<!-- Bootstrap Core JS -->
<script src="{{ asset('front') }}/assets/js/popper.min.js"></script>
<script src="{{ asset('front') }}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- Owl JS -->
<script src="{{ asset('front') }}/assets/plugins/owlcarousel/owl.carousel.min.js"></script>

<!-- Aos -->
<script src="{{ asset('front') }}/assets/plugins/aos/aos.js"></script>

<!-- Custom JS -->
<script src="{{ asset('front') }}/assets/js/script.js"></script>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>

<script src="{{ asset('front') }}/assets/plugins/dist/js/bs-dropzone.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
    integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.jqueryui.min.js"
   ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.dataTables.min.js"
    ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
    // $(document).ready(function() {
    //     $('#dataTableId').DataTable({
    //         paging: true,
    //         searching: true,
    //         ordering: true,
    //     });
    // });
    $('#dataTableId').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
        "order": [
            [0, "desc"]
        ]
    });
</script>
<script>
    $(document).ready(function() {
        $('.dropify').dropify({
            messages: {
                default: 'Upload',
                replace: 'Drag and drop or click to replace',
                remove: 'Remove',
                error: 'Error while uploading file',
            },
            error: {
                fileSize: 'The file size is too big.',
                fileExtension: 'The selected file format is not allowed.',
            },
        });

        $('.dropify-message .default').css('font-size', '10px');
    });
</script>

<script>
    @if (session('message'))
        toastr.success('{{ session('message') }}');
    @endif
</script>
<script>
    @if (session('alert'))
        toastr.alert('{{ session('alert') }}');
    @endif
</script>
<script>
    @if (session('error'))
        toastr.error('{{ session('error') }}');
    @endif
</script>

@yield('injected-scripts')
