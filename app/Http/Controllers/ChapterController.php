<?php

namespace App\Http\Controllers;

use App\Http\Services\ChapterService;
use App\Http\Services\StoryService;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    protected $chapter, $story;

    public function __construct(ChapterService $chapter, StoryService $story) {
        $this->chapter = $chapter;
        $this->story = $story;
    }

    public function create() {
        return view('admin/chapter/add', [
            'stories' => $this->story->getName()
        ]);
    }

    public function store(Request $request) {
        $result = $this->chapter->insert($request);
        if ($result) {
            return redirect('/admin/chapter/list');
        }
        return redirect()->back();
    }

    public function index() {
        return view('admin/chapter/list', [
            'values' => $this->chapter->getAll()
        ]);
    }

    public function show(Chapter $id) {
        return view('admin/chapter/edit', [
            'value' => $id,
            'stories' => $this->story->getName()
        ]);
    }

    public function update(Chapter $id, Request $request) {
        $result = $this->chapter->update($request, $id);
        if ($result) {
            return redirect('/admin/chapter/list');
        }
        return redirect()->back();
    }

    public function destroy(Request $request) {
        $result = $this->story->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa chương thành công!'
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Xóa chương thất bại!'
        ]);
    }
}
