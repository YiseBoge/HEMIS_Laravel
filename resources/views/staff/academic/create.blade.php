@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <form class=" pb-5">
            <h3 class="font-weight-bold text-primary">Add Academic Staff Member</h3>
            <div class="row my-5">
                <div class="col-md-5">
                    <fieldset class="card shadow" style="height: 370px;">
                        <div class="card-header text-primary">
                                Personal Information
                        </div>
                        <div class="card-body px-4">
                      
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <input type="text" id="grand_father_name" class="form-control" required>
                                    <label class="form-control-placeholder" for="grand_father_name">Name</label>
                                </div>
                            </div>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bdate">
                                        Date of Birth
                                    </label>
                                    <input class="form-control" id="bdate" type="date" placeholder="2011-08-19">
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="">
                                        Sex
                                    </label>
                                    <div>
                                        <label class="radio-inline"><input class="d-inline-block form-check-inline" type="radio"
                                                                            name="sex" value="Male">Male</label>
                                        <label class="radio-inline"><input class="d-inline-block form-check-inline" type="radio"
                                                                            name="sex" value="Female">Female</label>
                                    </div>
                                </div>     
                            </div>   
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-6">      
                                <div class="form-group">
                                    <input type="text" id="phoneno" class="form-control" required>
                                    <label class="form-control-placeholder" for="phoneno">Phone Number</label>
                                </div>
                            </div>       
                                
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" id="nationality" class="form-control" required>
                                    <label class="form-control-placeholder" for="nationality">Nationality</label>
                                </div>
                            </div>
                        </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-7">
                    <fieldset class="card shadow" style="height: 370px;">
                        <div class="card-header text-primary">
                                Employment Information
                        </div>
                        <div class="card-body px-5">
                        <div class="form-row">
                            <div class="col-md form-group">
                                <input type="text" id="job_title" class="form-control" required>
                                <label class="form-control-placeholder" for="job_title">Job Title</label>
                            </div>
                            <div class="col-md form-group">
                                <input type="text" id="salary" class="form-control" required>
                                <label class="form-control-placeholder" for="salary">Salary</label>
                            </div>
                            <div class="col-md form-group">
                                <input type="text" id="service_year" class="form-control" required>
                                <label class="form-control-placeholder" for="service_year">Service Year</label>
                            </div>
                          
                        </div>
        
                        <hr>
        
                        <div class="form-row">
                            <div class="col form-group">
                                <label for="empType">Employment Type</label>
                                <select class="form-control" id="empType">
                                    <option selected value="Employee">Employee</option>
                                    <option value="Contractor">Contractor</option>
                                </select>
                            </div>
        
                            <div class="col-md form-group">
                                <label for="dedication">Dedication</label>
                                <select class="form-control" id="dedication">
                                    <option selected value="Full Time">Full Time</option>
                                    <option value="Part Time">Part Time</option>
                                </select>
                            </div>
        
                            <div class="col-md form-group">
                                <label for="academic-level">Academic Level</label>
                                <select class="form-control selectpicker" id="academic-level" data-live-search="true">
                                    <option selected value="bachelors">Bachelors</option>
                                    <option value="M.D/D.V">M.D/D.V</option>
                                    <option value="Masters">Masters</option>
                                    <option value="PhD">PhD</option>
                                    <option value=">= Grade 10"><= Grade 10</option>
                                    <option value="Grade 11">Grade 11</option>
                                    <option value="Grade 12">Grade 12</option>
                                    <option value="10+1">10 + 1</option>
                                    <option value="10+2">10 + 2</option>
                                    <option value="10+3">10 + 3</option>
                                    <option value="Level I">Level I</option>
                                    <option value="Level II">Level II</option>
                                    <option value="Level III">Level III</option>
                                    <option value="Level IV">Level IV</option>
                                    <option value="Level V">Level V</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group form-check form-check-inline">
                            <input class="form-check-input" id="expatriate" type="checkbox" value="expatriate">
                            <label class="form-check-label" for="expatriate">Expatriate</label>
                        </div>
                    </fieldset>
                </div>
            </div>
           


           


            <fieldset id="academic-staff" class="card shadow">
                    <div class="card-header text-primary">
                            Academic Staff Information
                    </div>
                <div class="card-body px-5">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="field_study" class="form-control" required>
                            <label class="form-control-placeholder" for="field_study">Field of Study</label>
                        </div>                         
                    </div>

                    <div class="col-md-6 form-group pl-5">
                        <div class="form-group">
                            <input type="text" id="teaching_load" class="form-control" required>
                            <label class="form-control-placeholder" for="teaching_load">Teaching Load</label>
                        </div>
                       
                    </div>
                </div>
                <hr>
                <div class="form-row">
                    <div class="col-md-6">
                        
                        <div class="form-group">
                            <label for="aca-staff-rank">Academic Staff Rank</label>
                            <select class="form-control" id="aca-staff-rank">
                                <option selected value="Graduate Assistant I">Graduate Assistant I</option>
                                <option value="Graduate Assistant II">Graduate Assistant II</option>
                                <option value="Assistant Lecturer">Assistant Lecturer</option>
                                <option value="Lecturer">Lecturer</option>
                                <option value="Assistant Professor">Assistant Professor</option>
                                <option value="Associate Professor">Associate Professor</option>
                                <option value="Professor">Professor</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>                      
                                        
                    </div>

                    <div class="col-md-6 form-group pl-5">
                  
                        <div class="form-group">
                            <label for="overloadRemark">If Overloaded, why?</label>
                            <textarea rows="1" class="form-control" id="overloadRemark"></textarea>
                        </div>
                    </div>
                </div>
                <hr>               
                <div class="form-group row">
                    <div class="col form-group">
                        <label for="additional_remarks">
                            Additional Remarks
                        </label>
                        <textarea class="form-control" name="" id="additional_remarks" rows="3"></textarea>
                    </div>
                </div>
                </div>
            </fieldset>      
            <button class="btn btn-outline-secondary float-right my-1" type="submit">Submit</button>
        </form>
    </div>
@endsection
