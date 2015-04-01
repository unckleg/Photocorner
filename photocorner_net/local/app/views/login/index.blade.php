@extends('master/index')

@section('style')
	{{ HTML::style('static/css/slike.css') }}
@stop

@section('content')
<h1 class="content-heading">{{ t('Login') }}</h1>

{{ Form::open() }}
<div class="form-group">
    <label for="username">{{ t('Username or Email address') }}</label>
    {{ Form::text('username','',array('class'=>'form-control','id'=>'username','placeholder'=>t('Username or Email address')))}}
</div>
<div class="form-group">
    <label for="password">{{ t('Password') }}</label>
    {{ Form::password('password',array('class'=>'form-control','id'=>'password','placeholder'=>t('Password'),'autocomplete'=>'off')) }}
</div>
<div class="checkbox">
    <label>
       {{ t('Remember Me') }} {{ Form::checkbox('remember-me', 'value') }}
    </label>
    &nbsp;&middot;&nbsp; <a href="{{ url('password/remind') }}">Zaboravili ste šifru? </a>
</div>
{{ Form::submit(t('Login'),array('class'=>'btn btn-success')) }} ili putem <a href="{{ url('get/facebook') }}"><img src="{{ asset('static/img/facebook.png') }}"></a>&nbsp;<a href="{{ url('get/google') }}"><img src="{{ asset('static/img/google.png') }}"></a>
{{ Form::close() }}

@stop