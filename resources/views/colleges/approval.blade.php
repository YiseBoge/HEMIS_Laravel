@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Approval</h6>
            </div>
            <div class="card-body">
                <div class="row m-3">
                    <div class="col-md-6">
                        <form action="approval" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="department">
                                <button type="submit"
                                        class="btn btn-sm btn-primary shadow-sm">
                                    Approve All Department Data<i
                                            class="fas fa-check text-white-50 ml-2 fa-sm"></i>
                                </button>
                            </form>
                    </div>
                    <div class="col-md-6">
                        <form action="approval" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="college">
                                <button type="submit"
                                        class="btn btn-sm btn-primary shadow-sm">
                                    Approve All College Data<i
                                            class="fas fa-check text-white-50 ml-2 fa-sm"></i>
                                </button>
                            </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endSection
