@extends('layouts.front')

@section('content')
<div class="row">
    
</div>
@endsection

@section('pagination')
{!! $articles->links() !!}
@endsection
