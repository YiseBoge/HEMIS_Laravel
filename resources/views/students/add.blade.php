@extends('layouts.app')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs w-100">
            <li class="nav-item">
                <a class="nav-link active" href="#tab1" data-toggle="tab">Disabled Students</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tab2" data-toggle="tab">Foreigner Students</a>
            </li>
        </ul>


        <div class="tab-content py-4">

            <!--  Disabled Students Form  -->
            <div class="tab-pane active" id="tab1">
                <form action="" class="col-12">
                    <h3>Add Disabled Student</h3>
                    <hr>
                    <fieldset class="jumbotron shadow">
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
                                <input type="text" id="grand_father_name" name="grand_father_name"
                                       class="form-control mx-1"
                                       placeholder="Grand Father's Name">
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <input class="form-control" id="student_id" type="text" placeholder="Student ID">
                                <hr>
                                <input class="form-control " id="phoneno" type="tel" placeholder="Phone Number">
                            </div>
                            <div class="col-md-6 pl-md-5">
                                <label class="ml-2">
                                    Sex
                                </label>
                                <div>
                                    <label class="radio-inline"><input class="d-inline-block m-2 form-check-inline"
                                                                       type="radio"
                                                                       name="sex" value="Male">Male</label>
                                    <label class="radio-inline"><input class="d-inline-block m-2 form-check-inline"
                                                                       type="radio"
                                                                       name="sex" value="Female">Female</label>
                                </div>
                                <hr>
                                <label for="bdate">
                                    Date of Birth
                                </label>
                                <input class="form-control" id="bdate" type="date" placeholder="2011-08-19">
                            </div>
                        </div>
                    </fieldset>


                    <fieldset class="jumbotron shadow">
                        <legend>Student Service Info</legend>

                        <div class="form-group row" id="student_service">
                            <div class="col-md-6 form-group">
                                <label for="service_type">
                                    Food Service Type
                                </label>
                                <select class="form-control" name="food_service_type" id="food_service_type">
                                    <option value="kind">In Kind</option>
                                    <option value="cash">In Cash</option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="dormitory_service_type">
                                    Dormitory Service Type
                                </label>
                                <select class="form-control" name="dormitory_service_type" id="dormitory_service_type">
                                    <option value="kind">In Kind</option>
                                    <option value="cash">In Cash</option>
                                </select>
                            </div>

                        </div>
                        <hr>
                        {{--                                <label for="student_service" class="label-secondary">Dormitory Info</label>--}}
                        <div class="form-group row" id="dormitory_info">

                            <!-- this drop down is going to be changed -->
                            <div class="col-md-6 form-group">
                                <input type="text" name="block_number" class="form-control"
                                       placeholder="Block No">
                            </div>

                            <div class="col-md-6 form-group">
                                <input type="text" name="room_number" class="form-control"
                                       placeholder="Room No">
                            </div>

                        </div>

                    </fieldset>


                    <fieldset class="jumbotron shadow">
                        <legend>Disability Information</legend>

                        <div class="form-group row">
                            <div class="col-md-6 form-group">
                                <label for="service_type">
                                    Disability Type
                                </label>
                                <select class="form-control" name="disability_type" id="disability_type">
                                    <option value="">A</option>
                                    <option value="">B</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col form-group">
                                <label for="additional_remarks">
                                    Additional Remarks
                                </label>
                                <textarea class="form-control" name="" id="additional_remarks" rows="5"></textarea>
                            </div>
                        </div>

                    </fieldset>

                    <input type="submit" class="btn btn-outline-secondary float-right my-1" value="Submit">
                </form>
            </div>

            <div class="tab-pane" id="tab2">

                <form action="" class="col-12">
                    <h3>Add Foreigner Student</h3>
                    <hr>
                    <fieldset class="jumbotron shadow-sm">
                        <legend>Personal Information</legend>



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
                            <div class="col-md-6 form-group">
                                <input class="form-control" id="student_id" type="text" placeholder="Student ID">
                                <hr>
                                <input class="form-control " id="phoneno" type="text" placeholder="Phone Number">
                                <hr>
                                <label for="bdate">
                                    Date of Birth
                                </label>
                                <input class="form-control" id="bdate" type="date" placeholder="2011-08-19">
                            </div>
                            <div class="col-md-6 pl-md-5">
                                <label class="ml-2">
                                    Sex
                                </label>
                                <div>
                                    <label class="radio-inline"><input class="d-inline-block m-2 form-check-inline"
                                                                       type="radio"
                                                                       name="sex" value="Male">Male</label>
                                    <label class="radio-inline"><input class="d-inline-block m-2 form-check-inline"
                                                                       type="radio"
                                                                       name="sex" value="Female">Female</label>
                                </div>

                                <hr>
                                <input class="form-control" id="nationality" type="text" placeholder="Nationality">
                                <hr>
                                <input class="form-control" id="years_in_ethiopia" type="number"
                                       placeholder="Years in Ethiopia">

                            </div>
                        </div>
                    </fieldset>


                    <fieldset class="jumbotron shadow">
                        <legend>Student Service Info</legend>

                        <div class="form-group row" id="student_service">
                            <div class="col-md-6 form-group">
                                <label for="service_type">
                                    Food Service Type
                                </label>
                                <select class="form-control" name="food_service_type" id="food_service_type">
                                    <option value="kind">In Kind</option>
                                    <option value="cash">In Cash</option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="dormitory_service_type">
                                    Dormitory Service Type
                                </label>
                                <select class="form-control" name="dormitory_service_type" id="dormitory_service_type">
                                    <option value="kind">In Kind</option>
                                    <option value="cash">In Cash</option>
                                </select>
                            </div>

                        </div>
                        <hr>
                        {{--                                <label for="student_service" class="label-secondary">Dormitory Info</label>--}}
                        <div class="form-group row" id="dormitory_info">

                            <!-- this drop down is going to be changed -->
                            <div class="col-md-6 form-group">
                                <input type="text" name="block_number" class="form-control"
                                       placeholder="Block No">
                            </div>

                            <div class="col-md-6 form-group">
                                <input type="text" name="room_number" class="form-control"
                                       placeholder="Room No">
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col form-group">
                                <label for="additional_remarks">
                                    Additional Remarks
                                </label>
                                <textarea class="form-control" name="" id="additional_remarks" rows="5"></textarea>
                            </div>
                        </div>

                    </fieldset>

                    <input type="submit" class="btn btn-outline-secondary float-right my-1" value="Submit">
                </form>

            </div>


        </div>
@endsection

