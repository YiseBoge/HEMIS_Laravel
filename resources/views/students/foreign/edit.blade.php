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
        <form action="/student/foreign/{{$student->id}}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">

            <div class="row">
                <div class="col-md-10">
                    <h1 class="font-weight-bold text-primary">Foreigner Student</h1>
                </div>
                <div class="col-md-2 pt-3">
                    <button type="submit" class="form-control form-control-plaintext text-primary">
                        <i class="far fa-save mr-2"></i> Save
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
                                        <select class="form-control form-control-plaintext" name="sex">
                                            <option {{$student->general->sex == 'Male' ? 'selected' : ''}} value="Male">
                                                Male
                                            </option>
                                            <option {{$student->general->sex == 'Female' ? 'selected' : ''}} value="Female">
                                                Female
                                            </option>
                                        </select>

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

                                        <input type="date" class="form-control form-control-plaintext" name="birth_date"
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
                                        <input type="tel" class="form-control form-control-plaintext"
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
                        <div class="col-md-4">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Program</div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <label for="program" class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></label>
                                </div>
                                <select class="form-control form-control-plaintext" name="program" id="program">
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
                        <div class="col-md-4">
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
                        <div class="col-md-4">
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
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Nationality</div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                @include('inc.country_select', ['name' => 'nationality', 'default' => $student->nationality])
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Years in Ethiopia
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <input type="number" class="form-control form-control-plaintext"
                                       name="years_in_ethiopia"
                                       value="{{$student->years_in_ethiopia}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Student Type
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                <span class="input-group-text bg-white border-0"><i
                                            class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="student_type">
                                    @foreach ($student->general->getEnum("StudentType") as $key => $value)
                                        @if ($value == $student->general->student_type)
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
