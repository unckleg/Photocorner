@extends('master/index')
@section('meta')
   <meta name="description" content="{{ strlen($image->image_description) > 2 ? e($image->image_description) : e($image->title).' '.siteSettings('description') }}">
   <meta name="keywords" content="{{ strlen($image->tags) > 2 ? $image->tags : e($image->title) }}">
   <meta property="og:title" content="{{ ucfirst($image->title) }} - {{ siteSettings('siteName') }}"/>
   <meta property="og:type" content="article"/>
   <meta property="og:url" content="{{ route('image', ['id' => $image->id, 'slug' => $image->slug]) }}"/>
   <meta property="og:description" content="{{ strlen($image->image_description) > 2 ? e($image->image_description) : e($image->title).' '.siteSettings('description') }}"/>
   <meta property="og:image" content="{{ reSizeImage($image, 1140, 1140, 'cropResize') }}"/>
@stop

@section('style')
   {{ HTML::style('static/css/slike.css') }}
@stop

@section('content')
   <h1 class="content-heading">{{{ ucfirst($image->title) }}}</h1>
   <div class="main-image">
      @if($next)
         <div class="controlArrow controlArrow-prev "><a href="{{ route('image', ['id' => $next->id, 'slug' => $next->slug]) }}" class="fa fa-chevron-left"></a></div>
      @endif
      @if($previous)
         <div class="controlArrow controlArrow-next"><a href="{{ route('image', ['id' => $previous->id, 'slug' => $previous->slug]) }}" class="fa fa-chevron-right"></a></div>
      @endif
      <p><img src="{{ reSizeImage($image,1140,1140,'cropResize') }}" alt="{{{ ucfirst($image->title) }}}" class="mainImage img-thumbnail"/></p>
   </div>
   <!--.main-image-->
   <div class="clearfix">
      <div class="image-details">
         <div class="col-md-8">
            <h3 class="block-heading">
               {{ t('Description') }}
               <span class="pull-right">
               <div class="btn-group  btn-group-xs">
                  @if(checkFavorite($image->id) == true)
                     <button type="button" class="btn btn-danger favoritebtn" id="{{ $image->id }}"><i class="fa fa-heart"></i> {{ t('Un-Favorite') }}</button>
                  @else
                     <button type="button" class="btn  btn-success favoritebtn" id="{{ $image->id }}"><i class="fa fa-heart"></i> {{ t('Favorite') }}</button>
                  @endif
                  <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">
                     {{ t('More') }}
                     <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                     @if(siteSettings('allowDownloadOriginal') == 1 || siteSettings('allowDownloadOriginal') == 'leaveToUser' && $image->allow_download == 1)
                        <li>
                           <a href="{{ route('images.download', ['any' => Crypt::encrypt($image->id)]) }}">{{ t('Download Original') }}</a>
                        </li>
                     @endif
                     <li><a href="{{ route('images.report', ['id' => $image->id, 'slug' => $image->slug]) }}">{{ t('Report') }}</a></li>
                     @if(Auth::check() == true && Auth::user()->id == $image->user_id)
                        <li><a href="{{ route('images.edit', ['id' => $image->id, 'slug' => $image->slug]) }}">{{ t('Edit') }}</a></li>
                     @endif
                     @if(Auth::check() == true && Auth::user()->id == $image->user_id)
                        <li><a href="{{ route('images.delete', ['id' => $image->id, 'slug' => $image->slug]) }}">{{ t('Delete') }}</a></li>
                     @endif
                     @if(Auth::check() == true && Auth::user()->permission == 'admin')
                        <li><a href="{{ url('admin/image/'.$image->id.'/edit') }}">Edit From Admin Panel</a></li>
                     @endif
                  </ul>
                  <!-- end of dropdown menu-->
               </div>
            </span>
            </h3>
            <p>{{ nl2br(Smilies::parse(makeLinks(HTML::entities($image->image_description)))) }}</p>
         </div>
         <div class="col-md-4">
            <h3 class="block-heading">{{ t('Details') }}</h3>
            <div class="image-status">
               <ul class="list-inline">
                  <li><i class="fa fa-eye"> {{ $image->views }}</i></li>
                  <li><i class="fa fa-heart"></i> {{ $image->favorite->count() }}</li>
                  <li><i class="fa fa-comments"></i> {{ $image->comments->count() }}</li>
                  <li><i class="fa fa-download"></i> {{ $image->downloads }}</li>
               </ul>
            </div>
         </div>
         <!-- .col-md-4 -->
      </div>
   </div>
   <!--.clearfix-->
   @include('image/comment')
   @include('image/sidebar')
@stop