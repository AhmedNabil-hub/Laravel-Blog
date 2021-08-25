@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $article->title }}</div>

                    <div class="card-body">
                        <div class="">
                            @if($article->image)
                                <img src="{{ asset($article->image) }}" width="100" height="100"
                                     class="img-fluid">
                            @endif
                        </div>

                        <div class="my-5">{!! nl2br($article->body) !!}</div>

                        @foreach ($article->tags as $tag)
                            <a href="#" class="btn btn-outline-secondary">#{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
