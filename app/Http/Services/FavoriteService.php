<?php

namespace App\Http\Services;

use App\Models\Favorite;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class FavoriteService {
    public function toggleFavorite($request, $storyId)
    {
        $user_id = Auth::id();
        $story = Story::find($storyId);

        if (!$story) {
            return response()->json(['success' => false, 'message' => 'Truyện không tồn tại.'], 404);
        }

        $value = Favorite::where('user_id', $user_id)->where('story_id', $story->id)->first();

        if ($value) {
            return Favorite::where('id', $value->id)->delete();
        } else {
            $this->insert($user_id, $story->id);
        }
    }

    public function insert($user_id, $story_id) {
        try {
            Favorite::create([
                'user_id' => $user_id,
                'story_id' => $story_id,
            ]);
            Session::flash('success', 'Thêm đánh giá thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Thêm thất bại');
            Log::info($e->getMessage());
            return false;
        }
        return true;
    }

    public function count($id) {
        return Favorite::where('story_id', $id)->count();
    }

    public function favorite($request) {
        return Favorite::where('story_id', $request->story_id)->where('user_id', $request->user_id)->first();
    }
}
