@extends('layouts.admin')
@section('title', 'Ubah Kategori')
@section('description', 'Ubah jenis kategori')

@section('side-button')
<a href="{{ route('dashboard.category.index') }}" class="btn btn-white btn-border btn-round mr-2">
    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
    Kembali
</a>
@endsection

@section('content')
<div class="page-inner mt--5">
	<div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('dashboard.category.update', ['category' => $category->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <div class="card-title">Form Ubah Kategori "{{ $category->name }}"</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group form-inline">
                            <label for="kategori-name" class="col-md-3 col-form-label">Nama Kategori</label>
                            <div class="col-md-9 p-0">
                                <input type="text" class="form-control input-full" id="kategori-name" placeholder="Masukkan Kategori" name="name" value="{{ $category->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-success" type="submit">Submit</button>
                        <a href="{{ route('dashboard.category.index') }}" class="btn btn-danger" >Cancel</a>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>
@endsection
