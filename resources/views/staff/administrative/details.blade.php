@extends('layouts.app')

@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-9">
                <h1 class="font-weight-bold text-primary">Administrative Staff</h1>
            </div>
            <div class="col-md-3 pt-3">
                <a href="1/edit" class="text-muted mr-3"><i class="far fa-edit"></i> Edit</a>
                <a href="#" class="text-muted"><i class="far fa-trash-alt"></i> Delete</a>
            </div>
        </div>
        
        <div class="row my-3">
            <div class="col-md-11">
                <div class="card border-left-primary shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Name</div>
                                    <div class="mb-0 text-gray-800">Airi Satou Airi</div>
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Sex</div>
                                    <div class="mb-0 text-gray-800">Female</div>
                                    
                            </div>
                            <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Nationality</div>
                                    <div class="mb-0 text-gray-800">Indian</div>
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Phone Number</div>
                                    <div class="mb-0 text-gray-800">0000000000</div>
                            </div>
                            <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Date of Birth</div>
                                    <div class="mb-0 text-gray-800">1991-04-02</div>
                            </div>
                        </div>                 
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Job Title</div>
                <p>Lecturer</p>
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Dedication</div>
                <p>Full Time</p>
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Employment Type</div>
                <p>Employee</p>
            </div> 
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Academic Level</div>
                <p>phD</p>
            </div>        
        </div>     

        <div class="row mt-4">                       
            
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Salary</div>
                <p>$162,700</p>
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Years of Service</div>
                <p>5</p>
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Rank</div>
                <p>Lecturer</p>
            </div>
        </div>  
        <div class="text-sm font-weight-bold text-gray-900 text-uppercase my-2">Remarks</div>  
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>           
            
    </div>
    
@endsection
