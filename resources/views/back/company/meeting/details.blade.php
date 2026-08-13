@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
    {!! Breadcrumbs::render('company.meeting.details', $company, $meeting) !!}
@stop
@section('left-menu')
    @include('back.company.menu')
@stop

@section('right-content')
    <h4>Rendez-vous : {{ $meeting->name }} ( {{$company->name}} )</h4>

    {!! Formatter::editButton(route('company.meeting.edit', [$company->id, $meeting->id])) !!}

    {!! Formatter::deleteButton($meeting->id) !!}

    {!! Formatter::delete(route('company.meeting.delete', [$company->id, $meeting->id]), $meeting->id, "Supprimer un rendez-vous", "Voulez-vous vraiment supprimer le rendez-vous ?" ) !!}

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
            @if(auth()->user()->isAdmin())
                <tr>
                    <th> User </th>
                    <td>{{ $meeting->user->name or 'n/a'}} </td>
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
