@extends('master/index')
@section('content')
   @if (Session::has('error'))
      <div class="alert alert-danger fade in">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <strong>{{ trans(Session::get('reason')) }}</strong>
      </div>
   @endif
   <h1 class="content-heading">{{ t('Registration') }}</h1>
   <h3 class="content-heading"><a href="{{ url('get/facebook') }}"><img src="{{ asset('static/img/facebook.png') }}"></a>&nbsp;<a href="{{ url('get/google') }}"><img src="{{ asset('static/img/google.png') }}"></a></h3>

   {{ Form::open() }}
   <div class="form-group">
      <label for="username">{{ t('Select Username') }}<small>*</small></label>
      {{ Form::text('username','',['class'=>'form-control','id'=>'username','placeholder'=>t('Select Username'),'required'=>'required'])}}
   </div>
   <div class="form-group">
      <label for="email">{{ t('Your Email') }}<small>*</small></label>
      {{ Form::text('email','',['class'=>'form-control','type'=>'email','id'=>'email','placeholder'=>t('Your Email'),'required'=>'required'])}}
   </div>
   <div class="form-group">
      <label for="fullname">{{ t('Your Full Name') }}<small>*</small></label>
      {{ Form::text('fullname','',['class'=>'form-control','id'=>'fullname','placeholder'=>t('Your Full Name'),'required'=>'required'])}}
   </div>
   <div class="form-group">
      <label for="gender">{{ t('Gender') }}<small>*</small></label>
      {{ Form::select('gender', ['male' => 'Muško', 'female' => 'Žensko'], 'male',['id'=>'gender','class'=>'form-control','required'=>'required']) }}
   </div>
   <div class="form-group">
      <label for="password">{{ t('Password') }}<small>*</small></label>
      {{ Form::password('password',['class'=>'form-control','id'=>'password','placeholder'=>t('Enter Password'),'autocomplete'=>'off','required'=>'required']) }}
   </div>
   <div class="form-group">
      <label for="password_confirmation">{{ t('Retype Password') }}<small>*</small></label>
      {{ Form::password('password_confirmation',['class'=>'form-control','id'=>'password_confirmation','placeholder'=>'Potvrdi Šifru','autocomplete'=>'off','required'=>'required']) }}
   </div>
   <div class="form-group">
      <label for="recaptcha">{{ t('Type these words') }}<small>*</small></label>
      {{ app('captcha')->display() }}
   </div>
   <p><small>Klikom na "Napravi novi nalog" prihvatate sledeće<a href="{{ route('tos') }}"> uslove</a> i <a href="{{ route('privacy') }}">politiku privatnosti</a></small></p>
   {{ Form::submit(t('Create New Account'),['class'=>'btn btn-success'])}}
   {{ Form::close() }}

@stop