@extends('admin/master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-file-text-o"></i></small>
            Blog
            <small>( {{ $blogs->count() }} Blogs )</small>
        </h3>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover footable toggle-medium" data-filter="#filter">
        <thead>
        <tr>
            <th>#</th>
            <th>Naziv</th>
            <th >Napravljen od strane</th>
            <th data-hide="tablet,phone">Napravljen</th>
            <th>Uredba</th>
        </tr>
        </thead>
        <tbody>
        @foreach($blogs as $blog)
        <tr>
            <td>{{ $blog->id }}</td>
            <td>{{ Str::limit($blog->title,20) }}</td>
            <td><a href="{{ route('user', ['username' => $blog->user->username]) }}">{{ $blog->user->fullname }}</a></td>
            <td><abbr class="timeago" title="{{ date(DATE_ISO8601,strtotime($blog->created_at)) }}">{{ $blog->created_at->toISO8601String() }}</abbr></td>
            <td>
                <a class="btn btn-success" href="{{ route('blog', ['id' => $blog->id , 'slug' => $blog->slug]) }}">
                    <i class="glyphicon glyphicon-zoom-in"></i>
                </a>
                <a class="btn btn-info" href="{{ url('admin/blog/'.$blog->id. '/edit') }}">
                    <i class="glyphicon glyphicon-edit"></i>
                </a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{ $blogs->links() }}
@stop
