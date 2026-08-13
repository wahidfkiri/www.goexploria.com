@extends('layouts.front.master-with-breadcrumb')
@section('title', isset($location->name) ? ucfirst(Formatter::remove_accents($location->name)) : "Monde")

@section('breadcrumb-title')

ACTIVITÉ : {{ strtoupper($activity->name) }}

@stop

@section('breadcrumb')
@if (isset($hierarchie))
{!! Breadcrumbs::render('front.location', $hierarchie) !!}
@else
{!! Breadcrumbs::render('world') !!}
@endif
@stop

@section('main-content')
<div class="row">
    <div id="main" class="col-md-9">    
        <div class="tab-container style1" id="hotel-main-content">
            <ul class="tabs">
                <li class="active"><a data-toggle="tab" href="#map-tab">Carte</a></li>
                <li><a data-toggle="tab" href="#etablissement-tab">Établissements</a></li>
                
                @if(isset($pages))
                @foreach($pages as $key => $page)
                <li><a data-toggle="tab" href="#page{{$key}}-tab">{{$page->name}}</a></li>
                @endforeach
                @endif
                @if (isset($coordinate) && count_of($coordinate) > 0)
                <li><a data-toggle="tab" href="#coordonnees">Contact</a></li>
                @endif
            </ul>
            
            <div class="tab-content" id="destinations">
                <div id="map-tab" class="tab-pane active">
                    <!-- Carte -->                
                   

                    <div id="map"></div>

                </div>

                <div id="etablissement-tab" class="tab-pane">
                     <table class="table table-striped">
                    <tr>
                        <th>Compagnie</th>
                        <th>Site web</th>
                    </tr>
                    @foreach($compagnies as $compagny)
                        <tr>
                            <td>{{$compagny->name}}</td>
                            <td>{{$compagny->coordinate->website}}</td>
                        </tr>
                    @endforeach
                </table>
                </div>
            </div>
            
        </div>
    </div>
    <div class="sidebar col-md-3">
        <article class="detailed-logo">
            <ul class="grow">
                @foreach($provinces as $province)
                    <li><a class="custom-block" href="{{ route("front.activity.country",[$activity->id,$country->id,$province->id]) }}">{{$province->name}}</a></li>
                @endforeach
            </ul>         
        </article>       
    </div>
</div>
    
    <script type="text/javascript">
        
        function initMap() {
                
                
                var adress = [];
                
                @foreach($compagnies as $compagny)
                    adress.push({
                       name : "{!! $compagny->name !!}",
                       adress :  "{!! $compagny->coordinate->adresse !!} {!! $compagny->coordinate->code_postal !!}"
                    });                    
                @endforeach
                
                var map = new google.maps.Map(document.getElementById('map'), { 
                    mapTypeId: google.maps.MapTypeId.TERRAIN,
                    zoom: 6
                });
                
                
                var mainAdress = '{!! $location->name !!}';

              

                var geocoder = new google.maps.Geocoder();


                
                map.setOptions({
                    maxZoom: 16
                });

                geocoder.geocode({
                   'address': mainAdress
                }, 
                function(results, status) {
                    console.log(results[0].geometry.bounds);
                   if(status == google.maps.GeocoderStatus.OK) {
                      new google.maps.Marker({
                         center: results[0].geometry.location,
                         map: map
                      });
                      map.fitBounds(results[0].geometry.bounds);
                      map.setCenter(results[0].geometry.location);
                        var latlngbounds = new google.maps.LatLngBounds();
                        $.each(adress,function(i,a){                    
                             geocoder.geocode({'address': a.adress}, function(results, status) {
                                 if (status === google.maps.GeocoderStatus.OK) {
                                     new google.maps.Marker({
                                        map : map,
                                        title: a.name,
                                        position :  results[0].geometry.location
                                     });
                                     console.log(results[0].geometry.location.lat());
                                     latlngbounds.extend(results[0].geometry.location);  
                                     @if(isset($location->type) && $location->type->id == "5")
                                        // Zoom and center map to include all markers
                                        map.fitBounds(latlngbounds);       
                                        map.panToBounds(latlngbounds);                                         
                                     @endif
                                 }
                             });
                        });
                        
                   }
                });
               
            }
    </script>
    
    <style type="text/css">
        html, body { height: 100%; margin: 0; padding: 0; }
        #map { height: 100%; }
    </style>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxQrm6GTpLK9onLH1uF1Gv0AmqVYHhc5Q&callback=initMap">
    </script>
    @stop