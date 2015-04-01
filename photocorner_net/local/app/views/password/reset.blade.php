@extends('master/index')

@section('content')
    <h3 class="content-heading">{{ t('New Password') }}</h3>

    @if (Session::has('error'))
        <div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>{{ trans(Session::get('error')) }}</strong>
        </div>
    @endif

    {{ Form::open() }}
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="form-group">
        <label for="email">Email<small>*</small></label>
        {{ Form::text('email','',['class'=>'form-control','id'=>'email','placeholder'=>'Vaša email adresa','required'=>'required']) }}
    </div>
    <div class="form-group">
        <label for="password">Nova Šifra<small>*</small></label>
        {{ Form::password('password',['class'=>'form-control','id'=>'password','placeholder'=>'Enter Password','autocomplete'=>'off','required'=>'required']) }}
    </div>
    <div class="form-group">
        <label for="password_confirmation">Potvrdi šifru<small>*</small></label>
        {{ Form::password('password_confirmation',['class'=>'form-control','id'=>'password_confirmation','placeholder'=>'Confirm Password','autocomplete'=>'off','required'=>'required']) }}
    </div>
    {{ Form::submit('Promeni šifru',['class'=>'btn btn-success'])}}
    {{ Form::close() }}
@stop