@extends('layouts.index')

@section('content')
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    @include('layouts/sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            @include('layouts/topbar')
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container">

                <table class="table table-fixed">
                    <thead>
                        <tr>
                            <th class="w-5">ID</th>
                            <th class="w-15">Username</th>
                            <th class="w-25">Tiêu đề của truyện</th>
                            <th>Nội dung của bình luận</th>
                            <th class="w-20">Thời gian tạo bản ghi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($values) && !empty($values))
                            @foreach($values as $key => $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->title }}</td>
                                    <td>{{ $value->content }}</td>
                                    <td>{{ $value->created_at }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="card-footer clearfix">
                    @if (isset($values) && !empty($values))
                        {!! $values->links() !!}
                    @endif
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
