@extends('layouts.front.master-with-breadcrumb')
@section('title', "Entreprise")

@section('breadcrumb-title')
    {{ strtoupper(Formatter::remove_accents($company->name)) }}
@stop

@section('breadcrumb')
    {!! Breadcrumbs::render('front.company.newsletter', $company) !!}
@stop

@section('main-content')

{{ Form::open(['route' => ['front.company.newsletter.subscribe.post', $company->id], 'id' => 'loginForm']) }}
    <div class="seperator"><label>Inscription à la newsletter</label></div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <table class='table user'>
        <tr>
            <td>{{ Form::label('name', 'Nom') }}</td>
            <td>
            {{ Form::text('name', isset(Auth::user()->name) ? Auth::user()->name : null, ['class' => 'form-control', 'placeholder' => 'Nom']) }}

            </td>
        </tr>
        <tr>
            <td>{{ Form::label('mail', 'Email') }}</td>
            <td>{{ Form::email('mail', isset($email) ? $email : (isset(Auth::user()->email) ? Auth::user()->email : null), ['class' => 'form-control', 'placeholder' => 'Email']) }}</td>
        </tr>
    </table>
    {!! app('captcha')->render($lang = 'fr'); !!}
    {{ Form::submit("S'abonner", ['class' => 'button mid-width btn-medium']) }}
{{ Form::close() }}
    

@stop

@section('js') 
    {!! JsValidator::formRequest('App\Http\Requests\SubscribeInfolettreRequest', '#loginForm'); !!}
@stop
