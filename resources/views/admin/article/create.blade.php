@extends('layouts.admin')
@section('title', 'Tambah Artikel')
@section('description', 'Tambah artikel baru')

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
                <form action="{{ route('dashboard.article.store') }}" method="post">
                    @csrf
                    <div class="card-header">
                        <div class="card-title">Form Tambah Article</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group form-inline">
                            <label for="headline" class="col-md-3 col-form-label">Headline</label>
                            <div class="col-md-9 p-0">
                                <input type="text" class="form-control input-full" id="headline" placeholder="Masukkan Headline" name="headline">
                            </div>
                        </div>
                        <div class="form-group form-inline">
                            <label for="kategori" class="col-md-3 col-form-label">Kategori</label>
                            <div class="col-md-9 p-0">
                                <select class="form-control" id="kategori" name="kategori">
                                    @foreach($categories as $category)
                                    @if($category->id == 1)
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-inline">
                            <label for="link" class="col-md-3 col-form-label">Link</label>
                            <div class="col-md-9 p-0">
                                <input type="text" class="form-control input-full" id="link" placeholder="Masukkan Link" name="link">
                            </div>
                        </div>
                        <div class="form-group form-inline">
                            <label for="deskripsi" class="col-md-3 col-form-label">Deskripsi</label>
                            <div class="col-md-9 p-0">
                                <input type="text" class="form-control input-full" id="deskripsi" placeholder="Masukkan Deskripsi" name="deskripsi">
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
