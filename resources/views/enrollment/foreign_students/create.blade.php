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
        <form class="pb-5" action="/enrollment/foreign-students" method="POST">
            @csrf
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                                Foreign Students Enrollment
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <select class="form-control" name="reason" id="reason">
                                        @foreach ($reasons as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="reason" class="form-control-placeholder">
                                            Reason
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row pt-3">
                                    <div class="col form-group">
                                        <select class="form-control" name="band" id="band">
                                            @foreach ($bands as $band)
                                                <option value="{{$band->band_name}}">{{$band->band_name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="band" class="form-control-placeholder">
                                                Band
                                            </label>
                                    </div>
                
                                    <div class="col form-group">
                                        
                                        <select class="form-control" name="department" id="department">
                                            @foreach ($departments as $department)
                                                <option value="{{$department->department_name}}">{{$department->department_name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="department" class="form-control-placeholder">
                                                Department
                                            </label>
                                    </div>
                                    <div class="col form-group">
                                        
                                        <select class="form-control" name="college" id="college">
                                            @foreach ($colleges as $college)
                                                <option value="{{$college->college_name}}">{{$college->college_name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="college" class="form-control-placeholder">
                                                College
                                            </label>
                                    </div>
                                </div>
                                <div class="form-group row pt-3">
                                        <div class="col-md-4 form-group">
                                            
                                            <select class="form-control" name="program" id="program">
                                                @foreach ($programs as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                            <label for="program" class="form-control-placeholder">
                                                    Program
                                                </label>
                                        </div>

                                        <div class="col-md-5 form-group">
                                    
                                            <select class="form-control" name="education_level" id="level">
                                                @foreach ($education_levels as $key => $value)
                                                @if ($key == 'SPECIALIZATION')
                                                    <option disabled value="{{$key}}">{{$value}}</option>
                                                @else
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <label for="dormitory_service_type" class="form-control-placeholder">
                                                Education Level
                                            </label>
                                        </div>
                    
                                        <div class="col-md-3 form-group">
                                            
                                            <select class="form-control" name="year_level" id="year_level">
                                                @foreach ($year_levels as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                            <label for="year_level" class="form-control-placeholder">
                                                    Year Level
                                                </label>
                                        </div>
                                       
                    
                                    </div>
                                <hr>

                        <div class="form-group row pt-3">
                            <div class="col form-group">
                                <input type="text" id="male_number" name="male_number" class="form-control" required>
                                <label class="form-control-placeholder" for="male_number">Number of Male Students</label>
                            </div>
        
                            <div class="col form-group">
                                <input type="text" id="female_number" name="female_number" class="form-control" required>
                                <label class="form-control-placeholder" for="female_number">Number of Female Students</label>
                            </div>
                        </div>
                        </div>
                    </div>
                    </fieldset>
                </div>               

            <input type="submit" class="btn btn-outline-secondary float-right my-1" value="Submit">
        </form>
    </div>
@endsection
