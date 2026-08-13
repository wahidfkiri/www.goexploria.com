@extends('layouts.back.master') 
@section('title', "Utiliateur")
@section('content')
{!! Breadcrumbs::render('user.pass', $user) !!}
<h3>Profil de {{$user->name}} : Modification du mot de passe</h3>
{{ Form::open(['route' => ['user.pass.post', $user->id], 'id' => 'pass']) }}
    <table class='table user'>
        <tr>
            <td>{{ Form::label('new', 'Nouveau') }}</td>
            <td>{{ Form::password('new', null, ['class' => 'form-controls', 'placeholder' => 'Nouveau mot de passe']) }}</td>
        </tr>
        <tr>
            <td>{{ Form::label('confirm', 'Confirmation') }}</td>
            <td>{{ Form::password('confirm', null, ['class' => 'form-controls', 'placeholder' => 'Confirmation']) }}</td>
        </tr>
    </table>
	{{ Form::submit('Modifier', ['class' => 'button med-width btn-medium']) }}
{{ Form::close() }}


@stop

@section('js')
{!! JsValidator::formRequest('App\Http\Requests\AdminPassEditRequest', '#pass'); !!}
@stop