@extends('layouts.simple.master')
@section('title', trans('lang.countries'))

@section('breadcrumb-title')
<h3>{{ trans('lang.countries') }}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{route('home')}}">{{trans('lang.dashboard')}}</a></li>
<li class="breadcrumb-item">{{trans('lang.countries')}}</li>
@endsection

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<form class="needs-validation datatables_parameters" novalidate="">
						<div class="row g-3">
							<div class="col-md-4">
								<label class="form-label" for="validationCustom02">@lang('lang.slug')</label>
								<input class="form-control" name="slug" id="validationCustom02" type="text" value="">
								<div class="valid-feedback">Looks good!</div>
							</div>
							<div class="col-md-4 mb-3">
								<label class="form-label" for="validationCustom01">@lang('lang.status')</label>
								<select class="form-select" name="is_active" id="validationCustom01">
									<option value="" selected>Choose...</option>
									<option value="1">{{ trans('lang.active') }}</option>
									<option value="0">{{ trans('lang.not_active') }}</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<button class="btn btn-primary search_datatable" type="submit">{{trans('lang.search')}}</button>
							</div>
							<div class="col-md-3">
								<button class="btn btn-danger reset_form_data" type="button">{{trans('lang.rest')}}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="card">
                <div class="card-header">
					<a role="button" class="btn btn-success" href="{{ route('country.create')}}"><i class="fa fa-plus-circle"></i> {{ trans('lang.add_country')}}</a>
				</div>
				<div class="card-body">
					{!! $dataTable->table(['class'=>'table table-data table-striped table-bordered']) !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
{!! $dataTable->scripts() !!}
<script src="{{asset('assets/js/datatable-filter.js')}}"></script>
@endsection
