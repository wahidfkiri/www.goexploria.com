@extends('layouts.back.master')
@section('title', 'Etablissements')

@section('content')
    <h4>Rendez-vous : {{ $meeting->name }} ( {{$meeting->company->name or 'n/a'}} )</h4>

    {!! Formatter::editButton(route('users.meeting.edit', [$meeting->id])) !!}

    {!! Formatter::deleteButton($meeting->id) !!}

    {!! Formatter::delete(route('users.meeting.delete', [$meeting->id]), $meeting->id, "Supprimer un rendez-vous", "Voulez-vous vraiment supprimer le rendez-vous ?" ) !!}

    <br><br>

    <table class='table user'>
        <tr>
            <th>Libellé</th>
            <td>{{ $meeting->name }}</td>
        </tr>
        <tr>
            <th>Début</th>
            <td>{{ Formatter::convertToTimeWithoutSeconde($meeting->started_at) }}</td>
        </tr>
        <tr>
            <th>Fin</th>
            <td>{{ Formatter::convertToTimeWithoutSeconde($meeting->ended_at) }}</td>
        </tr>
        @if(isset($meeting->client))
            <tr>
                <th>Client</th>
                <td>{{ $meeting->client }}</td>
            </tr>
        @endif
        @if(isset($meeting->contact))
            <tr>
                <th>Contact</th>
                <td>{{ $meeting->contact }}</td>
            </tr>
        @endif
        @if(isset($meeting->content))
            <tr>
                <th>Détails</th>
                <td>{!! $meeting->content !!}</td>
            </tr>
        @endif
    </table>


@stop
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".delete").click(function () {
                var value = $(this).attr('data');
                $('#modal-delete-' + value).modal('show');
                return false;
            });
        });
    </script>
@stop
