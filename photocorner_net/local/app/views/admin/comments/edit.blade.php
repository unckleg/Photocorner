@extends('admin/master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-file-text-o"></i></small>
            Izmeni komentar
        </h3>
    </div>
</div>
<div class="row">
    <div class="col-md-10">
        {{ Form::open() }}


        <div class="form-group">
            <label for="description">Komentar</label>
            {{ Form::textarea('comment',$comment->comment,array('class'=>'form-control')) }}
        </div>

        <div class="form-group">
            <label for="featured">Izbriši komentar </label>
            {{ Form::checkbox('delete','TRUE', false) }}
            ( <i class="fa fa-info" data-toggle="tooltip" data-placement="top" data-original-title="Brisanjem komentara izgubićete sve odgovore sa istog"></i> )
        </div>

        {{ Form::submit('Update',array('class'=>'btn btn-success')) }}
        {{ Form::close() }}
    </div>
</div>
@stop
