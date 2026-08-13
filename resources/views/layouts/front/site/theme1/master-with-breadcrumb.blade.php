@extends('layouts.front.site.master')

@section('content')
<!-- En tête -->
<div class="page-title-container">
    
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

<!-- Contenu -->
<section id="content">
     
  @yield('main-content')
    
</section>
@stop
