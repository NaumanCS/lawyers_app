@extends('layouts.mainlayout')
@section('content')
<!-- TinyMCE library -->
<script src="https://cdn.tiny.cloud/1/your-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: 'textarea[name="city"]',
        plugins: 'autolink lists link image charmap print preview hr anchor',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image | link',
        height: 200,
        menubar: false,
    });
</script>

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
                                <h3 class="page-title">Add Setting</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <div class="card">
                        <div class="card-body">

                            <!-- Form -->
                            <form class="" action="{{ route('admin.setting.store', $update_id) }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>About us</label>
                                    <textarea name="about_us" class="form-control" required placeholder="Type something"><?= isset($obj->about_us) && !empty($obj->about_us) ? $obj->about_us : '' ?>{{ $obj->about_us ?? '' }}</textarea>

                                </div>
                                <div class="form-group">
                                    <label>Term and Condition</label>
                                    <textarea name="term_and_condition" class="form-control" required placeholder="Type something"><?= isset($obj->term_and_condition) && !empty($obj->term_and_condition) ? $obj->term_and_condition : '' ?>{{ $obj->term_and_condition ?? '' }}</textarea>

                                </div>
                                <div class="form-group">
                                    <label>Privacy and Policy</label>
                                    <textarea name="privacy_and_policy" class="form-control" required placeholder="Type something"><?= isset($obj->privacy_and_policy) && !empty($obj->privacy_and_policy) ? $obj->privacy_and_policy : '' ?> {{ $obj->privacy_and_policy ?? '' }}</textarea>

                                </div>
                               
                                
                                <div class="mt-4">
                                    <button class="btn btn-primary" type="submit">Add Setting</button>
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
@endsection
