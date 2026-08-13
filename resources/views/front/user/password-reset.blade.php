@extends('layouts.front.master')
@section('title', 'Mot de passe oublié')
@section('content')

{!! Form::open(['route' => 'auth.reset.pass.post', 'id' => 'registerForm']) !!}
    <div class="seperator"><label>Réinisalisation de mot de passe</label></div>
    <table class='table user'>
        <tr>
            <td>{!! Form::label('email', 'Email') !!}</td>
            <td class="{!! $errors->has('email') ? 'has-error' : '' !!}">
			{!! Form::email('email', null, ['class' => 'input-text full-width', 'placeholder' => 'Email']) !!}
            {!! $errors->first('email', '<small class="help-block">:message</small>') !!}
            </td>
        </tr>
    </table>
	{!! Form::submit('Reset', ['class' => 'button mid-width btn-medium']) !!}
{!! Form::close() !!}

<div class="seperator"></div>

<p>{{link_to_route('auth.login', 'Me connecter')}}</p>

@stop