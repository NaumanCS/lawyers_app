@extends('front-layouts.master-user-layout')
@section('content')
    <style>
        .avatar-upload {
            position: relative;
            max-width: 205px;
            margin: -18px 10px;

            .avatar-edit {
                position: absolute;
                right: 0px;
                z-index: 1;
                top: 0px;

                input {
                    display: none;

                    +label {
                        display: inline-block;
                        width: 34px;
                        height: 34px;
                        margin-bottom: 0;
                        border-radius: 100%;
                        background: #FFFFFF;
                        border: 1px solid transparent;
                        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
                        cursor: pointer;
                        font-weight: normal;
                        transition: all .2s ease-in-out;

                        &:hover {
                            background: #f1f1f1;
                            border-color: #d6d6d6;
                        }

                        &:after {
                            content: "\f040";
                            font-family: 'FontAwesome';
                            color: #757575;
                            position: absolute;
                            top: 10px;
                            left: 0;
                            right: 0;
                            text-align: center;
                            margin: auto;
                        }
                    }
                }
            }

            .avatar-preview {
                width: 160px;
                height: 160px;
                position: relative;
                border-radius: 30%;
                border: 5px solid black;
                box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);

                >div {
                    width: 100%;
                    height: 100%;
                    border-radius: 30%;
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center;
                }
            }
        }

        .avatar-upload {
            position: relative;
            max-width: 200px;
        }

        .avatar-edit {
            position: absolute;
            right: 12px;
            bottom: 12px;
        }

        .avatar-edit label {
            display: inline-block;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: black;
            padding: 0.05rem 0.4rem;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 20px;
            text-align: center;
            line-height: 32px;
        }

        .avatar-preview {
            width: 200px;
            height: 200px;
            position: relative;
            overflow: hidden;
            border-radius: 50%;
        }

        .avatar-preview div {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .fa-pencil {
            margin-top: 7px;
        }
    </style>

    <div class="col-xl-9 col-md-8">
        <div class="tab-content pt-0">
            <div class="tab-pane show active" id="user_profile_settings">
                <form action="{{ route('customer.profile.update', auth()->id()) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="widget">
                        <div class="row">
                            <div class="col-xl-6">
                                <h4 class="widget-title">Profile</h4>
                            </div>
                            <div class="form-group col-xl-6">
                                <div class="media align-items-center mb-3 d-flex">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type="file" id="imageUpload" name="image" accept=".png, .jpg, .jpeg" hidden />
                                            <label for="imageUpload" class="btn btn-primary" class="pencil-lable"><i
                                                    class="fas fa-pencil-alt"></i>
                                            </label>
                                        </div>
                                       
                                        <div class="avatar-preview">
                                            <div id="imagePreview" style="background-image: url({{$customerProfile->customer_image ?? ''}});"></div>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <p class="mb-0">Advocate</p>
                                        <h5 class="mb-0">{!! $customerProfile->name !!}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <h5 class="form-title">Personal Information</h5>
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label">Name</label>
                            <input class="form-control black_input" name="name" type="text" value="{!! $customerProfile->name !!}">
                            @error('name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label">Email</label>
                            <input class="form-control black_input" name="email" type="email" value="{!! $customerProfile->email !!}">
                            @error('email')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label">Mobile Number</label>
                            <input class="form-control black_input no_only" name="phone" type="text"
                                value="{!! $customerProfile->phone !!}" required>
                            @error('phone')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label" for="city">City</label>
                            <input class="form-control black_input" type="text" name="city" value="{!! $customerProfile->city !!}">
                            @error('city')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-12">
                            <button class="btn btn-primary ps-5 pe-5 update_button" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });
    </script>
@endsection
