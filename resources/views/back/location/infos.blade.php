@extends('layouts.back.master-with-left-menu') @section('title',
'Destination') @section('breadcrumb') {!!
Breadcrumbs::render('location.edit.infos', $country, $location) !!}
@stop @section('left-menu') @include('back.location.menu') @stop

@section('right-content')
<h4>
    <b>{{ Formatter::slugToNames($location->slugify()) }}</b> :
    Informations
</h4>
@if ($location->drapeau != null)
<!-- Popup image -->
{!! Formatter::popup([], 'drapeau-dialog', 'Drapeau/Blason',
Html::image($location->drapeau)) !!} @endif {{ Form::open(array('route'
=> array('location.edit.infos.post', $country->code, $location->id),
'method' => 'post', 'id' => 'editForm', 'files'=>true)) }}
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<table class='table user'>
    <tr>
        <td>{{ Form::label('name', "Nom*", ['class' => "control-label"]) }}</td>
        <td>{{ Form::text('name', $location->name, ["data-validate" =>
			"required", 'class' => 'reload form-control', 'placeholder' => 'Nom
			de la destination']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('slug', "Slug*", ['class' => "control-label"]) }}</td>
        <td>{{ Form::text('slug', $location->slug, ["data-validate" =>
			"required", 'class' => 'form-control ', 'placeholder' => 'Slug']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('latitude', "Latitude", ['class' =>
			"control-label"]) }}</td>
        <td>{{ Form::number('latitude', $location->latitude, ['id' =>
			'latitude', 'step'=> '0.001', 'class' => 'form-control',
			'placeholder' => 'Latitude']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('longitude', "Longitude", ['class' =>
			"control-label"]) }}</td>
        <td>{{ Form::number('longitude', $location->longitude, ['id' =>
			'longitude','step'=> '0.001', 'class' => 'form-control',
			'placeholder' => 'Longitude']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('population', "Population", ['class' =>
			"control-label"]) }}</td>
        <td>{{ Form::number('population', $location->population, ['step'=>
			'1', 'class' => 'form-control', 'placeholder' => 'Population du
			destination']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('superficie', "Superifice (km2) ", ['class' =>
			"control-label"]) }}</td>
        <td>{{ Form::number('superficie', $location->superficie, ['step'=>
			'0.01', 'class' => 'form-control', 'placeholder' => 'Superficie']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('gentile', "Gentilé", ['class' => "control-label"])
            }}</td>
        <td>{{ Form::text('gentile', $location->gentile, ['class' =>
			'form-control', 'placeholder' => 'Gentilé']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('drapeau', "Drapeau (blason)", ['class' =>
			"control-label"]) }} @if ($location->drapeau != null) <a
                            data-toggle="modal" href="#drapeau-dialog"
                            class="btn btn-info btn-sm btn-icon icon-left"> <i
                                class="entypo-picture"></i> Voir l'actuel
                        </a> @endif
        </td>
        <td>{{ Form::file('drapeau', null, ['class' => 'form-control']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('fondation', "Fondée le", ['class' =>
			"control-label"]) }}</td>
        <td>
            <div class="input-group">
                {{ Form::text('fondation', $location->fondation != null ?
				date("m/d/y", strtotime($location->fondation)) : '', ['class' =>
				'datepicker form-control', 'placeholder' => 'Date de fondation']) }}
                                <div class="input-group-addon">
                                    <a href="#"><i class="entypo-calendar"></i></a>
                                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>{{ Form::label('languages', "Langues principales", ['class' =>
			"control-label"]) }}</td>
        <td>{!! Form::select('languages[]', $languages,
            $location->languages->pluck('id')->all(), ['multiple'=>'multiple',
            'class' => 'form-control multiselect']) !!}</td>
    </tr>
    <tr>
        <td>{{ Form::label('description', "Description", ['class' =>
			"control-label"]) }}</td>
        <td>{{ Form::textarea('description', $location->description, ['class'
			=> 'form-control ckeditor', 'placeholder' => 'description']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('map_url', "Url de la carte", ['class' => "control-label"]) }}</td>
        <td>{{ Form::text('map_url', $location->map_url, [ 'class' => 'reload form-control'
                    , 'placeholder' => 'URL']) }}</td>
    </tr>
    <tr>
        <th>Cartes</th>
        <td class="row">
            <div class="col-sm-6 carte">
                <div id="map" class='carte'></div>
            </div>
            <div class="col-sm-6 carte" id='frame'>                
                <iframe id='mapframe'
                        src="{{empty($location->map_url) ? "https://maps.google.com/maps?q={$location->name},{$location->type->country->name}&amp;num=1&amp;ie=UTF8&amp;t=m&amp;output=embed" : $location->map_url }}"></iframe>
            </div>
        </td>
    </tr>
</table>
{{ Form::submit('Modifier') }} {{ Form::close() }}
@stop 
@section('js')
{!! JsValidator::formRequest('App\Http\Requests\LocationInfosRequest', '#editForm'); !!} 
{{ Html::style('css/jquery-ui/jquery-ui.css') }} 
{{ Html::style('css/back/ui.multiselect.css') }} 
{{ Html::script('js/jquery-ui/ui.js') }} 
{{ Html::script('js/multiselect/ui.js') }} 
{{ Html::script('js/multiselect/plugins/localisation/jquery.localisation.js') }} 
{{ Html::script('js/multiselect/plugins/scrollTo/jquery.scrollTo-min.js') }} 
{{ Html::script('js/bootstrap/datepicker.js') }} 


<!--<script type="text/javascript">
    $(document).ready(function() {

    $.localise('ui-multiselect', {language: 'fr', path: '/js/multiselect/locale/'});
            $(".multiselect").multiselect();
            initAutocomplete();
// This example adds a search box to a map, using the Google Place Autocomplete
// feature. People can enter geographical searches. The search box will return a
// pick list containing a mix of places and predicted search terms.

            function initAutocomplete() {
            var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: {{ $location->latitude != null ? $location->latitude : 0 }}, lng: {{ $location->longitude != null ? $location->longitude : 0 }}},
                    zoom: 8,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
            });
                    // Create the search box and link it to the UI element.
                    var input = document.getElementById('name');
                    var searchBox = new google.maps.places.SearchBox(input);
                    // Bias the SearchBox results towards current map's viewport.
                    map.addListener('bounds_changed', function() {
                    searchBox.setBounds(map.getBounds());
                    });
                    var markers = [];
                    // Listen for the event fired when the user selects a prediction and retrieve
                    // more details for that place.
                    searchBox.addListener('places_changed', function() {
                    var places = searchBox.getPlaces();
                            if (places.length == 0) {
                    return;
                    }

                    // Clear out the old markers.
                    markers.forEach(function(marker) {
                    marker.setMap(null);
                    });
                            markers = [];
                            // For each place, get the icon, name and location.
                            var bounds = new google.maps.LatLngBounds();
                            places.forEach(function(place) {
                            var icon = {
                            url: place.icon,
                                    size: new google.maps.Size(71, 71),
                                    origin: new google.maps.Point(0, 0),
                                    anchor: new google.maps.Point(17, 34),
                                    scaledSize: new google.maps.Size(25, 25)
                            };
                                    // Create a marker for each place.
                                    markers.push(new google.maps.Marker({
                                    map: map,
                                            icon: icon,
                                            title: place.name,
                                            position: place.geometry.location
                                    }));
                                    $('#latitude').val(place.geometry.location.lat());
                                    $('#longitude').val(place.geometry.location.lng());
                                    $('#frame').html("<iframe id='mapframe'"
                                    + "src='https://maps.google.com/maps?q=" + place.name + "&amp;num=1&amp;ie=UTF8&amp;t=m&amp;output=embed'>"
                                    + "</iframe>");
                                    if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);
                            } else {
                            bounds.extend(place.geometry.location);
                            }
                            });
                            map.fitBounds(bounds);
                    });
                    }
    });
</script>-->

  
@stop
