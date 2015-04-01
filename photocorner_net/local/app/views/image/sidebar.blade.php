<div class="col-md-4">
   <h3 class="block-heading">{{ t('Author') }}</h3>
   <div class="image-author">
      <img src="{{ getAvatar($image->user,80,80) }}" alt=""/>
      <a href="{{ route('user', ['username' => $image->user->username]) }}">{{{ ucfirst($image->user->fullname) }}}</a>
      <p>
         <small>{{ $image->user->username }}</small>
      </p>
      @if(Auth::check() == false)
         <button class="btn btn-info btn-xs replyfollow follow" id="{{ $image->user->id }}">Follow Me
         </button>
      @else
         @if(Auth::user()->id == $image->user->id)
            <a class="btn btn-success btn-xs" href="{{ route('users.settings') }}">{{ t('Edit Profile') }}</a>
         @else
            @if(checkFollow($image->user->id))
               <button class="btn btn-default btn-xs replyfollow follow" id="{{ $image->user->id }}">{{ t('Un Follow') }}
               </button>
            @else
               <button class="btn btn-default btn-xs replyfollow follow" id="{{ $image->user->id }}">{{ t('Follow Me') }}
               </button>
            @endif
         @endif
      @endif
   </div>
   <hr/>
   <h3 class="block-heading">{{ t('Color Palette') }}</h3>
   <div class="colorPalettes clearfix">
   </div>
   @include('image/exif')
   <h3 class="block-heading">{{ t('Tags') }}</h3>
   <ul class="list-inline taglist">
      @foreach(explode(',',$image->tags) as $tag)
         <li><a href="{{ route('tag', ['tag' => urlencode($tag)]) }}" class="tag"><span
                       class="label label-info">{{{ $tag }}}</span></a></li>
      @endforeach
   </ul>
   <h3 class="block-heading">{{ t('Share This') }} {{ siteSettings('siteName') }}</h3>
   <div class="clearfix">
      <div class="more-from-site">
         @include('master/share')
      </div>
   </div>
   <h3 class="block-heading">{{ t('More From') }} {{ siteSettings('siteName') }}</h3>
   <div class="clearfix">
      <div class="more-from-site">
         @foreach(moreFromSite() as $sidebarImage)
            <a href="{{ route('image', ['id' => $sidebarImage->id, 'slug' => $sidebarImage->slug]) }}"><img src="{{ reSizeImage($sidebarImage,70,70,'zoomCrop') }}" alt="{{{ $sidebarImage->title }}}"/></a>
         @endforeach
      </div>
   </div>
   @if($image->favorite->count() >= 1)
      <!-- DIMPLY USERS WHO FAVORITE THIS IMAGE -->
      <h3 class="block-heading">{{ t('Favorites') }} <small class="pull-right">{{ $image->favorite->count() }}</small></h3>
      <div class="clearfix">
         <div class="more-from-site">
            @foreach($image->favorite()->take(16)->get() as $sidebarImage)
               <a href="{{ route('user', ['username' => $sidebarImage->user->username]) }}"><img src="{{ getAvatar($sidebarImage->user,70,70) }}" alt="{{{ $sidebarImage->user->fullname }}}"/></a>
            @endforeach
         </div>
      </div>
   @endif
</div>