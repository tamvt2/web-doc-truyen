<?php

namespace App\Http\Services;

use App\Models\Comment;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CommentService {
    public function insert($request) {
        try {
            Comment::create([
                'user_id' => Auth::id(),
                'story_id' => $request->input('story_id'),
                'content' => $request->input('content'),
            ]);
            Session::flash('success', 'Thêm truyện thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Thêm thất bại');
            Log::info($e->getMessage());
            return false;
        }
        return true;
    }

    public function getAll() {
        return Comment::join('users', 'users.id', '=', 'comments.user_id')->join('stories', 'stories.id', '=', 'comments.story_id')->select('comments.id', 'comments.content', 'comments.created_at', 'users.name', 'stories.title')->orderBy('comments.id', 'asc')->paginate(15);
    }

    public function getId($slug) {
        $id = Story::where('slug', $slug)->select('id')->firstOrFail();
        return Comment::join('users', 'users.id', '=', 'comments.user_id')->select('comments.content', 'comments.created_at', 'users.name')->where('story_id', $id->id)->orderBy('comments.id', 'desc')->get();
    }
}
