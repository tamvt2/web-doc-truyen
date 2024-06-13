<?php

namespace App\Http\Services;

use App\Models\Genre;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class GenreService {
    public function insert($request) {
        $name = $request->input('name');
        $slug = UrlNormal($name);
        try {
            Genre::create([
                'name' => $name,
                'slug' => $slug,
            ]);
            Session::flash('success', 'Thêm thể loại thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Thêm thất bại');
            Log::info($e->getMessage());
            return false;
        }
        return true;
    }

    public function getAll() {
        return Genre::orderBy('id', 'ASC')->paginate(15);
    }

    public function update($request, $id) {
        $name = $request->input('name');
        $slug = UrlNormal($name);
        try {
            $id->fill([
                'name' => $name,
                'slug' => $slug
            ]);
            $id->save();
            Session::flash('success', 'Cập nhật thể loại thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Cập nhật thất bại');
            Log::info($e->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($request) {
        $id = $request->input('id');
        $value = Genre::where('id', $id)->first();
        if ($value) {
            return Genre::where('id', $id)->delete();
        }
        return false;
    }

    public function getAllGenres() {
        return Genre::orderBy('id', 'asc')->get();
    }

    public function makeNameFromSlug($slug) {
        $results =  Genre::select('name')->where('slug', $slug)->get();
        $value = '';
        if ($results) {
            foreach ($results as $result) {
                $value = $result->name;
            }
        }
        return $value;
    }
}
