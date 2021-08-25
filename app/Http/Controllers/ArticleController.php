<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{

    public function index()
    {
        $articles = Article::paginate(5);

        return view('articles.index', compact('articles'));
    }


    public function create()
    {
        $categories = Category::all();

        return view('articles.create', compact('categories'));
    }


    public function store(Request $request)
    {

        $data = Arr::except(
            $request->validate([
                'title' => 'required|max:100|string',
                'body' => 'required|string',
                'image' => 'nullable',
                'category_id' => 'required|exists:categories,id',
                'tags' => 'required'
            ]),
            'tags'
        );

        $tags = collect(explode(',', $request->tags))->map(function ($tag) {
            return trim($tag);
        });

        $imageName = 'articles/' . (
            ($request->has('image')) ?
            $request->file('image')->getClientOriginalName()
            : 'defaultArticleImage.jpg'
        );


        $article = Article::create(
            array_merge(
                $data,
                [
                    'image' => 'storage/' . $imageName,
                    'user_id' => auth()->id()
                ]
            )
        );

        foreach ($tags as $tag) {
            $tag = Tag::firstOrCreate(['name' => $tag]);
            $article->tags()->attach($tag);
        }

        $request->file('image')->storeAs(
            'public',
            $imageName
        );

        return redirect()->route('articles.index');
    }


    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }


    public function edit(Article $article)
    {
        $categories = Category::all();
        $tags = [];
        foreach ($article->tags as $tag) {
            array_push($tags, $tag->name);
        }

        $tags = implode(',', $tags);

        return view('articles.edit', compact('article', 'categories', 'tags'));
    }


    public function update(Request $request, Article $article)
    {

        $data = Arr::except(
            $request->validate([
                'title' => 'required|max:100|string',
                'body' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable',
                'tags' => 'required'
            ]),
            'tags'
        );


        if ($request->has('image')) {

            Storage::delete('public/' . $article->image);

            $imageName = 'articles/' . $request->file('image')->getClientOriginalName();

            $request->file('image')->storeAs(
                'public',
                $imageName
            );

            $data = array_merge(
                $data,
                ['image' => 'storage/' . $imageName]
            );
        }

        $article->update(
            array_merge(
                $data,
                ['user_id' => auth()->id()]
            )
        );

        $tags = explode(',', $request->tags);

        $newTags = [];
        foreach ($tags as $tag) {
            $tag = Tag::firstOrCreate(['name' => $tag]);
            array_push($newTags, $tag->id);
        }

        $article->tags()->sync($newTags);


        return redirect()->route('articles.index');
    }


    public function destroy(Article $article)
    {

        if ($article->image) {
            Storage::delete('public/' . $article->image);
        }

        $article->tags()->detach();
        $article->delete();

        return redirect()->route('articles.index');
    }
}
