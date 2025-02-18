@extends('layouts.simple.master')

@section('title', trans('lang.user_packages'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.user_packages') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('user-packages.index') }}">{{ trans('lang.user_packages') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.edit') }}</li>
@endsection
@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- center --}}
                            <div class="col-md-6">
                                <label class="form-label" for="center">{{ trans('lang.center') }}</label>
                                <p class="form-control" id="center">{{ $userPackage->center->user->name }}</p>
                            </div>
                            {{-- user --}}
                            <div class="col-md-6">
                                <label class="form-label" for="user">{{ trans('lang.user') }}</label>
                                <p class="form-control" id="user">{{ $userPackage->user->name }}</p>
                            </div>
                            {{-- num_nabadat --}}
                            <div class="col-md-6">
                                <label class="label-control" for="num_nabadat">{{ trans('lang.num_nabadat') }}</label>
                                <p class="form-control" id="num_nabadat">{{ $userPackage->num_nabadat }}</p>
                            </div>
                            {{-- price --}}
                            <div class="col-md-6">
                                <label class="label-control" for="price">{{ trans('lang.price') }}</label>
                                <p class="form-control" id="price">{{ $userPackage->price }}</p>
                            </div>
                            {{-- discount_percentage --}}
                            <div class="col-md-6">
                                <label class="label-control" for="discount_percentage">{{ trans('lang.discount_percentage') }}</label>
                                <p class="form-control" id="discount_percentage">{{ $userPackage->discount_percentage }}</p>
                            </div>
                            {{-- payment_method --}}
                            <div class="col-md-6">
                                <label class="label-control" for="payment_method">{{ trans('lang.payment_method') }}</label>
                                <p class="form-control" id="payment_method">{{ $userPackage->payment_method }}</p>
                            </div>
                            {{-- payment_status --}}
                            <div class="col-md-6">
                                <label class="label-control" for="payment_status">{{ trans('lang.payment_status') }}</label>
                                <p class="form-control" id="payment_status">{{ $userPackage->payment_status }}</p>
                            </div>
                            {{-- status --}}
                            <div class="col-md-6">
                                <label class="label-control" for="status">{{ trans('lang.status') }}</label>
                                <p class="form-control" id="status">{{ $userPackage->status }}</p>
                            </div>
                            {{-- used --}}
                            <div class="col-md-6">
                                <label class="label-control" for="used">{{ trans('lang.used') }}</label>
                                <p class="form-control" id="used">{{ $userPackage->used }}</p>
                            </div>
                            {{-- remain --}}
                            <div class="col-md-6">
                                <label class="label-control" for="remain">{{ trans('lang.remain') }}</label>
                                <p class="form-control" id="remain">{{ $userPackage->remain }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')
@endsection