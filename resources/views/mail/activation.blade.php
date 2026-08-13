@extends('layouts.mail.master')
@section('title', 'Activation')
@section('content')

<p>Il vous suffit de cliquer sur le lien suivant pour activer votre compte (lien valide 6h) : {{link_to_route('account.activate', 'Activer mon compte', [$activationToken])}}</p>

@stop
