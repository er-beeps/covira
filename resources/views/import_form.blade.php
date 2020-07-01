@extends('backpack::blank')


@section('content')
    <div class="row mt-40">
        <div class="col-md-4 col-md-offset-4">
            <h3 class="text-center m-b-20">Import Excel to Database</h3>
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
            
                <div class="box">
                <div class="box-body">
                    <form class="col-md-12 p-t-10"  method="POST" file="true" action="{{ backpack_url('/import_excel') }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <div class="form-group">
                                <input name="file" type="file" required="required">
                        </div>

                            <div>
                                <button type="submit" class="btn btn-block btn-primary">Import</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


