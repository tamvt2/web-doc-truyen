@extends('layouts/index')

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

                <!-- Outer Row -->
                <div class="row justify-content-center mt-5">
                    <div class="col-xl-10 col-lg-12 col-md-9">
                        <div class="card-body p-0">
                            @include('layouts/alert')
                            <form class="user" method="post" action="">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="form-label ml-3">Tiêu đề của truyện</label>
                                    <select name="story_id" class="form-control">
                                        <option value="0" {{ $value->story_id == 0 ? 'selected' : '' }}>Chọn tiêu đề của truyện</option>
                                        @foreach($stories as $story)
                                            <option value="{{ $story->id }}" {{ $value->story_id == $story->id ? 'selected' : '' }}>{{ $story->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="form-label ml-3">Tên của chương</label>
                                    <input type="text" class="form-control form-control-user" name="title" placeholder="Nhập tên của chương" value="{{ $value->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="name" class="form-label ml-3">Nội dung của chương</label>
                                    <textarea class="form-control" name="content" placeholder="Nhập nội dung của chương" rows="10">{{ $value->content }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="form-label ml-3">Chương số</label>
                                    <input type="text" class="form-control form-control-user" name="chapter_number" placeholder="Nhập chương số" value="{{ $value->chapter_number }}">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Lưu
                                </button>
                            </form>
                        </div>
                    </div>

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
