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
    <div class="row">
        <div class="col-md-12">

            <div class="panel-body">

                {{ Form::open(array('route' => array('company.users.assign',  $company->id), 'method' => 'post', 'id' => 'addForm', 'class' => 'form-horizontal form-groups-bordered')) }}

                <div class="form-group">
                    <label>Utilisateurs</label>
                    <select name="users" class="form-control" id="users" placeholder="Choisir un utilisateur">
                        <option value=""></option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
                {{ Form::submit('Ajouter') }}
                {{ Form::close() }}

            </div>

        </div>
    </div>

@stop
@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\PageRequest', '#addForm'); !!}
    {{Html::script('js/selectize.js') }}
    <script type="text/javascript">
        $('#users').selectize({
            create: false,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            dropdownParent: 'body'
        });
    </script>
@stop