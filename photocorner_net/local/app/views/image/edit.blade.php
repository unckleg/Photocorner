@extends('master/index')
@section('meta')
    <meta name="description" content="{{ strlen($image->description) > 2 ? e($image->description) : e($image->title).' '.siteSettings('description') }}">
    <meta name="keywords" content="{{ strlen($image->tags) > 2 ? $image->tags : e($image->title) }}">
    <meta property="og:title" content="{{ ucfirst($image->title) }} - {{ siteSettings('siteName') }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{ route('image', ['id' => $image->id, 'slug' => $image->slug]) }}"/>
    <meta property="og:description" content="{{ route('image', ['id' => $image->id, 'slug' => $image->slug]) }}"/>
    <meta property="og:image" content="{{ reSizeImage($image, 1140, 1140, 'cropResize') }}"/>
@stop

@section('content')
    <h1 class="content-heading">{{ t('Editing Image') }}</h1>
    {{ Form::open() }}
    <div class="form-group">
        <label for="title">{{ t('Title') }}</label>
        {{ Form::text('title',$image->title,['class'=>'form-control','required'=>'required']) }}
    </div>
    <div class="form-group">
        <label for="title">{{ t('Description') }}</label>
        {{ Form::textarea('description',$image->image_description,['class'=>'form-control']) }}
    </div>
    <div class="form-group">
        <label for="category">{{ t('Category') }}</label>
        {{ Form::select('category', array_pluck(siteCategories(), 'name', 'id'),$image->category->id,['class' => 'form-control', 'required' => 'required']) }}
    </div>

    <div class="form-group">
        <input type="text" autocomplete="off" name="tags" placeholder="Tags" class="form-control tagging" value="{{{ $image->tags }}}"/>
    </div>

    <div class="form-group">
        {{ Form::submit('Update Image',array('class'=>'btn btn-success')) }}
    </div>
    {{ Form::close() }}

@stop

@section('extrafooter')
    <script>
        $(function(){
            $('.tagging').select2({
                minimumInputLength: 3,
                maximumSelectionSize: {{ (int)siteSettings('tagsLimit') }},
                placeholder: $(this).attr('placeholder'),
                tags: [],
                tokenSeparators: [","]
                // width: '360px'
            });
        });
    </script>
@stop

@section('sidebar')
    @include('image/sidebar')
@stop