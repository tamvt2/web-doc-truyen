<?php

namespace App\Http\Controllers;

use App\Http\Services\GenreService;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    protected $genre;

    public function __construct(GenreService $genre) {
        $this->genre = $genre;
    }

    public function create() {
        return view('admin/genre/add');
    }

    public function store(Request $request) {
        $result = $this->genre->insert($request);
        if ($result) {
            return redirect('/admin/genre/list');
        }
        return redirect()->back();
    }

    public function index() {
        return view('admin/genre/list', [
            'values' => $this->genre->getAll()
        ]);
    }

    public function show(Genre $id) {
        return view('admin/genre/edit', [
            'value' => $id,
        ]);
    }

    public function update(Genre $id, Request $request) {
        $result = $this->genre->update($request, $id);
        if ($result) {
            return redirect('/admin/genre/list');
        }
        return redirect()->back();
    }

    public function destroy(Request $request) {
        $result = $this->genre->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thể loại thành công!'
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Xóa thể loại thất bại!'
        ]);
    }
}
