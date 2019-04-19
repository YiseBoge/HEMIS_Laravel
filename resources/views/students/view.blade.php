@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="btn btn-outline-secondary btn-sm float-right mb-0" href="students/add">Add Student<i
                class="fas fa-arrow-right text-secondary ml-2"></i></a>
        <ul class="nav nav-tabs w-100">
            <li class="nav-item">
                <a class="nav-link active" href="#tab1" data-toggle="tab">Disabled Students</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tab2" data-toggle="tab">Foreigner Students</a>
            </li>
        </ul>


        <div class="tab-content py-4">

            <!--  Disabled Students Form  -->
            <div class="tab-pane active" id="tab1">

                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>ID</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Phone Number</th>
                        <th>Student Service</th>
                        <th>Disability Type</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td style="width: 15%;">Jhon</td>
                        <td>The</td>
                        <td>Ripper</td>
                        <td>JTR/1212/99</td>
                        <td>Male</td>
                        <td>22</td>
                        <td>+1254999999</td>
                        <td>In Cash</td>
                        <td>Visually Impared</td>
                    </tr>
                    <tr>
                        <td style="width: 15%;">Jhon</td>
                        <td>The</td>
                        <td>Ripper</td>
                        <td>JTR/1212/99</td>
                        <td>Male</td>
                        <td>22</td>
                        <td>+1254999999</td>
                        <td>In Cash</td>
                        <td>Visually Impared</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane" id="tab2">
                <table class="table table-striped table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>ID</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Phone Number</th>
                        <th>Nationality</th>
                        <th>Student Service</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td style="width: 15%;">Jhon</td>
                        <td>The</td>
                        <td>Ripper</td>
                        <td>JTR/1212/99</td>
                        <td>Male</td>
                        <td>22</td>
                        <td>+1254999999</td>
                        <td>Martian</td>
                        <td>In Cash</td>
                    </tr>
                    <tr>
                        <td style="width: 15%;">Jhon</td>
                        <td>The</td>
                        <td>Ripper</td>
                        <td>JTR/1212/99</td>
                        <td>Male</td>
                        <td>22</td>
                        <td>+1254999999</td>
                        <td>Martian</td>
                        <td>In Cash</td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>


    </div>
@endsection
