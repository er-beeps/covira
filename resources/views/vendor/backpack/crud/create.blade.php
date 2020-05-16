@extends(backpack_view('layouts.top_left'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.add') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
	<section class="container-fluid">
	  <h2>
		@if(backpack_user())
			@if ($crud->hasAccess('list'))
			<small><a href="{{ url($crud->route) }}" class="hidden-print back-btn"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }}</a></small>
			@endif
		@else
			<small><a href="{{ url('/') }}" class="hidden-print back-btn"><i class="fa fa-angle-double-left"></i> {{ trans('Back to dashboard') }}</a></small>
		@endif	
		<br>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        {{-- <small>{!! $crud->getSubheading() ?? trans('backpack::crud.add').' '.$crud->entity_name !!}.</small> --}}

      
	  </h2>
	</section>
@endsection

@section('content')

<div class="row">
	<div class="{{ $crud->getCreateContentClass() }}">
		<!-- Default box -->
		@include('crud::inc.grouped_errors')

		@if(backpack_user())
		  <form method="post" action="{{ url($crud->route) }}"
				@if ($crud->hasUploadFields('create')) enctype="multipart/form-data"
				@endif>
		@else
		  <form method="post" action="{{ url('/response/store') }}"
				@if ($crud->hasUploadFields('create')) enctype="multipart/form-data"
				@endif>
		@endif
			  {!! csrf_field() !!}

		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
		      @else
		      	@include('crud::form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
		      @endif
				@if(backpack_user())
				  	@include('crud::inc.form_save_buttons')
				@else
					@include('crud::inc.custom_form_save_button')
				@endif
		  </form>
	</div>
</div>

@endsection

<style>
	.back-btn{
		background-color:grey; 
		color:white;
		border-radius: 4px;
		line-height: 50px;
		padding:1px 7px 1px 2px;
		transition: transform .2s;
		}

	.back-btn:hover{
		background-color:grey; 
		color:white;
		font-weight: bold;
		text-decoration-line: none;
	}
</style>
