<!-- upload multiple input -->
<div @include('crud::inc.field_wrapper_attributes')>
	<label>{!! $field['label'] !!}</label>
	@include('crud::inc.field_translatable_icon')

	{{-- Show the file name and a "Clear" button on EDIT form. --}}
	@if (isset($field['value']) && count($field['value']))
	<div class="well well-sm file-preview-container">
		@foreach($field['value'] as $key => $file_path)

		<?php

		$data = explode('.', $file_path);
		$extension = $data[1];
		//  dd($extension);	 
		?>

		@if($extension == 'pdf')
		<!-- <iframe src="{{  isset($field['disk'])?asset(\Storage::disk($field['disk'])->url($file_path)):asset($file_path)}}" style="width:720px; height:700px;" frameborder="0"></iframe>
 -->
		<div class="file-preview" style="display:inline-flex">
			<a target="_blank" href="{{ isset($field['disk'])?asset(\Storage::disk($field['disk'])->url($file_path)):asset($file_path) }}" title="Click to Preview"> <i class="fa fa-file-pdf-o fa-4x" style="color:red; position:relative; top: -5px"></i></a>
			<a id="{{ $field['name'] }}_{{ $key }}_clear_button" href="#" class="btn btn-default btn-xs pull-right file-clear-button" title="Clear file" data-filename="{{ $file_path }}"><i class="fa fa-remove"></i></a>

		</div>
		@else

		<div class="file-preview" style="display:inline-flex;">
			<img class="image_thumbnail" style="max-height:70px; max-width:70x; border-radius:10px; margin-top:10px;" src="{{ isset($field['disk'])?asset(\Storage::disk($field['disk'])->url($file_path)):asset($file_path) }}" title="Click to Preview" />
			<a id="{{ $field['name'] }}_{{ $key }}_clear_button" href="#" class="btn btn-default btn-xs pull-right file-clear-button" title="Clear file" data-filename="{{ $file_path }}"><i class="fa fa-remove"></i></a>
		</div>
		<div class="modal" id="modal">
			<span class="close">&times;</span>
			<img class="modal-content" id="modal-content">
		</div>
		@endif
		@endforeach


	</div>
	@endif
	{{-- Show the file picker on CREATE form. --}}
	<input name="{{ $field['name'] }}[]" type="hidden" value="">
	<input type="file" id="{{ $field['name'] }}_file_input" name="{{ $field['name'] }}[]" value="@if (old(square_brackets_to_dots($field['name']))) old(square_brackets_to_dots($field['name'])) @elseif (isset($field['default'])) $field['default'] @endif" @include('crud::inc.field_attributes') multiple>
		<div id="{{ $field['name'] }}">
			<ul class="nav nav-pills"></ul>
		</div>
	{{-- HINT --}}
	@if (isset($field['hint']))
	<p class="help-block">{!! $field['hint'] !!}</p>
	@endif
</div>

{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}

@push('crud_fields_scripts')
<!-- no scripts -->
<script>
	$(".file-clear-button").click(function(e) {
		e.preventDefault();
		var container = $(this).parent().parent();
		var parent = $(this).parent();
		// remove the filename and button
		parent.remove();
		// if the file container is empty, remove it
		if ($.trim(container.html()) == '') {
			container.remove();
		}
		$("<input type='hidden' name='clear_{{ $field['name'] }}[]' value='" + $(this).data('filename') + "'>").insertAfter("#{{ $field['name'] }}_file_input");
	});

	$("#{{ $field['name'] }}_file_input").change(function() {

		var fileName = [];
		$('#{{ $field['name'] }} ul').html('');
		for(var i = 0; 	i<$(this).get(0).files.length; i++){
			fileName.push($(this).get(0).files[i].name);
		}

		jQuery.each(fileName,function(i,name){

			$('#{{ $field['name'] }} ul').append('<li class="badge bg-light text-dark">'+name+'</li>');

        });

		// $('.fa-remove').click(function(){
		// 	var fileId = $(this).attr('data-id');
		// 	var parent = $(this).parent();
		// 	fileName.splice(fileName.indexOf(fileName[fileId]), 1);
		// 	parent.remove();
						
		// });


		// remove the hidden input, so that the setXAttribute method is no longer triggered
		$(this).next("input[type=hidden]").remove();
	});

	function showFileName(event) {
		
		
	}
</script>
@endpush

<style>
	.image_thumbnail {
		border-radius: 5px;
		cursor: pointer;
		transition: 0.3s;
	}

	.image_thumbnail:hover {
		opacity: 0.9;
	}

	/* The Modal (background) */
	.modal {
		display: none;
		/* Hidden by default */
		position: fixed;
		/* Stay in place */
		z-index: 1;
		/* Sit on top */
		padding-top: 50px;
		/* Location of the box */
		left: 0;
		top: 0;
		width: 100%;
		/* Full width */
		height: 100%;
		/* Full height */
		overflow: auto;
		/*Enable scroll if needed */
		background-color: rgb(0, 0, 0);
		/* Fallback color */
		background-color: rgba(0, 0, 0, 0.95);
		/* Black w/ opacity */
	}

	/* Modal Content (Image) */
	.modal-content {
		margin: auto;
		display: block;
		width: 80%;
		max-width: 800px;
		animation-name: zoom;
		animation-duration: 0.6s;
	}

	@keyframes zoom {
		from {
			transform: scale(0)
		}

		to {
			transform: scale(1)
		}
	}

	/* The Close Button */
	.close {
		position: absolute;
		top: 15px;
		right: 35px;
		color: white;
		font-size: 70px;
		font-weight: bold;
		transition: 0.3s;
	}

	.close:hover,
	.close:focus {
		color: white;
		text-decoration: none;
		cursor: pointer;
	}
</style>

<script>
	var modal = document.getElementById("modal");
	var i;
	// Get the image and insert it inside the modal - use its "alt" text as a caption
	var img = document.getElementsByClassName("image_thumbnail");
	var modalImg = document.getElementById("modal-content");
	console.log(img, modalImg);

	for (i = 0; i < img.length; i++) {
		img[i].onclick = function() {

			modal.style.display = "block";
			modalImg.src = this.src;
		}
	}

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}
</script>



