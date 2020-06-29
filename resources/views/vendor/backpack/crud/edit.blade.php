@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.edit') => false,
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
        {{-- <small>{!! $crud->getSubheading() ?? trans('backpack::crud.edit').' '.$crud->entity_name !!}.</small> --}}

	  </h2>
	</section>
@endsection

@section('content')
<div class="row">
	<div class="{{ $crud->getEditContentClass() }}">
		<!-- Default box -->

		@include('crud::inc.grouped_errors')
		@if(backpack_user())
			@if($crud->getRoute() == 'admin/response') 
				@if(isset($next_btn))

					<form method="post"
						action="{{ backpack_url('response/'.$entry->getKey().'/nextstep') }}"
						@if ($crud->hasUploadFields('update', $entry->getKey()))
						enctype="multipart/form-data"
						@endif
						>
				@endif
			@else
				<form method="post"
					action="{{ url($crud->route.'/'.$entry->getKey()) }}"
					@if ($crud->hasUploadFields('update', $entry->getKey()))
					enctype="multipart/form-data"
					@endif
					>
			@endif
		@else
			@if(isset($next_btn))
				<form method="post"
					action="{{ url('/response/'.$entry->getKey().'/nextstep') }}"
					@if ($crud->hasUploadFields('update', $entry->getKey()))
					enctype="multipart/form-data"
					@endif
					>
			@endif		
		@endif		
			  

		 
		  {!! csrf_field() !!}
		  {!! method_field('PUT') !!}

		  	@if ($crud->model->translationEnabled())
		    <div class="mb-2 text-right">
		    	<!-- Single button -->
				<div class="btn-group">
				  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[$crud->request->input('locale')?$crud->request->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
					  	<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}?locale={{ $key }}">{{ $locale }}</a>
				  	@endforeach
				  </ul>
				</div>
		    </div>
		    @endif
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
		      @else
		      	@include('crud::form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
			  @endif
			 	@if($crud->getRoute() == 'admin/response')
					@if(isset($next_btn) && (isset($current_step_id) && $current_step_id < 4))
					<div class="row">
						@include('crud::buttons.step_buttons')
					</div>
					<div class="row">
						@include('crud::buttons.cancel_button')
					</div>	
					@else
						@include('crud::buttons.cancel_button')
					@endif
				@else
					@include('crud::inc.form_save_buttons')
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
