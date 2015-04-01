@extends('master/index')
@section('content')

    @include('user/topbar')
    <style>
        .follwing {
            margin-bottom:10px;
        }
    </style>
    <h1 class="content-heading">{{ t('Users')}} I'm following</h1>

    @foreach($user->following as $follower)
        <div class="col-md-4 br-right follwing">
            <a href="{{ route('user', ['username' => $follower->followingUser->username]) }}" class="pull-left user-profile-avatar">
                <img src="{{ getAvatar($follower->followingUser,120,120) }}" alt="...">
            </a>
            <h4>{{{ $follower->followingUser->fullname }}}<br><small>{{{ $follower->followingUser->username }}}</small></h4>
            @if(Auth::check() == true)
                @if(checkFollow($follower->followingUser->id))
                    <a type="button" class="btn btn-info btn-xs  follow" id="{{ $follower->followingUser->id }}">{{ t('Un Follow') }}</a>
                @else
                    <a type="button" class="btn btn-info btn-xs  follow" id="{{ $follower->followingUser->id }}">{{ t('Follow Me') }}</a>
                @endif
            @endif
        </div>

    @endforeach
@stop