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
        {!! Form::open(['action' => 'Department\AcademicStaffController@store', 'method' => 'POST', 'class' => 'w-100']) !!}
        @csrf
        <div class="row my-5">
            <div class="col">
                <fieldset class="card shadow h-100">
                    <div class="card-header text-primary">
                        Upgrading Staff
                    </div>
                    <div class="card-body px-4">

                        <div class="form-group row pt-3">
                            <div class="form-group">
                                {!! Form::select('rank_level', \App\Models\Department\AcademicStaff::getEnum('StaffRanks') , $data['rank_level'] , ['class' => 'form-control', 'id' => 'add_education_level', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('rank_level', 'Rank Level', ['class' => 'form-control-placeholder', 'for' => 'education_level']) !!}
                            </div>
                        </div>
                        <div class="form-group row pt-3">

                            <div class="col form-group">

                                <select name="band_names" class="form-control" id="band_names">
                                    @foreach ($data['bands'] as $band)
                                        <option value="{{ $band->id }}">{{ $band->band_name }}</option>
                                    @endforeach
                                </select>
                                <label for="dormitory_service_type" class="form-control-placeholder">
                                    Band Name
                                </label>
                            </div>

                            <div class="col form-group">

                                <select name="college_names" class="form-control" id="college_names">
                                    @foreach ($data['colleges'] as $college)
                                        <option value="{{ $college->id }}">{{ $college->college_name }}</option>
                                    @endforeach
                                </select>
                                <label for="dormitory_service_type" class="form-control-placeholder">
                                    College Name
                                </label>
                            </div>

                            <div class="col form-group">

                                <select class="form-control" name="department" id="department">
                                    @foreach ($data['departments'] as $department)
                                        <option value="{{$department->id}}">{{$department->department_name}}</option>
                                    @endforeach
                                </select>
                                <label for="dormitory_service_type" class="form-control-placeholder">
                                    Department
                                </label>
                            </div>

                        </div>
                        <hr>

                        <div class="form-group row pt-3">
                            <div class="col form-group">
                                <input type="text" id="male_number" name="male_number" class="form-control" required>
                                <label class="form-control-placeholder" for="male_number">Number of Male Teacchers</label>
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
        {!! Form::close() !!}
    </div>
@endsection
