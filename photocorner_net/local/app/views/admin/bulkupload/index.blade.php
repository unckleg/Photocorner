@extends('admin/master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-edit"></i></small>
            Bulk Otpremanje
        </h3>
    </div>
</div>
<div class="col-md-9">

    <form id="fileupload" action="" method="POST" enctype="multipart/form-data">

        <div class="fileupload-buttonbar">
            <div class="form-group">
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>{{ t('Dodaj Fajlove...') }}</span>
                    <input type="file" name="files[]" accept="image/*" multiple>
                </span>
            <button type="reset" class="btn btn-warning cancel">
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span>{{ t('Prekini Otpremanje') }}</span>
            </button>
            <button type="submit" class="btn btn-primary start">
                <i class="glyphicon glyphicon-upload"></i>
                <span>Počni sa Otpremanjem</span>
            </button>
           </div>

            <div class="form-group">
                {{ Form::label('category', 'Kategorija') }}
                {{ Form::select('category', array_pluck(siteCategories(), 'name', 'id'),NULL,array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('allow_Download', 'Dozvoli preuzimanje Fotografija') }}
                {{ Form::select('allow_download',array('1' => 'Yes', '0' => 'No'),NULL,array('class' => 'form-control')) }}
            </div>

        <div class="form-group">

        </div>
        <div class="form-group">
            {{ Form::label('tags', 'Tags') }}
            <input type="text" autocomplete="off" name="tags" placeholder="Tags" class="tagging" value="" style="width: 100%"/>
        </div>

            <div class="col-md-12 fileupload-progress fade">
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>

        <div role="presentation"><div class="row files"></div></div>
    </form>

    <script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<div class="clearfix template-upload fade">
<hr/>
        <div class="col-md-3">
         <p>
                   <span class="preview"> </span>
          </p>
         </div>

        <div class="col-md-5"> <p>

          </p>
        </div>

        <div class="col-md-3">
        <p>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>{{ t('Start') }}</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>{{ t('Cancel') }}</span>
                </button>
            {% } %}
               <div class="size">{{ t('Processing') }}</div>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </p>

        </div>
</div>

{% } %}
</script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<hr>
    <div class="clearfix template-download fade">

        <div class="col-md-12">
            <div class="col-md-3">
                {% if (file.title) { %}
                     <p><span class="label label-danger">{{ t('Rejected') }}</span></p>
                {% } %}
                {% if (file.tags) { %}
                     <p><span class="label label-danger">{{ t('Rejected') }}</span></p>
                {% } %}
                {% if (file.error) { %}
                    <p><span class="label label-danger">{{ t('Rejected') }}</span></p>
                {% } %}
                {% if (file.success) { %}
                    <p><img src="{%=file.thumbnail%}"/></p>
                {% } %}
               </div>
<div class="col-md-5">
                   {% if (file.title) { %}
                     <p>{%=file.title%}</p>
                 {% } %}
                 {% if (file.tags) { %}
                   <p>{%=file.tags%}</p>
                 {% } %}
                 {% if (file.error) { %}
                    <p>{%=file.error%}</p>
                {% } %}
                {% if (file.success) { %}
                    <p>{{ t('Your Image is uploaded successfully') }}</p>
                     <p><a href="{%=file.successSlug%}">{%=file.successTitle%}</a></p>
                {% } %}
</div>
<div class="col-md-3">
  {% if (file.success) { %}
                <a class="btn btn-success" href="{%=file.successSlug%}" target="_blank">
                    <i class="glyphicon glyphicon-new-window"></i>
                    <span>{{ t('Visit') }}</span>
                </a>
  {% } %}
</div>
        </div>
</div>
{% } %}
</script>

</div>
@stop

@section('extra-js')
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

        $("#fileupload").fileupload({
            type: "POST",
            previewMaxHeight: 210,
            previewMaxWidth: 210,
            limitMultiFileUploads: 1,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
});
</script>
@stop