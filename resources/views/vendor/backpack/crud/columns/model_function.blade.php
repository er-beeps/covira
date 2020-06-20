{{-- custom return value --}}
@php
	$value = $entry->{$column['function_name']}(...($column['function_parameters'] ?? []));
@endphp

<span>
	{!! nl2br((array_key_exists('prefix', $column) ? $column['prefix'] : '').str_limit($value, array_key_exists('limit', $column) ? $column['limit'] : 150, "[...]").(array_key_exists('suffix', $column) ? $column['suffix'] : '')) !!}
</span>