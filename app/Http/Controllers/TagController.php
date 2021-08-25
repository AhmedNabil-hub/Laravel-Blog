<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function index()
    {
        $tags = Tag::paginate(5);

        return view('tags.index', compact('tags'));
    }


    public function create()
    {
        return view('tags.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:100|string'
        ]);


        Tag::create($data);

        return redirect()->route('tags.index');
    }


    public function show(Tag $tag)
    {
        return view('tags.show', compact('tag'));
    }


    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }


    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'name' => 'required|max:100|string'
        ]);


        $tag->update($data);

        return redirect()->route('tags.index');
    }


    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('tags.index');
    }
}
