@php
    $value = data_get($entry, $column['name']);
@endphp
<span>
    @if ($value && count($value))
        @foreach ($value as $file_path)

        <?php

		$data = explode('.', $file_path);
		$extension = $data[1];
		//  dd($extension);	 
        ?>

        @if($extension == 'pdf')
        <i class="fa fa-file-pdf-o"  style="color:red;"></i>
        @else
        <i class="fa fa-image"></i>
        @endif
        @endforeach
    @else
        ----
    @endif
</span>
