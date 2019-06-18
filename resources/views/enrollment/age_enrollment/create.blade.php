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
        <form class="pb-5" action="/enrollment/age-enrollment" method="POST">
            @csrf
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                                Enrollment
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group row pt-3">
                                <div class="col-md form-group">                                                
                                    <select class="form-control" id="ageRange" name="age_range">
                                        @foreach ($age_range as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="empType" class="form-control-placeholder pt-3">Age Range</label>
                                </div>
                            </div>
                            
                            <div class="form-group row pt-3">
                                <div class="col-md-4 form-group">
                                    
                                    <select class="form-control" name="program" id="program">
                                        @foreach ($programs as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="service_type" class="form-control-placeholder">
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
                                    <label for="dormitory_service_type" class="form-control-placeholder">
                                            Year Level
                                        </label>
                                </div>
            
                            </div>
                            <hr>

                        <div class="form-group row pt-3">
                            <div class="col form-group">
                                <input type="text" id="number_of_males" name="number_of_males" class="form-control" required>
                                <label class="form-control-placeholder" for="number_of_males">Number of Male Students</label>
                            </div>
        
                            <div class="col form-group">
                                <input type="text" id="number_of_females" name="number_of_females" class="form-control" required>
                                <label class="form-control-placeholder" for="number_of_females">Number of Female Students</label>
                            </div>
                        </div>
                        </div>
                    </fieldset>
                    </div>

                </div>               

            <input type="submit" class="btn btn-outline-secondary float-right my-1" value="Submit">
        </form>
    </div>
@endsection

