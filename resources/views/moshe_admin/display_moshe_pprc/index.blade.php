@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">View PPRC </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            {{-- <div class="col text-right">
                                <a class="btn btn-outline-primary btn-sm mb-0" href="/moshe-admin/manage-bsc/create">Add<i
                                    class="fas fa-arrow-right ml-2"></i></a>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table border dataTable table-striped table-hover" id="dataTable" width="100%"
                                        cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                        style="width: 100%;">
                                    <thead>
                                    <tr role="row">
                                        <th style="min-width: 50px; width: 50px"></th>
                                        {{-- <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending" width="15"
                                            style="width: 15%;">Category
                                        </th> --}}
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                            >Policy
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            >KPI Indicator
                                        </th>

                                        {{-- <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            >Baseline
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            >Current
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            >Target
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            >Change
                                        </th> --}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                      @if (count($data['pprc_info']) > 0)
                                        @foreach ($data['pprc_info'] as $data)
                                            <tr role="row" class="odd" onclick="window.location='display-pprc/{{$data->id}}'">
                                                <td class="pl-4">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <a href="manage-pprc/{{$data->id}}/edit" class="text-primary"><i class="far fa-edit"></i> </a>
                                                        </div>
                                                        <div class="col-6">
                                                            <form class="p-0" action="/moshe-admin/manage-pprc/{{$data->id}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button type="submit" class="form-control form-control-plaintext text-danger p-0">
                                                                        <i class="far fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>


                                                </td>
                                                <td class="sorting_1">{{$data->category}}</td>
                                                <td>{{$data->policy}}</td>
                                                <td>{{$data->kpi_description}}</td>                                                                                   
                                                {{-- <td>{{$data->kpi_description}}</td>                                                                                   
                                                <td>{{$data->kpi_description}}</td>                                                                                   
                                                <td>{{$data->kpi_description}}</td>                                                                                    --}}
                                                {{-- <td>{{$data->female_number}}</td>                                                                                    --}}
                                            </tr>
                                        @endforeach
                                      @else
                                          
                                      @endif 

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    @if ($data['page_name'] == 'moshe_admin.manage_pprc_info.create')
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <div class="modal-header">
                        <form class="" action="/moshe-admin/manage-bsc" method="POST">
                            @csrf
                            <h3 class="font-weight-bold text-primary">Add PPRC Info</h3>
                            <div class="row">
                </div>
                <div class="modal-body row p-2">
                        <div class="col-12">
                                @if(count($errors) > 0)
                                @foreach($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{$error}}
                                    </div>
                                @endforeach
                                @endif
                                <fieldset class="h-100">
                                    <div class="form-row pt-3">
                                            <div class="col-md form-group">
                                                
                                                <select class="form-control" id="cat" name="categories">
                                                    @foreach ($data['categories'] as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="cat" class="form-control-placeholder pt-3">Category</label>
                                            </div>
                                        </div>  

                                    <div class="">
                                        <div class="row ptt-1">
                                            <div class="col-12 form-group">
                                                <input type="text" id="policy" name="policy" class="form-control" required>
                                                <label class="form-control-placeholder" for="policy">Policy</label>
                                            </div>
    
                                            <div class="col-12 form-group">
                                                <input type="text" id="kpi_indicator" name="kpi_indicator" class="form-control" required>
                                                <label class="form-control-placeholder" for="kpi_indicator">KPI Indicator</label>
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

    @if ($data['page_name'] == 'moshe_admin.manage_pprc_info.edit')
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
    aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">

       <div class="modal-content">
           <div class="modal-header">
                   <form class="" action="/moshe-admin/manage-bsc/{{$data['pprc_obj']->id}}" method="POST">
                       @csrf
                       <input type="hidden" name="_method" value="PUT">
                       <h3 class="font-weight-bold text-primary">Edit PPRC Info</h3>
                       <div class="row">
           </div>
           <div class="modal-body row p-2">
                   <div class="col-12">
                           @if(count($errors) > 0)
                           @foreach($errors->all() as $error)
                               <div class="alert alert-danger">
                                   {{$error}}
                               </div>
                           @endforeach
                           @endif
                           <fieldset class="h-100">
                               <div class="form-row pt-3">
                                       <div class="col-md form-group">
                                           
                                           <select class="form-control" id="cat" name="categories">
                                               @foreach ($data['categories'] as $key => $value)
                                                   <option value="{{$key}}">{{$value}}</option>
                                               @endforeach
                                           </select>
                                           <label for="cat" class="form-control-placeholder pt-3">Category</label>
                                       </div>
                                   </div>  

                               <div class="">
                                   <div class="row ptt-1">
                                       <div class="col-12 form-group">
                                           <input type="text" id="policy" name="policy" class="form-control" required value="{{$data['pprc_obj']->policy}}">
                                           <label class="form-control-placeholder" for="policy">Policy</label>
                                       </div>

                                       <div class="col-12 form-group">
                                           <input type="text" id="kpi_indicator" name="kpi_indicator" class="form-control" required value="{{$data['pprc_obj']->kpi_description}}">
                                           <label class="form-control-placeholder" for="kpi_indicator">KPI Indicator</label>
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

    </div>
    
@endsection
