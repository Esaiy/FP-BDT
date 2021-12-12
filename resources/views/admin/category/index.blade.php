@extends('layouts.admin')
@section('title', 'Kategori')
@section('description', 'Kategori pada berita')

@section('side-button')
<a href="{{ route('dashboard.category.create') }}" class="btn btn-white btn-border btn-round mr-2">Tambah Kategori</a>
@endsection

@section('content')
<div class="page-inner mt--5">
	<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Daftar Kategori</div>
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
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    <a href="{{ route('dashboard.category.edit',['category' => $category->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('dashboard.category.destroy', ['category' => $category->id]) }}" method="post" class="d-inline">
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
@endsection
