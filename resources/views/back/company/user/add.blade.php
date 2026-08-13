@extends('layouts.back.master-with-left-menu')
@section('more_css')
    {{Html::style('css/selectize.css') }}
@endsection
@section('title', 'Ajout d\'utilisateurs pour '.$company->nam)
@section('breadcrumb')
    {!! Breadcrumbs::render('company.page.add', $company) !!}
@stop
@section('left-menu')
    @include('back.company.menu')
@stop

@section('right-content')
    <h4>Ajouter un utilisateur pour : {{ $company->name}}</h4>
    <div class="panel panel-primary panel-user hidden" data-collapsed="0">
        <div class="panel-heading">
            <div class="panel-title">
                Utilisateur
            </div>
            <div class="panel-options">
                <a href="javascript:" class="btn-close" data-rel="close"><i class="entypo-cancel"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <div class="seperator"><label>Profil</label></div>
            <table class='table user'>

                <tr>
                    <td>{!! Form::label('user_mail', 'Email*') !!}</td>
                    <td class="{!! $errors->has('mail') ? 'has-error' : '' !!}">
                        <input placeholder="Nom" class="form-control" name="user_mail[]" type="text"
                               id="user_mail">
                    </td>
                </tr>

                <tr>
                    <td>{!! Form::label('user_type', 'Type de compte*') !!}</td>
                    <td class="{!! $errors->has('type') ? 'has-error' : '' !!}">
                        <select class="form-control" name="user_type[]" aria-invalid="false" id="user_type">
                            @foreach($types as $ndx => $value)
                                <option value="{{ $ndx }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>

            <!-- Info relative à la personne -->
            <div class="seperator"><label>Identité</label></div>
            <table class='table user'>
                <tr>
                    <td>{!! Form::label('user_name', 'Nom complet') !!}</td>
                    <td class="{!! $errors->has('name') ? 'has-error' : '' !!}">
                        <input placeholder="Nom complet" class="form-control" name="user_name[]" type="text"
                               id="user_name">
                    </td>
                </tr>
                <tr>
                    <td>{!! Form::label('user_last_name', 'Nom') !!}</td>
                    <td class="{!! $errors->has('last_name') ? 'has-error' : '' !!}">
                        <input placeholder="Nom" class="form-control" name="user_last_name[]" type="text"
                               id="user_last_name">
                    </td>
                </tr>
                <tr>
                    <td>{!! Form::label('user_first_name', 'Prénom') !!}</td>
                    <td class="{!! $errors->has('first_name') ? 'has-error' : '' !!}">
                        <input placeholder="Prénom" class="form-control" name="user_first_name[]"
                               type="text" id="user_first_name">
                    </td>
                </tr>
            </table>

            <!-- Info relative à ses coordonnées -->
            <div class="seperator"><label>Coordonnées</label></div>
            <table class='table user'>
                <tr>
                    <td>{{ Form::label('user_tel', "Téléphone") }}</td>
                    <td class="{!! $errors->has('tel') ? 'has-error' : '' !!}">
                        <input placeholder="Téléphone" class="form-control" name="user_tel[]" type="text"
                               id="user_tel">
                    </td>
                </tr>
            </table>

            <p>
                {{Form::checkbox('user_news[]', 'true')}}     {{ Form::label('news', "Recevoir les newsletters et les offres ?", ['class' => "control-label"]) }}
            </p>
        </div>
    </div>
    {!! Form::open(array('route' => array('company.users.store',$company->id), 'method' => 'post','name' => 'companyUserForm', 'id' => 'addForm', 'class' => 'form-wizard validate')) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-12">
            <div class="tab-pane" id="tab2-4">
                <div class="btn-centered" style="text-align: center; margin-bottom: 15px;">
                    <input id="btn-add" type="button" class="btn btn-secondary" value="Ajouter un utilisateur"/>
                </div>


            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group text-center">
                {!! Form::submit("Save", ['class' => 'btn btn-primary']) !!}
            </div>

        </div>
    </div>
    {!! Form::close() !!}
@stop
@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\AddCompanyUserPostRequest', '#addForm'); !!}
    <script type="text/javascript">

        $('.panel-user').first().clone().removeClass('hidden').appendTo('#tab2-4');
        $('#btn-add').click(function () {

            $('.panel-user').first().clone().removeClass('hidden').appendTo('#tab2-4');
        });
    </script>
@stop