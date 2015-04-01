@extends('master/index')

@section('content')
    <h3 class="content-heading">{{ t('Password Reset') }}</h3>

    <h2>Registracija</h2>
    <hr>
    {{ Form::open() }}
    <div class="form-group">
        <label for="email">Email
            <small>*</small>
        </label>
        {{ Form::text('email','',['class'=>'form-control','id'=>'email','placeholder'=>'Vaša email adresa','required'=>'required']) }}
    </div>
    <div class="form-group">
        <label for="recaptcha">Unesite ove reči
            <small>*</small>
        </label>
        {{ app('captcha')->display() }}
    </div>

    {{ Form::submit('Promeni šifru',['class'=>'btn btn-success'])}}
    {{ Form::close() }}
@stop