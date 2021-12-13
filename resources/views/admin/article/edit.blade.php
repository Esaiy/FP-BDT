@extends('layouts.admin')
@section('title', 'Edit Artikel')
@section('description', 'Edit artikel baru')

@section('side-button')
<a href="{{ route('dashboard.article.index') }}" class="btn btn-white btn-border btn-round mr-2">
    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
    Kembali
</a>
@endsection

@section('content')
<div class="page-inner mt--5">
	<div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('dashboard.article.update', ['article' => $article->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <div class="card-title">Form Edit Article</div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="id" value="{{ $article->id }}">
                        <div class="form-group form-inline">
                            <label for="headline" class="col-md-3 col-form-label">Headline</label>
                            <div class="col-md-9 p-0">
                                <input type="text" class="form-control input-full" id="headline" placeholder="Masukkan Headline" name="headline" value="{{ $article->headline }}">
                            </div>
                        </div>
                        <div class="form-group form-inline">
                            <label for="kategori" class="col-md-3 col-form-label">Kategori</label>
                            <div class="col-md-9 p-0">
                                <select class="form-control" id="kategori" name="kategori">
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}"
                                    @if($article->category_id == $category->id)
                                        selected = 'selected'
                                    @endif
                                    >{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-inline">
                            <label for="link" class="col-md-3 col-form-label">Link</label>
                            <div class="col-md-9 p-0">
                                <input type="text" class="form-control input-full" id="link" placeholder="Masukkan Link" name="link" value="{{ $article->link }}">
                            </div>
                        </div>
                        <div class="form-group form-inline">
                            <label for="deskripsi" class="col-md-3 col-form-label">Deskripsi</label>
                            <div class="col-md-9 p-0">
                                <input type="text" class="form-control input-full" id="deskripsi" placeholder="Masukkan Deskripsi" name="deskripsi" value="{{ $article->description }}">
                            </div>
                        </div>
                        <div class="form-group form-inline">
                            <label for="tanggal" class="col-md-3 col-form-label">Tanggal</label>
                            <div class="col-md-9 p-0">
                                <input type="date" id="tanggal" name="tanggal">
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-success" type="submit">Submit</button>
                        <a href="{{ route('dashboard.article.index') }}" class="btn btn-danger" >Cancel</a>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>
@endsection
