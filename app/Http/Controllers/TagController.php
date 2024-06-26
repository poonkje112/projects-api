<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return Tag::all();
    }

    public function show(Tag $tag)
    {
        return Tag::with('projects')->find($tag->id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        return Tag::create($request->all());
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required'
        ]);
        
        return $tag->update($request->all());
    }

    public function destroy(Tag $tag)
    {
        return $tag->delete();
    }
}
