<?php

namespace App\Http\Controllers;

use App\Http\Services\GenreService;
use App\Http\Services\HomeService;
use App\Http\Services\StoryService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $genre, $story, $home;

    public function __construct(GenreService $genre, StoryService $story, HomeService $home) {
        $this->genre = $genre;
        $this->story = $story;
        $this->home = $home;
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
}
