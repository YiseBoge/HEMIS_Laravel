@extends('layouts.app')

@section('content')
    <div class="container">

        <form class="px-md-5 pb-5">
            <h3>Add Staff Member</h3>
            <hr>
            <fieldset class="jumbotron shadow-sm">
                <legend>Personal Information</legend>
                <div class="form-row">
                    <div class="col-md form-group">
                        <input type="text" id="personal_name" name="personal_name" class="form-control mx-1"
                               placeholder="Personal Name">
                    </div>
                    <div class="col-md form-group">
                        <input type="text" id="father_name" name="father_name" class="form-control mx-1"
                               placeholder="Father's Name">
                    </div>
                    <div class="col-md form-group">
                        <input type="text" id="grand_father_name" name="grand_father_name" class="form-control mx-1"
                               placeholder="Grand Father's Name">
                    </div>
                </div>
                <hr>
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label for="bdate">
                            Date of Birth
                        </label>
                        <input class="form-control" id="bdate" type="date" placeholder="2011-08-19">
                        <hr>
                        <input class="form-control " id="phoneno" type="text" placeholder="Phone Number">
                    </div>
                    <div class="col-md-6 pl-md-5">
                        <label class="ml-2">
                            Sex
                        </label>
                        <div>
                            <label class="radio-inline"><input class="d-inline-block m-2 form-check-inline" type="radio"
                                                               name="sex" value="Male">Male</label>
                            <label class="radio-inline"><input class="d-inline-block m-2 form-check-inline" type="radio"
                                                               name="sex" value="Female">Female</label>
                        </div>
                        <hr>
                        <input class="form-control" id="nationality" type="text" placeholder="Nationality">
                    </div>
                </div>
            </fieldset>


            <fieldset class="jumbotron shadow-sm">
                <legend>Employment Information</legend>
                <div class="form-row">
                    <div class="col-md form-group">
                        <input class="form-control" id="job-title" type="text" placeholder="Job Title">
                    </div>

                    <div class="col-md form-group">
                        <input class="form-control" id="salary" type="number" placeholder="Salary">
                    </div>

                    <div class="col-md form-group">
                        <input class="form-control" id="service-year" type="number" placeholder="Service Year">
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
                        <select class="selectpicker form-control" id="academic-level">
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

                <hr>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="job-type">Staff Type</label>
                        <select class="form-control" id="job-type">
                            <option selected value="Academic"><a href="#">Academic Staff</a></option>
                            <option value="Technical">Technical Staff</option>
                            <option value="Administrative">Administrative Staff</option>
                            <option value="ICT">ICT Staff</option>
                            <option value="Supportive">Supportive Staff</option>
                        </select>
                    </div>
                </div>
            </fieldset>


            <fieldset id="academic-staff" class="jumbotron shadow-sm">
                <legend>Academic Staff Information</legend>
                <div class="form-row">
                    <div class="col-md-6 form-group p-md-3">
                        <input class="form-control" id="field-study" type="text" placeholder="Field of Study">
                        <hr>
                        <input class="form-control" id="teaching-load" type="text" placeholder="Teaching Load">
                    </div>

                    <div class="col-md-6 form-group p-md-3">
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

                <div class="form-group">
                    <label for="overloadRemark">If Overloaded, why?</label>
                    <textarea class="form-control" id="overloadRemark"></textarea>
                </div>
            </fieldset>

            <fieldset id="technical-staff" style="display: none" class="jumbotron">
                <legend>Technical Staff Information</legend>
                <div class="form-row">
                    <div class="col-sm-4 form-group row">
                        <label class="col-sm-6 col-form-label" for="tech-staff-rank">Technical Staff Rank</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" id="tech-staff-rank">
                                <option selected value="Technical Assistant I">Technical Assistant I</option>
                                <option value="Technical Assistant II">Technical Assistant II</option>
                                <option value="Technical Assistant III">Technical Assistant III</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset id="administrative-staff" style="display: none;" class="jumbotron shadow-sm">
                <legend>Administrative Staff Information</legend>
                <div class="form-row">
                    <div class="col-sm-4 form-group row">
                        <label class="col-sm-6 col-form-label" for="admin-staff-rank">Administrative Staff Rank</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" id="admin-staff-rank">
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
            </fieldset>

            <fieldset id="ict-staff" style="display: none;" class="jumbotron shadow-sm">
                <legend>ICT Staff Information</legend>
                <div class="form-row">
                    <div class="col-sm-4 form-group row">
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
                    <div class="col-sm-4 form-group row">
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
                    <div class="col-sm-4 form-group row">
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" id="ict-type">

                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset id="supportive-staff" style="display: none" class="jumbotron shadow-sm">
                <legend>Supportive Staff Information</legend>
                <div class="form-row">
                    <div class="col-sm-4 form-group row">
                        <label class="col-sm-6 col-form-label" for="sup-staff-rank">Supportive Staff Rank</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" id="sup-staff-rank">
                                <option selected>Graduate Assistant I</option>
                                <option>Graduate Assistant II</option>
                                <option>Assistant Lecturer</option>
                                <option>Lecturer</option>
                                <option>Assistant Professor</option>
                                <option>Associate Professor</option>
                                <option>Professor</option>
                                <option>Other</option>
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>
            <button class="btn btn-dark float-right" type="submit">Submit</button>
        </form>
    </div>
@endsection
