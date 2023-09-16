@extends('front-layouts.master-layout')
@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-title">
                        <h2>Categories</h2>
                    </div>
                </div>
                <div class="col-auto float-end ms-auto breadcrumb-menu">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Categories</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <div class="content">
        <div class="container">
            <div class="catsec clearfix">
                <div class="row">
                    @foreach ($categories as $category)
                        <div class="col-lg-4 col-md-6">
                            {{-- <a href="{{route('lawyers.with.category', ['category'=>'all'])}}"> --}}
                            <a href="{{ route('lawyers.services', $category->id) }}">
                                <div class="cate-widget">
                                    <img src="{{ asset('front') }}/assets/img/category/Category1.jpg" alt="">
                                    <div class="cate-title category">
                                        <h3>{{ $category->title ?? '' }}</h3>
                                        <p>{{ $category->description ?? 'There is no description Provided about this category.' }}
                                        </p>
                                    </div>
                                    <div class="cate-count">
                                        <p class="mb-0">View Lawyers</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">
                    {{ $categories->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
