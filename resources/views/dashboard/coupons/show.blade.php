@extends('layouts.simple.master')

@section('title', trans('lang.coupons'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.coupons') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.coupons') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        
                        <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate="" action="{{ route('coupons.store') }}">
                            @csrf

                            <div class="row g-3">

                                {{-- code --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="code">{{ trans('lang.code') }}</label>
                                    <input disabled="true" name="code" class="form-control @error('code') is-invalid @enderror"
                                        id="code" type="text"  value={{ $coupon->code }} required>
                                    @error('code')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- min_buy --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="min_buy">{{ trans('lang.min_buy') }}</label>
                                    <input disabled="true" name="min_buy" class="form-control @error('min_buy') is-invalid @enderror"
                                        id="min_buy" type="number"  value={{ $coupon->min_buy }} required>
                                    @error('min_buy')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- discount_type --}}
                                <div class="col-md-6  my-3">
                                    <div class="col-form-label">{{ __('lang.discount_type') }}</div>
                                    <select disabled="true" id="select_discount_type" name="discount_type"
                                        class="js-example-basic-single col-sm-12">
                                        <option {{ $coupon->discount_type == 0 ? 'selected' : '' }} value=0>Flat</option>
                                        <option {{ $coupon->discount_type == 1 ? 'selected' : '' }} value=1>Percent</option>
                                    </select>
                                </div>
                                {{-- discount --}}
                                <div class="col-md-6  my-3">
                                    <label class="form-label" for="discount">@lang('lang.discount')</label>
                                    <input disabled="true" type="number" name="discount" step="0.01" value={{ $coupon->discount }}
                                        class="form-control  @error('discount') is-invalid @enderror">
                                    @error('discount')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- start_date --}}
                                <div class="col-md-6  my-3">
                                    <label class="form-label" for="start_date">@lang('lang.start_date')</label>
                                    <input disabled="true" type="date" name="start_date"
                                        class="form-control value={{ $coupon->start_date }}  @error('end_date') is-invalid @enderror">
                                    @error('start_date')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- end_date --}}
                                <div class="col-md-6 ">
                                    <label class="form-label  col-3" for="end_date">@lang('lang.end_date')</label>
                                    <input disabled="true" type="date" name="end_date" value={{ $coupon->end_date }}
                                        class="form-control @error('end_date') is-invalid @enderror">
                                    @error('end_date')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                
                            </div>
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