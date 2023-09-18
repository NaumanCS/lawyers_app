<!-- Bootstrap Core JS -->
<script src="{{ asset('admin') }}/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('admin') }}/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

{{-- Light box cdns starts here --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"
    integrity="sha512-Ixzuzfxv1EqafeQlTCufWfaC6ful6WFqIz4G+dWvK0beHw0NVJwvCKSgafpy5gwNqKmgUfIBraVwkKI+Cz0SEQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- Light box cdns ends here --}}

<!-- Custom JS -->
<script src="{{ asset('admin') }}/assets/js/admin.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.28/dist/sweetalert2.all.min.js"></script>

@yield('injected-scripts')

<script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
<script>
    $(document).ready(function() {
        $('form').parsley();
        $('.dropify').dropify();
    });
</script>
