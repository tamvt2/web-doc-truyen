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
                                    <input type="text" class="form-control form-control-user" name="title" placeholder="Nhập tiêu đề của truyện" value="{{ $value->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="name" class="form-label ml-3">Mô tả về truyện</label>
                                    <textarea class="form-control" id="content" name="description" rows="3" required placeholder="Nhập mô tả về truyện">{{ $value->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="form-label ml-3">Tên thể loại</label>
                                    <select name="genre_id" class="form-control">
                                        <option value="0" {{ $value->genre_id == 0 ? 'selected' : '' }}>Chọn thể loại</option>
                                        @foreach($genres as $genre)
                                            <option value="{{ $genre->id }}" {{ $value->genre_id == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label ml-3">Ảnh</label>
                                    <input type="file" name="file" class="form-control mb-3" id="upload">
                                    <div id="image_show"></div>
                                    <input type="hidden" name="cover_image" id="cover_image" value="{{ $value->cover_image }}">
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
