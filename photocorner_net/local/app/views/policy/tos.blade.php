@extends('master/index')

@section('content')
<h1 class="content-heading">{{ t('Terms Of Services') }}</h1>
<p>
    {{ siteSettings('tos') }}
</p>
@stop