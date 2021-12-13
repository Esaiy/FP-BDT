@extends('layouts.admin')
@section('title', 'Artikel')
@section('description', 'Artikel')

@section('side-button')
<a href="{{ route('dashboard.article.create') }}" class="btn btn-white btn-border btn-round mr-2">Tambah Artikel</a>
@endsection

@section('content')
<div class="page-inner mt--5">
	<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Daftar Artikel</div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div>
                            {{ session('success') }}
                            <button type="button" class="close p-0" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    @endif
                    @if (session('deleted'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <div>
                            {{ session('deleted') }}
                            <button type="button" class="close p-0" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    @endif
                    <div class="table-responsive custom-table-row">
                        <table class="table custom-table">
                            <thead>
                                <tr class="d-flex">
                                    <th class="col-1">ID</th>
                                    <th class="col-3">Headline</th>
                                    <th class="col-2">Author</th>
                                    <th class="col-2">Category</th>
                                    <th class="col-3">Slug</th>
                                    <th class="col-1">Link</th>
                                    <th class="col-4">Description</th>
                                    <th class="col-1">Status</th>
                                    <th class="col-2">Date</th>
                                    <th class="col-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <style>
                                </style>
                                @foreach ($articles as $article)
                                <tr class="d-flex">
                                    <td class="col-1">{{ $article->id }}</td>
                                    <td class="col-3">{{ $article->headline }}</td>
                                    <td class="col-2">{{ $article->author->name }}</td>
                                    <td class="col-2">{{ $article->category->name }}</td>
                                    <td class="col-3">{{ $article->slug }}</td>
                                    <td class="col-1"><a href="{{ $article->link }}">Link</a></td>
                                    <td class="col-4">{{ $article->description }}</td>
                                    <td class="col-1">{{ $article->is_active }}</td>
                                    <td class="col-2">{{ $article->date }}</td>
                                    <td class="col-2">
                                        <a href="{{ route('dashboard.article.edit', $article->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('dashboard.article.destroy', ['article' => $article->id]) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection
