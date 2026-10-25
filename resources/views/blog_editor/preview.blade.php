@extends('admin.layouts.app')

@section('content')
<h1>{{ $blog->title }}</h1>
<div>{!! $blog->content_html !!}</div>
@endsection
