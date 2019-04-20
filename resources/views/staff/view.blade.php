@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="btn btn-outline-secondary btn-sm float-right mb-0" href="staff/add">Add Staff Member<i
                class="fas fa-arrow-right text-secondary ml-2"></i></a>
        <ul class="nav nav-tabs w-100">
            <li class="nav-item">
                <a class="nav-link active" href="#tab1" data-toggle="tab">Academic Staff</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tab2" data-toggle="tab">Technical Staff</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tab3" data-toggle="tab">Administrative Staff</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tab4" data-toggle="tab">ICT Staff</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tab5" data-toggle="tab">Supportive Staff</a>
            </li>
        </ul>


        <div class="tab-content py-4">

            <div class="tab-pane active" id="tab1">
                <table class="table table-striped table-hover ">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Job Title</th>
                        <th>Is Expatriate</th>
                        <th>Dedication</th>
                        <th>Academic Level</th>
                        <th>Employment Type</th>
                        <th>Service Year</th>
                        <th>Field of Study</th>
                        <th>Teaching Load</th>
                        <th>Staff Rank</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr onclick="window.location='add.html';">
                        <td style="width: 15%;">1</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    <tr onclick="window.location='add.html';">
                        <td>John Doe John</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    <tr onclick="window.location='add.html';">
                        <td>John Doe John</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="tab2">
                <table class="table table-striped table-hover ">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Job Title</th>
                        <th>Is Expatriate</th>
                        <th>Dedication</th>
                        <th>Academic Level</th>
                        <th>Employment Type</th>
                        <th>Service Year</th>
                        <th>Field of Study</th>
                        <th>Teaching Load</th>
                        <th>Staff Rank</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr onclick="window.location='add.html';">
                        <td style="width: 15%;">1</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    <tr onclick="window.location='add.html';">
                        <td>John Doe John</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    <tr onclick="window.location='add.html';">
                        <td>John Doe John</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="tab3">
                <table class="table table-striped table-hover ">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Job Title</th>
                        <th>Is Expatriate</th>
                        <th>Dedication</th>
                        <th>Academic Level</th>
                        <th>Employment Type</th>
                        <th>Service Year</th>
                        <th>Field of Study</th>
                        <th>Teaching Load</th>
                        <th>Staff Rank</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr onclick="window.location='add.html';">
                        <td style="width: 15%;">1</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    <tr onclick="window.location='add.html';">
                        <td>John Doe John</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    <tr onclick="window.location='add.html';">
                        <td>John Doe John</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="tab4">
                <table class="table table-striped table-hover ">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Job Title</th>
                        <th>Is Expatriate</th>
                        <th>Dedication</th>
                        <th>Academic Level</th>
                        <th>Employment Type</th>
                        <th>Service Year</th>
                        <th>Field of Study</th>
                        <th>Teaching Load</th>
                        <th>Staff Rank</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr onclick="window.location='add.html';">
                        <td style="width: 15%;">1</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    <tr onclick="window.location='add.html';">
                        <td>John Doe John</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    <tr onclick="window.location='add.html';">
                        <td>John Doe John</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="tab5">
                <table class="table table-striped table-hover ">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Job Title</th>
                        <th>Is Expatriate</th>
                        <th>Dedication</th>
                        <th>Academic Level</th>
                        <th>Employment Type</th>
                        <th>Service Year</th>
                        <th>Field of Study</th>
                        <th>Teaching Load</th>
                        <th>Staff Rank</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr onclick="window.location='add.html';">
                        <td style="width: 15%;">1</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    <tr onclick="window.location='add.html';">
                        <td>John Doe John</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    <tr onclick="window.location='add.html';">
                        <td>John Doe John</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection
