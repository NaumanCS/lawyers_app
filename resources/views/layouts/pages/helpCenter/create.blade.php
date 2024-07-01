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
                                <h3 class="page-title">Add Complaint reply</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <div class="card">
                        <div class="card-body">

                            <!-- Form -->
                            <form class="" action="{{ route('admin.help.center.store', $update_id) }}"
                                method="post" >
                                @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" value="<?=(isset($obj->name) && !empty($obj->name) ? $obj->name:'')?>" class="form-control" required placeholder="Type something" readonly/>

                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" value="<?=(isset($obj->phone) && !empty($obj->phone) ? $obj->phone:'')?>" class="form-control" required placeholder="Type something" readonly/>

                                </div>
                                <div class="form-group">
                                    <label>Transaction Id</label>
                                    <input type="text" name="transaction_id" value="<?=(isset($obj->transaction_id) && !empty($obj->transaction_id) ? $obj->transaction_id:'')?>" class="form-control" required placeholder="Type something" readonly/>

                                </div>

                                <div class="form-group">
                                    <label>Complaint</label>
                                    <textarea name="complaint" class="form-control" required placeholder="Type something" readonly>{{ $obj->complaint ?? '' }}</textarea>

                                </div>

                                <div class="form-group">
                                    <label>Reply</label>
                                    <textarea name="reply" class="form-control" required placeholder="Type something"> {{ $obj->reply ?? '' }}</textarea>

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
