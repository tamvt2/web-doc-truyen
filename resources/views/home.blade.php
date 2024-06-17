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
                @if(Request::is('truyen/*'))
                    @if (isset($story) && !empty($story))
                        @php $id = $story->id @endphp
                        <div class="card mb-4">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="{{ $story->cover_image }}" class="card-img" alt="{{ $story->title }}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body d-flex flex-column h-100">
                                        <h4 class="card-title text-center">{{ $story->title }}</h4>
                                        <h6 class="card-text">
                                            <small class="text-muted">
                                                <i class="fa fa-user" aria-hidden="true"></i> Tác giả: {{ $story->username }}
                                            </small>
                                        </h6>
                                        <h6 class="card-text">
                                            <small class="text-muted">
                                                <i class="fa fa-tags"></i> Thể loại: {{ $story->name }}
                                            </small>
                                        </h6>
                                        <h6 class="card-text">
                                            <small class="text-muted">
                                                <i class="fas fa-heart"></i>
                                                <span class="favoriteCount fs-4" data-story-id="{{ $story->id }}">0</span> yêu thích
                                            </small>
                                        </h6>
                                        <p class="card-text">{{ $story->description }}</p>
                                        @if (auth()->check())
                                            <button class="btn btn-primary toggle-favorite" data-story-id="{{ $story->id }}" data-liked="false">
                                                <i class="fas fa-heart"></i> <span class="favorite-text">Thích</span>
                                            </button>
                                        @else
                                            <button class="btn btn-primary toggle-favorite">
                                                <i class="fas fa-heart"></i> <span class="favorite-text">Thích</span>
                                            </button>
                                        @endif
                                        <div class="star-rating">
                                            <form action="">
                                                @csrf
                                                <input type="hidden" id="story_id" value="{{ $story->id }}">
                                                <input type="radio" name="rate" id="rate-5" value="5">
                                                <label for="rate-5" class="fas fa-star"></label>
                                                <input type="radio" name="rate" id="rate-4" value="4">
                                                <label for="rate-4" class="fas fa-star"></label>
                                                <input type="radio" name="rate" id="rate-3" value="3">
                                                <label for="rate-3" class="fas fa-star"></label>
                                                <input type="radio" name="rate" id="rate-2" value="2">
                                                <label for="rate-2" class="fas fa-star"></label>
                                                <input type="radio" name="rate" id="rate-1" value="1">
                                                <label for="rate-1" class="fas fa-star"></label>
                                            </form>
                                        </div>
                                        <div class="mt-auto text-center">
                                            <a href="{{ url('doc-truyen/' . $story->slug.'-'.$story->chapter_id) }}" class="btn btn-primary">Đọc truyện</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <h3 class="text-center">Danh sách chương</h3>
                    <div class="row">
                        @if (isset($chapters) && !empty($chapters))
                        @php
                            $totalChapters = count($chapters);
                            $columns = 3; // Số cột
                            $chaptersPerColumn = ceil($totalChapters / $columns); // Số chương trên mỗi cột
                        @endphp

                        @for ($col = 0; $col < $columns; $col++)
                            <div class="col-md-4">
                                <div class="list-group">
                                    @foreach($chapters as $index => $chapter)
                                        @if ($index >= $col * $chaptersPerColumn && $index < ($col + 1) * $chaptersPerColumn)
                                            <a href="/doc-truyen/{{ $chapter->slug }}-{{ $chapter->id }}" class="list-group-item list-group-item-action">{{ $chapter->title }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endfor
                    @endif
                    </div>
                    <h3 class="text-center mt-3">Bình luận</h3>
                    <form action="{{ url('add') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="content">Comment:</label>
                            <textarea class="form-control" id="content" name="content" rows="2" required></textarea>
                            <input type="hidden" name="story_id" value="{{ $story->id }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <div class="list-group">
                        <!-- PHP code to loop through comments and display them -->
                        @if (isset($comments) && !empty($comments))
                            @foreach ($comments as $comment)
                                <div class="list-group-item mt-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $comment->name }}</h5>
                                        <small>{{ $comment->created_at }}</small>
                                    </div>
                                    <p class="mb-1 text-black">{!! nl2br($comment->content) !!}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @elseif(Request::is('doc-truyen/*'))
                    <div class="chapter">
                        <a class="chapter_title" href="{{ url('truyen/'.$chapter->slug) }}">
                            <h2 class="text-center">{{ $chapter->title }}</h2>
                        </a>
                        <div class="content text-black ml-5 mx-5">
                            {!! nl2br($chapter->content) !!}
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        @if($prevChapter)
                            <a href="{{ url('doc-truyen/'. $prevChapter->slug .'-'. $prevChapter->id) }}" class="btn btn-primary">Chương trước</a>
                        @else
                            <span class="btn btn-secondary disabled">Chương trước</span>
                        @endif

                        @if($nextChapter)
                            <a href="{{ url('doc-truyen/'. $nextChapter->slug .'-'. $nextChapter->id) }}" class="btn btn-primary">Chương tiếp theo</a>
                        @else
                            <span class="btn btn-secondary disabled">Chương tiếp theo</span>
                        @endif
                    </div>
                @else
                    <h3>{{ $title }}</h1>
                    <div class="row">
                        @if (isset($stories) && !empty($stories))
                            @foreach($stories as $story)
                                <div class="w3-col s6 m-3 l3 list">
                                    <a class="w3-hover-opacity" href="{{ url('truyen/'.$story->slug) }}" title="{{ $story->title }}">
                                        <img alt="{{ $story->title }}" class="list-thumbnail lazy loaded" height="208" width="157" src="{{ $story->cover_image }}" data-was-processed="true">
                                    </a>
                                    <div class="list-caption mt-1">
                                        <h3>
                                            <a href="{{ url('truyen/'.$story->slug) }}" title="{{ $story->title }}">{{ $story->title }}</a>
                                        </h3>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endif
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
