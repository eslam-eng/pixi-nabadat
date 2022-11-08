@extends('layouts.simple.master')

@section('title', trans('lang.products'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.products') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.products') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">

        <form class="needs-validation" novalidate="" action="{{ route('products.update',$product) }}" method="post">
            @csrf
            @method('put')
            <div class="row ">

                <div class="col-md-8">

                    {{-- product_information --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6 class="card-titel">{{ __('lang.product_information') }}</h6>
                        </div>
                        <div class="card-body row">
                                {{-- name_ar  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <label class="form-label col-3 " for="name_ar">{{ trans('lang.name_ar') }}</label>
                                    <input name="name[ar]" disabled="true" class="form-control @error('name.ar') is-invalid @enderror"
                                        id="name_ar" type="text" value={{ $product->getTranslation('name', 'ar') }} required>
                                </div>
                                {{-- name_en  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <label class="form-label col-3" for="name_en">{{ trans('lang.name_en') }}</label>
                                    <input name="name[en]" disabled="true" class="form-control @error('name.en') is-invalid @enderror"
                                        id="name_en" type="text" value={{ $product->getTranslation('name', 'en') }} required>
                                </div>
                                {{--categories  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <div class="col-form-label col-3">{{ __('lang.categories') }}</div>
                                    <select id="select_category" name="category" class="js-example-basic-single col-sm-12">
                                                {{ $product->category_id }}
                                    </select>
                                </div>
                                {{--  purchase_price  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <label class="form-label col-3" for="purchase_price">@lang('lang.purchase_price')</label>
                                    <input type="number" disabled="true" name="purchase_price" step="0.01"
                                        class="form-control @error('purchase_price') is-invalid @enderror"
                                        value={{ $product->purchase_price }} >
                                </div>
                                {{--  unit_price  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <label class="form-label col-3" for="unit_price">@lang('lang.unit_price')</label>
                                    <input type="number" disabled="true" name="unit_price" step="0.01"
                                        class="form-control @error('unit_price') is-invalid @enderror"
                                        value={{ $product->unit_price }}>
                                </div>
                        </div>
                    </div>
                    
                    {{-- description --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6 class="mb-0 h6">@lang('lang.product_description')</h6>
                        </div>
                        <div class="card-body row">
                                {{-- description_ar --}}
                                <div class="col-md-12  d-flex my-3">
                                    <label class="form-label col-3"
                                        for="description_ar">{{ trans('lang.description_ar') }}</label>
                                    <input name="description[ar]" disabled="true"
                                        class="form-control  @error('description.ar') is-invalid @enderror"
                                        id="description_ar" type="text" value={{ $product->getTranslation('description', 'ar')  }} required>
                                </div>

                                {{-- description_en --}}
                                <div class="col-md-12  d-flex my-3">
                                    <label class="form-label  col-3"
                                        for="description_en">{{ trans('lang.description_en') }}</label>
                                    <input name="description[en]" disabled="true"
                                        class="form-control  @error('description.en') is-invalid @enderror"
                                        id="description_en" type="text" value={{ $product->getTranslation('description', 'en')  }} required>
                                </div>
                        </div>
                    </div>

                    {{-- product_images --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.product_images') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    @if($product->attachments->count())
                                        @foreach($product->attachments as $attachment)
                                            <div class="col-md-3 col-lg-3 col-sm-12">
                                                <div class="img-container">
                                                    <div class="form-group my-3">
                                                        <img src="{{asset($attachment->path.'/'.$attachment->filename)}}" style="width: 150px;height: 150px" class="img-thumbnail image" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- product_discount --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.product_discount') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 row">
                                {{-- discount_type --}}
                                <div class="col-md-12  d-flex my-3">
                                    <div class="col-form-label  col-3">{{ __('lang.discount_type') }}</div>
                                    <select id="select_discount_type" disabled="true" name="discount_type"
                                        class="js-example-basic-single col-sm-12">
                                        <option {{ $product->discount_type == 0 ? 'selected' : '' }} value="0">Flat</option>
                                        <option {{ $product->discount_type == 1 ? 'selected' : '' }} value="1">Percent</option>
                                    </select>
                                </div>
                                {{-- discount --}}
                                <div class="col-md-12 d-flex my-3">
                                    <label class="form-label  col-3" for="discount">@lang('lang.discount')</label>
                                    <input type="number" disabled="true" name="discount" step="0.01"
                                        class="form-control @error('discount') is-invalid @enderror"
                                        value={{ $product->discount }}>
                                </div>
                                {{-- discount_start_date --}}
                                <div class="col-md-12  d-flex my-3">
                                    <label class="form-label  col-3" for="discount_start_date">@lang('lang.discount_start_date')</label>
                                    <input type="date" disabled="true" name="discount_start_date"
                                        class="form-control  @error('discount_start_date') is-invalid @enderror"
                                        value={{ $product->discount_start_date }}>
                                </div>
                                {{-- discount_end_date --}}
                                <div class="col-md-12  d-flex my-3">
                                    <label class="form-label  col-3" for="discount_end_date">@lang('lang.discount_end_date')</label>
                                    <input type="date" disabled="true" name="discount_end_date"
                                        class="form-control @error('discount_end_date') is-invalid @enderror"
                                        value={{ $product->discount_end_date }}>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class='col-md-4'>

                    {{-- tax --}}
                    <div class="card col-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.Vat_TAX') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 row">
                                <label class="form-label  " for="tax">@lang('lang.tax')</label>
                                <div class="col-md-6 ">
                                    <input type="number" disabled="true" name="tax" step="0.01"
                                        class="form-control @error('tax') is-invalid @enderror" value={{ $product->tax }}>
                                </div>

                                <div class="col-md-6">
                                    <select id="tax_type" name="tax_type" class="js-example-basic-single col-sm-12">
                                        <option {{ $product->tax_type == 0 ? 'selected' : '' }} value="0">Flat</option>
                                        <option {{ $product->tax_type == 1 ? 'selected' : '' }} value="1">Percent</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- featured --}}
                    <div class="card col-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.featured') }}</h6>
                        </div>
                        <div class="card-body row">
                            <div class="media mb-2">
                                <label class="col-form-label m-r-10">{{ __('lang.status') }}</label>
                                <div class="media-body  icon-state">
                                    <label class="switch">
                                        <input type="checkbox" disabled="true" name="featured" {{ $product->featured == 1 ? 'checked' : '' }}><span
                                            class="switch-state" ></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- product_points --}}
                    <div class="card col-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.product_points') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 row">
                                <label class="form-label" for="num_points">@lang('lang.num_points')</label>
                                <input type="number" disabled="true" name="num_points" step="0.01"
                                    class="form-control @error('num_points') is-invalid @enderror"
                                    value={{ $product->num_points }}>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </form>

    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')

@endsection
