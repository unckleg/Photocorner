@extends('admin/master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <h3 class="page-header">
         <small><i class="fa fa-edit"></i></small>
         Uređivanje Fotografija
      </h3>
   </div>
</div>
<div class="col-md-3">
   <p><img src="{{ reSizeImage($image,280,280,'zoomCrop') }}" class="thumbnail"/></p>
   <h4 class="content-heading">Detalji Fotografije</h4>
   <hr/>
   <p><strong><i class="fa fa-user"></i> Napravljeno od strane</strong> <a href="{{ route('user', ['username' => $image->user->username]) }}">{{{ $image->user->fullname }}}</a></p>
   <p><strong><i class="fa fa-picture-o"></i> Original Fotografija</strong> <a href="{{ url('uploads/' . $image->image_name .'.'. $image->type) }}">{{ $image->image_name }}.{{ $image->type }}</a></p>
   <p><strong><i class="fa fa-heart-o"></i> Omiljene</strong> {{ $image->favorite()->count() }}</p>
   <p><strong><i class="fa fa-comments-o"></i> Komentari</strong> {{ $image->comments()->count() }}</p>
   <p><strong><i class="fa fa-clock-o"></i> Napravljeno</strong> <abbr class="timeago" title="{{ date(DATE_ISO8601,strtotime($image->created_at)) }}">{{ $image->created_at->toISO8601String() }}</abbr></p>
</div>
<div class="col-md-9">
   <div class="row">
      {{ Form::open() }}
      <div class="form-group">
         <label for="title">Naziv</label>
         {{ Form::text('title',$image->title,array('class'=>'form-control','required'=>'required')) }}
      </div>
      <div class="form-group">
         <label for="title">Opis</label>
         {{ Form::textarea('description',$image->image_description,array('class'=>'form-control')) }}
      </div>
      <div class="form-group">
         <label for="category">Kategorija</label>
            {{ Form::select('category', array_pluck(siteCategories(), 'name', 'id'),$image->category->id,array('class' => 'form-control', 'required' => 'required')) }}
      </div>
      <div class="form-group">
         <input type="text" autocomplete="off" name="tags" placeholder="Tags" class="tagging" value="{{{ $image->tags }}}" style="width: 100%"/>
      </div>
      <div class="form-group">
          <lable for="delete">Featured ovu Fotografiju</lable>
          @if($image->featured_at)
          {{ Form::checkbox('featured', 1, true) }}
          @else
          {{ Form::checkbox('featured', 1, false) }}
          @endif
      </div>

       <div class="form-group">
            <lable for="delete">Obriši ovo</lable>
             {{ Form::checkbox('delete', 1, false) }}
       </div>

      <div class="form-group">
         {{ Form::submit('Update Image',array('class'=>'btn btn-success')) }}
      </div>
      {{ Form::close() }}
   </div>
</div>
@stop
@section('extra-js')
<script>
$(function(){
        $('.tagging').select2({
            minimumInputLength: 3,
            maximumSelectionSize: {{ (int)siteSettings('tagsLimit') }},
            placeholder: $(this).attr('placeholder'),
            tags: [ @foreach(explode(',',$image->tags) as $tag) "{{ $tag }}", @endforeach  ],
            tokenSeparators: [","]
            // width: '360px'
        });
});
</script>
@stop