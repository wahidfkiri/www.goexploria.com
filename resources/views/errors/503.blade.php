@extends('layouts.front.master')
@section('title', 'Accès refusé')
@section('content')
        <div class="page-title-container">
            <div class="container">
                <div class="page-title pull-right">
                    <h2 class="entry-title">Oops !</h2>
                </div>
                <ul class="breadcrumbs pull-left" id="ariane">
                    {!! Breadcrumbs::render('error.503') !!}
                </ul>
            </div>
        </div>

        <section id="content">
            <div class="container centered">
                <div class="row">
                    <div class="col-md-4">
                        <i class='fa fa-frown-o fa-4x'></i>
                    </div>
                    <div class='col-md-4'>
                    </div>
                    <div class="col-md-4">
                        <i class='fa fa-frown-o fa-4x'></i>
                    </div>
                </div>
                <div class='bootsrap-heading title-custom-big'>
                    <p>Ooops !</p>
                    <p>Erreur 503</p>
                    <p>Vous n'avez pas le droit d'accéder à cette page !</p>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <i class='fa fa-frown-o fa-4x'></i>
                    </div>
                    <div class='col-md-4'>
                    </div>
                    <div class="col-md-4">
                        <i class='fa fa-frown-o fa-4x'></i>
                    </div>
                </div>
            </div>
        </section>
@stop

