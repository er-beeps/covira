@if (config('backpack.base.scripts') && count(config('backpack.base.scripts')))
    @foreach (config('backpack.base.scripts') as $path)
    <script type="text/javascript" src="{{ asset($path).'?v='.config('backpack.base.cachebusting_string') }}"></script>
    @endforeach
@endif

@if (config('backpack.base.mix_scripts') && count(config('backpack.base.mix_scripts')))
    @foreach (config('backpack.base.mix_scripts') as $path => $manifest)
    <script type="text/javascript" src="{{ mix($path, $manifest) }}"></script>
    @endforeach
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>


@if(!empty($load_scripts))
        @foreach ($load_scripts as $script)
            <script type="text/javascript" src={{ $script }}></script>
        @endforeach
    @endif

    {{-- Specific style in $this->data['script_js'] --}}
    @if(!empty($script_js))
        <script type="text/javascript">
            {{!! html_entity_decode($script_js) !!}}
        </script>
    @endif

@include('backpack::inc.alerts')

<!-- page script -->
<script type="text/javascript">
    // To make Pace works on Ajax calls
    $(document).ajaxStart(function() { Pace.restart(); });

    // Ajax calls should always have the CSRF token attached to them, otherwise they won't work
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    {{-- Enable deep link to tab --}}
    var activeTab = $('[href="' + location.hash.replace("#", "#tab_") + '"]');
    location.hash && activeTab && activeTab.tab('show');
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        location.hash = e.target.hash.replace("#tab_", "#");
    });
</script>