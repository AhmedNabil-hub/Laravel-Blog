<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

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

        $data = $request->validate([
            'title' => 'required|max:100|string',
            'body' => 'required|string',
            'image' => 'nullable',
            'category_id' => 'required|exists:categories,id'
        ]);

        $imageName = 'articles/' . (
            ($request->has('image')) ?
            $request->file('image')->getClientOriginalName()
            : 'defaultArticleImage.jpg'
        );

        $request->file('image')->storeAs(
            'public',
            $imageName
        );


        Article::create(
            array_merge(
                $data,
                [
                    'image' => 'storage/' . $imageName,
                    'user_id' => auth()->id()
                ]
            )
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

        return view('articles.edit', compact('article,categories'));
    }


    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title' => 'required|max:100|string',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => '',
            'tags' => ''
        ]);

        if ($request->file('image')) {
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

        return redirect()->route('articles.index');
    }


    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index');
    }
}
