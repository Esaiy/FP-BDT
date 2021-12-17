@extends('layouts.admin')
@section('title', 'Dashboard')
@section('description', 'Dashboard portal berita')
@section('content')
<div class="page-inner mt--5">
	<div class="row">
		<div class="col-sm-12 col-md-6">
			<div class="card card-stats card-round">
				<div class="card-body">
					<div class="row align-items-center">
						<div class="col-icon">
							<div class="icon-big text-center icon-info bubble-shadow-small">
								<i class="far fa-newspaper"></i>
							</div>
						</div>
						<div class="col col-stats ml-3 ml-sm-0">
							<div class="numbers">
								<p class="card-category">Artikel</p>
								<h4 class="card-title">{{ $articleCount }}</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-6">
			<div class="card card-stats card-round">
				<div class="card-body">
					<div class="row align-items-center">
						<div class="col-icon">
							<div class="icon-big text-center icon-success bubble-shadow-small">
								<i class="fas fa-tags"></i>
							</div>
						</div>
						<div class="col col-stats ml-3 ml-sm-0">
							<div class="numbers">
								<p class="card-category">Kategori</p>
								<h4 class="card-title">{{ $categoryCount }}</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
        <div class="col-md-12">
			<div class="card full-height">
				<div class="card-header">
					<div class="card-head-row">
						<div class="card-title">Artikel Terbaru</div>
						<div class="card-tools">
							<a href="{{ route('dashboard.article.index') }}" class="btn btn-info btn-border btn-round mr-2">
								<span class="btn-label-label">Menuju Artikel</span>
							</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive custom-table-row">
							<table class="table custom-table">
								<thead>
									<tr class="d-flex">
										<th class="col-1">ID</th>
										<th class="col-5">Headline</th>
										<th class="col-2">Author</th>
										<th class="col-2">Category</th>
										<th class="col-2">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<style>
									</style>
									@foreach ($articles as $article)
									<tr class="d-flex">
										<td class="col-1">{{ $article->id }}</td>
										<td class="col-5">{{ $article->headline }}</td>
										<td class="col-2">{{ $article->author->name }}</td>
										<td class="col-2">{{ $article->category->name }}</td>
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
