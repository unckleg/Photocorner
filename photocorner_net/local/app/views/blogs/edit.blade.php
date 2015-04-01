@extends('admin/master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-file-text-o"></i></small>
            Napravi Novi Blog
        </h3>
    </div>
</div>
<div class="row">
    <div class="col-md-10">
        {{ Form::open() }}
        <div class="form-group">
            <label for="title">Naziv</label>
            {{ Form::text('title',$blog->title,array('class'=>'form-control')) }}
        </div>

        <div class="form-group">
            <label for="description">Telo Bloga</label>
            {{ Form::textarea('description',$blog->description,array('class'=>'form-control ckeditor')) }}
        </div>

        <div class="form-group">
            <label for="featured">Obriši ovaj Blog </label>
            {{ Form::checkbox('delete','TRUE', false) }}
            ( <i class="fa fa-info" data-toggle="tooltip" data-placement="top" data-original-title="Deleting this blog, it can't restored"></i> )
        </div>

        {{ Form::submit('Update',array('class'=>'btn btn-success')) }}
        {{ Form::close() }}
    </div>
</div>
@stop
