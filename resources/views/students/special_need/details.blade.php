@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="row">
            <div class="col-md-9">
                <h1 class="font-weight-bold text-primary">Special Need Student</h1>
            </div>
            <div class="col-md-2 pt-4">
                <a href="{{$student->id}}/edit" class="text-primary mr-3"><i class="far fa-edit"></i> Edit</a>
                <a href="" class="d-inline text-danger" data-toggle="modal"
                   data-target="#deleteModal"><i class="far fa-trash-alt"></i> Delete
                </a>
            </div>
        </div>

        <div class="row my-3">
            <div class="col">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Name</div>
                                <div class="mb-0 text-gray-800">{{$student->general->name}}</div>

                            </div>
                            <div class="col-md-4">
                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Sex</div>
                                <div class="mb-0 text-gray-800">{{$student->general->sex}}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Date of Birth
                                </div>
                                <div class="mb-0 text-gray-800">{{$student->general->birth_date}}</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Student ID</div>
                                <div class="mb-0 text-gray-800">{{$student->general->student_id}}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Phone Number
                                </div>
                                <div class="mb-0 text-gray-800">{{$student->general->phone_number}}</div>
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
                        <p>{{$student->department->college->band->bandName->band_name}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">College</div>
                        <p>{{$student->department->college->collegeName->college_name}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Department</div>
                        <p>{{$student->department->departmentName->department_name}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Program</div>
                        <p>{{$student->department->college->education_program}}</p>
                    </div>

                </div>
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Education Level</div>
                        <p>{{$student->department->college->education_level}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Year Level</div>
                        <p>{{$student->department->year_level}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Disability</div>
                        <p>{{$student->disability}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Student Type</div>
                        <p>{{$student->general->student_type}}</p>
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
                        <p>{{$student->general->studentService->food_service_type}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Dormitory Service</div>
                        <p>{{$student->general->studentService->dormitoryService->dormitory_service_type}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Block Number</div>
                        <p>{{$student->general->studentService->dormitoryService->block}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Room Number</div>
                        <p>{{$student->general->studentService->dormitoryService->room_no}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header text-primary">
                Remarks
            </div>
            <div class="card-body">
                <p>{{$student->general->remarks}}</p>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you wish to delete?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="/student/special-need/{{$student->id}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="form-control btn btn-danger">
                            <i class="far fa-trash-alt"></i> Delete
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
