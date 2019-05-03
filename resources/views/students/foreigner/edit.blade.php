@extends('layouts.app')

@section('content')
    <div class="container">
       
        <form action="" class="col-12">
            <h3 class="font-weight-bold text-primary">Add Foreigner Student</h3>
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
                            <input type="text" id="student_id" class="form-control" required>
                            <label class="form-control-placeholder" for="student_id">Student Id</label>
                        </div>
                        <hr>
                        <div class="form-group">
                            <input type="text" id="phoneno" class="form-control" required>
                            <label class="form-control-placeholder" for="phoneno">Phone Number</label>
                        </div>                        
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
                        <div class="form-group">
                            <input type="text" id="nationality" class="form-control" required>
                            <label class="form-control-placeholder" for="nationality">Nationality</label>
                        </div>
                        <hr>
                        <div class="form-group">
                            <input type="text" id="years_in_ethiopia" class="form-control" required>
                            <label class="form-control-placeholder" for="years_in_ethiopia">Years in Ethiopia</label>
                        </div>                       
                    </div>
                </div>
            </fieldset>

            <fieldset class="jumbotron shadow py-4">
                <legend class="text-primary">Academic Information</legend>
                <div class="form-group row">
                    <div class="col-md-6 form-group">
                        <label for="service_type">
                            Band
                        </label>
                        <select class="form-control" name="food_service_type" id="food_service_type">
                            <option value="kind">Engineering and Technology </option>
                            <option value="cash"> Business and Economics</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="dormitory_service_type">
                            Department
                        </label>
                        <select class="form-control" name="dormitory_service_type" id="dormitory_service_type">
                            <option value="kind">Civil, Construction & Transport engineering</option>
                            <option value="cash">Environmental engineering</option>
                        </select>
                    </div>

                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-md-4 form-group">
                        <label for="service_type">
                            Program
                        </label>
                        <select class="form-control" name="food_service_type" id="food_service_type">
                            <option value="kind">Daytime</option>
                            <option value="cash">Extension</option>
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="dormitory_service_type">
                            Education Level
                        </label>
                        <select class="form-control" name="dormitory_service_type" id="dormitory_service_type">
                            <option value="kind">Under Graduate</option>
                            <option value="cash">Post Graduate</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="dormitory_service_type">
                            Year Level
                        </label>
                        <select class="form-control" name="dormitory_service_type" id="dormitory_service_type">
                            <option value="kind">1</option>
                            <option value="cash">2</option>
                        </select>
                    </div>

                </div>
                
            </fieldset>            

            <fieldset class="jumbotron shadow  py-4">
                <legend class="text-primary">Student Service Info</legend>

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
                        <input type="text" id="block_number" class="form-control" required>
                        <label class="form-control-placeholder" for="block_number">Block No</label>
                    </div>
                    <div class="col-md-6 form-group">
                        <input type="text" id="room_number" class="form-control" required>
                        <label class="form-control-placeholder" for="room_number">Room No</label>
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


@endsection

