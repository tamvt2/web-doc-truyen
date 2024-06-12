<?php

namespace App\Http\Services;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class StoryService {
    public function insert($request) {
        try {
            $title = $request->input('title');
            $slug = convert_vi_to_en($title);
            Story::create([
                'title' => $title,
                'description' => $request->input('description'),
                'user_id' => Auth::id(),
                'genre_id' => $request->input('genre_id'),
                'cover_image' => $request->input('cover_image'),
                'slug' => $slug
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
        return Story::join('users', 'users.id', '=', 'stories.user_id')->join('genres', 'genres.id', '=', 'stories.genre_id')->select('stories.*', 'users.name as username', 'genres.name as name')->orderBy('stories.id', 'ASC')->paginate(15);
    }

    public function update($request, $id) {
        try {
            $title = $request->input('title');
            $slug = convert_vi_to_en($title);
            $id->fill([
                'title' => $title,
                'description' => $request->input('description'),
                'user_id' => Auth::id(),
                'genre_id' => $request->input('genre_id'),
                'cover_image' => $request->input('cover_image'),
                'slug' => $slug
            ]);
            $id->save();
            Session::flash('success', 'Cập nhật truyện thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Cập nhật thất bại');
            Log::info($e->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($request) {
        $id = $request->input('id');
        $value = Story::where('id', $id)->first();
        if ($value) {
            return Story::where('id', $id)->delete();
        }
        return false;
    }

    public function getName() {
        return Story::select('id', 'title')->orderBy('id', 'asc')->get();
    }

    public function getStory($slug) {
        return Story::join('genres', 'genres.id', '=', 'stories.genre_id')->orderBy('stories.id', 'asc')->where('genres.slug', $slug)->get();
    }
}
