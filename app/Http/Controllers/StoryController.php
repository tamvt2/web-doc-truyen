<?php

namespace App\Http\Controllers;

use App\Http\Services\GenreService;
use App\Http\Services\StoryService;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    protected $story, $genre;

    public function __construct(StoryService $story, GenreService $genre) {
        $this->story = $story;
        $this->genre = $genre;
    }

    public function create() {
        return view('admin/story/add', [
            'genres' => $this->genre->getAllGenres()
        ]);
    }

    public function store(Request $request) {
        $result = $this->story->insert($request);
        if ($result) {
            return redirect('/admin/story/list');
        }
        return redirect()->back();
    }

    public function index() {
        return view('admin/story/list', [
            'values' => $this->story->getAll()
        ]);
    }

    public function show(Story $id) {
        return view('admin/story/edit', [
            'value' => $id,
            'genres' => $this->genre->getAllGenres()
        ]);
    }

    public function update(Story $id, Request $request) {
        $result = $this->story->update($request, $id);
        if ($result) {
            return redirect('/admin/story/list');
        }
        return redirect()->back();
    }

    public function destroy(Request $request) {
        $result = $this->story->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa truyện thành công!'
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Xóa truyện thất bại!'
        ]);
    }
}
