@extends('layouts/index')

@section('content')
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            @include('layouts/topbar')
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid w-75">
                <h3>{{ $title }}</h1>
                <div class="row">
                    @foreach($stories as $story)
                        <div class="w3-col s6 m-3 l3 list">
                            <a class="w3-hover-opacity" href="truyen/{{ $story['slug'] }}" title="{{ $story['title'] }}">
                                <img alt="{{ $story['title'] }}" class="list-thumbnail lazy loaded" height="208" width="157" src="{{ $story['cover_image'] }}" data-was-processed="true">
                            </a>
                            <div class="list-caption mt-1">
                                <h3>
                                    <a href="truyen/{{ $story['slug'] }}" title="{{ $story['title'] }}">{{ $story['title'] }}</a>
                                </h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website 2021</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
@endsection
