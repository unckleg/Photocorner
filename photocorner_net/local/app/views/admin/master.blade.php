<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ siteSettings('siteName') }} - Admin Panel</title>
    {{ HTML::style('static/admin/css/bootstrap.min.css') }}
    {{ HTML::style('static/admin/font-awesome/css/font-awesome.css') }}
    @yield('extra-css')
    {{ HTML::style('static/css/jquery-ui.css') }}
    {{ HTML::style('static/css/jquery.fileupload.css') }}
    {{ HTML::style('static/css/jquery.fileupload-ui.css') }}
      {{ HTML::style('static/plugin/css/select2.css') }}
    {{ HTML::style('static/css/tagmanager.css') }}
    {{ HTML::style('static/admin/plugins/footable/css/footable.core.css') }}
    {{ HTML::style('static/admin/css/sb-admin.css') }}

</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('admin') }}">Admin Panel</a>
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ route('home') }}">Vrati se na sajt</a>
                </li>
            </ul>
        </div>
    </nav>
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="{{ url('admin') }}"><i class="fa fa-dashboard fa-fw"></i>Glavni Panel</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-users fa-fw"></i> Korisnici<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ url('admin/users') }}">Svi Korisnici</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/users/featured') }}">Featured Korisnici</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/users/banned') }}">Banovani Korisnici</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/adduser') }}">Dodaj prave/lažne korisnike</a>
                        </li>
                    </ul>
                    <!-- /.nav-sledeci nivo -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-picture-o fa-fw"></i> Fotografije<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ url('admin/images') }}">Sve Fotografije</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/images/featured') }}">Featured Fotografije</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/images/approval') }}">Potrebna Dozvola</a>
                        </li>
                    </ul>
                    <!-- /.nav-sledeci nivo -->
                </li>

                <li>
                    <a href="#"><i class="fa fa-file-text-o fa-fw"></i> Blog<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ url('admin/blogs') }}">Svi Blogovi</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/blog/create') }}">Dodaj Novi</a>
                        </li>
                    </ul>
                    <!-- /.nav-sledeci nivo -->
                </li>

                <li>
                    <a href="#"><i class="fa fa-wrench fa-fw"></i> Podešavanja Mreže<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ url('admin/sitesettings') }}">Detalji Mreže</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/limitsettings') }}">Ograniči Podešavanja</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/sitecategory') }}">Foto Kategorije</a>
                        </li>
                    </ul>
                    <!-- /.nav-sledeci nivo -->
                </li>

                <li>
                    <a href="#"><i class="fa fa-plus fa-fw"></i> Extra<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ url('admin/updatesitemap') }}">Ažuriraj SiteMap</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/bulkupload') }}">Bulk Otpremanje</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/clearcache') }}">Očisti Keš</a>
                        </li>
                    </ul>
                    <!-- /.nav-sledeci nivo -->
                </li>
            </ul>
            <!-- /#side-meni -->
        </div>
        <!-- /.sidebar-ruši -->
    </nav>
    <div id="page-wrapper">
        @if(Session::has('flashSuccess'))
        <div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>{{ Session::get('flashSuccess') }}</strong>
        </div>
        @endif

        @if(Session::has('flashError'))
        <div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>{{ Session::get('flashError') }}</strong>
        </div>
        @endif

        @if(Session::has('errors'))
        <div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>{{ Session::get('errors')->first() }}</strong>
        </div>
        @endif

        <!--Sadrzaj-->
        @yield('content')

    </div> <!--.page-wrapper-->
</div>

{{ HTML::script('static/admin/js/jquery-1.10.2.js') }}
{{ HTML::script('static/admin/js/jquery-ui.min.js') }}
{{ HTML::script('static/admin/js/bootstrap.min.js') }}
{{ HTML::script('static/admin/js/plugins/metisMenu/jquery.metisMenu.js') }}
{{ HTML::script('static/admin/js/sb-admin.js') }}
{{ HTML::script('static/js/jquery.timeago.js') }}
{{ HTML::script('static/plugin/js/select2.min.js') }}
{{ HTML::script('static/admin/plugins/footable/js/footable.js') }}
{{ HTML::script('static/admin/plugins/footable/js/footable.filter.js') }}
{{ HTML::script('static/admin/plugins/footable/js/footable.sort.js') }}
{{ HTML::script('static/admin/js/multiUpload.js') }}
{{ HTML::script('static/admin/js/sortable.js') }}
{{ HTML::script('static/admin/js/custom.js') }}
@yield('extra-js')

<script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.2/ckeditor.js"></script>
<script>
    var time = $('abbr.timeago');
    time.timeago();
    $('[data-toggle="tooltip"]').tooltip();
    $('.footable').footable();
</script>
</body>
</html>