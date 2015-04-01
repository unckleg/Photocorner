@extends('master/index')

@section('content')
    <h2 class="content-heading">{{ $title }}</h2>

    @foreach($blogs as $blog)
        <h1 class="blog-title"><a href="{{ route('blog', ['id' => $blog->id, 'slug' => $blog->slug]) }}">{{ ucfirst($blog->title) }}</a></h1>
        <p class="blog-meta">{{ t('Published by') }} <a href="{{ route('user', ['username' => $blog->user->username]) }}">{{ $blog->user->fullname }}</a> &middot; <abbr class="timeago comment-time" title="{{ $blog->created_at->toISO8601String() }}">{{ $blog->created_at->toISO8601String() }}</abbr></p>
        <p>{{ $blog->description }}</p>
        <hr/>
    @endforeach

@stop

@section('pagination')
    <div class="row">
        <div class="container">
            {{ $blogs->links() }}
        </div>
    </div>
@stop