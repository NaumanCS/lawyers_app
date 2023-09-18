@extends('front-layouts.master-layout')
@section('content')
    <style>
        .dropbtn {
            background-color: #04AA6D;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropbtn:hover,
        .dropbtn:focus {
            background-color: #3e8e41;
        }

        #myInput {
            box-sizing: border-box;
            background-image: url('searchicon.png');
            background-position: 14px 12px;
            background-repeat: no-repeat;
            font-size: 16px;
            padding: 14px 20px 12px 45px;
            border: none;
            border-bottom: 1px solid #ddd;
        }

        #myInput:focus {
            outline: 3px solid #ddd;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f6f6f6;
            min-width: 230px;
            overflow: auto;
            border: 1px solid #ddd;
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown a:hover {
            background-color: #ddd;
        }

        .show {
            display: block;
        }
    </style>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="layer">
            <div class="home-banner"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-search aos">
                            <h3>Find Best <span>Lawyers</span></h3>
                            <p>Discuss your problems by meeting and on online sessions</p>
                            <div class="search-box" style="z-index: 9999">
                                <form action="{{ route('search') }}" method="GET">
                                    <div class="search-input line">
                                        <i class="fas fa-tv bficon"></i>
                                        <div class="form-group mb-0">
                                            <select name="select_category" class="form-control mt-2 text-center"
                                                style="border: #f6f6f6">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="search-input">
                                        <i class="fas fa-location-arrow bficon">
                                        </i>
                                        <div class="form-group mb-0">
                                            <select name="select_location" class="form-control mt-2 text-center"
                                                style="border: #f6f6f6">
                                                <option value="">Select Location</option>
                                                @foreach ($cities->unique('city') as $city)
                                                    @if ($city->city != null)
                                                        <option value="{{ $city->city }}">{{ $city->city }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <a class="current-loc-icon current_location" href="javascript:void(0);">
                                                <i class="fas fa-crosshairs"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="search-btn">
                                        <button class="btn search_service" type="submit">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Hero Section -->

    <!-- Category Section -->
    <section class="category-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="heading aos">
                                <h2 class="text-black">Categories</h2>
                                <span>What do you need to find?</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="viewall aos">
                                <h4><a href="{{ route('categories', ['filter' => 'all']) }}">View All <i
                                            class="fas fa-angle-right"></i></a></h4>
                                <span>Featured Categories</span>
                            </div>
                        </div>
                    </div>
                    <div class="catsec">
                        <div class="row">
                            @foreach ($categories as $category)
                                <div class="col-lg-4 col-md-6">
                                    <a href="{{ route('lawyers.services', $category->id) }}">
                                        <div class="cate-widget aos">
                                            <img src="{{ $category->image }}" alt="">
                                            <div class="cate-title">
                                                <h3> {{ $category->title }}</h3>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Category Section -->

    <section class="popular-services">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="heading aos">
                        <h2 class="text-black">Most Popular Services</h2>
                        <span>Explore the greates our services. You won’t be disappointed</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="viewall aos">
                        <h4><a href="{{ route('categories', ['filter' => 'all']) }}">View All <i
                                    class="fas fa-angle-right"></i></a></h4>
                        <span>Most Popular</span>
                    </div>
                </div>
            </div>
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row my-3 justify-content-center">
                            @foreach ($services as $service)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="card cate-widget">
                                        <img src="{{ asset('front') }}/assets/img/services/Services1.jpg"
                                            class="card-img-top" alt="service-img">
                                        <div class="card-body px-1">
                                            <div class="service-content">
                                                <h3 class="title">
                                                    <a href="service-details.html"
                                                        class="text-black">{{ $service->title }}</a>
                                                </h3>
                                                <div class="rating">
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <span class="d-inline-block average-rating">(5)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cities">
        <div class="container">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between">
                    <div class="heading">
                        <h2>Cities</h2>
                        <span>We are here in your own city</span>
                    </div>
                    <div class="viewall-dark"
                        style="display: flex; flex-direction: column; align-items: end; justify-content: center;">
                        <h4><a href="{{ route('categories', ['filter' => 'all']) }}">View All <i
                                    class="fas fa-angle-right"></i></a></h4>
                        <span>Featured Cities</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 pb-4 cities_button">
                    @foreach ($services->unique('location') as $location)
                        @if ($location->location !== null)
                            <a href="#">
                                <button class="btn btn-primary my-2 w-100">
                                    {{ $location->location ?? 'No City Available Yet' }}
                                </button>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-work">
        <div class="container py-3 how-it-work-bg">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading howitworks aos">
                        <h2>How It Works</h2>
                    </div>
                    <div class="howworksec">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="howwork aos">
                                    <div class="iconround">
                                        <div class="steps">01</div>
                                        <img src="{{ asset('front') }}/assets/img/icon-1.png" alt="">
                                    </div>
                                    <h3>Find What you need</h3>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="howwork aos">
                                    <div class="iconround">
                                        <div class="steps">02</div>
                                        <img src="{{ asset('front') }}/assets/img/icon-2.png" alt="">
                                    </div>
                                    <h3>Find an Experienced Lawyer</h3>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="howwork aos">
                                    <div class="iconround">
                                        <div class="steps">03</div>
                                        <img src="{{ asset('front') }}/assets/img/icon-3.png" alt="">
                                    </div>
                                    <h3>Meet and Consult</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /How It Works -->
    <script>
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        function filterFunction() {
            var input, filter, ul, li, a, i;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            div = document.getElementById("myDropdown");
            a = div.getElementsByTagName("a");
            for (i = 0; i < a.length; i++) {
                txtValue = a[i].textContent || a[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    a[i].style.display = "";
                } else {
                    a[i].style.display = "none";
                }
            }
        }
    </script>
@endsection

@section('injected-scripts')
    <script>
        const myModal = document.getElementById('myModal')
        const myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus()
        })
    </script>
@endsection
