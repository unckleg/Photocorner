@extends('master/index')
@section('meta')
    <meta name="description" content="{{{ Str::limit($blog->description,200) }}}">
    <meta name="keywords" content="{{{ ucfirst($blog->title) }}}">
    <meta property="og:title" content="{{{ ucfirst($blog->title) }}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{ route('blog', ['id' => $blog->id, 'slug' => $blog->slug]) }}"/>
    <meta property="og:description" content="{{{ Str::limit($blog->description,200) }}}"/>
@stop
@section('content')
    <h2 class="content-heading">{{ t('Blog') }}</h2>
    <h1 class="blog-title"><a href="{{ route('blog', ['id' => $blog->id, 'slug' => $blog->slug]) }}">{{{ ucfirst($blog->title) }}}</a></h1>
    <p class="blog-meta">{{ t('Published by') }} <a href="{{ route('user', ['username' => $blog->user->username]) }}">{{{ ucfirst($blog->user->fullname) }}}</a> &middot; <abbr class="timeago comment-time" title="{{ $blog->created_at->toISO8601String() }}">{{ $blog->created_at->toISO8601String() }}</abbr></p>
    <p>{{ $blog->description }}</p>
@stop