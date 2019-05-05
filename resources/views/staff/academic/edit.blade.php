@extends('layouts.app')

@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-9">
                <h1 class="font-weight-bold text-primary">Academic Staff</h1>
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
                                    <div class="input-group mb-3"> 
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>                                      
                                        <input type="text" class="form-control form-control-plaintext" value="Airi Satou Airi">
                                        
                                    </div>                                  
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Sex</div>
                                    <div class="input-group mb-3">  
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext" value="Female">
                                    </div>  
                                    
                            </div>
                            <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Nationality</div>
                                    <div class="input-group mb-3">   
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext" value="Indian">
                                    </div>  
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Phone Number</div>
                                    <div class="input-group mb-3">   
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext" value="0000000000">
                                    </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Date of Birth</div>
                                <div class="input-group mb-3">  
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-plaintext" value="1983-06-03">
                                </div>  
                            </div>
                        </div>                 
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Job Title</div>
                <div class="input-group mb-3">  
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="Lecturer">
                </div>  
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Dedication</div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="Full Time">
                </div>  
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Employment Type</div>
                <div class="input-group mb-3">   
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="Employee">
                </div>  
            </div> 
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Status</div>
                <div class="input-group mb-3">    
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="On Study Leave">
                </div>  
            </div>                         
        </div>     

        <div class="row mt-4">                       
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Academic Level</div>
                <div class="input-group mb-3">   
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="PhD">
                </div>  
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Salary</div>
                <div class="input-group mb-3">  
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="$162,700">
                </div>  
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Years of Service</div>
                <div class="input-group mb-3"> 
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="5">
                </div>  
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Rank</div>
                <div class="input-group mb-3"> 
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="Rank">
                </div>  
            </div>
        </div>       
        <div class="row mt-4">           
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Field of Study</div>
                <div class="input-group mb-3"> 
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="Software Engineering">
                </div>  
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Teaching Load</div>
                <div class="input-group mb-3">     
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="10 Credit Hours">
                </div>  
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Reason for Overload</div>
                <div class="input-group mb-3">  
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="Shortage of Lecturers">
                </div>  
            </div>
        </div> 
        <div class="text-lg font-weight-bold text-gray-900 text-uppercase my-1">Leave Information</div>
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Leave Type</div>
                <div class="input-group mb-3">   
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="Partial">
                </div> 
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Country</div>
                <div class="input-group mb-3"> 
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="Country">
                </div> 
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Institution</div>
                <div class="input-group mb-3">     
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="Institution">
                </div> 
            </div>            
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Status</div>
                <div class="input-group mb-3">  
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="Status">
                </div> 
            </div>
        </div> 
        <div class="row">
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Rank</div>
                <div class="input-group mb-3">   
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="Rank">
                </div> 
            </div>
            <div class="col-md-3">
                <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Scholarship</div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text bg-light border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                    </div>
                    <input type="text" class="form-control form-control-plaintext" value="Government">
                </div> 
            </div>
        </div>
        <div class="text-sm font-weight-bold text-gray-900 text-uppercase my-2">Remarks</div>  
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
            
    </div>
    
@endsection
