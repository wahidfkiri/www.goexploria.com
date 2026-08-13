@extends('layouts.back.master-with-left-menu')
@section('more_css')
    {{Html::style('css/selectize.css') }}
@endsection
@section('title', 'Etablissements')
@section('breadcrumb')
{!! Breadcrumbs::render('company.meeting.edit', $company, $meeting) !!}
@stop
@section('left-menu')
@include('back.company.menu')
@stop

@section('right-content')
<h4>Modifier un rendez-vous pour : {{$company->name}}</h4>
<div class="row">
    <div class="col-md-12">

        <div class="panel-body">

            {{ Form::open(array('route' => array('company.meeting.edit.post', $company->id, $meeting->id), 'method' => 'post', 'id' => 'editForm', 'class' => 'form-horizontal form-groups-bordered')) }}
            <table class='table user'>
                <tr>
                    <td>{{ Form::label('name', "Libellé", ['class' => "control-label"]) }}</td>
                    <td>{{ Form::text('name', $meeting->name, ['class' => 'form-control', 'placeholder' => 'Titre' ]) }}</td>
                </tr>
                <tr>
                    <td>{{ Form::label('date', "Date", ['class' => "control-label"]) }}</td>
                    <td>{{ Form::text('date', Formatter::range($meeting->started_at, $meeting->ended_at), [ 'class' => 'form-control', 'placeholder' => 'Date', 'id' => 'datepick']) }}</td>
                </tr>
                @if(auth()->user()->isAdmin())
                    <tr id="dropDownBody">
                        <td><label>Utilisateurs</label></td>
                        <td>
                            <div class="form-group">
                                <select name="user_id" class="form-control" id="users"
                                        placeholder="Choisir un utilisateur">
                                    <option value=""></option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}" {{$meeting->user_id==$user->id?'selected':''}}>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td>{{ Form::label('client', "Client", ['class' => "control-label"]) }}</td>
                    <td>{{ Form::text('client', $meeting->client, ['class' => 'form-control', 'placeholder' => 'Nom Prénom']) }}</td>
                </tr>
                <tr>
                    <td>{{ Form::label('contact', "Contact", ['class' => "control-label"]) }}</td>
                    <td>{{ Form::textarea('contact', $meeting->contact, ['class' => 'form-control', 'placeholder' => 'Adresse, téléphone, etc']) }}</td>
                </tr>
                <tr>
                    <td>{{ Form::label('content', "Contenu", ['class' => "control-label"]) }}</td>
                    <td>{{ Form::textarea('content', $meeting->content, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) }}</td>
                </tr>
            </table>

            {{ Form::submit('Modifier') }}
            {{ Form::close() }}

        </div>

    </div>
</div>

@stop
@section('js')
    {{Html::script('js/selectize.js') }}

    {{Html::script('js/moment.min.js') }}
{{Html::script('js/daterangepicker/daterangepicker.js') }}
{{Html::style('js/daterangepicker/daterangepicker-bs3.css') }}
{!! JsValidator::formRequest('App\Http\Requests\CompanyMeetingRequest', '#editForm'); !!}
<script type="text/javascript">
    $(document).ready(function () {
        var optionSet = {
            showDropdowns: true,
            showWeekNumbers: false,
            timePicker: true,
            timePickerIncrement: 5,
            timePicker12Hour: false,
            format: 'DD/MM/YYYY HH:mm',
            startDate: "{{ Formatter::convertToTimeWithoutSeconde($meeting->started_at) }}",
            endDate: "{{ Formatter::convertToTimeWithoutSeconde($meeting->ended_at) }}",
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

    });
</script>
@stop
