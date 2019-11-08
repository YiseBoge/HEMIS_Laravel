@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Final Approval</h6>
            </div>
            <div class="card-body">
                <div class="row m-4">
                    <div class="col-md-7"> Re-approve all data Approved by College Super Admins</div>
                    <div class="col-md-5">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="approval/approve">
                            Approve All<i class="fas fa-check-double text-white-50 ml-2 fa-sm"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endSection
