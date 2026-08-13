@extends('layouts.back.master')
@section('title', 'Administration')
@section('content')


<h1>Test</h1>
<ul>
@foreach($villes as $ville)

  <li>{{Formatter::slugToString($ville->slugify())}}</li>
@endforeach
</ul>
@stop

@section('js')

@stop