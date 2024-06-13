<?php
namespace App\Http\Services;

use App\Models\Chapter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ChapterService {
    public function insert($request) {
        try {
            $title = $request->input('title');
            $slug = UrlNormal($title);
            Chapter::create([
                'story_id' => $request->input('story_id'),
                'title' => $title,
                'content' => $request->input('content'),
                'chapter_number' => $request->input('chapter_number'),
                'slug' => $slug
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
            $title = $request->input('title');
            $slug = UrlNormal($title);
            $id->fill([
                'story_id' => $request->input('story_id'),
                'title' => $title,
                'content' => $request->input('content'),
                'chapter_number' => $request->input('chapter_number'),
                'slug' => $slug
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

    public function getChaptersFromSlug($slug) {
        return Chapter::join('stories', 'stories.id', '=', 'chapters.story_id')->select('chapters.title', 'chapters.slug', 'chapters.id')->where('stories.slug', $slug)->get();
    }

    public function getChapters($id, $slug) {
        return Chapter::join('stories', 'stories.id', '=', 'chapters.story_id')->where('chapters.slug', $slug)->where('chapters.id', $id)->select('chapters.title', 'content', 'story_id', 'stories.slug')->firstOrFail();
    }

    public function prevChapter($id, $slug) {
        $chapter = $this->getChapters($id, $slug);
        return Chapter::where('story_id', $chapter->story_id)->where('id', '<', $id)->select('slug', 'id')->orderBy('id', 'desc')->first();
    }

    public function nextChapter($id, $slug) {
        $chapter = $this->getChapters($id, $slug);
        return Chapter::where('story_id', $chapter->story_id)->where('id', '>', $id)->select('slug', 'id')->orderBy('id')->first();
    }
}
