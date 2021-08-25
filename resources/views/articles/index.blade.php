@extends('layouts.app')
@section('content')
    <div class="container">

        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('articles.create') }}">
                    Add article
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="fa fa-align-justify"></i> Articles list</div>
            <div class="card-body">
                @if (session('errors'))
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <table class="table table-responsive-sm table-striped">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Body</th>
                        <th>User</th>
                        <th>Category</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->body }}</td>
                            <td>{{ $article->user->name }}</td>
                            <td>{{ $article->category->name }}</td>
                            <td>
                                <a class="btn btn-xs btn-info"
                                   href="{{ route('articles.edit', $article->id) }}">
                                    Edit
                                </a>

                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $articles->links() }}

            </div>
        </div>

    </div>
@endsection
