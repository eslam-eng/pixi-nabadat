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
                        <form class="needs-validation" novalidate="" enctype="multipart/form-data"
                            action="{{ route('user-packages.update', $userPackage) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="row g-3">
                                {{--center  --}}
                                <div class="col-md-6">
                                    <div class="form-label">{{ __('lang.centers') }}</div>
                                    <select id="center_id" name="center_id" class="js-example-basic-single col-sm-12 @error('center') is-invalid @enderror">
                                        @foreach ($centers as $center)
                                            <option value="{{ $center->id }}" {{ $userPackage->center->id == $center->id ? "selected":"" }}>{{ $center->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('center_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{--user  --}}
                                <div class="col-md-6">
                                    <div class="form-label">{{ __('lang.users') }}</div>
                                    <select id="user_id" name="user_id" class="js-example-basic-single col-sm-12 @error('user_id') is-invalid @enderror">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"  {{ $userPackage->user->id == $user->id ? "selected":"" }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                {{--  num_nabadat  --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="num_nabadat">@lang('lang.num_nabadat')</label>
                                    <input type="number" name="num_nabadat" step="1"
                                        value="{{ $userPackage->num_nabadat }}" class="form-control @error('num_nabadat') is-invalid @enderror">
                                    @error('num_nabadat')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{--  price  --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="price">@lang('lang.price')</label>
                                    <input type="number" name="price" step="0.01"
                                        value="{{ $userPackage->price }}" class="form-control @error('price') is-invalid @enderror">
                                    @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{--  discount percentage  --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="discount_percentage">@lang('lang.discount_percentage')</label>
                                    <input type="number" name="discount_percentage" step="0.01"
                                        value="{{ $userPackage->discount_percentage }}" class="form-control @error('discount_percentage') is-invalid @enderror">
                                    @error('discount_percentage')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{--payment_method  --}}
                                <div class="col-md-6">
                                    <div class="form-label">{{ __('lang.payment_method') }}</div>
                                    <select id="payment_method" name="payment_method" class="js-example-basic-single col-sm-12 @error('payment_method') is-invalid @enderror">
                                        <option value="{{ App\Enum\PaymentMethodEnum::CASH }}" {{ $userPackage->payment_method == App\Enum\PaymentMethodEnum::CASH ? "selected":"" }}>{{ App\Enum\PaymentMethodEnum::CASH }}</option>
                                        <option value="{{ App\Enum\PaymentMethodEnum::CREDIT }}" {{ $userPackage->payment_method == App\Enum\PaymentMethodEnum::CREDIT ? "selected":"" }}>{{ App\Enum\PaymentMethodEnum::CREDIT }}</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{--payment_status  --}}
                                <div class="col-md-12">
                                    <div class="form-label">{{ __('lang.payment_status') }}</div>
                                    <select id="payment_status" name="payment_status" class="js-example-basic-single col-sm-12 @error('payment_status') is-invalid @enderror">
                                        <option selected>...</option>
                                        <option value="{{ App\Enum\PaymentStatusEnum::PAID }}" {{ $userPackage->payment_status == App\Enum\PaymentStatusEnum::PAID ? "selected":"" }}>{{ App\Enum\PaymentStatusEnum::PAID }}</option>
                                        <option value="{{ App\Enum\PaymentStatusEnum::UNPAID }}" {{ $userPackage->payment_status == App\Enum\PaymentStatusEnum::UNPAID ? "selected":"" }}>{{ App\Enum\PaymentStatusEnum::UNPAID }}</option>
                                    </select>
                                    @error('payment_status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            
                            <button class="btn btn-primary my-3" type="submit">{{ trans('lang.submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')
@endsection