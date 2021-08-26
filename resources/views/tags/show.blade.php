@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">{{ $tag->name }}</div>

          <div class="card-body">
            <div class="row">
              @foreach ($tag->articles as $article)
                <div class="col-md-4">
                  <div>
                    <a href="{{ route('articles.show', $article) }}">
                      @if ($article->image)
                        <img src="{{ asset($article->image) }}" width="100" height="100" class="img-fluid">
                      @endif
                    </a>
                  </div>
                  <div class="d-flex justify-content-between">
                    <div class="text-muted">{{ $article->created_at->format('d F Y') }}</div>
                    <div class=""><a href="#" class="font-weight-bolder text-info">{{ $article->category->name }}</a>
                    </div>
                  </div>
                  <a href="{{ route('articles.show', $article) }}" class="font-weight-bold text-success">
                    <h3 class=""">{{ $article->title }}</h3>
                                                          </a>
                                                          <p class=" text-muted">{{ $article->body }}</p>
                </div>
              @endforeach
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
