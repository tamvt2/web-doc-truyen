<?php
namespace App\Http\Services;

use App\Models\Chapter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ChapterService {
    public function insert($request) {
        try {
            Chapter::create([
                'story_id' => $request->input('story_id'),
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'chapter_number' => $request->input('chapter_number'),
            ]);
            Session::flash('success', 'Thêm chương thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Thêm thất bại');
            Log::info($e->getMessage());
            return false;
        }
        return true;
    }

    public function getAll() {
        return Chapter::join('stories', 'stories.id', '=', 'chapters.story_id')->select('chapters.*', 'stories.title as name')->orderBy('chapters.id', 'ASC')->paginate(15);
    }

    public function update($request, $id) {
        try {
            $id->fill([
                'story_id' => $request->input('story_id'),
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'chapter_number' => $request->input('chapter_number'),
            ]);
            $id->save();
            Session::flash('success', 'Cập nhật chương thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Cập nhật thất bại');
            Log::info($e->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($request) {
        $id = $request->input('id');
        $value = Chapter::where('id', $id)->first();
        if ($value) {
            return Chapter::where('id', $id)->delete();
        }
        return false;
    }
}
