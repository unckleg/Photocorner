<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{{ $title }}} - {{ siteSettings('siteName') }}</title>
    @yield('meta', '<meta name="description" content="'.siteSettings('description').'">')
    <link rel="shortcut icon" href="{{ asset(siteSettings('favIcon')) }}" type="image/x-icon"/>
    <!--[if IE 8]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    {{ HTML::style('static/css/bootstrap.min.css') }}
    {{ HTML::style('static/css/jquery-ui.css') }}
    {{ HTML::style('static/css/datepicker.css') }}
    {{ HTML::style('static/css/blueimp-gallery.min.css') }}
    {{ HTML::style('static/css/style.css') }}
     {{ HTML::style('static/css/half-slider.css') }}
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    {{ HTML::style('static/plugin/css/select2.css') }}
    {{ HTML::style('static/plugin/css/datepicker.css') }}
    {{ HTML::style('static/plugin/css/jquery.timepicker.css') }}
    {{ HTML::style('static/plugin/css/app.css') }}
    {{ HTML::style('static/css/alert.css') }}
    @yield('style')
</head>
<body>
@include('master/notices')
@include('master/navbar')
<div class="container">
    <div class="row">
        @yield('custom')
        <div class="col-md-12">
            @yield('content')
        </div>
    </div>
    @yield('pagination')
    @include('master/footer')
</div>
{{ HTML::script('static/js/jquery.js') }}
{{ HTML::script('static/js/jquery-ui.min.js') }}
{{ HTML::script('static/js/bootstrap.min.js') }}
{{ HTML::script('static/js/alert.js') }}
{{ HTML::script('static/js/jquery.lazyload.min.js') }}
{{ HTML::script('http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=en') }}
{{ HTML::script('static/plugin/js/fileupload/vendor/jquery.ui.widget.js') }}
{{ HTML::script('static/plugin/js/fileupload/jquery.fileupload.js') }}
{{ HTML::script('static/plugin/js/fileupload/jquery.fileupload-process.js') }}
{{ HTML::script('static/plugin/js/fileupload/jquery.fileupload-image.js') }}
{{ HTML::script('static/plugin/js/exif.js') }}
{{ HTML::script('static/plugin/js/binaryajax.js') }}
{{ HTML::script('static/plugin/js/canvasResize.js') }}
{{ HTML::script('static/plugin/js/tmpl.min.js') }}
{{ HTML::script('static/plugin/js/jquery.resizeimagetoparent.min.js') }}
{{ HTML::script('static/plugin/js/select2.min.js') }}
{{ HTML::script('static/plugin/js/bootstrap-datepicker.js') }}
{{ HTML::script('static/plugin/js/jquery.timepicker.js') }}
{{ HTML::script('static/plugin/js/app.js') }}
{{ HTML::script('static/js/blueimp-gallery.min.js') }}
{{ HTML::script('static/js/jquery.timeago.js') }}
{{ HTML::script('static/js/bootstrap-datepicker.js') }}
{{ HTML::script('static/js/json2html.js') }}
{{ HTML::script('static/js/jquery.json2html.js') }}
{{ HTML::script('static/js/color-thief.js') }}
{{ HTML::script('static/js/custom.js') }}
@yield('extrafooter')
</body>
</html>