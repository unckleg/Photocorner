@extends('master/index')

@section('style')
	{{ HTML::style('static/css/slike.css') }}
@stop

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>{{ trans(Session::get('reason')) }}</strong>
        </div>
    @endif
    <h1 class="content-heading">{{ t('Registration') }}</h1>
    {{ Form::open() }}
    <div class="form-group">
        <label for="username">{{ t('Select Username') }}<small>*</small></label>
        {{ Form::text('username','',['class'=>'form-control','id'=>'username','placeholder'=>'Izaberite Korisničko ime','required'=>'required'])}}
    </div>

    <div class="form-group">
        <label for="password">{{ t('Password') }}<small>*</small></label>
        {{ Form::password('password',['class'=>'form-control','id'=>'password','placeholder'=>'Unesi šifru','autocomplete'=>'off','required'=>'required']) }}
    </div>
    <div class="form-group">
        <label for="password_confirmation">{{ t('Retype Password') }}<small>*</small></label>
        {{ Form::password('password_confirmation',['class'=>'form-control','id'=>'password_confirmation','placeholder'=>'Potvrdi šifru','autocomplete'=>'off','required'=>'required']) }}
    </div>
      <p><small>Klikom na "Napravi novi nalog" prihvatate sledeće<a href="{{ route('tos') }}"> uslove</a> i <a href="{{ route('privacy') }}">politiku privatnosti</a></small></p>
   {{ Form::submit(t('Create New Account'),['class'=>'btn btn-success'])}}
   {{ Form::close() }}
@stop
