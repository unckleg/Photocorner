@extends('master/index')

@section('style')
   {{ HTML::style('static/css/slike.css') }}
@stop

@section('content')
   <h3 class="content-heading">{{ t('Users')}} </h3>
   @foreach($users as $user)
      <div class="row">
         <div class="col-md-6">
            <div class="row">
               <div class="col-md-4 col-sm-3 pull-left" style="margin-bottom:15px;min-wdth:100px">
                  <a href="{{ route('user', ['user' => $user->username]) }}"><img class="thumbnail img-responsive" src="{{ getAvatar($user,114,114) }}"></a>
               </div>
               <div class="col-md-8">
                  <h3 style="margin-top:0px">
                     <a href="{{ route('user', ['user' => $user->username]) }}">{{{ ucfirst($user->fullname) }}}</a>
                     <p>
                        <small><i class="glyphicon glyphicon-comment"></i> {{ $user->comments->count() }} komentara &middot; <i class="glyphicon glyphicon-picture"></i> {{ $user->images->count() }} fotografija</small>
                     </p>
                  </h3>
                  <p>{{{ Str::limit($user->about_me,50) }}}</p>
               </div>
            </div>
         </div>
         @foreach($user->latestImages->take(3) as $image)
            <div class="col-md1 col-md-2 col-sm-3 col-xs-3" style="display: block;min-width:100px">
               <a href="{{ route('image', ['id' => $image->id, 'slug' => $image->slug]) }}"><img src="{{ reSizeImage($image,200,200,'zoomCrop') }}" class="img-responsive thumbnail"></a>
            </div>
         @endforeach
      </div>
      <hr>
   @endforeach
@stop
@section('pagination')
   <div class="row">
      <div class="container">
         <div class="col-md-12">{{ $users->links() }}</div>
      </div>
   </div>
@stop