@extends('layouts.mail.master')
@section('title', 'Récupération de mot de passe')
@section('content')

<p>Vous avez souhaité à réinitialiser votre mot de passe, en voici donc un nouveau : {!! $newPass !!} </p>

<p>Pour l'utiliser, suivez les étapes suivantes :
	<ol>
		<li>Cliquez sur le lien suivant pour confirmer le changement de mot de passe (lien valide 6 heures) : {{link_to_route('auth.validate.pass', 'Changer mon mot de passe', [$resetToken])}}</li>
		<li>Connectez vous avec le mot de passe qui vous a été fourni dans ce mail</li>
		<li>Lors de votre connexion, vous serez inviter à changer le mot de passe</li>
	</ol>
</p>

@stop
