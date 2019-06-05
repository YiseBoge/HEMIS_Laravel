@extends('layouts.app')

@section('content')
    <div class="container-fluid">
    <!--  Disabled Students Form  -->
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
        @endif
        <form class="pb-5" action="/student/foreign" method="POST">
            @csrf
            <h3 class="font-weight-bold text-primary">Add Foreign Student</h3>
            <hr>
            <div class="row my-5">
                <div class="col-md-5">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                                Academic Information
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group row pt-3">
                                <div class="col form-group">                                    
                                    <select class="form-control" name="education_level" id="level">
                                        @foreach ($education_levels as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="dormitory_service_type" class="form-control-placeholder">
                                        Education Level
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row pt-3">
                                <div class="col-md-6 form-group">                                    
                                    <select class="form-control" name="program" id="program">
                                        @foreach ($programs as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="service_type" class="form-control-placeholder">
                                            Program
                                        </label>
                                </div>

                                <div class="col-md-6 form-group">                                    
                                    <select class="form-control" name="year_level" id="year_level">
                                        @for ($i = 1; $i < 7; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                    <label for="dormitory_service_type" class="form-control-placeholder">
                                            Year Level
                                        </label>
                                </div>
            
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-7">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                                Personal Information
                        </div>
                        <div class="card-body px-4">
                            <div class="form-row">
                                <div class="col-md form-group">
                                    <input type="text" id="name" name="name" class="form-control" required>
                                    <label class="form-control-placeholder" for="name">Name</label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row pt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        
                                        <input class="form-control" id="bdate" name="birth_date" type="date" placeholder="2011-08-19">
                                        <label for="bdate" class="form-control-placeholder">
                                            Date of Birth
                                        </label>
                                    </div>                       
                                    <hr>
                                    <div class="form-group">
                                        <input type="text" id="student_id" name="student_id" class="form-control" required>
                                        <label class="form-control-placeholder" for="student_id">Student ID</label>
                                       
                                    </div>
                                </div>
                                
                                <div class="col-md-6 pl-md-5">
                                    <div class="form-group">
                                        <div>
                                            <label class="radio-inline"><input class="d-inline-block m-2 form-check-inline"
                                                                                type="radio"
                                                                                name="sex" value="Male">Male</label>
                                            <label class="radio-inline"><input class="d-inline-block m-2 form-check-inline"
                                                                                type="radio"
                                                                                name="sex" value="Female">Female</label>
                                        </div>
                                    </div>                        
                                    <hr>
                                    <div class="form-group">
                                        <input type="text" id="phoneno" name="phone_number" class="form-control" required>
                                        <label class="form-control-placeholder" for="phoneno">Phone Number</label>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>

            <fieldset class="card shadow my-5">
                <div class="card-header text-primary">
                        Student Service Information
                </div>
                <div class="card-body px-4">
                    <div class="form-group row pt-3" id="student_service">
                        <div class="col-md-6 form-group">
                            
                            <select class="form-control" name="food_service_type" id="food_service_type">
                                @foreach ($food_service_types as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                            <label for="service_type" class="form-control-placeholder">
                                Food Service Type
                            </label>
                        </div>

                        <div class="col-md-6 form-group">
                            
                            <select class="form-control" name="dormitory_service_type" id="dormitory_service_type">
                                @foreach ($dormitory_service_types as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                            <label for="dormitory_service_type" class="form-control-placeholder">
                                    Dormitory Service Type
                                </label>
                        </div>
                    </div>
                    <hr>

                    <div class="form-group row" id="dormitory_info">
                        <!-- this drop down is going to be changed -->
                        <div class="col-md-6 form-group">
                            <input type="text" id="block_number" name="block_number" class="form-control" required>
                            <label class="form-control-placeholder" for="block_number">Block No</label>
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="text" id="room_number" name="room_number" class="form-control" required>
                            <label class="form-control-placeholder" for="room_number">Room No</label>
                        </div>
                    </div>
                    
                </div>
            </fieldset>

            <fieldset class="card shadow h-100 my-5">
                <div class="card-header text-primary">
                        Foreign Student Information
                </div>
                <div class="card-body px-4">
                    <div class="form-group row pt-3">
                        <div class="col-md-6 form-group">
                            <input type="text" id="nationality" name="nationality" class="form-control" required>
                            <label class="form-control-placeholder" for="nationality">Nationality</label>
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="text" id="years_in_ethiopia" name="years_in_ethiopia" class="form-control" required>
                            <label class="form-control-placeholder" for="years_in_ethiopia">Years in Ethiopia</label>
                        </div>
                        </div>
                    <hr>
                    <div class="form-group row pt-3">
                        <div class="col form-group">
                            
                            <textarea class="form-control" name="additional_remarks" id="additional_remarks" rows="3"></textarea>
                            <label for="additional_remarks" class="form-control-placeholder">
                                Additional Remarks
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <input type="submit" class="btn btn-outline-secondary float-right my-1" value="Submit">
        </form>
    </div>
@endsection

