@extends('layouts.mail.master')
@section('title', 'Newsletter')
@section('content')

<div>{!! $news->content !!}</div>

<p>Si vous ne souhaitez plus recevoir les newsletters, {{link_to_route('account.newsletter', "cliquez-ici")}}</p>
@stop
