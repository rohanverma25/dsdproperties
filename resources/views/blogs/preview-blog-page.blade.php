@extends('layouts.app')


@section('content')
    <article class="bg-white p-6 rounded-xl shadow">
        <div class="prose max-w-none">
            @include("blogs.html")
        </div>
    </article>
@endsection
