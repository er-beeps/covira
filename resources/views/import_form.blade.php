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
                    <div class="box mt-3">
                        <a class="btn btn-light btn-sm btn-view" href="#popup">View CSV format</a>
                    </div>
                    <div id="popup" class="overlay">
                        <div class="popup">
                            <center><h5 style="color:red">*Note: Make sure you format csv header row as below before importing !!</h5></center>
                            <a class="close" href="#">×</a>
                            <div class="content m-5">
                                <center><img src="{{ asset('img/csv_format.PNG') }}" /></center>                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>

@endsection

@section('after_styles')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">


<style>

.btn-view{
    cursor:pointer;
    color:blue;
    background-color:lightgray;
}

.overlay {
 position: fixed;
 top: 0;
 bottom: 0;
 left: 0;
 right: 0;
 background: rgba(0, 0, 0, 0.7);
 transition: opacity 500ms;
 visibility: hidden;
 opacity: 0;
}
.overlay:target {
 visibility: visible;
 opacity: 1;
}

.popup {
 margin: 70px auto;
 padding: 20px;
 background: #fff;
 border-radius: 5px;
 width: 60%;
 position: relative;
 transition: all 5s ease-in-out;
}

.popup h2 {
 margin-top: 0;
 color: #333;
 font-family: Tahoma, Arial, sans-serif;
}
.popup .close {
 position: absolute;
 top: 20px;
 right: 30px;
 transition: all 200ms;
 font-size: 30px;
 font-weight: bold;
 text-decoration: none;
 color: #333;
}
.popup .close:hover {
 color: #06D85F;
}
.popup .content {
 max-height: 40%;
 overflow: auto;
}

@media screen and (max-width: 700px){
 .box{
 width: 70%;
 }
 .popup{
 width: 70%;
 }
}
</style>

@endsection

@section('after_scripts')
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@endsection




