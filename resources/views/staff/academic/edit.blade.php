@extends('layouts.app')

@section('content')
    <div class="container mb-5">
            @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
            @endif
    <form action="/staff/academic/{{$staff->id}}" method="POST">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="row">
            <div class="col-md-9">
                <h1 class="font-weight-bold text-primary">Academic Staff</h1>
            </div>
            <div class="col-md-3 pt-3">
                <button type="submit" class="form-control form-control-plaintext text-primary">
                        <i class="far fa-save mr-2"></i></i> Save
                </button>
            </div>
        </div>
        
        <div class="row my-3">
            <div class="col-md-12">
                <div class="card border-left-primary shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Name</div>
                                    <div class="input-group mb-3"> 
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>                                      
                                        <input type="text" class="form-control form-control-plaintext" name="name" value="{{$staff->general->name}}">
                                        
                                    </div>                                  
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Sex</div>
                                    <div class="input-group mb-3">  
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext" name="sex" value="{{$staff->general->sex}}">
                                    </div>  
                                    
                            </div>
                            <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Nationality</div>
                                    <div class="input-group mb-3">   
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext" name="nationality" value="{{$staff->general->nationality}}">
                                    </div>  
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Phone Number</div>
                                    <div class="input-group mb-3">   
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext" name="phone_number" value="{{$staff->general->phone_number}}">
                                    </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Date of Birth</div>
                                <div class="input-group mb-3">  
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-plaintext" name="birth_date" value="{{$staff->general->birth_date}}">
                                </div>  
                            </div>
                        </div>                 
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header text-primary">
                Employment Information
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Job Title</div>
                        <div class="input-group mb-3">  
                            <div class="input-group-append">
                                <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                            </div>
                            <input type="text" class="form-control form-control-plaintext" name="job_title" value="{{$staff->general->job_title}}">
                        </div>  
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Dedication</div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                            </div>
                            <select class="form-control form-control-plaintext" name="dedication">
                                @foreach ($staff->general->getEnum("Dedications") as $key => $value)
                                    @if ($value == $staff->general->dedication)
                                        <option selected value="{{$key}}">{{$value}}</option>
                                    @else
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                            
                        </div>  
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Employment Type</div>
                        <div class="input-group mb-3">   
                            <div class="input-group-append">
                                <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                            </div>
                            <select class="form-control form-control-plaintext" name="employment_type">
                                @foreach ($staff->general->getEnum("EmploymentTypes") as $key => $value)
                                    @if ($value == $staff->general->employment_type)
                                        <option selected value="{{$key}}">{{$value}}</option>
                                    @else
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                            
                        </div>  
                    </div> 
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Status</div>
                        <div class="input-group mb-3">    
                            <div class="input-group-append">
                                <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                            </div>
                            <select class="form-control form-control-plaintext" id="status_select" name="status">
                                @if ($staff->staff_leave_id == 0)
                                    <option value="onLeave">On Study Leave</option>
                                    <option value="onDuty" selected>On Duty</option>                                    
                                @else
                                <option value="onLeave" selected>On Study Leave</option>
                                <option value="onDuty">On Duty</option>
                                @endif
                               
                            </select>
                            
                        </div>  
                    </div>                         
                </div>     
        
                <div class="row mt-4">                       
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Academic Level</div>
                        <div class="input-group mb-3">   
                            <div class="input-group-append">
                                <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                            </div>
                            <select class="form-control form-control-plaintext" name="academic_level">
                                @foreach ($staff->general->getEnum("AcademicLevels") as $key => $value)
                                    @if ($value == $staff->general->academic_level)
                                        <option selected value="{{$key}}">{{$value}}</option>
                                    @else
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                            
                        </div>  
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Salary</div>
                        <div class="input-group mb-3">  
                            <div class="input-group-append">
                                <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                            </div>
                            <input type="text" class="form-control form-control-plaintext" name="salary" value="{{$staff->general->salary}}">
                        </div>  
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Years of Service</div>
                        <div class="input-group mb-3"> 
                            <div class="input-group-append">
                                <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                            </div>
                            <input type="text" class="form-control form-control-plaintext" name="service_year" value="{{$staff->general->service_year}}">
                        </div>  
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Is Expatriate</div>
                        <div class="input-group mb-3">    
                            <div class="input-group-append">
                                <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                            </div>
                            <select class="form-control form-control-plaintext" name="expatriate">
                                @if ($staff->general->is_expatriate == 0)
                                    <option value="1">Yes</option>
                                    <option selected value="0">No</option>
                                @else
                                    <option selected value="1">Yes</option>
                                    <option value="0">No</option>
                                @endif
                                
                            </select>
                            
                        </div>  
                    </div>   
                   
                </div> 
            </div>
        </div>
        <div class="card shadow mt-3">
            <div class="card-header text-primary">
                Academic Staff Information
            </div>
            <div class="card-body">
                <div class="row mt-4"> 
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Rank</div>
                        <div class="input-group mb-3"> 
                            <div class="input-group-append">
                                <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                            </div>
                            <select class="form-control form-control-plaintext" name="academic_staff_rank">
                                @foreach ($staff->getEnum("StaffRanks") as $key => $value)
                                    @if ($value == $staff->staffRank)
                                        <option selected value="{{$key}}">{{$value}}</option>
                                    @else
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>  
                    </div>          
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Field of Study</div>
                        <div class="input-group mb-3"> 
                            <div class="input-group-append">
                                <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                            </div>
                            <input type="text" class="form-control form-control-plaintext" name="field_of_study" value="{{$staff->field_of_study}}">
                        </div>  
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Teaching Load</div>
                        <div class="input-group mb-3">     
                            <div class="input-group-append">
                                <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                            </div>
                            <input type="text" class="form-control form-control-plaintext" name="teaching_load" value="{{$staff->teaching_load}}">
                        </div>  
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Reason for Overload</div>
                        <div class="input-group mb-3">  
                            <div class="input-group-append">
                                <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                            </div>
                            <input type="text" class="form-control form-control-plaintext" name="overload_remark" value="{{$staff->overload_remarks}}">
                        </div>  
                    </div>
                </div> 
            </div>
        </div>
      
         
            <div class="card shadow mt-3">
                <div class="card-header text-primary">
                    Leave Information
                </div>
                @if ($staff->staff_leave_id == 0)
                <div class="mb-0 text-gray-600 p-3" id="leave_message">Staff Member is on Duty</div>
                <div class="card-body d-none" id="leave_card">
                @else 
                <div class="card-body" id="leave_card">
                @endif
                    <div class="row mt-4 text-muted">
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Leave Type</div>
                            <div class="input-group mb-3">   
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                @if ($staff->staff_leave_id == 0)
                                    <select class="form-control form-control-plaintext" name="leave_type">
                                        @foreach ($staff_leave_types as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                @else 
                                    <select class="form-control form-control-plaintext" name="leave_type">
                                    @foreach ($staff_leave_types as $key => $value)
                                        @if ($value == $staff->staffLeave->leave_type)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                @endif
                            </div> 
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Country</div>
                            <div class="input-group mb-3"> 
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                @if ($staff->staff_leave_id == 0)
                                <input type="text" name="leave_country" class="form-control form-control-plaintext">
                                @else 
                                <input type="text" name="leave_country" class="form-control form-control-plaintext" value="{{$staff->staffLeave->country_of_study}}">
                                @endif
                            </div> 
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Institution</div>
                            <div class="input-group mb-3">     
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                @if ($staff->staff_leave_id == 0)
                                <input type="text" name="leave_institution" class="form-control form-control-plaintext">
                                @else 
                                <input type="text" name="leave_institution" class="form-control form-control-plaintext" value="{{$staff->staffLeave->institution}}">
                                @endif
                            </div> 
                        </div>            
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Status</div>
                            <div class="input-group mb-3">  
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                @if ($staff->staff_leave_id == 0)
                                <input type="text" name="leave_status" class="form-control form-control-plaintext">
                                @else 
                                <input type="text" name="leave_status" class="form-control form-control-plaintext" value="{{$staff->staffLeave->status_of_study}}">
                                @endif
                            </div> 
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Rank</div>
                            <div class="input-group mb-3">   
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                @if ($staff->staff_leave_id == 0)
                                <input type="text" name="leave_rank" class="form-control form-control-plaintext">
                                @else 
                                <input type="text" name="leave_rank" class="form-control form-control-plaintext" value="{{$staff->staffLeave->rank_of_study}}">
                                @endif
                            </div> 
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Scholarship</div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                @if ($staff->staff_leave_id == 0)
                                    <select class="form-control form-control-plaintext" name="leave_scholarship">
                                        @foreach ($staff_scholarship_types as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                @else 
                                    <select class="form-control form-control-plaintext" name="leave_scholarship">
                                    @foreach ($staff_scholarship_types as $key => $value)
                                        @if ($value == $staff->staffLeave->leave_type)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                @endif
                                
                            </div> 
                        </div>
                    </div>
                </div>
            </div>

        <div class="card shadow mt-3">
            <div class="card-header text-primary">
                Remarks
            </div>
            <div class="card-body">
                <textarea class="form-control" id="additional_remarks" name="additional_remark" rows="3">{{$staff->general->remarks}}</textarea>
            </div>
            
        </div>      
            
    </form> 
    </div>
<script>
    var statusSelect = document.getElementById('status_select')
    var leaveCard = document.getElementById('leave_card')
    var leaveMessage = document.getElementById('leave_message')
    statusSelect.addEventListener('change', function (e) {
        switch (statusSelect.selectedIndex) {
            case 0:
                leaveCard.className = "card-body"
                leaveMessage.className = 'mb-0 text-gray-600 p-3 d-none'
                break
            case 1:
                leaveCard.className = "card-body d-none"
                leaveMessage.className = 'mb-0 text-gray-600 p-3'
                break
        }
    })
</script>
@endsection
