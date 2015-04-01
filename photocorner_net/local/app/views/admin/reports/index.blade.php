@extends('admin/master')
@section('content')
<h2>{{ $title }}</h2>
<hr>
<table class="table table-bordered table-hover table-striped tablesorter">
    <thead>
    <tr>
        <th>Na id-u <i class="fa fa-sort"></i></th>
        <th>Prijavljeno <i class="fa fa-sort"></i></th>
        <th>Prijavljeno od strane <i class="fa fa-sort"></i></th>
        <th>Detalji <i class="fa fa-sort"></i></th>
        <th>Napravljeno <i class="fa fa-sort"></i></th>
        <th>Provereno <i class="fa fa-sort"></i></th>
        <th>Pročitaj celu prijavu <i class="fa fa-sort"></i></th>
    </tr>
    </thead>
    <tbody>
    @foreach($reports as $report)
    <tr>
        @if($report->type == 'user')
        <td><a href="{{ url('user/'.$report->report)  }}">{{ Str::limit($report->report)  }}</a></td>
        @endif
        @if($report->type == 'image')
        <td><a href="{{ url('image/'.$report->report) }}">Fotografija</a></td>
        @endif
        <td>{{ $report->type }}</td>
        <td><a href="{{ url('user/'.$report->user->username) }}">{{ $report->user->username }}</a></td>
        <td>{{ $report->description }}</td>
        <td><abbr class="timeago" title="{{ date(DATE_ISO8601,strtotime($report->created_at)) }}">{{ date(DATE_ISO8601,strtotime($report->created_at)) }}</abbr></td>
        @if($report->created_at == $report->updated_at)
        <td>Unchecked</td>
        @else
        <td><abbr class="timeago" title="{{ date(DATE_ISO8601,strtotime($report->updated_at)) }}">{{ date(DATE_ISO8601,strtotime($report->updated_at)) }}</abbr></td>
        @endif
        <td><a href="{{ url('admin/report/'.$report->id) }}">Pročitaj sve</a></td>
    </tr>
    @endforeach

    </tbody>
</table>
@stop