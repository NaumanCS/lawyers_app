@extends('front-layouts.master-user-layout')
@section('content')
    <div class="col-xl-9 col-md-8">
        <div class="row">
            <div class="col-lg-4">
                <a href="" class="dash-widget dash-bg-2">
                    <span class="dash-widget-icon">{{ $allOrder ?? '' }}</span>
                    <div class="dash-widget-info">
                        <span>All Orders</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="" class="dash-widget dash-bg-2">
                    <span class="dash-widget-icon">{{ $pendingOrder ?? '' }}</span>
                    <div class="dash-widget-info">
                        <span>Pending Order</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="" class="dash-widget dash-bg-2">
                    <span class="dash-widget-icon">{{ $completedOrders ?? '' }}</span>
                    <div class="dash-widget-info">
                        <span>Completed Order</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
