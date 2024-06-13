<?php

namespace App\Http\Controllers;

use App\Http\Services\ChapterService;
use App\Http\Services\CommentService;
use App\Http\Services\GenreService;
use App\Http\Services\HomeService;
use App\Http\Services\StoryService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $genre, $story, $home, $chapter, $comment;

    public function __construct(GenreService $genre, StoryService $story, HomeService $home, ChapterService $chapter, CommentService $comment) {
        $this->genre = $genre;
        $this->story = $story;
        $this->home = $home;
        $this->chapter = $chapter;
        $this->comment = $comment;
    }

    public function index() {
        return view('home', [
            'title' => 'Danh sách truyện',
            'genres' => $this->genre->getAllGenres(),
            'stories' => $this->story->getAll()
        ]);
    }

    public function show($slug) {
        return view('home', [
            'title' => $this->genre->makeNameFromSlug($slug),
            'genres' => $this->genre->getAllGenres(),
            'stories' => $this->story->getStory($slug)
        ]);
    }

    public function search(Request $request) {
        return view('home', [
            'title' => 'Danh sách truyện',
            'genres' => $this->genre->getAllGenres(),
            'stories' => $this->home->search($request)
        ]);
    }

    public function story($slug) {
        $result = $this->story->makeAllFromSlug($slug);

        return view('home', [
            'genres' => $this->genre->getAllGenres(),
            'story' => $result,
            'chapters' => $this->chapter->getChaptersFromSlug($slug),
            'comments' => $this->comment->getId($slug)
        ]);
    }

    public function chapter($url) {
        $lastDashPosition = strrpos($url, '-');
        $id = substr($url, $lastDashPosition + 1);
        $slug = substr($url, 0, $lastDashPosition);
        $result = $this->chapter->getChapters($id, $slug);
        $prevChapter = $this->chapter->prevChapter($id, $slug);
        $nextChapter = $this->chapter->nextChapter($id, $slug);

        return view('home', [
            'genres' => $this->genre->getAllGenres(),
            'chapter' => $result,
            'nextChapter' => $nextChapter,
            'prevChapter' => $prevChapter
        ]);
    }
}
