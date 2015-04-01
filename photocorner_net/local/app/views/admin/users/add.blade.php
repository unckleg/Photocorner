@extends('admin/master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><small><i class="fa fa-plus"></i></small> Dodavanje novog Korisnika
        </h3>
    </div>
</div>

<div class="row">


<div class="col-md-9">
    {{ Form::open() }}

    <div class="form-group">
        <label for="username">Korisničko Ime</label>
        {{ Form::text('username','',array('class'=>'form-control','placeholder'=>'Izaberite originalno korisničko ime')) }}
    </div>

    <div class="form-group">
        <label for="username">Puno Ime</label>
        {{ Form::text('fullname','',array('class'=>'form-control','placeholder'=>'Novo korisničko puno ime')) }}
    </div>

    <div class="form-group">
        <label for="username">Email</label>
        {{ Form::text('email','',array('class'=>'form-control','placeholder'=>'Novi korisnički Email')) }}
    </div>

    <div class="form-group">
        <label for="username">Zaštitna Šifra</label>
        {{ Form::password('password',array('class'=>'form-control','placeholder'=>'Nova korisnička šifra')) }}
    </div>


    <div class="form-group">
        {{ Form::submit('Dodaj Korisnika',array('class'=>'btn btn-success')) }}
    </div>

    {{ Form::close() }}
</div>
</div>
@stop
