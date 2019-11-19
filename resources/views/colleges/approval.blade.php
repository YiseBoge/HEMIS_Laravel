@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Complete Approval</h6>
            </div>
            <div class="card-body">
                <div class="row m-4">
                    <div class="col-md-7"> Approve all Data input by Department Admins</div>
                    <div class="col-md-5">
                        <form action="approval" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="department">
                            <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                                Approve All<i class="fas fa-check text-white-50 ml-2 fa-sm"></i>
                                </button>
                            </form>
                    </div>
                </div>
                <div class="row m-4">
                    <div class="col-md-7"> Approve all Data input by the College Admin</div>
                    <div class="col-md-5">
                        <form action="approval" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="college">
                            <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                                Approve All<i class="fas fa-check text-white-50 ml-2 fa-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endSection
