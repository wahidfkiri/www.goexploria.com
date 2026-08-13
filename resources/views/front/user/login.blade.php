@extends('layouts.front.master')
@section('title', 'Connexion')
@section('content')

<!-- Connexion -->
    {!! Form::open(['route' => 'auth.login.post', 'id' => 'loginForm']) !!}
    <div class="seperator"><label>CONNEXION</label></div>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="redirect" value="{{ app('request')->input('id') }}">
    <table class='table user'>
        <tr>
            <td>{!! Form::label('identifiant', 'Identifiant') !!}</td>
            <td class="{!! $errors->has('identifiant') ? 'has-error' : '' !!}">
            {!! Form::text('identifiant', null, ['class' => 'form-control', 'placeholder' => 'test@mail.fr']) !!}
            {!! $errors->first('identifiant', '<small class="help-block">:message</small>') !!}
            </td>
        </tr>
        <tr>
            <td>{!! Form::label('password', 'Mot de passe') !!}</td>
            <td class="{!! $errors->has('password') ? 'has-error' : '' !!}">
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'dEf87/*(8f']) !!}
            {!! $errors->first('password', '<small class="help-block">:message</small>') !!}
            </td>
        </tr>
    </table>
    <div class="checkbox">
        {!! Form::checkbox('remember', 'null') !!} Se souvenir de moi
    </div>
        {!! Form::submit('Connexion', ['class' => 'button mid-width btn-medium']) !!}
    {!! Form::close() !!}
    
    <div class="seperator"></div>
    <div><br>Pas encore inscrit ? {{link_to_route('account.register', 'Rejoignez-nous !', [], ['class' => 'link'])}}<br>{{link_to_route('auth.reset.pass', 'Mot de passe oublié ?', [], ['class' => 'link'])}}<br>
    {{link_to_route('account.activate.form', "Je n'ai pas reçu le mail d'activation", [], ['class' => 'link'])}}</div>

@stop

@section('js') 
    {!! JsValidator::formRequest('App\Http\Requests\RegisterPostRequest', '#loginForm'); !!}
@stop
