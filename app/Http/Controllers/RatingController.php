<?php

namespace App\Http\Controllers;

use App\Http\Services\RatingService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected $rating;

    public function __construct(RatingService $rating) {
        $this->rating = $rating;
    }

    public function store(Request $request) {
        $result = $this->rating->storeOrUpdateRating($request);
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function show($story_id) {
        $rating = $this->rating->show($story_id);

        if ($rating) {
            return response()->json(['rating' => round($rating)]);
        } else {
            return response()->json(['rating' => 0]);
        }
    }

    public function index() {
        return view('admin/rating/list', [
            'values' => $this->rating->getAll()
        ]);
    }
}
