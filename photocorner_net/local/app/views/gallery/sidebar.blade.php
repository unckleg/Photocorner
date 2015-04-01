<div class="clearfix">
    <h3 class="content-heading">{{ t('Share This') }}</h3>
    @include('master/share')
</div>
<div class="clearfix">
    <h3 class="content-heading">{{ t('Featured Image') }}</h3>

    <div class="imagesFromUser">
        @foreach(getFeaturedImage() as $featuredImage)
            <a href="{{ route('image', ['id' => $featuredImage->id, 'slug' => $featuredImage->slug]) }}" class="pull-left userimage">
                <img src="{{ reSizeImage($featuredImage,223,223,'zoomCrop') }}"
                     alt="{{{ $featuredImage->title }}}" class="thumbnail">
            </a>
        @endforeach
    </div>
</div>
@if(getFeaturedUser()->count() >= 1)
    <div class="clearfix">
        <h3 class="content-heading">{{ t('Featured User') }}</h3>

        <div class="imagesFromUser">
            @foreach(getFeaturedUser() as $featuredUser)
                <div class="col-md-12">
                    <div class="row">
                        <a href="{{ route('user', ['username' => $featuredUser->username]) }}" class="thumbnail pull-left">
                            <img src="{{ getAvatar($featuredUser,69,69) }}" alt="{{{ $featuredUser->fullname }}}">
                        </a>

                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <p><strong><a href="{{ route('user', ['username' => $featuredUser->username]) }}">{{{ $featuredUser->fullname }}}</a></strong></p>
                            @if(Auth::check())
                                @if(checkFollow($featuredUser->id))
                                    <button class="btn btn-default btn-xs replyfollow follow" id="{{ $featuredUser->id }}">{{ t('Un-Follow') }}</button>
                                @else
                                    <button class="btn btn-default btn-xs replyfollow follow" id="{{ $featuredUser->id }}">{{ t('Follow Me') }}</button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
<div class="clearfix">
    <h3 class="content-heading">{{ t('More From') }} {{ siteSettings('siteName') }}</h3>

    <div class="more-from-site">
        @foreach(moreFromSite() as $sidebarImage)
            <a href="{{ route('image', ['id' => $sidebarImage->id, 'slug' => $sidebarImage->slug]) }}"><img src="{{ reSizeImage($sidebarImage,70,70,'zoomCrop') }}" alt="{{{ $sidebarImage->title }}}"/></a>
        @endforeach
    </div>
</div>