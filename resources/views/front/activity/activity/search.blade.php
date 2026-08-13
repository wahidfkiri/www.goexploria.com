@extends('layouts.front.master-with-breadcrumb')
@section('title', isset($activity->name) ? ucfirst(Formatter::remove_accents($activity->name)) : "")

@section('breadcrumb-title')
{{ strtoupper($activity->name) }}
@stop

@section('breadcrumb')
@if (isset($hierarchie))
{!! Breadcrumbs::render('front.location', $hierarchie) !!}
@endif
@stop

@section('main-content')
<div class="row">
    <div id="main" class="col-md-9">    
        <div class="tab-container style1" id="hotel-main-content">
            <ul class="tabs">
                <!-- <li class="active"><a data-toggle="tab" href="#map-tab">Carte</a></li> -->
                <li class="active"><a data-toggle="tab" href="#etablissement-tab">Établissements</a></li>
                
            </ul>
            
            <div class="tab-content" id="destinations">
                <div id="map-tab" class="tab-pane">
                    <!-- Carte -->                
                   

                    <div id="map"></div>

                </div>

                <div id="etablissement-tab" class="tab-pane active">
                    <!-- <select>
                        <option>Trier par pays...</option>
                        @foreach( $activity_countries as $country )
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                    -->

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Localisation</th>
                                <th>Entreprise</th>
                                <th>Site web</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $itemIndex=0; ?>
                            @foreach( $activity->companies as $company )
                            <?php $itemIndex++; ?>
                                <tr>
                                    <td>{{ $company->location->country->name }} -> {{ $company->location->head->name }} -> {{ $company->location->name }}</td>
                                    <td>{{ $company->name }}</td>
                                    <td><a href="{{ $company->coordinate->website }}" target="_blank">{{ str_is('http*/', $company->coordinate->website) ? substr($company->coordinate->website, 0, -1) : $company->coordinate->website }}</a></td>
                                </tr>
                            @endforeach
                            <?php
                            if( $itemIndex == 0 ){
                                ?>
                                    <tr>
                                    <td colspan="3">Aucun résultat trouvé.</td>
                                    </tr>
                                    <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
    <div class="sidebar col-md-3">
        <article class="detailed-logo">
            <ul class="grow">
                
            </ul>         
        </article>       
    </div>
</div>
    
<style type="text/css">
    html, body { height: 100%; margin: 0; padding: 0; }
    #map { height: 100%; }
</style>

@stop