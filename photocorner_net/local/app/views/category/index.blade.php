@extends('master/index')
{{--Title of the page--}}
@section('title')
   @if(Input::get('category')){{{ $title }}} {{{ t('in category') }}} {{ getCategoryName(Input::get('category')) }}@else{{{ $title }}}@endif
@stop


@section('style')
	{{ HTML::style('static/css/slike.css') }}
@stop


{{--Main cotent--}}
@section('content')
   @if(Input::get('category'))
      <h1 class="content-heading">{{{ $title }}} {{{ t('in category') }}} {{ getCategoryName(Input::get('category')) }}</h1>
   @else
      <h1 class="content-heading">{{{ $title }}}</h1>
   @endif
   @include('gallery/util-list') 
   <div class="gallery"> 
      <span id="links"></span>
      @foreach(array_chunk($images->getCollection()->all(),5) as $img)
         <div class="row">
            @foreach($img as $image)
               @if($image->user)
                  <div class="col-xs-15 col-sm-3 gallery-display">
                     @if($image->featured_at)
                        <div class="right-ribbon"> 
                           {{ t('Featured') }}
                        </div>
                     @endif
                     <figure>
                        <a href="{{ route('image', ['id' => $image->id, 'slug' => $image->slug]) }}">
                           <img data-original="{{ reSizeImage($image,360,360,'zoomCrop') }}" alt="{{{ Str::limit(ucfirst($image->title),30) }}}" class="display-image">
                        </a>
                        <a href="{{ route('image', ['id' => $image->id, 'slug' => $image->slug]) }}" class="figcaption">
                           <h3>{{{ Str::limit(ucfirst($image->title),40) }}}</h3>
                           <span>{{{ Str::limit(ucfirst($image->image_description),80) }}}</span>
                        </a>
                     </figure>
                     <!--figure-->
                     <div class="box-detail">
                        <h5 class="heading"><a href="{{ route('image', ['id' => $image->id, 'slug' => $image->slug]) }}">{{{ Str::limit(ucfirst($image->title),15) }}}</a></h5>
                        <ul class="list-inline gallery-details">
                           <li><a href="{{ route('user', ['username' => $image->user->username]) }}">{{{ ucfirst($image->user->fullname) }}}</a></li>
                           <li class="pull-right"><i class="fa fa-eye"></i> {{ $image->views }} <i class="fa fa-heart"></i> {{ $image->favorite->count() }} <i class="fa fa-comments"></i> {{ $image->comments->count() }}
                              <span id="links"><a href="{{ reSizeImage($image,1140,1140,'cropResize') }}" title="{{{ ucfirst($image->title) }}}" data-gallery data-description="{{{ $image->image_description }}}"><i class="fa fa-external-link"></i></a></span>
                           </li>
                        </ul>
                     </div>
                     <!--.box-detail-->
                  </div>
                  <!--.gallery-display-->
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