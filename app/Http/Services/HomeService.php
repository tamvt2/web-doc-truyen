<?php

namespace App\Http\Services;

use App\Models\Genre;
use App\Models\Story;

class HomeService {
    public function search($request) {
        $search = strtolower($request->input('search'));
        $results = [];

        $titleResults = Story::whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%'])->get();

        if (!$titleResults->isEmpty()) {
            $results = $titleResults;
            return $results;
        }

        $genre = Story::join('genres', 'genres.id', '=', 'stories.genre_id')->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])->get();
        if ($genre) {
            $results = $genre;
        }

        return $results;
    }
}
