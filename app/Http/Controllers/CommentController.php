<?php

namespace App\Http\Controllers;

use App\Http\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $comment;

    public function __construct(CommentService $comment) {
        $this->comment = $comment;
    }

    public function store(Request $request) {
        $result = $this->comment->insert($request);
        if ($result) {
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function index() {
        return view('admin/comment/list', [
            'values' => $this->comment->getAll()
        ]);
    }
}
