{{-- custom return value via attribute --}}
@php
	$model_function = $entry->{$column['function_name']}(...($column['function_parameters'] ?? []));
	
	if ($model_function) {
	    $value = $model_function->{$column['attribute']};
	} else {
		$value = '';
	}
@endphp
<span>
	{!! nl2br((array_key_exists('prefix', $column) ? $column['prefix'] : '').str_limit($value, array_key_exists('limit', $column) ? $column['limit'] : 70, "[...]").(array_key_exists('suffix', $column) ? $column['suffix'] : '')) !!}
</span>