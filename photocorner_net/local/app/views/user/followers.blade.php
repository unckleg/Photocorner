@extends('master/index')
@section('content')

    @include('user/topbar')
    <style>
        .follwing {
            margin-bottom:10px;
        }
    </style>
    <h1 class="content-heading">{{ t('Users')}} I'm following</h1>

    @foreach($user->followers as $follower)
        <div class="col-md-4 br-right follwing">
            <a href="{{ route('user', ['username' => $follower->user->username]) }}" class="pull-left user-profile-avatar">
                <img src="{{ getAvatar($follower->user,120,120) }}" alt="...">
            </a>
            <h4><a href="{{ route('user', ['username' => $follower->user->username]) }}">{{{ $follower->user->fullname }}}</a><br><small>{{{ $follower->user->username }}}</small></h4>
            @if(Auth::check() == true)
                @if(checkFollow($follower->user->id))
                    <a type="button" class="btn btn-info btn-xs  follow" id="{{ $follower->user->id }}">{{ t('Un Follow') }}</a>
                @else
                    <a type="button" class="btn btn-info btn-xs  follow" id="{{ $follower->user->id }}">{{ t('Follow Me') }}</a>
                @endif
            @endif
        </div>

    @endforeach
@stop