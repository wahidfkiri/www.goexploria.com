@extends('layouts.back.master')
@section('title', 'Destinations')
@section('content')
{!! Breadcrumbs::render('location.search', $country) !!}
<h3>Liste des destinations</h3>
{!! Formatter::addButton(route('location.add', $country->code))!!}

</br></br>

<div class="modal fade" id="map-dialog">
    <div class="modal-dialog" style='width: 60%'>
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Carte</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-sm-6"><div id="map" class='carte'></div></div>
                    <div class="col-sm-6 carte" id='frame'></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>


<div class="panel panel-primary" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            Rechercher
        </div>

    </div>

    <div class="panel-body">
        {{ Form::open(array('route' => array('location.search.post', $country->code), 'method' => 'post')) }}
        <table class="table">
            <tr>
                <td>{{ Form::label('name', 'Nom') }}</td>
                <td>{{ Form::text('name', isset($search) ? $search->name : '', ['id' => 'name-search', 'class' => 'form-control', 'placeholder' => 'Nom']) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('type', 'Type') }}</td>
                <td>{{ Form::text('type', isset($search) ? $search->type : '', ['id' => 'type-search', 'class' => 'form-control', 'placeholder' => 'Type']) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('parent', 'Parent') }}</td>
                <td>{{ Form::text('parent', isset($search) ? $search->parent : '', ['id' => 'parent-search', 'class' => 'form-control', 'placeholder' => 'Parent']) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('statut', 'Statut') }}</td>
                <td>{{ Form::select('statut', ['-1' => 'Tous'] + $statuts, isset($search->statut) ? $search->statut : null, ['id' => 'statut-search', 'class' => 'form-control']) }}</td>
            </tr>

        </table>
        {{ Form::button("<i class='entypo-search'></i> Rechercher", ['class'=>'btn btn-success btn-sm btn-icon icon-left', 'type' => 'submit']) }}
        <a href="{{ route('location.search.clear', [$country->code]) }}">{{ Form::button("<i class='entypo-cancel'></i> Effacer", ['id'=> 'clear', 'class'=>'btn btn-primary btn-sm btn-icon icon-left']) }}</a>
        {{ Form::close() }}
    </div>
</div>

<table class="table table-bordered table-striped" id="table">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Type</th>
            <th>Parent</th>
            <th>Statut</th>
            <th>Galeries</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($locations as $location)
        <tr>
            <td class="search-name">{{ $location->name }}</td>
            <td class="search-type">{{ $location->type->name }}</td>
            <td class="search-parent" data="{{$location->head != null ? $location->head->name : ''}}">{{ $location->head != null ? $location->head->name .' ('.$location->type->head->name.')' : 'Aucun' }}</td>
            <td data='{{$location->is_activated}}' class="search-statut">
                {{$location->statut()->name}}   
            </td>
            <td class="search-gallery" align="center">@if( $location->galleries->count() > 0 )<a href="{{ route('location.gallery.search', ['lid' => $location->id]) }}"> {{ $location->galleries->count() }} </a> @endif</td>
            <td>

                {!! Formatter::seeButton(route('front.location.id', [$location->id]))!!}

                {!! Formatter::button('#map-dialog', 'info map', 'entypo-map', 'Carte', [ "data-toggle" => "modal", "map" => $location->map, "latitude" => $location->latitude, "longitude" => $location->longitude ])!!}

                {!! Formatter::button(route('location.page.search', [$country->code, $location->id]), 'primary', 'fa-file-text fa', 'Pages')!!}

                {!! Formatter::button(route('location.statut', [$country->code, $location->id]), 'warning', 'fa fa-'.($location->is_activated ? 'ban' : 'check'), $location->statut()->action)!!}

                {!! Formatter::editButton(route('location.edit', [$country->code, $location->id]))!!}

                {!! Formatter::deleteButton($location->id)!!}

                {!! Formatter::delete(route('location.delete', [$country->code, $location->id]), $location->id, "Supprimer une destination", "Voulez-vous vraiment supprimer le destination " .$location->name ." ?" ) !!}


            </td>


        </tr>
        @endforeach
    </tbody>
</table>
{{ $locations->render() }}


<br />
<br />
@stop

@section('js')
{{ Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyAf8zmKIqxFXtKtgSLI_oC0nCIVcDfwCsQ&libraries=places') }} 	 
<script type="text/javascript">
    $(document).ready(function () {

        /**************************************************************/
        /************************* CARTES *****************************/
        /**************************************************************/
        var map, centerAt, latitude = 0, longitude = 0;
        // Initialisation de la carte
        function initMap() {
            var centerPnt = new google.maps.LatLng(51.55211, -106.17376);
            var mapOptions = {
                zoom: 5,
                center: centerPnt,
                continuousZoom: true
            };
            map = new google.maps.Map(document.getElementById("map"), mapOptions);
        }

        /** Clique sur un des boutons carte*/
        $(".map").click(function () {
            // Rechargement de la carte JS
            latitude = $(this).attr('latitude');
            longitude = $(this).attr('longitude');
            resizeMap();

            // Recréation de la carte iFrame
            $('#frame').html("<iframe id='mapframe'"
                    + "src='https://maps.google.com/maps?q=" + $(this).attr('map')
                    + "&amp;num=1&amp;ie=UTF8&amp;t=m&amp;output=embed'>"
                    + "</iframe>");
        });

        /** Affichage de la boite de dialogues*/
        $('#map-dialog').on('show.bs.modal', function () {
            resizeMap();
        });

        /* Appel de la recharge*/
        function resizeMap() {
            if (typeof map == "undefined")
                return;
            setTimeout(function () {
                resizingMap();
            }, 400);
        }

        /** Recharge la page avec la nouvelle position */
        function resizingMap() {
            if (typeof map == "undefined")
                return;
            map.setCenter(new google.maps.LatLng(latitude, longitude));
            google.maps.event.trigger(map, "resize");
        }

        /** Ajout des évènements */
        google.maps.event.addDomListener(window, 'load', initMap);
        google.maps.event.addDomListener(window, "resize", resizingMap());

        /**************************************************************/
        /************************* SUPPRESSION ************************/
        /**************************************************************/
        $(".delete").click(function () {
            var value = $(this).attr('data');
            $('#modal-delete-' + value).modal('show');

            return false;
        });

        /**************************************************************/
        /************************* RECHERCHE **************************/
        /**************************************************************/
        /* Clique sur le nom */
        $(".search-name").click(function () {
            var value = $(this).html();
            $('#name-search').val(value);
        });

        /** Clique sur le type */
        $(".search-type").click(function () {
            var value = $(this).html();
            $('#type-search').val(value);
        });

        /** Clique sur le parent*/
        $(".search-parent").click(function () {
            var value = $(this).attr('data');
            $('#parent-search').val(value);
        });

        /** Clique sur le statut */
        $(".search-statut").click(function () {
            var value = $(this).attr('data');
            $('#statut-search').val(value);
        });

    });
</script>
@stop
