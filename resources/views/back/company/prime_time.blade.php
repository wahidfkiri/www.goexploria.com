@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
    {!! Breadcrumbs::render('company.edit', $company) !!}
@stop
@section('left-menu')
    @include('back.company.menu')
@stop

@section('right-content')
    <h4>{{$company->name}}</h4>
    <form action="{{route('company.primeTime.save',$company->id)}}" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label class="checkbox">
                <input type="checkbox" name="prime_time" value="1" {{!empty($company->prime_time)?'checked':''}}>
                Afficher dans l'onglet Tourisme et/ou Affaire des destinations
            </label>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Save">
        </div>
    </form>
@stop

@section('js')

@stop
