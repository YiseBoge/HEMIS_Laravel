@extends('layouts.app')

@section('content')
    <div class="container-fluid">
            @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
            @endif
        <form class="pb-5" action="/staff/academic" method="POST">
            @csrf
            <h3 class="font-weight-bold text-primary">Add Foreign Staff Member</h3>
            <div class="row my-5">
                <div class="col-md-5">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                                Personal Information
                        </div>
                        <div class="card-body px-4">
                            <div class="form-row pt-3">
                                <div class="col form-group">
                                    <input type="text" id="name" name="name" class="form-control" required>
                                    <label class="form-control-placeholder" for="grand_father_name">Full Name</label>
                                </div>
                            </div>
                        <hr>
                        <div class="form-row pt-3">
                            {{-- <div class="col-md-6">
                                <div class="form-group">                                    
                                    <input class="form-control" id="bdate" name="birth_date" type="date" placeholder="2011-08-19">
                                    <label for="bdate" class="form-control-placeholder">Date of Birth</label>
                                </div>
                            </div>  --}}
                            <div class="col-md-6">
                                <div class="form-group">                                                                        
                                    <div id="sex">
                                        <label class="radio-inline"><input class="form-check-inline" type="radio"
                                                                            name="sex" value="Male" id="male">Male</label>
                                        <label class="radio-inline"><input class="form-check-inline" type="radio"
                                                                            name="sex" value="Female">Female</label>
                                    </div>
                                    <!--<label class="form-control-placeholder" for="male">Sex</label>-->
                                </div>     
                            </div>   
                        </div>
                        <hr>
                        {{-- <div class="form-row pt-3"> --}}
                            <div class="col">      
                                <div class="form-group">
                                    <input type="text" id="phoneno" name="phone_number" class="form-control" required>
                                    <label class="form-control-placeholder" for="phoneno">Origin</label>
                                </div>
                            </div>       
                                
                            <div class="col">
                            {{-- This input must be replaced with a drop down  --}}
                                <div class="form-group">
                                    <input type="text" id="nationality" name="nationality" class="form-control" required>
                                    <label class="form-control-placeholder" for="nationality">Department</label>
                                </div>
                            </div>
                        {{-- </div> --}}
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-7">
                    <fieldset class="card shadow mt-md-0 mt-5 h-100">
                        <div class="card-header text-primary">
                                Employment Information
                        </div>
                        <div class="card-body px-5">
                        <div class="form-row pt-3">
                            {{-- dont forget to convert these in to a dropdown too --}}
                            <div class="col-md form-group">
                                <input type="text" id="job_title" name="job_title" class="form-control" required>
                                <label class="form-control-placeholder" for="job_title">Education Level</label>
                            </div>
                            <div class="col-md form-group">
                                <input type="text" id="salary" name="salary" class="form-control" required>
                                <label class="form-control-placeholder" for="salary">Specialization</label>
                            </div>
                            {{-- <div class="col-md form-group">
                                <input type="text" id="service_year" name="service_year" class="form-control" required>
                                <label class="form-control-placeholder" for="service_year">Service Year</label>
                            </div> --}}
                          
                        </div>
        
                        <hr>
        
                        <div class="form-row pt-3">
                            <div class="col form-group">
                                {{-- 
                                <select class="form-control" id="empType" name="employment_type">
                                    @foreach ($data['employment_types'] as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>--}}
                                {{-- <label for="empType" class="form-control-placeholder">Contrat Information</label> --}}
                                <div class="col">
                                <div class="form-group">                                    
                                    <input class="form-control" id="bdate" name="birth_date" type="date" placeholder="2011-08-19">
                                    <label for="bdate" class="form-control-placeholder">Date of Birth</label>
                                </div>
                                </div> 
                            </div> 
        
                            <div class="col-md form-group">
                                
                                {{-- <select class="form-control" id="dedication" name="dedication">
                                    @foreach ($data['dedications'] as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select> --}}
                                 <div class="col">
                                <div class="form-group">                                    
                                    <input class="form-control" id="bdate" name="birth_date" type="date" placeholder="2011-08-19">
                                    <label for="bdate" class="form-control-placeholder">Employment Date</label>
                                </div>
                            </div> 
                                {{-- <label for="dedication" class="form-control-placeholder">Dedication</label> --}}
                            </div>
        
                            <div class="col-md form-group">
                                
                                {{-- <select class="form-control selectpicker" id="academic-level" name="academic_level" data-live-search="true">
                                    @foreach ($$data['academic_levels'] as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select> --}}

                                 <div class="col">
                                <div class="form-group">                                    
                                    <input class="form-control" id="bdate" name="birth_date" type="date" placeholder="2011-08-19">
                                    <label for="bdate" class="form-control-placeholder">End of contract</label>
                                </div>
                            </div>  
                                {{-- <label for="academic-level" class="form-control-placeholder">Academic Level</label> --}}
                            </div>
                        </div>
                        {{-- <hr>
                        <div class="form-group form-check form-check-inline">
                            <input class="form-check-input" id="expatriate" name="expatriate" type="checkbox" value="expatriate">
                            <label class="form-check-label" for="expatriate">Expatriate</label>
                        </div> --}}
                    </fieldset>
                </div>
            </div>
            
            <fieldset id="academic-staff" class="card shadow">
                    <div class="card-header text-primary">
                            Additional Information
                    </div>
                {{-- <div class="card-body px-5">
                <div class="form-row pt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="field_study" name="field_of_study" class="form-control" required>
                            <label class="form-control-placeholder" for="field_study">Field of Study</label>
                        </div>                         
                    </div>

                    <div class="col-md-6 form-group pl-md-5">
                        <div class="form-group">
                            <input type="text" id="teaching_load" name="teaching_load" class="form-control" required>
                            <label class="form-control-placeholder" for="teaching_load">Teaching Load</label>
                        </div>
                       
                    </div>
                </div>
                <hr>
                <div class="form-row pt-3">
                    <div class="col-md-6">                        
                        <div class="form-group"> --}}
                            {{-- <select class="form-control" id="aca-staff-rank" name="academic_staff_rank">
                                @foreach ($$data['staff_ranks'] as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select> --}}
                            {{-- <label for="aca-staff-rank" class="form-control-placeholder">Academic Staff Rank</label> 
                        </div>                      
                                        
                    </div>

                    <div class="col-md-6 form-group pl-md-5">
                  
                        <div class="form-group">                           
                            <textarea rows="1" class="form-control" id="overloadRemark" name="overload_remark"></textarea>
                            <label for="overloadRemark" class="form-control-placeholder">If Overloaded, why?</label>
                        </div>
                    </div>
                </div>
                <hr>                --}}
                <div class="form-row pt-3">
                    <div class="col form-group">                       
                        <textarea class="form-control" id="additional_remarks" name="additional_remark" rows="3"></textarea>
                        <label for="additional_remarks" class="form-control-placeholder">Additional Remarks</label>
                    </div>
                </div>
                {{-- </div> --}}
            </fieldset>      
            <button class="btn btn-outline-secondary float-right my-1" type="submit">Submit</button>
        </form>
    </div>
@endsection