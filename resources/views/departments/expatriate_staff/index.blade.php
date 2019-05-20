@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="text-primary card-header">Expatriate Staff</div>
            <div class="card-body">
                <div class="row">
                    <div class="col p-3 m-3 text-center">
                        <a href="/department/expatriate-staff/create"
                           class="btn btn-outline-primary btn-sm mb-0">
                            Add<i class="fas fa-plus ml-2"></i></a>
                    </div>
                </div>
                <div class="row">

                    {!! Form::open(['action' => 'Department\ExaptriateStaffsController@index', 'method' => 'GET', 'class' => 'w-100']) !!}
                    <div class="form-row">
                        <div class="col-md-5 px-3 py-md-1 col">
                            <div class="form-group">
                                {!! Form::select('rank_level', \App\Models\Department\ExpatriateStaff::getEnum('StaffRanks') , $data['rank_level'] , ['class' => 'form-control', 'id' => 'add_education_level', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('rank_level', 'Rank Level', ['class' => 'form-control-placeholder', 'for' => 'education_level']) !!}
                            </div>
                        </div>


                    </div>
                    <div class="form-row">
                        <div class="col-md-5 px-3 py-md-1 col">
                            <select name="band_names" class="form-control" id="band_names">
                                @foreach ($data['bands'] as $band)
                                    <option value="{{ $band->id }}">{{ $band->band_name }}</option>
                                @endforeach
                            </select>
                            <label for="dormitory_service_type" class="form-control-placeholder">
                                Band Name
                            </label>
                            {{--{!! Form::select('band_names',$data['bands'],null, ['class' => 'form-control', 'id' => 'add_band_ name', 'onchange' => 'this.form.submit()']) !!}--}}
                            {{--{!! Form::label('band','Band',['class'=> 'form-control-placeholder','for'=>'add_band']) !!}--}}

                        </div>
                        <div class="col-md-5 px-3 py-md-1 col">
                            <div class="form-group">
                                <select name="college_names" class="form-control" id="college_names">
                                    @foreach ($data['colleges'] as $college)
                                        <option value="{{ $college->id }}">{{ $college->college_name }}</option>
                                    @endforeach
                                </select>
                                <label for="dormitory_service_type" class="form-control-placeholder">
                                    College Name
                                </label>
                                {{--{!! Form::select('college_names',$data['colleges'],null, ['class' => 'form-control', 'id' => 'add_college_name', 'onchange' => 'this.form.submit()']) !!}--}}
                                {{--{!! Form::label('college','College',['class'=> 'form-control-placeholder','for'=>'add_college']) !!}--}}

                            </div>

                        </div>


                    </div>
                    {!! Form::close() !!}

                </div>

                <div class="row">
                    <div class="table-responsive col-12 py-3">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered dataTable table-striped table-hover"
                                           id="dataTable"
                                           width="100%"
                                           cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                           style="width: 100%;">

                                        <thead>
                                        <tr role="row">
                                            <th style="min-width: 50px; width: 50px"></th>

                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Age: activate to sort column ascending"
                                            >Rank
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Age: activate to sort column ascending"
                                            >Male
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Age: activate to sort column ascending"
                                            >Female
                                            </th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['expatriate_staff'] as $upgrading_staff)
                                            <tr>
                                                <td class="text-center">
                                                    <a href=""
                                                       class="mr-2 d-inline text-primary"><i
                                                                class="far fa-edit"></i> </a>
                                                    <a href="" class="d-inline text-danger" data-toggle="modal"
                                                       data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                                    </a>
                                                </td>

                                                <td>{{ $upgrading_staff->staff_rank}}</td>
                                                <td>{{ $upgrading_staff->male_number }}</td>
                                                <td>{{ $upgrading_staff->female_number }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>


                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if ($data['page_name'] == 'departments.expatriate_staff.create')
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
    aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">

       <div class="modal-content">
           <div class="modal-header">
                   <form class="" action="/institution/non-admin" method="POST">
                       @csrf
                       <h3 class="font-weight-bold text-primary">Add Admin(Non Academic) Staff Member</h3>
                       <div class="row">
           </div>
           <div class="modal-body row p-2">
                   <div class="col-12">
                           <fieldset class="h-100">
                               

                               <div class="form-row pt-3">
                                       <div class="col-md form-group">
                                           
                                           <select class="form-control" id="staffRnk" name="staff_rank">
                                               @foreach ($data['staff_rank'] as $key => $value)
                                                   <option value="{{$key}}">{{$value}}</option>
                                               @endforeach
                                           </select>
                                           <label for="staffRnk" class="form-control-placeholder pt-3">Staff Rank</label>
                                       </div>
                                   </div>  

                               <div class="">
                                   <div class="form-row ptt-1">
                                       <div class="col form-group">
                                           <input type="text" id="no_of_females" name="number_of_females" class="form-control" required>
                                           <label class="form-control-placeholder" for="no_of_females">Females(Aggregate)</label>
                                       </div>

                                       <div class="col form-group">
                                           <input type="text" id="no_of_males" name="number_of_males" class="form-control" required>
                                           <label class="form-control-placeholder" for="no_of_males">Males(Aggregate)</label>
                                       </div>
                                   </div>
                               </div>  
                           </fieldset>
                       </div>
                   </div>    
           </div>
           <div class="modal-footer">
                   <button class="btn btn-outline-secondary float-right my-1" type="submit">Submit</button>
           </div>
       </div>

   </div>
</div>
    @endif

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
                    <a class="btn btn-danger" href="/institution/budget/delete">
                        Delete
                    </a>

                </div>
            </div>
        </div>
    </div>

@endSection