@extends('front-layouts.master-lawyer-layout')
@section('content')
    <h4 class="widget-title">Dashboard</h4>
    <div class="row">
        <div class="col-lg-4">
            <a href="{{route('lawyer.all.orders')}}" class="dash-widget dash-bg-2">
                <span class="dash-widget-icon">{{$order ?? 0}}</span>
                <div class="dash-widget-info">
                    <span>My Order</span>
                </div>
            </a>
        </div>
        <div class="col-lg-4">
            <a href="{{route('lawyer.service.list')}}" class="dash-widget dash-bg-2">
                <span class="dash-widget-icon">{{$service ?? 0}}</span>
                <div class="dash-widget-info">
                    <span>My Services</span>
                </div>
            </a>
        </div>
        <div class="col-lg-4">
            <a href="{{route('lawyer.wallet')}}" class="dash-widget dash-bg-2">
                <span class="dash-widget-icon">{{$earning ?? 0}}</span>
                <div class="dash-widget-info">
                    <span>My Earnings</span>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
          
                @if ($documentStatus == 'pending')
                <span class="dash-widget dash-bg-2 text-danger ">Your account is under review ,you will be notified on email after approval.</span>
                @endif
                @if ($documentStatus == 'depreciated')
                <span class="dash-widget bg-dark text-danger ">It is informed to you that some of your documents are not approved.Please upload your document again. <span class="text-danger"> <a href="{{ route('lawyer.document.verification.update') }}">upload</a></span></span>
               
                @endif
               
          
        </div>
       
    </div>
@endsection
