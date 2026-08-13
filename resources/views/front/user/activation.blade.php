@extends('layouts.front.master')
@section('title', 'Activer mon compte')
@section('content')

{!! Form::open(['route' => 'account.activate.resend', 'id' => 'resend']) !!}
    <div class="seperator"><label>Renvoi du mail d'activation</label></div>
    <table class='table user'>
        <tr>
            <td>{!! Form::label('email', 'Email') !!}</td>
            <td class="{!! $errors->has('email') ? 'has-error' : '' !!}">
			{!! Form::email('email', null, ['class' => 'input-text full-width', 'placeholder' => 'Email']) !!}
            {!! $errors->first('email', '<small class="help-block">:message</small>') !!}
            </td>
        </tr>
    </table>
	{!! Form::submit('Renvoyer', ['class' => 'button med-width btn-medium']) !!}
{!! Form::close() !!}

<div class="seperator"></div>

<p>{{link_to_route('auth.login', 'Me connecter')}}</p>

@stop
