<!DOCTYPE html>
<html class="full" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{{ $title }}} - {{ siteSettings('siteName') }}</title>
    @yield('metaDescription')
    <link rel="shortcut icon" href="{{ asset(siteSettings('favIcon')) }}" type="image/x-icon"/>
    <!--[if IE 8]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
     <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
     {{ HTML::style('static/css/bootstrap.min.css') }}
     {{ HTML::style('static/css/jquery-ui.css') }}
     {{ HTML::style('static/css/datepicker.css') }}
     {{ HTML::style('static/css/blueimp-gallery.min.css') }}
     {{ HTML::style('static/css/style.css') }}
     <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
     {{ HTML::style('static/plugin/css/select2.css') }}
     {{ HTML::style('static/plugin/css/datepicker.css') }}
     {{ HTML::style('static/plugin/css/jquery.timepicker.css') }}
     {{ HTML::style('static/plugin/css/snap.css') }}
     {{ HTML::style('static/plugin/css/app.css') }}
     {{ HTML::style('static/css/alert.css') }}
    @yield('style')
    <style type="text/css">
        body {
        @foreach(getFeaturedImage() as $featuredImage)
        background: url({{ asset(zoomCrop('uploads/'.$featuredImage->image_name.'.' . $featuredImage->type,1920,1080)) }}) no-repeat fixed;
        @endforeach
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
</head>
<body>
@include('master/navbar')
<div class="home-centerDiv">
    <h1>{{ siteSettings('siteName') }}</h1>
    <h2>{{ siteSettings('description') }}</h2>
    <a href="{{ route('gallery') }}" class="btn btn-info btn-lg">Browse Gallery</a>
    <a href="{{ route('login') }}" class="btn btn-info btn-lg">Login To Site</a>
</div>
      {{ HTML::script('static/js/jquery.js') }}
      {{ HTML::script('static/js/jquery-ui.min.js') }}
      {{ HTML::script('static/js/bootstrap.min.js') }}
      {{ HTML::script('static/js/alert.js') }}
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