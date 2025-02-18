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

        <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate="" action="{{ route('products.store') }}">
            @csrf

            <div class="row ">

                <div class="col-md-8">

                    {{-- product_information --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6 class="card-titel">{{ __('lang.product_information') }}</h6>
                        </div>
                        <div class="card-body row">
                                {{-- name_ar  --}}
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="name_ar">{{ trans('lang.name_ar') }}</label>
                                    <input name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror"
                                        id="name_ar" type="text" required>
                                    @error('name.ar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- name_en  --}}
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="name_en">{{ trans('lang.name_en') }}</label>
                                    <input name="name[en]" class="form-control @error('name.en') is-invalid @enderror"
                                        id="name_en" type="text" required>
                                    @error('name.en')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{--categories  --}}
                                <div class="col-md-12 mt-3">
                                    <div class="col-form-label">{{ __('lang.categories') }}</div>
                                    <select id="category_id" name="category_id" class="js-example-basic-single col-sm-12">
                                        <option></option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                 {{--type  --}}
                                 <div class="col-md-12 mt-3">
                                    <div class="form-label">{{ __('lang.product_type') }}</div>
                                    <select id="type" name="type" class="js-example-basic-single col-sm-12">
                                        <option value="{{\App\Models\Product::PRODUCTCENTER}}">{{ __('lang.center') }}</option>
                                        <option value="{{\App\Models\Product::PRODUCTUSER}}">{{ __('lang.user') }}</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{--  purchase_price  --}}
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="purchase_price">@lang('lang.purchase_price')</label>
                                    <input type="number" name="purchase_price" step="0.01"
                                        class="form-control @error('purchase_price') is-invalid @enderror">
                                    @error('purchase_price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{--  unit_price  --}}
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="unit_price">@lang('lang.unit_price')</label>
                                    <input type="number" name="unit_price" step="0.01"
                                        class="form-control @error('unit_price') is-invalid @enderror">
                                    @error('unit_price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{--  stock  --}}
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="stock">@lang('lang.stock')</label>
                                    <input type="number" name="stock" step="1"
                                        class="form-control @error('stock') is-invalid @enderror">
                                    @error('stock')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
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
                                <div class="col-md-12 mt-3">
                                    <label class="form-label"
                                        for="description_ar">{{ trans('lang.description_ar') }}</label>
                                    <input name="description[ar]"
                                        class="form-control  @error('description.ar') is-invalid @enderror"
                                        id="description_ar" type="text" required>
                                    @error('description.ar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- description_en --}}
                                <div class="col-md-12 mt-3">
                                    <label class="form-label"
                                        for="description_en">{{ trans('lang.description_en') }}</label>
                                    <input name="description[en]"
                                        class="form-control @error('description.en') is-invalid @enderror"
                                        id="description_en" type="text" required>
                                    @error('description.en')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                        </div>
                    </div>
                    {{-- product_logo --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.product_logo') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 d-flex">
                                <label class="form-label col-3" for="logo">{{ trans('lang.logo') }}</label>
                                    <input name="logo" class="form-control image @error('logo') is-invalid @enderror"
                                        id="logo" type="file">
                                    @error('logo')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                            </div>

                            <div class="form-group mt-3">
                                <img src="{{ asset('/uploads/products/default.png') }}" style="width: 100px" class="image-preview " alt="">
                            </div>
                        </div>
                    </div>
                    {{-- product_images --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.product_images') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 d-flex">
                                <label class="form-label col-3" for="image">{{ trans('lang.image') }}</label>
                                    <input name="images[]" class="form-control image @error('image') is-invalid @enderror"
                                        id="image" type="file" multiple>
                                    @error('image')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                            </div>

                            <div class="form-group mt-3">
                                <img src="{{ asset('/uploads/products/default.png') }}" style="width: 100px" class="image-preview " alt="">
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
                                {{-- discount --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="discount">@lang('lang.discount')</label>
                                    <input type="number" name="discount" value="0" step="0.01"
                                        class="form-control @error('discount') is-invalid @enderror">
                                    @error('discount')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- discount_start_date --}}
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="discount_start_date">@lang('lang.discount_start_date')</label>
                                    <input type="date" name="discount_start_date"
                                        class="form-control  @error('discount_end_date') is-invalid @enderror">
                                    @error('discount_start_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- discount_end_date --}}
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="discount_end_date">@lang('lang.discount_end_date')</label>
                                    <input type="date" name="discount_end_date"
                                        class="form-control @error('discount_end_date') is-invalid @enderror">
                                    @error('discount_end_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class='col-md-4'>

                    {{-- tax --}}
                    <div class="card col-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.vat_tax') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 row">
                                <label class="form-label" for="tax">@lang('lang.tax')</label>
                                <div class="col-md-6 ">
                                    <input type="number" value="0" name="tax" step="0.01"
                                        class="form-control @error('tax') is-invalid @enderror">
                                    @error('tax')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- featured --}}
                    <div class="card col-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.featured_status') }}</h6>
                        </div>
                        <div class="card-body row">
                            <div class="media mb-2">
                                <label class="col-form-label m-r-10">{{ __('lang.featured') }}</label>
                                <div class="media-body  icon-state">
                                    <label class="switch">
                                        <input type="checkbox" name="featured" checked=""><span
                                            class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="media mb-2">
                                <label class="col-form-label m-r-10">{{ __('lang.status') }}</label>
                                <div class="media-body  icon-state">
                                    <label class="switch">
                                        <input type="checkbox" name="is_active" checked=""><span
                                            class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btn-toolbar float-right mb-3" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group" aria-label="Third group">
                        <button class="btn btn-primary my-3" type="submit">{{ trans('lang.submit') }}</button>
                    </div>
                </div>
            </div>

        </form>

    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')

@endsection
