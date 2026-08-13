@extends('layouts.mail.company')
@section('title', 'Newsletter')
@section('content')

<div>{!! $news->content !!}</div>

<p>Si vous ne souhaitez plus recevoir les newsletters, {{link_to_route('front.company.newsletter.resign', "cliquez-ici", [$company->id, $user->email])}}</p>
@stop
