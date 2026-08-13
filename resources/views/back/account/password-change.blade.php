@extends('layouts.back.master-with-left-menu')
@section('title', 'Mot de passe')
@section('breadcrumb')
    {!! Breadcrumbs::render('account.pass') !!}
@stop
@section('left-menu')
    @include('back.account.menu')
@stop

@section('right-content')
<h4>Mon compte : changement de mot de passe</h4>
{{ Form::open(['route' => 'account.change.pass.post', 'id' => 'pass']) }}
    <table class='table user'>
        <tr>
            <td>{{ Form::label('current', 'Actuel') }}</td>
            <td>{{ Form::password('current', null, ['class' => 'input-text full-width', 'placeholder' => 'Mot de passe actuel']) }}</td>
        </tr>
        <tr>
            <td>{{ Form::label('new', 'Nouveau') }}</td>
            <td>{{ Form::password('new', null, ['class' => 'input-text full-width', 'placeholder' => 'Nouveau mot de passe']) }}</td>
        </tr>
        <tr>
            <td>{{ Form::label('confirm', 'Confirmation') }}</td>
            <td>{{ Form::password('confirm', null, ['class' => 'input-text full-width', 'placeholder' => 'Confirmation']) }}</td>
        </tr>
    </table>
	{{ Form::submit('Modifier', ['class' => 'button med-width btn-medium']) }}
{{ Form::close() }}


@stop

@section('js')
{!! JsValidator::formRequest('App\Http\Requests\PostPassRequest', '#pass'); !!}
@stop