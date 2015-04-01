@extends('admin/master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-users"></i></small>
            {{ $title }}
        </h3>
    </div>
</div>
<table class="table table-bordered table-hover table-striped tablesorter">
    <thead>
    <tr>
        <th>Id <i class="fa fa-sort"></i></th>
        <th>Od <i class="fa fa-sort"></i></th>
        <th>Fotografija <i class="fa fa-sort"></i></th>
        <th>Komentar <i class="fa fa-sort"></i></th>
        <th>Komentarisano <i class="fa fa-sort"></i></th>
        <th>Uredba <i class="fa fa-sort"></i></th>
    </tr>
    </thead>
    <tbody>
    @foreach($comments as $comment)
    <tr>
        <td>{{ $comment->id }}</td>
        <td><span data-toggle="tooltip" data-placement="left" data-original-title="{{ $comment->user->username }}"><a href="{{ url('user/'.$comment->user->username) }}">{{{ Str::limit($comment->user->fullname,15) }}}</a></span></td>
        <td><a href="{{ route('image', ['id' => $comment->image->id, 'slug' => $comment->image->slug]) }}">{{{ $comment->image->title }}}</a></td>
        <td>{{{ Str::limit($comment->comment,20) }}}</td>
        <td><abbr class="timeago" title="{{ $comment->created_at->toISO8601String() }}">{{ $comment->created_at->toISO8601String() }}</abbr></td>
        <td>
            <a class="btn btn-info" href="{{ url('admin/comment/'.$comment->id. '/edit') }}">
                <i class="glyphicon glyphicon-edit"></i>
            </a></td>
    </tr>
    @endforeach

    </tbody>
</table>
@stop