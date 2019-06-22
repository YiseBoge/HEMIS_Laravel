<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script
            src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
            crossorigin="anonymous"></script>

</head>

<body id="page-top">
<div id="app"></div>
<!-- Page Wrapper -->
<div id="wrapper">
    @isset($page_name)

    @else
        <div class="d-none">{{ $page_name = '1.2.3' }}</div>
@endisset


@guest
@else
    @include('inc.sidebar')
@endguest



<!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

        @include('inc.navbar')

        <!-- Begin Page Content -->
            <div class="container-fluid">

                @yield('content')

            </div>
            <!-- End of Page Content -->
        </div>
        <!-- End of Main Content -->

        @include('inc.footer')

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

@include('inc.logout_modal')

<script src="{{ asset('js/app.js') }}" defer></script>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });
</script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script>
    $(document).ready(function () {
        $('#exporter').on('click', function () {
            $('#printable').tableExport({type: 'excel'});
        })
    });
</script>


<script>


    $(document).ready(function () {
        $(".uncollapse").css("transition", "height 0s !important");

        @isset($page_name)
        @if(preg_split ("/\./", $page_name)[0] == 'enrollment')
        $("#collapseEnrollment").collapse("show");
        $("#collapseEnrollment").addClass("uncollapse");
        @elseif(preg_split ("/\./", $page_name)[0] == 'budgets')
        $("#collapseBudget").collapse("show");
        $("#collapseBudget").addClass("uncollapse");
        @elseif(preg_split ("/\./", $page_name)[0] == 'students')
        $("#collapseStudents").collapse("show");
        $("#collapseStudents").addClass("uncollapse");
        @elseif(preg_split ("/\./", $page_name)[0] == 'staff')
        $("#collapseStaff").collapse("show");
        $("#collapseStaff").addClass("uncollapse");
        @elseif(preg_split ("/\./", $page_name)[0] == 'report')
        $("#collapseReport").collapse("show");
        $("#collapseReport").addClass("uncollapse");
        @elseif(preg_split ("/\./", $page_name)[0] == 'administer')
        $("#collapseAdmin").collapse("show");
        $("#collapseAdmin").addClass("uncollapse");
        @endif
        @endisset

    });

</script>


</body>

</html>

