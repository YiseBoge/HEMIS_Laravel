@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Semester Overview</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col-sm-6 text-left">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href=""
                           data-toggle="modal" data-target="#confirmModal">
                            Shift to New Semester<i class="fas fa-hourglass-end text-white-50 fa-sm ml-2"></i>
                        </a>
                    </div>
                    <div class="col-sm-6 text-right">
                        New Available Semester :
                        @if (\App\User::adminInstance() != null)
                            <span class="mx-1 text-left text-primary">
                                {{ \App\User::adminInstance() }}
                            </span>
                        @else
                            <span class="mx-1 text-left text-muted">
                                No Semester Available
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="table-responsive col-12 py-3">
                        <table class="table table-bordered dataTable table-striped table-hover" id="dataTable"
                               width="100%"
                               cellspacing="0" role="grid" aria-describedby="dataTable_info"
                               style="width: 100%;">
                            <thead>
                            <tr role="row">
                                <th style="min-width: 50px; width: 50px"></th>
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending" width="15"
                                    style="width: 15%;">Name
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="p-0" id="delete-form"
                      method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        Changing the current semester will clear semester affect semester related data and will affect
                        all admins in this institution.
                    </div>

                    <div class="modal-footer">
                        <a class="btn btn-secondary shadow-sm" href="" data-dismiss="modal"> Cancel</a>
                        <a class="btn btn-primary shadow-sm" href="/institution/change-semester"> Proceed</a>
                    </div>

                    <input type="hidden" name="_method" value="DELETE">
                </form>
            </div>
        </div>
    </div>
@endSection