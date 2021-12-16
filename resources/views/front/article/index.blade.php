@extends('layouts.front')

@section('content')
<div class="row">
    @foreach($articles as $article)
    <div class="col-md-4 mt-3">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('category', ['category' => $article->category->slug]) }}"><span class="badge badge-primary">{{ $article->category->name }}</span></a>
                <span class="badge badge-secondary">{{ Carbon\Carbon::parse($article->date)->diffForHumans() }}</span>
                <h5 class="card-title">{{ $article->headline }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $article->description }}</p>
            </div>
            <ul class="list-group list-group-flush">
                <a href="{{ route('author', ['author' => $article->author->id]) }}"><li class="list-group-item"><i class="fa fa-user-circle"></i> {{ $article->author->name }}</li></a>
            </ul>
            <div class="card-footer">
                <a href="{{ $article->link }}" class="card-link" target="_blank">Link Artikel</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('pagination')
{!! $articles->links() !!}
@endsection
