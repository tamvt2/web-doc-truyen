<?php

namespace App\Http\Controllers;

use App\Http\Services\FavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    protected $favorite;

    public function __construct(FavoriteService $favorite) {
        $this->favorite = $favorite;
    }

    public function toggleFavorite(Request $request, $storyId) {
        $result = $this->favorite->toggleFavorite($request, $storyId);

        if ($result !== 1) {
            return response()->json(['success' => true, 'is_liked' => true]);
        }
        return response()->json(['success' => true, 'is_liked' => false]);
    }

    public function count($id) {
        $result = $this->favorite->count($id);
        if ($result) {
            return response()->json([
                'count' => $result,
                'error' => false
            ]);
        }
        return response()->json([
            'error' => true
        ]);
    }

    public function favorite(Request $request) {
        $result = $this->favorite->favorite($request);

        if (!empty($result)) {
            return response()->json(['success' => true, 'is_liked' => true]);
        }
        return response()->json(['success' => true, 'is_liked' => false]);
    }
}
