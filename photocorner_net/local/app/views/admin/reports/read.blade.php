@extends('admin/master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <h3 class="page-header">
         <small><i class="fa fa-edit"></i></small>
         Cela Prijava
      </h3>
   </div>
</div>
<div class="row">
<div class="col-md-12">

    @if($report->type == 'user')
    <h5>Reported {{ $report->type }}: <a href="{{ route('user', ['username' => $report->report]) }}" target="_blank">{{{ $report->report }}} <i class="fa fa-external-link"></i></a></h5>
    @elseif($report->type == 'image')
    <h5>Reported {{ $report->type }}: With id {{ $report->report }} <a href="{{ url('image/'.$report->report)}}" target="_blank">View Image <i class="fa fa-external-link"></i></a></h5>
    @endif
    <h5>Prijavljeno od strane: <a href="{{ route('user',['username' => $report->user->username]) }}">{{{ $report->user->username }}}</a> <small>( {{{ $report->user->fullname }}} )</small> </h5>
    <h5>Prijavljeno: <abbr class="timeago" title="{{ $report->updated_at->toDateTimeString() }}">{{ $report->updated_at->toDateTimeString() }}</abbr> </h5>
    <hr>
    <h4>Opis</h4>
    <hr>
    <p>{{{ $report->description }}}</p>
    </div>
</div>
@stop