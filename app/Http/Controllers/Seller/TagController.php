<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function store(Request $request)
    {
        $name = trim($request->input('name', ''));

        if (!$name || mb_strlen($name) > 60) {
            return response()->json(['error' => 'Invalid tag name.'], 422);
        }

        $tag = Tag::findOrCreateByName($name);

        return response()->json([
            'id'   => $tag->id,
            'name' => $tag->name,
            'slug' => $tag->slug,
        ]);
    }
}
