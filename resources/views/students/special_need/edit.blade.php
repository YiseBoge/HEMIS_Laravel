@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
        @endif
        <form action="/student/special-need/{{$student->id}}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">

            <div class="row">
                <div class="col-md-10">
                    <h1 class="font-weight-bold text-primary">Special Need Student</h1>
                </div>
                <div class="col-md-2 pt-3">
                    <button type="submit" class="form-control form-control-plaintext text-primary">
                        <i class="far fa-save mr-2"></i></i> Save
                    </button>
                </div>
            </div>

            <div class="row my-3">
                <div class="col">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Name</div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0"><i
                                                        class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext" name="name"
                                               value="{{$student->general->name}}">

                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Sex</div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0"><i
                                                        class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext" name="sex"
                                               value="{{$student->general->sex}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Date of
                                        Birth
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0"><i
                                                        class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext" name="birth_date"
                                               value="{{$student->general->birth_date}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Student ID
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0"><i
                                                        class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext" name="student_id"
                                               value="{{$student->general->student_id}}">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Phone
                                        Number
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0"><i
                                                        class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext"
                                               name="phone_number" value="{{$student->general->phone_number}}">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header text-primary">
                    Student Information
                </div>
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Band</div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="band">
                                    @foreach ($bands as $band)
                                        @if ($band->band_name == $student->department->college->band->bandName->band_name)
                                            <option selected value="{{$band->band_name}}">{{$band->band_name}}</option>
                                        @else
                                            <option value="{{$band->band_name}}">{{$band->band_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">College</div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                <span class="input-group-text bg-white border-0"><i
                                            class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="college">
                                    @foreach ($colleges as $college)
                                        @if ($college->college_name == $student->department->college->college_name)
                                            <option selected
                                                    value="{{$college->college_name}}">{{$college->college_name}}</option>
                                        @else
                                            <option value="{{$college->college_name}}">{{$college->college_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Department</div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="department">
                                    @foreach ($departments as $department)
                                        @if ($department->department_name == $student->department->departmentName->department_name)
                                            <option selected
                                                    value="{{$department->department_name}}">{{$department->department_name}}</option>
                                        @else
                                            <option value="{{$department->department_name}}">{{$department->department_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Program</div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="program">
                                    @foreach ($student->department->college->getEnum("EducationPrograms") as $key => $value)
                                        @if ($value == $student->department->college->education_program)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Education Level
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="education_level">
                                    @foreach ($student->department->college->getEnum("EducationLevels") as $key => $value)
                                        @if ($value == $student->department->college->education_level)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Year Level</div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="year_level">
                                    @for ($i = 1; $i < 8; $i++)
                                        @if ($i == $student->department->year_level)
                                            <option selected value="{{$i}}">{{$i}}</option>
                                        @else
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endif
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Disability</div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="disability_type">
                                    @foreach ($student->getEnum("Disabilitys") as $key => $value)
                                        @if ($value == $student->disability)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header text-primary">
                    Student Service Information
                </div>
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Food Service</div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="food_service_type">
                                    @foreach ($student->general->studentService->getEnum("FoodServiceTypes") as $key => $value)
                                        @if ($value == $student->general->studentService->food_service_type)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Dormitory Service
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="dormitory_service_type">
                                    @foreach ($student->general->studentService->dormitoryService->getEnum("DormitoryServiceTypes") as $key => $value)
                                        @if ($value == $student->general->studentService->dormitoryService->dormitory_service_type)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Block Number</div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <input type="text" class="form-control form-control-plaintext" name="block_number"
                                       value="{{$student->general->studentService->dormitoryService->block}}">

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Room Number</div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <input type="text" class="form-control form-control-plaintext" name="room_number"
                                       value="{{$student->general->studentService->dormitoryService->room_no}}">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header text-primary">
                    Remarks
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <textarea class="form-control" id="additional_remarks" name="additional_remarks"
                                  rows="3">{{$student->general->remarks}}</textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
