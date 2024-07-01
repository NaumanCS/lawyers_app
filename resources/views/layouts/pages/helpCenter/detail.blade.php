@extends('layouts.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">




            <div class="row">
                <div class="col-md-12 d-flex">

                    <!-- Payments -->
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title">Help Center</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-center">
                                    <thead>
                                        <tr>
                                            <th>Nav Logo</th>
                                            <th>Footer logo</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>
                                                <img class="rounded service-img me-1" src="<?= $generalSetting->navLogo ?>"
                                                    alt="nav logo">
                                            </td>
                                            <td>
                                                <img class="rounded service-img me-1"
                                                    src="<?= $generalSetting->footerLogo ?>" alt="Footer logo">
                                            </td>
                                            <td>{{ $generalSetting->title }}</td>
                                            <td>{{ $generalSetting->description }}</td>

                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Payments -->
                </div>
            </div>
        </div>
    </div>
@endsection
