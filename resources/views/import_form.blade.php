@extends('backpack::blank')


@section('content')
    <div class="row">
        <div class="col-md-4" style="margin-left:30%">
            <div class="card h-200 p-3">
                <div class="card-header bg-primary p-2"><i class="fa fa-info"></i>Import CSV</div>
                <div class="card-body p-0">
                    @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            Upload Validation Error<br><br>
                            <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    <form method="POST" file="true" action="{{ backpack_url('/import_excel') }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group mt-5 mb-3">
                            <input name="file" type="file" required  oninvalid="this.setCustomValidity('Please Choose File!')"
            oninput="this.setCustomValidity('')">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-sm btn-block btn-primary">Import</button>
                        </div>
                    </form>
                </div>
            </div>  
        </div>
    </div>

@endsection


