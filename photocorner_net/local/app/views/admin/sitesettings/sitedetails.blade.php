@extends('admin/master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-wrench"></i></small>
            Detalji Mreže
        </h3>
    </div>
</div>
<div class="row">
    <div class="col-md-10">
        {{ Form::open() }}
        <div class="form-group">
            <label for="sitename">Ime Mreže</label>
            {{ Form::text('sitename',siteSettings('siteName'),array('class'=>'form-control')) }}
        </div>

        <div class="form-group">
            <label for="description">Opis</label>
            {{ Form::text('description',siteSettings('description'),array('class'=>'form-control')) }}
        </div>

        <div class="form-group">
            <label for="favicon">Favicon URL <small>( http://example.com/favicon.ico )</small></label>
            {{ Form::text('favicon',siteSettings('favIcon'),array('class'=>'form-control')) }}
        </div>

        <div class="form-group">
            <label for="tos">Terms Of Services</label>
            {{ Form::textarea('tos',htmlspecialchars(siteSettings('tos')),array('class'=>'form-control ckeditor')) }}
        </div>

        <div class="form-group">
            <label for="privacy">Privacy Policy</label>
            {{ Form::textarea('privacy',htmlspecialchars(siteSettings('privacy')),array('class'=>'form-control ckeditor')) }}
        </div>

        <div class="form-group">
            <label for="faq">Frequently Asked Questions</label>
            {{ Form::textarea('faq',htmlspecialchars(siteSettings('faq')),array('class'=>'form-control ckeditor')) }}
        </div>

        <div class="form-group">
            <label for="about">O Nama</label>
            {{ Form::textarea('about',htmlspecialchars(siteSettings('about')),array('class'=>'form-control ckeditor')) }}
        </div>

        {{ Form::submit('Update',array('class'=>'btn btn-success')) }}
        {{ Form::close() }}
    </div>
</div>
@stop
