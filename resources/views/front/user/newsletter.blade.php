@extends('layouts.front.master')
@section('title', 'Se désabonner')
@section('content')

{!! Form::open(['route' => 'account.newsletter.post']) !!}
    <div class="seperator"><label>Désabonnement des newsletter</label></div>
    <table class='table user'>
        <tr>
            <td>{!! Form::label('email', 'Email') !!}</td>
            <td class="{!! $errors->has('email') ? 'has-error' : '' !!}">
			{!! Form::email('email', null, ['class' => 'input-text full-width', 'placeholder' => 'Email']) !!}
            {!! $errors->first('email', '<small class="help-block">:message</small>') !!}
            </td>
        </tr>
    </table>
	{!! Form::submit('Se désabonner', ['class' => 'button med-width btn-medium']) !!}
{!! Form::close() !!}

@stop
