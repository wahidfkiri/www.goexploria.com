@extends('layouts.back.master')
@section('title', 'Etablissements')
@section('more_css')
    {{Html::style('css/selectize.css') }}
@endsection
@section('content')
    <h4>Ajout un rendez-vous pour : {{$user->name}}</h4>
    <div class="row">
        <div class="col-md-12">

            <div class="panel-body">

                {{ Form::open(array('route' => array('users.meeting.add.post'), 'method' => 'post', 'id' => 'addForm', 'class' => 'form-horizontal form-groups-bordered')) }}
                <table class='table user'>
                    <tr>
                        <td>{{ Form::label('name', "Libellé", ['class' => "control-label"]) }}</td>
                        <td>{{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Titre' ]) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('date', "Date", ['class' => "control-label"]) }}</td>
                        <td>{{ Form::text('date', null, ['class' => 'form-control', 'placeholder' => 'Date', 'id' => 'datepick']) }}</td>
                    </tr>
                    @if(auth()->user()->isAdmin())
                        <tr id="dropDownBody">
                            <td><label>Utilisateurs</label></td>
                            <td>
                                <div class="form-group">
                                    <select name="user_id" class="form-control" id="users"
                                            placeholder="Choisir un utilisateur">
                                        <option value=""></option>
                                        @foreach($users as $u)
                                            <option value="{{$u->id}}" {{$user->id==$u->id?'selected':''}}>{{$u->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>{!! Form::label('entreprise', 'entreprise') !!}</td>
                        <td>{!! Form::text('entreprise', null, ['placeholder' => 'Entreprise', 'class' => 'form-control typeahead']) !!}</td>
                        <input type="hidden" name="company_id" value="null" id="company_id">
                    </tr>
                    <tr>
                        <td>{{ Form::label('client', "Client", ['class' => "control-label"]) }}</td>
                        <td>{{ Form::text('client', null, ['class' => 'form-control', 'placeholder' => 'Nom Prénom']) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('contact', "Contact", ['class' => "control-label"]) }}</td>
                        <td>{{ Form::textarea('contact', null, ['class' => 'form-control', 'placeholder' => 'Adresse, téléphone, etc']) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('content', "Contenu", ['class' => "control-label"]) }}</td>
                        <td>{{ Form::textarea('content', null, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) }}</td>
                    </tr>
                </table>

                {{ Form::submit('Ajouter') }}
                {{ Form::close() }}

            </div>

        </div>
    </div>

@stop
@section('css')
    @parent
    <style>
        .tt-menu {
            width: 422px;
            margin: 12px 0;
            padding: 8px 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
            border-radius: 8px;
            -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
            -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
            box-shadow: 0 5px 10px rgba(0,0,0,.2);
        }
    </style>
@stop
@section('js')
    {{Html::script('js/moment.min.js') }}
    {{Html::script('js/daterangepicker/daterangepicker.js') }}
    {{Html::style('js/daterangepicker/daterangepicker-bs3.css') }}
    {!! JsValidator::formRequest('App\Http\Requests\CompanyMeetingRequest', '#addForm'); !!}
    {{Html::script('js/selectize.js') }}
    <script src="/js/typeahead.bundle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var optionSet = {
                showDropdowns: true,
                showWeekNumbers: false,
                timePicker: true,
                timePickerIncrement: 5,
                timePicker12Hour: false,
                format: 'DD/MM/YYYY HH:mm',
                separator: ' => ',
                locale: {
                    applyLabel: 'Valider',
                    cancelLabel: 'Effacer',
                    fromLabel: 'De',
                    toLabel: 'A',
                    customRangeLabel: 'Personnaliser',
                    daysOfWeek: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
                    monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
                    firstDay: 1
                }
            };
            $('#datepick').daterangepicker(optionSet);
            /*$('#company_id').selectize({
                create: false,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                },
                dropdownParent: 'body'
            });*/
        });


        ////////////////////////////
        // typeahead (autocomplete)
        ////////////////////////////
        const companies = {!! json_encode($companies) !!};
        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
                var matches, substringRegex;

                // an array that will be populated with substring matches
                matches = [];

                // regex used to determine if a string contains the substring `q`
                substrRegex = new RegExp(q, 'i');

                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                $.each(strs, function(i, obj) {
                    if (substrRegex.test(obj.name)) {
                        matches.push(obj);
                    }
                });

                cb(matches);
            };
        };
        $('.typeahead').typeahead({
                    hint: false,
                    highlight: true,
                    minLength: 1
                },
                {
                    name: 'company',
                    source: substringMatcher(companies),
                    display: 'name',
                }).bind('typeahead:select',function(ev, suggestion) {
            $('input[name="company_id"]').val(suggestion.id);
        }).bind('typeahead:change',function(ev, suggestion) {
            if( suggestion  === "") {
                $('input[name="company_id"]').val("");
            }

        });
    </script>
@stop
