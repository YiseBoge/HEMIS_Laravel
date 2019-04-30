@extends('layouts.app')

@section('content')
    <div class="container">

        <form class="px-md-5 pb-5">
            <h3 class="font-weight-bold text-primary">Add ICT Staff Member</h3>
            <hr>
            <fieldset class="jumbotron shadow py-4">
                <legend class="text-primary">Personal Information</legend>
                <div class="form-row">
                    <div class="col-md form-group">
                        <input type="text" id="personal_name" class="form-control" required>
                        <label class="form-control-placeholder" for="personal_name">Personal Name</label>
                    </div>
                    <div class="col-md form-group">
                        <input type="text" id="father_name" class="form-control" required>
                        <label class="form-control-placeholder" for="father_name">Father's Name</label>
                    </div>
                    <div class="col-md form-group">
                        <input type="text" id="grand_father_name" class="form-control" required>
                        <label class="form-control-placeholder" for="grand_father_name">Grand Father's Name</label>
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
                        <hr>
                        <div class="form-group">
                            <input type="text" id="phoneno" class="form-control" required>
                            <label class="form-control-placeholder" for="phoneno">Phone Number</label>
                        </div>
                    </div>
                    <div class="col-md-6 pl-md-5">
                        <div class="form-group">
                            <label class="ml-2">
                                Sex
                            </label>
                            <div>
                                <label class="radio-inline"><input class="d-inline-block m-2 form-check-inline" type="radio"
                                                                    name="sex" value="Male">Male</label>
                                <label class="radio-inline"><input class="d-inline-block m-2 form-check-inline" type="radio"
                                                                    name="sex" value="Female">Female</label>
                            </div>
                        </div>                        
                        <hr>
                        <div class="form-group">
                            <input type="text" id="nationality" class="form-control" required>
                            <label class="form-control-placeholder" for="nationality">Nationality</label>
                        </div>
                    </div>
                </div>
            </fieldset>


            <fieldset class="jumbotron shadow py-4">
                <legend class="text-primary">Employment Information</legend>
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
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="expatriate" type="checkbox" value="expatriate">
                    <label class="form-check-label" for="expatriate">Expatriate</label>
                </div>
            </fieldset>

            <fieldset id="ict-staff" class="jumbotron shadow py-4">
                <legend class="text-primary">ICT Staff Information</legend>
                <div class="form-row">
                    <div class="col-sm-6 form-group row">
                        <label class="col-sm-6 col-form-label" for="ict-staff-rank">ICT Staff Rank</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" id="ict-staff-rank">
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
                </div>
                <div class="form-row">
                    <div class="col-sm-6 form-group row">
                        <label class="col-sm-6 col-form-label" for="ict-category">ICT Staff Type</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" id="ict-category">
                                <option selected value="ictCategory1">Infrastructure & Services</option>
                                <option value="ictCategory2">Business Application Administration & Development</option>
                                <option value="ictCategory3">Teaching and Learning Technologies</option>
                                <option value="ictCategory4">Support and Maintenance</option>
                                <option value="ictCategory5">Training and Consultancy</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 form-group row">
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" id="ict-type">

                            </select>
                        </div>
                    </div>
                </div>
            
                <div class="form-group row">
                    <div class="col form-group">
                        <label for="additional_remarks">
                            Additional Remarks
                        </label>
                        <textarea class="form-control" name="" id="additional_remarks" rows="3"></textarea>
                    </div>
                </div>
            </fieldset>
            <button class="btn btn-outline-secondary float-right my-1" type="submit">Submit</button>
        </form>
    </div>
@endsection
