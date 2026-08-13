@extends('layouts.mail.master')
@section('title', 'Bienvenue sur GoExploria')
@section('content')

<p>Un compte a été ouvert pour vous sur la plateforme GoExploria </p>

<p>Pour l'utiliser, suivez les étapes suivantes :
	<ol>
		<li>Cliquez sur le lien suivant pour activer votre compte (lien valide 6 heures) : {{link_to_route('account.activate', 'Activer mon compte', [$activationToken])}}</li>
		<li>Connectez vous avec votre adresse email et ce mot de passe : {!! $pass !!}</li>
		<li>Lors de votre connexion, vous serez inviter à changer le mot de passe</li>
	</ol>
</p>

@stop
