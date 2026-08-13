@extends('layouts.mail.master')


@section('content')
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

table, td, th {
    border: 1px solid black;
    padding: 2px;
}
td, th {
    min-width: 16%;
}
</style>
<h1>{{ $company->name }}</h1>
<table>
    <tr>
        <th>Début</th>
        <th>Fin</th>
        <th>Libellé</th>
        <th>Client</th>
        <th>Contact</th>
        <th>Détails</th>        
    </tr>
    @foreach($meetings as $meeting)
    <tr>
        <td>{{ Formatter::convertToTimeWithoutSecondeBis($meeting->started_at) }}</td>
        <td>{{ Formatter::convertToTimeWithoutSecondeBis($meeting->ended_at) }}</td>
        <td>{{ $meeting->name }}</td>
        <td>{{ $meeting->client }}</td>
        <td>{{ $meeting->contact }}</td>
        <td>{!! $meeting->content !!}</td>

    </tr>
    @endforeach
</table>
<br >
@stop
