@extends('admin.layouts.legacy')

@section('content')
<form method="POST">
@csrf
<input name="name" placeholder="Template Name">
<input name="subject" placeholder="Subject">
<textarea name="body"></textarea>
<input name="segment" placeholder="segment or leave empty">
<button>Save</button>
</form>

@foreach($templates as $t)
<p>{{ $t->name }} ({{ $t->segment ?? 'generic' }})</p>
@endforeach

@endsection