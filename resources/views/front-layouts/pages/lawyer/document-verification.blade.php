<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Lawyer Verification</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('front') }}/assets/img/favicon.png">

    <link href="../css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('front') }}/assets/plugins/bootstrap/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('front') }}/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ asset('front') }}/assets/plugins/fontawesome/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('front') }}/assets/css/style.css">

    <link rel="stylesheet" href="{{ asset('front') }}/assets/plugins/dist/css/bs-dropzone.css" />
    <style>
        .dropify-wrapper {
            height: 180px !important;
            border: none;
            box-shadow: 0 0 20px 2px rgba(0, 0, 0, 0.3);
            color: black !important;
        }
        .dropify-wrapper:hover{
            box-shadow: 0 2px 5px 2px rgba(0, 0, 0, 0.3);
        }

        .preview-image {
            display: inline-block;
            width: 100px;
            height: 100px;
            margin-right: 10px;
        }

        .dropify-wrapper .dropify-message span.file-icon {
            font-size: 30px !important;
        }
        .dropify-infos-message {
            font-size: 15px !important;
        }
        .dropify-wrapper .dropify-clear {
            display: block;
            color: black !important;
        }
        .dropify-wrapper .dropify-error {
            display: block;
            color: black !important;
        }
        .dropify-wrapper .dropify-replace {
            display: block;
            color: black !important;
        }
        .bs-dropzone{
            box-shadow: 0 0 20px 2px rgba(0, 0, 0, 0.3);
            transition: box-shadow 0.3s ease-in-out;
        }
        .bs-dropzone:hover{
            box-shadow: 0 2px 5px 2px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
<div class="main-wrapper">
        <!-- Header -->
        <header class="header">
            <nav class="navbar navbar-expand-lg header-nav">
                <h3 class="text-light">Account Verification</h3>
                <ul class="nav header-navbar-rht ms-auto">
                    <!-- User Menu -->
                    <li class="nav-item dropdown has-arrow logged-item">
                        <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="user-img">
                                <img class="rounded-circle"
                                    src="{{ asset('front') }}/assets/img/provider/provider-01.jpg" alt=""
                                    width="31">
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <!-- /User Menu -->

                </ul>

            </nav>
        </header>
        <!-- /Header -->

        <div class="content">
            <div class="container m-0">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        @if ($user->document_status == 'depreciated')
                        <div class="section-header text-center">
                            <h2>Depreciated</h2>
                            <p>It is informed to you that some of your documents are not approved.</p>
                            <span class="text-danger">Reason</span>
                            <p>{{ $user->reason ?? '' }}</p>
                            <div class="mt-3">
                                <a href="{{ route('lawyer.document.verification.update') }}">
                                <button class="btn btn-primary">Update</button>
                            </a>
                            </div>
                        </div>
                        @else
                        <div class="section-header text-center">
                            <h2>Thank You for Registration</h2>
                            <p>We will shortly verify your profile, and you can provide services.</p>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script data-cfasync="false" src="../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="{{ asset('front') }}/assets/js/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('front') }}/assets/js/popper.min.js"></script>
    <script src="{{ asset('front') }}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('front') }}/assets/js/script.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>

    <script src="{{ asset('front') }}/assets/plugins/dist/js/bs-dropzone.js"></script>
    <script>
        $("#demo-4").bs_dropzone({
            preview: true,
            accepted: ["jpg", "jpeg", "png", 'bmp', 'webp', 'jfif'],
            dropzoneTemplate: '<div class="bs-dropzone"><div class="bs-dropzone-area"></div><div class="bs-dropzone-message"></div><div class="bs-dropzone-preview mt-0"></div></div>',
            parentTemplate: '<div class="row ml-0 justify-content-center align-items-center"></div>',
            childTemplate: '<div class="col-4 col-md-3 pl-0"></div>',
            imageClass: "img-fluid mt-3 rounded",
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify({
                messages: {
                    default: 'Upload Document',
                    replace: 'Drag and drop or click to replace',
                    remove: 'Remove',
                    error: 'Error while uploading file',
                },
                error: {
                    fileSize: 'The file size is too big.',
                    fileExtension: 'The selected file format is not allowed.',
                },
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.images-dropify').dropify({
                messages: {
                    default: 'Upload Documents',
                    replace: 'Drag and drop or click to replace',
                    remove: 'Remove',
                    error: 'Error while uploading file',
                },
                error: {
                    fileSize: 'The file size is too big.',
                    fileExtension: 'The selected file format is not allowed.',
                },
            });

            $('.images-dropify').on('change', function() {
                var files = $(this).get(0).files;
                var imagesContainer = $(this).siblings('.dropify-wrapper').find(
                    '.dropify-preview');

                imagesContainer.empty();
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    var reader = new FileReader();

                    reader.onload = (function(file) {
                        return function(e) {
                            var img = $('<img>').addClass('preview-image').attr('src', e.target
                                .result);
                            imagesContainer.append(img);
                        };
                    })(file);

                    reader.readAsDataURL(file);
                }
            });
        });
    </script>


</body>

</html>
