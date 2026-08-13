@extends('layouts.front.master')

@section('content')
<!-- En tête -->
<div class="page-title-container">
    <div class="container">
        <!-- Titre  à droite -->
        <div class="page-title pull-right">
            <h2 class="entry-title">
                @yield('breadcrumb-title')
            </h2>
        </div>

        <!-- Fil d'ariane -->
        <ul class="breadcrumbs pull-left" id="ariane">
            @yield('breadcrumb')
        </ul>
    </div>
</div>

<!-- Contenu -->
<section id="content">
     <div class="container">
        @yield('main-content')
    </div>
</section>
@stop
