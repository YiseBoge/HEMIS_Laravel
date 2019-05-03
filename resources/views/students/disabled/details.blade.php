@extends('layouts.app')

@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-9">
                <h1 class="font-weight-bold text-primary">Disabled Student</h1>
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
                                    
                            </div>
                            <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Sex</div>
                                    <div class="mb-0 text-gray-800">Female</div>
                            </div>
                            <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Date of Birth</div>
                                    <div class="mb-0 text-gray-800">1996-02-04</div>
                            </div>
                        </div>   
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Student ID</div>
                                <div  class="mb-0 text-gray-800">JTR/1212/99</div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Phone Number</div>
                                <div  class="mb-0 text-gray-800">0000000000</div>
                            </div>
                        </div>              
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Band</div>
                <p>Engineering and Technology</p>
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Department</div>
                <p>Civil, Construction & Transport engineering</p>
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Program</div>
                <p>Daytime</p>
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Education Level</div>
                <p>Undergraduate</p>
            </div>                                           
        </div>    
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Year Level</div>
                <p>2</p>
            </div>   
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Disability</div>
                <p>Visually Impaired</p>
            </div>   
        </div> 
        <div class="text-lg font-weight-bold text-gray-900 text-uppercase mt-4">Student Service Information</div>
        <div class="row mt-4">                       
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Food Service</div>
                <p>In Cash</p>
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Dormitory Service</div>
                <p>In Kind</p>
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Block Number</div>
                <p>5</p>
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Room Number</div>
                <p>305</p>
            </div>
        </div> 
        <div class="text-sm font-weight-bold text-gray-900 text-uppercase my-2">Remarks</div>  
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
    </div>
    
@endsection
