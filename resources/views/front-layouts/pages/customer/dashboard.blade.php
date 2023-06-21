@extends('front-layouts.master-user-layout')
@section('content')
    <div class="col-xl-9 col-md-8">
        <div class="row">
            <div class="col-lg-4">
                <a href="user-bookings.html" class="dash-widget dash-bg-1">
                    <span class="dash-widget-icon">223</span>
                    <div class="dash-widget-info">
                        <span>Bookings</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="user-reviews.html" class="dash-widget dash-bg-2">
                    <span class="dash-widget-icon">16</span>
                    <div class="dash-widget-info">
                        <span>Reviews</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="notifications.html" class="dash-widget dash-bg-3">
                    <span class="dash-widget-icon">1</span>
                    <div class="dash-widget-info">
                        <span>Notification</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
