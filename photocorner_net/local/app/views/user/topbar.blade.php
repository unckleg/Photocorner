<div class="row">
    <div class="col-md-3 br-right">
        <a href="{{ route('user', ['username' => $user->username]) }}" class="pull-left user-profile-avatar">
            <img src="{{ getAvatar($user,100,100) }}" alt="{{ $user->fullname }}">
        </a>
        <h4>{{{ ucfirst($user->fullname) }}} <br/>
            <small>{{{ $user->username }}}</small>
        </h4>
        @if(Auth::check() == true)
            @if(Auth::user()->id == $user->id)
                <p><a href="{{ route('users.settings') }}" type="button" class="btn btn-info btn-xs">{{ t('Edit My Profile') }}</a></p>
                <p><a href="{{ route('users.following', ['username' => $user->username]) }}" type="button" class="btn btn-info btn-xs">{{ t("I'm following") }}</a></p>
            @else
                @if(checkFollow($user->id))
                    <a type="button" class="btn btn-info btn-xs  follow" id="{{ $user->id }}">{{ t('Un Follow') }}</a>
                @else
                    <a type="button" class="btn btn-info btn-xs  follow" id="{{ $user->id }}">{{ t('Follow Me') }}</a>
                @endif
            @endif
        @endif
    </div>

    <div class="col-md-3 br-right">
        <div class="col-md-6 br-right">
            <h3>{{ $user->images->count() }} <br/>
                <small>{{ t('images') }}</small>
            </h3>
        </div>
        <div class="col-md-6">
            <p>{{ $user->images->sum('views') }} {{ t('Views') }}</p>

            <p>{{ $user->comments->count() }} {{ t('Comments') }}</p>

            <p>{{ $user->followers->count() }} <a href="{{ route('users.followers', ['username' => $user->username]) }}">{{ t('Followers') }}</a></p>

            <p>{{ $user->favorites->count() }} <a href="{{ route('users.favorites', ['username' => $user->username]) }}">{{ t('Favorites') }}</a></p>
        </div>
    </div>

    <div class="col-md-2 br-right">
        <p>Lokacija {{ countryResolver($user->country) }}</p>

        <p>{{{ $user->about_me }}}</p>
    </div>

    <div class="col-md-4 br-right">
        <div class="col-md-4 br-right">
            <p><a href="{{ route('users.rss', ['username' => $user->username]) }}" class="black entypo-rss" target="_blank"> RSS</a></p>
            @if(strlen($user->fb_link) > 2)
                <p><a href="{{ addhttp($user->fb_link) }}" class="black entypo-facebook" target="_blank"> Facebook</a></p>
            @endif
            @if(strlen($user->tw_link) > 2)
                <p><a href="{{ addhttp($user->tw_link) }}" class="black entypo-twitter" target="_blank"> Twitter</a></p>
            @endif
            @if(strlen($user->blogurl) > 2)
                <p><a href="{{ addhttp($user->blogurl) }}" class="black fa fa-link" target="_blank"> Blog Url</a></p>
            @endif
        </div>
        <div class="col-md-8">
            <p>Najviše korišćene oznake</p>
            @foreach($mostUsedTags as $tag => $key)
                <a href="{{ route('tag', ['tag' => urlencode($key)]) }}" class="tag"><span class="label label-info">{{{ $key }}}</span></a>
            @endforeach
        </div>
    </div>
</div>
<hr/>