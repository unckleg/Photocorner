@extends('master/index')
@section('meta')
    <meta name="description" content="{{ strlen($user->about_me) > 2 ? e($user->about_me) : e($user->fullname).' '.siteSettings('description') }}">
    <meta name="keywords" content="{{ $user->fullname. ' ' .$user->username }}">
    <meta property="og:title" content="{{ ucfirst($user->fullname) }} {{ t('profil') }} - {{ siteSettings('siteName') }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{ route('user', ['id' => $user->username]) }}"/>
    <meta property="og:description" content="{{ strlen($user->about_me) > 2 ? e($user->about_me) : e($user->fullname).' '.siteSettings('description') }}"/>
    <meta property="og:image" content="{{ getAvatar($user,100,100) }}"/>
@stop
@section('content')
    @include('user/topbar')
    <h1 class="content-heading">{{{ ucfirst($user->fullname) }}} Profil</h1>
    <div class="gallery">
        <span id="links"></span>
        @foreach(array_chunk($images->getCollection()->all(),3) as $img)
            <div class="row">
                @foreach($img as $image)
                    @if($image->deleted_at == null)
                        <div class="col-md-4 col-sm-4 gallery-display">
                            @if($image->featured_at)
                                <div class="right-ribbon">
                                    {{ t('Featured') }}
                                </div>
                            @endif
                            <figure>
                                <a href="{{ route('image', ['id' => $image->id, 'slug' => $image->slug]) }}"><img data-original="{{ reSizeImage($image,360,360,'zoomCrop') }}"  alt="{{{ Str::limit(ucfirst($image->title),30) }}}" class="display-image"></a>
                                <a href="{{ route('image', ['id' => $image->id, 'slug' => $image->slug]) }}" class="figcaption">
                                    <h3>{{{ Str::limit(ucfirst($image->title),40) }}}</h3>
                                    <span>{{{ Str::limit(ucfirst($image->image_description),80) }}}</span>
                                </a>
                            </figure>
                            <div class="box-detail">
                                <h5 class="heading"><a href="{{ route('image', ['id' => $image->id, 'slug' => $image->slug]) }}">{{{ Str::limit(ucfirst($image->title),15) }}}</a></h5>
                                <ul class="list-inline gallery-details">
                                    <li><a href="{{ route('user', ['username' => $image->user->username]) }}">{{{ ucfirst($image->user->fullname) }}}</a></li>
                                    <li class="pull-right"><i class="fa fa-eye"></i> {{ $image->views }} <i class="fa fa-heart"></i> {{ $image->favorite->count() }} <i class="fa fa-comments"></i> {{ $image->comments->count() }}
                                        <span id="links"><a href="{{ reSizeImage($image,1140,1140,'cropResize') }}" title="{{{ ucfirst($image->title) }}}" data-gallery data-description="{{{ $image->image_description }}}"><i class="fa fa-external-link"></i></a></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endforeach
        <div id="blueimp-gallery" class="blueimp-gallery">
            <div class="slides"></div>
            <h3 class="title"></h3>

            <p class="description"></p>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>
        <!--.blueimp-gallery-->
    </div>
@stop
@section('pagination')
    <div class="row">
        <div class="container">
            <div class="col-md-12"> {{ $images->links() }}</div>
        </div>
    </div>
@stop