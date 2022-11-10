@extends('layouts.simple.master')
@section('title', trans('lang.centers'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.centers') }}</h3>
@endsection
@section('style')
<link rel=”stylesheet” href=”//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css”>
<link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css”>

<style>
    body {
        display: flex;
        flex-direction: column;
        margin-top: 1%;
        justify-content: center;
        align-items: center;
    }

    #rowAdder {
        margin-left: 17px;
    }
</style>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{route('home')}}">{{trans('lang.dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('centers.index')}}">{{trans('lang.centers')}}</a></li>
    <li class="breadcrumb-item">{{trans('lang.add')}}</li>
@endsection

@section('content')
<div class="container-fluid">

    <div class="container-fluid">

        <form class="needs-validation" novalidate="" method="post" enctype="multipart/form-data" action="{{route('centers.store')}}" >
            @csrf
            <div class="row ">

                <div class="col-lg-12 col-md-12">
                    {{-- center information --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6 class="card-titel">{{ __('lang.centers') }}</h6>
                        </div>
                        <div class="card-body row">
                            {{-- name_ar  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3 " for="name_ar">{{ trans('lang.name_ar') }}</label>
                                <input name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror"
                                       id="name_ar" type="text" required>
                                @error('name.ar')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- name_en  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="name_en">{{ trans('lang.name_en') }}</label>
                                <input name="name[en]" class="form-control @error('name.en') is-invalid @enderror"
                                       id="name_en" type="text" required>
                                @error('name.en')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- username  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3 " for="user_name">{{ trans('lang.user_name') }}</label>
                                <input name="user_name" class="form-control @error('user_name') is-invalid @enderror"
                                       id="user_name" type="text" required>
                                @error('user_name')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- email --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3 " for="email">{{ trans('lang.email') }}</label>
                                <input name="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" type="email" required>
                                @error('email')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- password  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3 " for="password">{{ trans('lang.password') }}</label>
                                <input name="password" class="form-control @error('password') is-invalid @enderror"
                                       id="name_ar" type="password" required>
                                @error('password')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>

{{--                            address_ar--}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="address_ar">{{ trans('lang.address_ar') }}</label>
                                <textarea name="address[ar]" class="form-control @error('address.ar') is-invalid @enderror"></textarea>
                                @error('address.ar')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>

{{--                            address_en--}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="address_ar">{{ trans('lang.address_en') }}</label>
                                <textarea name="address[en]" class="form-control @error('address.en') is-invalid @enderror"></textarea>
                                @error('address.en')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>

{{--                            description ar--}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="address_ar">{{ trans('lang.description_ar') }}</label>
                                <textarea name="description[ar]" class="form-control @error('description.ar') is-invalid @enderror"></textarea>
                                @error('description.ar')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>

{{--                            description_en--}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="address_ar">{{ trans('lang.description_en') }}</label>
                                <textarea name="description[en]" class="form-control @error('description.en') is-invalid @enderror"></textarea>
                                @error('description.en')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
{{--                            date_of_birth--}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="col-form-label col-3">{{__('lang.date_of_birth')}}</label>
                                <div class="input-group">
                                    <input name="date_of_birth" class="datepicker-here form-control digits @error('date_of_birth') is-invalid @enderror" type="text"
                                        >
                                </div>
                                @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- phones  --}}
                            {{-- <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3 " for="phone">{{ trans('lang.phone') }}</label>
                                <input name="phone[]" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" type="text" required>
                                @error('phone')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="field_wrapper col-md-12 d-flex my-3">
                                <label class="form-label col-3 " for="phone">{{ trans('lang.phone') }}</label>
                                {{-- <div class="field_wrapper"> --}}
                                    <div>
                                        <input type="text" class="form-control  @error('phone') is-invalid @enderror" name="phone[]" value="" placeholder="primary phone"/>
                                        @error('phone')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                        <a href="javascript:void(0);" class="add_button" title="Add field"><img src="http://demos.codexworld.com/add-remove-input-fields-dynamically-using-jquery/images/add-icon.png"/></a>
                                    </div>
                                {{-- </div> --}}

                            </div>

                            {{-- <div class="">
                                <div class="col-md-12 d-flex my-3">
                                    <div id="row">
                                        <label class="form-label col-3 " for="phone">{{ trans('lang.phone') }}</label>
                                        <div class="input-group m-3">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-danger"
                                                    id="DeleteRow" type="button">
                                                    <i class="bi bi-trash"></i>
                                                    Delete
                                                </button>
                                            </div>
                                            <input type="text" name="phone[]"
                                                class="form-control m-input">
                                        </div>
                                    </div>

                                    <div id="newinput"></div>
                                    <button id="rowAdder" type="button"
                                        class="btn btn-dark">
                                        <span class="bi bi-plus-square-dotted">
                                        </span> ADD
                                    </button>
                                </div>
                            </div> --}}


                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-12 col-sm-12">
                    {{-- locations --}}
                    <div class="card col-lg-12 col-md-12">
                            <div class="card-header py-4">
                                <h6 class="mb-0 h6">@lang('lang.Locations')</h6>
                            </div>
                            <div class="card-body row">
                                <div class="col-md-6 mb-3">
                                    <div class="col-form-label">{{trans("lang.Choose_Country")}}</div>
                                    <select  id="country" class="form-select form-control mb-3 @error('parent_id') is-invalid @enderror" >
                                        <option selected value="">{{trans('lang.choose_country')}}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{$country->id}}">{{$country->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="col-form-label">{{trans("lang.Governorate")}}</div>
                                    <select class="form-select form-control mb-3" id="governorate"></select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="col-form-label">{{trans("lang.City")}}</div>
                                    <select name="location_id" class="form-select form-control mb-3 @error('location_id') is-invalid @enderror" id="city"></select>
                                    @error('location_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    {{-- center lat and lng and google map url --}}
                    <div class="col-lg-12 col-md-12">

                        {{-- center information --}}
                        <div class="card  col-md-12">
                            <div class="card-header py-4">
                                <h6 class="card-titel">{{ __('lang.cordinates') }}</h6>
                            </div>
                            <div class="card-body row">
                                {{-- name_ar  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <label class="form-label col-3 " for="lat">{{ trans('lang.lat') }}</label>
                                    <input name="lat" class="form-control @error('lat') is-invalid @enderror" id="validationCustom01" type="text" placeholder="{{trans("lang.lat")}}" required="">
                                    @error('lat')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- name_en  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <label class="form-label col-3" for="lng">{{ trans('lang.lng') }}</label>
                                    <input name="lng" class="form-control @error('lng') is-invalid @enderror" id="validationCustom01" type="text" placeholder="{{trans("lang.lng")}}" required="">
                                    @error('lng')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- name_en  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <label class="form-label col-3" for="google_map_url">{{ trans('lang.google_map_url') }}</label>
                                    <input name="google_map_url" class="form-control @error('google_map_url') is-invalid @enderror" id="validationCustom01" type="text" placeholder="{{trans("lang.google_map_url")}}" required="">
                                    @error('google_map_url')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- center_images --}}
                    <div class="row">
                        <div class="card  col-md-8">
                            <div class="card-header py-4">
                                <h6>{{ __('lang.center_image') }}</h6>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12  d-flex">
                                    <div class="col-md-12">
                                        <label class="form-label" for="image">{{ trans('lang.image') }}</label>
                                        <input name="images[]" class="form-control image @error('image') is-invalid @enderror"
                                               id="image" type="file" multiple>
                                        @error('image')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <img src="{{ asset('/uploads/device/default.png') }}" style="width: 500px" class="img-thumbnail image-preview " alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-4'>

                            {{-- activation and autoservice --}}
                            <div class="card col-12">
                                <div class="card-header py-4">
                                    <h6>{{ __('lang.activation_and_autoservice') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12 row">
                                        <div class="mb-3">
                                            <div class="media mb-2">
                                                <label class="col-form-label m-r-10">{{trans('lang.is_active')}}</label>
                                                <div class="media-body  icon-state">
                                                    <label class="switch">
                                                        <input type="checkbox" name="is_active" value="1" checked=""><span class="switch-state"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="media mb-2">
                                                <label class="col-form-label m-r-10">{{trans('lang.is_support_auto_service')}}</label>
                                                <div class="media-body  icon-state">
                                                    <label class="switch">
                                                        <input type="checkbox" name="is_support_auto_service" value="1" checked=""><span class="switch-state"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
</div>
@endsection


<script type="text/javascript">

    $("#rowAdder").click(function () {
        newRowAdd =
        '<div id="row"> <div class="input-group m-3">' +
        '<div class="input-group-prepend">' +
        '<button class="btn btn-danger" id="DeleteRow" type="button">' +
        '<i class="bi bi-trash"></i> Delete</button> </div>' +
        '<input type="text" class="form-control m-input"> </div> </div>';

        $('#newinput').append(newRowAdd);
    });

    $("body").on("click", "#DeleteRow", function () {
        $(this).parents("#row").remove();
    })
</script>

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src=”//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js”></script>


<script type="text/javascript">
    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><input type="text" class="form-control" name="phone[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="http://demos.codexworld.com/add-remove-input-fields-dynamically-using-jquery/images/remove-icon.png"/></a></div>'; //New input field html
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#country').on('change', function () {
            var countryId = this.value;
            $('#governorate').html('');
            $.ajax({
                url: '{{ route('allGovernorates') }}?country_id='+countryId,
                type: 'get',
                success: function (res) {
                    $('#governorate').html('<option value="">Select Governorate</option>');
                    $.each(res, function (key, value) {
                        $('#governorate').append('<option value="' + value
                            .id + '">' + value.title['en'] + '</option>');
                    });
                    $('#city').html('<option value="">Select City</option>');
                }
            });
        });
        $('#governorate').on('change', function () {
                var governorateId = this.value;
                $('#city').html('');
                $.ajax({
                    url: '{{ route('allGovernorates') }}?country_id='+governorateId,
                    type: 'get',
                    success: function (res) {
                        $('#city').html('<option value="">Select City</option>');
                        $.each(res, function (key, value) {
                            $('#city').append('<option value="' + value
                                .id + '">' + value.title['en'] + '</option>');
                        });
                    }
                });
        });
    });
</script>

@endsection
