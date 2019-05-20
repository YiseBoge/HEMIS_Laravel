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
        <form class="pb-5" action="/department/expatriate-staff" method="POST">
            @csrf
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                                Teachers
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group row pt-3">
                                   
                                    <div class="col form-group">
                                        <select class="form-control" name="band" id="band">
                                            @foreach ($data['bands'] as $band)
                                                <option value="{{$band->band_name}}">{{$band->band_name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="band" class="form-control-placeholder">
                                                Band
                                            </label>
                                    </div>
                                    <div class="col form-group">
                                        <select class="form-control" name="college" id="college">
                                            @foreach ($data['colleges'] as $college)
                                                <option value="{{$college->college_name}}">{{$college->college_name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="college" class="form-control-placeholder">
                                                College
                                            </label>
                                    </div>  
                            </div>
                            <div class="form-group row pt-3">
                                <div class="col-md-6 form-group">
                                    <select class="form-control" name="department" id="department">
                                        @foreach ($data['departments'] as $department)
                                            <option value="{{$department->department_name}}">{{$department->department_name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="department" class="form-control-placeholder">
                                            Department
                                        </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <select class="form-control" name="staff_rank" id="staff_rank">
                                        @foreach ($data['staff_rank'] as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="education_level" class="form-control-placeholder">
                                            Staff Rank
                                        </label>
                                </div>              
                            </div>


                        <div class="form-group row pt-3">
                            <div class="col form-group">
                                <input type="text" id="male_number" name="male_number" class="form-control" required>
                                <label class="form-control-placeholder" for="male_number">Number of Male Teachers</label>
                            </div>
        
                            <div class="col form-group">
                                <input type="text" id="female_number" name="female_number" class="form-control" required>
                                <label class="form-control-placeholder" for="female_number">Number of Female Teachers</label>
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

