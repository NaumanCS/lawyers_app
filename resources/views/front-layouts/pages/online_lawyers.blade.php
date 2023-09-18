@extends('front-layouts.master-layout')
@section('content')
    <!-- Breadcrumb -->
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-title">
                        <h2>Find a Professional</h2>
                    </div>
                </div>
                <div class="col-auto float-end ms-auto breadcrumb-menu">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Find a Professional</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 theiaStickySidebar h-100">
                    <div class="card filter-card" style="border: none !important;">
                        <div class="card-body" style="background: dimgrey; border-radius: 20px;">
                            <h4 class="text-light mb-4">Search Filter</h4>
                            <form action="{{ route('lawyers.services', ['filter' => 0]) }}" method="GET">
                                @csrf
                                <div class="filter-widget">
                                    <div class="filter-list">
                                        <h4 class="filter-title">Sort By</h4>
                                        <select name="price_order" class="form-control selectbox select form-select">
                                            <option value="" selected disabled>Price Range</option>
                                            <option value="asc">Price Low to High</option>
                                            <option value="desc">Price High to Low</option>
                                        </select>
                                    </div>
                                    <div class="filter-list">
                                        <h4 class="filter-title">Categories</h4>
                                        <select name="category_id"
                                            class="form-control form-control selectbox select form-select">
                                            <option value="" selected disabled>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="filter-list">
                                        <h4 class="filter-title">Location</h4>
                                        <select name="location"
                                            class="form-control form-control selectbox select form-select">
                                            <option value="" selected disabled>Available Locations</option>
                                            @foreach ($services->unique('location') as $city)
                                                <option value="{{ $city->location }}">
                                                    {{ $city->location }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary pl-5 pr-5 btn-block get_services w-100"
                                    type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div>
                        <div class="row">
                            @if (!$services->isEmpty())
                            @foreach ($services as $service)
                                <div class="col-lg-4 col-md-6">
                                    <a href="{{ route('lawyers.with.category', $service->user->id) }}">
                                        <div class="cate-widget">
                                            <img src="{{ asset('front') }}/assets/img/customer/lawyer-01.png"
                                                alt="">
                                            <div class="cate-title online">
                                                <div class="w-100">
                                                    <h3 class="text-center mb-2">{{ $service->title ?? '' }}</h3>
                                                    <div class="w-100 px-3 bg-white d-flex justify-content-between">
                                                        <p class="mb-0" style="color: black !important;">Category:</p>
                                                        <p class="mb-0" style="color: black !important;">
                                                            {{ $service->category->title ?? '' }}</p>
                                                    </div>
                                                </div>
                                                <div class="lawyerDetails">
                                                    <h6 class="text-light text-center">Advocate</h6>
                                                    <p class="mb-1">{{ $service->user->name ?? '' }}</p>
                                                </div>
                                                <div class="w-100 d-flex justify-content-between">
                                                    <div class="price text-light w-25">
                                                        <span>Rs {{ $service->amount }}</span>
                                                    </div>
                                                    <div class="OnlineLawyersRatings text-end">
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                        <span class="fa fa-star checked"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                            @else
                            <div class="col-md-12">
                                <div class="w-100 d-flex justify-content-center align-items-center" style="height: 70vh">
                                    <h1>No Services Available</h1>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $services->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
