@extends(backpack_view('layouts.top_left'))

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
            <a href="{{ url('/') }}" style="font-size:18px;">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Our Team</li>
        </ol>

        <div class="card bg-white team-card">
            <div class= "row">
                <div class="col-md-6">            
                    <div class="row box">
                        <img class="rounded-circle profile" src="{{ asset('/img/male-profile-icon.png') }}" alt=""/>
                        <div class="inner">
                            <h2>Rishi Ram Parajuli</h2>
                            <p>PhD, University of Bristol, UK, (Engineering)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">            
                    <div class="row box">
                        <img class="rounded-circle profile" src="{{ asset('/img/male-profile-icon.png') }}" alt=""/>
                        <div class="inner">
                            <h2>Bhogendra Mishra</h2>
                            <p>PhD, Science Hub, Nepal (Spatial Data Science)</p>
                        </div>
                    </div>
                </div>
            </div>    

            <div class="row">
                <div class="col-md-6">
                    <div class="row box">
                        <img class="rounded-circle profile" src="{{ asset('/img/male-profile-icon.png') }}" alt=""/>
                        <div class="inner">
                            <h2>Amrit Banstola</h2>
                            <p>University of West of England, UK (Public Health)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"> 
                    <div class="row box">
                        <img class="rounded-circle profile" src="{{ asset('/img/male-profile-icon.png') }}" alt=""/>
                        <div class="inner">
                            <h2>Bhoj Raj Ghimire</h2>
                            <p>PhD, Nepal Open University, Nepal (ICT)</p>
                        </div>
                    </div>
                </div>    
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row box">
                        <img class="rounded-circle profile" src="{{ asset('/img/female-profile-icon.jpg') }}" alt=""/>
                        <div class="inner">
                            <h2>Shova Paudel</h2>
                            <p>PhD, Science Hub, Nepal (Livelihood)</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row box">
                        <img class="rounded-circle profile" src="{{ asset('/img/female-profile-icon.jpg') }}" alt=""/>
                        <div class="inner">
                            <h2>Kusum Sharma</h2>
                            <p>Science Hub, Nepal (Engineering)</p>
                        </div>
                    </div>
                </div>    
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row box">
                        <img class="rounded-circle profile" src="{{ asset('/img/male-profile-icon.png') }}" alt=""/>
                        <div class="inner">
                            <h3>Sameer Mani Dixit</h3>
                            <p>PhD, Center for Molecular Dynamics, Nepal (Public Health)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row box">
                        <img class="rounded-circle profile" src="{{ asset('/img/male-profile-icon.png') }}" alt=""/>
                        <div class="inner">
                            <h3>Prof. Padam Simkhada</h3>
                            <p>PhD, University of Huddersfield, UK (Public Health)</p>
                        </div>
                    </div>
                </div>    
            </div>    

            <div class="row">
                <div class="col-md-6">
                    <div class="row box">
                        <img class="rounded-circle profile" src="{{ asset('/img/male-profile-icon.png') }}" alt=""/>
                        <div class="inner">
                            <h3>Bipin Khatiwada</h3>
                            <p>Science Hub, Nepal (Web Development)</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row box">
                        <img class="rounded-circle profile" src="{{ asset('/img/male-profile-icon.png') }}" alt=""/>
                        <div class="inner">
                            <h3>Sujan Parajuli</h3>
                            <p>Science Hub, Nepal (Engineering)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</html>
<style>
.team-card{
    border-radius:10px;
}
.box{
    margin:40px;
    background-color:#ebf2ec;
    border-radius:15px;
    padding:20px;
}
.profile{
    width:120px;
    height:120px;
}
.inner{
    padding:20px;
}
</style>
@endsection