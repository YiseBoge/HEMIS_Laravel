@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ Auth::user()->hasRole('University Admin') ? 'College Super Admins' : 'Administrative Admins' }}</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 mx-2 shadow-sm" href="/college-admin/generate">Auto
                            Generate<i
                                    class="fas fa-magic text-white-50 fa-sm ml-2"></i></a>
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/college-admin/create">New Entry<i
                                    class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive col-12 py-3">
                        <table class="table table-bordered dataTable table-striped table-hover"
                               id="dataTable"
                               width="100%"
                               cellspacing="0" role="grid" aria-describedby="dataTable_info"
                               style="width: 100%;">

                            <thead>
                            <tr role="row">
                                <th style="min-width: 50px; width: 50px"></th>
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending"
                                >Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >College
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >Email
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($editors as $editor)
                                <tr>
                                    <td class="text-center">
                                        <div class="row px-0">
                                                <div class="col px-0">
                                                    <form class="p-0"
                                                            action="/college-admin/{{$editor->id}}/edit"
                                                            method="GET">
                                                        <button type="submit"
                                                                class="btn btn-primary btn-circle text-white btn-sm mx-0"
                                                                style="opacity:0.80"
                                                                data-toggle="tooltip" title="Edit">
                                                            <i class="fas fa-pencil-alt fa-sm"
                                                                style="opacity:0.75"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            <div class="col px-0">
                                                <button type="submit"
                                                        class="btn btn-danger btn-circle text-white btn-sm mx-0 deleter"
                                                        style="opacity:0.80" data-id="{{$editor->id}}"
                                                        data-toggle="tooltip" title="Delete">
                                                    <i class="fas fa-trash fa-sm"
                                                       style="opacity:0.75"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $editor->name }}</td>
                                    <td>{{ $editor->collegeName->college_name }}</td>
                                    <td>{{ $editor->email }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endSection
