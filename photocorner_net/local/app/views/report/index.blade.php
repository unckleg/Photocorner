@extends('master/index')
@section('content')
    <h1 class="content-heading">{{ $title }}</h1>

    {{ Form::open() }}
    <div class="form-group">
        <label for="report">Razlog za prijavu</label>
        {{ Form::textarea('report','',['class'=>'form-control','id'=>'username','placeholder'=>'Upišite detalje'])}}
    </div>
    <div class="form-group">
        {{ Form::submit('Prijavi',['class'=>'btn btn-default'])}}
    </div>
    {{ Form::close() }}
@stop