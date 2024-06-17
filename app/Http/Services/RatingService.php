<?php

namespace App\Http\Services;

use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RatingService {
    public function insert($user_id, $story_id, $rating) {
        try {
            Rating::create([
                'user_id' => $user_id,
                'story_id' => $story_id,
                'rating' => $rating,
            ]);
            Session::flash('success', 'Thêm đánh giá thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Thêm thất bại');
            Log::info($e->getMessage());
            return false;
        }
        return true;
    }

    public function update($rating, $id) {
        try {
            $id->fill([
                'rating' => $rating,
            ]);
            $id->save();
            Session::flash('success', 'Cập nhật đánh giá thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Cập nhật thất bại');
            Log::info($e->getMessage());
            return false;
        }
        return true;
    }

    public function storeOrUpdateRating($request) {
        $user_id = Auth::id();
        $story_id = $request->story_id;
        $rating = $request->rating;
        $value = Rating::where('user_id', $user_id)->where('story_id', $story_id)->first();
        if ($value) {
            $this->update($rating, $value);
        } else {
            $this->insert($user_id, $story_id, $rating);
        }
        return true;
    }

    public function getAll() {
        return Rating::join('users', 'users.id', '=', 'ratings.user_id')->join('stories', 'stories.id', '=', 'ratings.story_id')->select('ratings.id', 'ratings.rating', 'users.name', 'stories.title')->orderBy('ratings.id', 'asc')->paginate(15);
    }

    public function show($story_id) {
        return Rating::where('story_id', $story_id)->avg('rating');
    }
}
