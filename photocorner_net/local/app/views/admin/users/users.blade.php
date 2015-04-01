@extends('admin/master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-users"></i></small>
            {{ $title }} <small> ( {{ $users->count() }} users )</small>
        </h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Filter Table</label>
                    <input class="form-control" id="filter" placeholder="Filter Table">
                </div>
            </div>
            <form method="GET">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Sort By</label>
                        {{ Form::select('sortBy', array('username' => 'Username', 'fullname' => 'Fullname','created_at'=>'Registered on','updated_at'=>'Last Updated'), Request::get('sortBy'),array('class'=>'form-control')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Direction</label>
                        {{ Form::select('direction', array('asc' => 'Asc', 'desc' => 'Desc'), Request::get('direction'),array('class'=>'form-control')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <input type="submit" class="btn btn-info form-control" value="Filter Data"/>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover footable toggle-medium" data-filter="#filter">
        <thead>
        <tr>
            <th data-hide="tablet,phone">Avatar</th>
            <th data-toggle="true">Username</th>
            <th>Fullname</th>
            <th data-hide="tablet,phone">Email</th>
            <th data-hide="tablet,phone">Registered on</th>
            <th data-hide="tablet,phone">Last Updated</th>
            <th data-hide="phone">Status</th>
            <th data-hide="phone">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
        @if($user AND $user->deleted_at != NULL)
        <tr class="danger">
            @else
        <tr>
            @endif
            <td><img src="{{ getAvatar($user,40,40) }}" alt=""/></td>
            <td>{{ Str::limit($user->username,15) }}</td>
            <td><span data-toggle="tooltip" data-placement="left" data-original-title="{{ $user->fullname }}">{{ Str::limit($user->fullname,15) }}</span></td>
            <td><span data-toggle="tooltip" data-placement="right" data-original-title="{{ $user->email }}">{{ Str::limit($user->email,15) }}</span></td>
            <td><abbr class="timeago" title="{{ date(DATE_ISO8601,strtotime($user->created_at)) }}">{{ date(DATE_ISO8601,strtotime($user->created_at)) }}</abbr></td>
            <td><abbr class="timeago" title="{{ date(DATE_ISO8601,strtotime($user->updated_at)) }}">{{ date(DATE_ISO8601,strtotime($user->updated_at)) }}</abbr></td>
            @if($user->confirmed == 1)
            <td>@if(strtotime($user->updated_at) < strtotime('-30 days'))
                <span class="label label-default" data-toggle="tooltip" data-placement="top" data-original-title="Users is in not active from month">Inactive</span>
                @else
                <span class="label label-success" data-toggle="tooltip" data-placement="top" data-original-title="This is active users of site">Active</span>
                @endif
            </td>
            @else
            <td><span class="label label-danger" data-toggle="tooltip" data-placement="top" data-original-title="Email validation is required">email activation required</span></td>
            @endif
            <td>
                <a class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Visit Profile" href="{{ url('user/'.$user->username) }}">
                    <i class="glyphicon glyphicon-zoom-in"></i>
                </a>
                <a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit Profile" href="{{ url('admin/user/'.$user->username.'/edit') }}">
                    <i class="glyphicon glyphicon-edit"></i>
                </a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $users->links() }}
<!-- /.table-responsive -->
</div>
<!-- /.col-lg-12 -->
</div>

<!-- /.row -->
@stop
