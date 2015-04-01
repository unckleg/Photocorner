<div class="col-md-3">
    <a href="{{ route('user', ['username' => $user->username]) }}" class="thumbnail">
        <img src="{{ getAvatar($user,263,236) }}" alt="{{ $user->username }}">
    </a>

    <h1 class="profile-fullname">
        <span>{{{ $user->fullname }}}</span>

        <p>
            <small>{{{ $user->username }}}</small>
        </p>
    </h1>
    <hr>
    <h2 class="profile-social">
        <a href="{{ route('users.rss', ['username' => $user->username]) }}" class="black entypo-rss" target="_blank"></a>
        @if(strlen($user->fb_link) > 2)
            <a href="{{ addhttp($user->fb_link) }}" class="black entypo-facebook" target="_blank"></a>
        @endif
        @if(strlen($user->tw_link) > 2)
            <a href="{{ addhttp($user->tw_link) }}" class="black entypo-twitter" target="_blank"></a>
        @endif
        @if(strlen($user->blogurl) > 2)
            <a href="{{ addhttp($user->blogurl) }}" class="black fa fa-link" target="_blank"></a>
        @endif
    </h2>
    <hr>
    @if(Auth::check() == true)
        @if(Auth::user()->id == $user->id)
            <a href="{{ route('users.settings') }}" type="button" class="btn btn-info btn-lg btn-block">{{ t('Edit My Profile') }}</a>
            <a href="{{ route('users.following', ['username' => Auth::user()->username]) }}" type="button" class="btn btn-info btn-lg btn-block">{{ t("I'm following") }}</a>
        @else
            @if(checkFollow($user->id))
                <a type="button" class="btn btn-default btn-lg btn-block follow" id="{{ $user->id }}">{{ t('Un Follow') }}</a>
            @else
                <a type="button" class="btn btn-default btn-lg btn-block follow" id="{{ $user->id }}">{{ t('Follow Me') }}</a>
            @endif
        @endif
        <hr>
    @endif

    <div class="userdetails">
        <h3 class="content-heading">{{ $user->followers->count() }}&nbsp;&nbsp; {{ t('Followers') }}
            <small class="pull-right"><a href="{{ route('users.followers',  ['username' => $user->username]) }}">{{ t('See all') }}</a></small>
        </h3>

        <div class="clearfix">
            <div class="imagesFromUser">
                @foreach($user->followers->take(9) as $follower)
                    <a href="{{ route('user', ['username' => $follower->user->username]) }}" class="pull-left userimage">
                        <img src="{{ getAvatar($follower->user,69,69) }}" alt="{{{ $follower->user->fullname }}}" class="thumbnail">
                    </a>
                @endforeach
            </div>
        </div>

        <h3 class="content-heading">{{ t('Status') }}</h3>

        <p><i class="fa fa-eye"></i> {{ $user->images()->sum('views') }} {{ t('Views') }}</p>

        <p><i class="fa fa-picture-o"></i> {{ $user->images()->count() }} {{ t('Images Shared') }}</p>

        <p><i class="fa fa-comments"></i> {{ $user->comments()->count() }} {{ t('Comments') }}</p>

        <h3 class="content-heading">{{ t('Most Used Tags') }}</h3>
        @foreach($mostUsedTags as $tag => $key)
            <a href="{{ url('tag/'.urlencode($key)) }}" class="tag"><span class="label label-info">{{{ $key }}}</span></a>
        @endforeach
        <hr>

        @if(strlen($user->about_me) > 2)
            <h3 class="content-heading">{{ t('About Me') }}</h3>

            <p>{{{ $user->about_me }}}</p>
            <hr>
        @endif

        @if(strlen($user->country) == 2)
            <h3 class="content-heading">{{ t('Country') }}</h3>

            <p>{{ countryResolver($user->country) }}</p>
            <hr>
        @endif

    </div>


    @if(Auth::check() === true AND Auth::user()->id != $user->id)
        <small><a href="{{ route('user.report',['username' => $user->username]) }}">{{ t('Report') }}</a></small>
    @endif
</div>