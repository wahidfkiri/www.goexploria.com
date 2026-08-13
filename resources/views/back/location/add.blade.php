@extends('layouts.back.master') @section('title', 'Destinations')
@section('content') {!! Breadcrumbs::render('location.add', $country)
!!}

<h4>Ajouter une destination</h4>
<hr />

{{ Form::open(array('route' => array('location.add.post',
$country->code), 'method' => 'post','name' => 'locationForm', 'id' =>
'addForm', 'class' => 'form-wizard validate', 'files'=>true)) }}
<input type="hidden" name="_token" value="{{ csrf_token() }}">
@if (count_of($type) > 0)
<div class="steps-progress">
    <div class="progress-indicator"></div>
</div>
<ul>
    <li class="active"><a href="#tab2-1" data-toggle="tab"><span>1</span>Type
            de destination</a></li>
    <li><a href="#tab2-2" data-toggle="tab"><span>2</span>Informations de
            la destination</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="tab2-1">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('locationType', "Type de
					destination*", ['class' => "control-label"]) }} {{
					Form::select('locationType', $type, null, ['id' => 'type', 'class'
					=> 'form-control']) }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">{{ Form::label('parentID', "Parent de la
					destination", ['class' => "control-label"]) }} {{
					Form::select('parentID', array(), null, ['id' => 'search-engine',
					'minChar' => 2, 'placeholder' => 'Parent', 'source' =>
					route('search.location.parent', [$country->code, ':data'])]) }}</div>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="tab2-2">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">{{ Form::label('name', "Nom*", ['class' =>
					"control-label"]) }} {{ Form::text('name', null, ['id' => 'name',
					"data-validate" => "required", 'class' => 'form-control controls',
					'placeholder' => 'Nom du destination']) }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">{{ Form::label('latitude', "Latitude",
					['class' => "control-label"]) }} {{ Form::number('latitude', null,
					['id' => 'latitude', 'step'=> '0.001', 'class' => 'form-control
					controls', 'placeholder' => 'Latitude']) }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">{{ Form::label('longitude', "Longitude",
					['class' => "control-label"]) }} {{ Form::number('longitude', null,
					['id' => 'longitude', 'step'=> '0.001', 'class' => 'form-control
					controls', 'placeholder' => 'Longitude']) }}</div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-4">
                <div class="form-group">{{ Form::label('population', "Population",
					['class' => "control-label"]) }} {{ Form::number('population',
					null, ['id' => 'population', 'step'=> '1', 'class' => 'form-control
					controls', 'placeholder' => 'Population de la destination']) }}</div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">{{ Form::label('superficie', "Superifice
					(km2) ", ['class' => "control-label"]) }} {{
					Form::number('superficie', null, ['id' => 'superficie', 'step'=>
					'0.01', 'class' => 'form-control controls', 'placeholder' =>
					'Superficie']) }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">{{ Form::label('gentile', "Gentilé",
					['class' => "control-label"]) }} {{ Form::text('gentile', null,
					['id' => 'gentile', 'class' => 'form-control controls',
					'placeholder' => 'Gentilé']) }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">{{ Form::label('drapeau', "Drapeau
					(blason)", ['class' => "control-label"]) }} {{
					Form::file('drapeau', null, ['id' => 'drapeau', 'class' =>
					'form-control controls']) }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('fondation', "Date de fondation", ['class' =>
					"control-label"]) }}
                                        <div class="input-group">
                                            {{ Form::text('fondation', null, ['id' => 'fondation', 'class' =>
						'datepicker form-control', 'placeholder' => 'Fondation']) }}
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">{{ Form::label('languages', "Langues
					principales", ['class' => "control-label"]) }} {{
					Form::select('languages[]', $languages, null, ['id' => 'languages',
					'multiple'=>'multiple', 'class' => 'form-control multiselect']) }}
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-12">
                <div class="form-group">{{ Form::label('description', "Description",
					['class' => "control-label"]) }} {{ Form::textarea('description',
					null, ['class' => 'form-control ckeditor', 'placeholder' =>
					'Description']) }}</div>
            </div>

        </div>
        <div class="row hidden" id='mapblock'>
            <div class="col-sm-6 carte">
                <div id="map" class='carte'></div>
            </div>
            <div class="col-sm-6 carte" id='frame'></div>
        </div>

        <div class="form-group">{{ Form::submit('Ajouter', ['class' => 'btn
			btn-primary']) }}</div>

    </div>


    <ul class="pager wizard">
        <li class="previous"><a href="#"><i class="entypo-left-open"></i>
                Précédent</a></li>

                <li class="next"><a href="#">Suivant <i class="entypo-right-open"></i></a>
                </li>
    </ul>
</div>
@else
<div class='error'>
    <p class='error-message'>Aucun type de destination définit pour ce pays</p>
    <a href="{{ route('location.type.add', $country->code) }}"
       class="btn btn-primary btn-sm btn-icon icon-left"> <i
            class="entypo-plus"></i>Ajouter un type
    </a>
</div>
@endif {{ Form::close() }} @stop @section('js') {{
Html::style('css/jquery-ui/jquery-ui.css') }} {{
Html::style("css/selectize.css")}} {{
Html::style('css/back/ui.multiselect.css') }} {{
Html::script('js/jquery-ui/ui.js') }} {!!
JsValidator::formRequest('App\Http\Requests\AddLocationPostRequest',
'#addForm') !!} {{ Html::script('js/jquery/bootstrap.wizard.min.js') }}
{{ Html::script('js/multiselect/ui.js') }} {{
Html::script('js/multiselect/plugins/localisation/jquery.localisation.js')
}} {{
Html::script('js/multiselect/plugins/scrollTo/jquery.scrollTo-min.js')
}} {{ Html::script('js/bootstrap/datepicker.js') }} {{
Html::script("js/selectize.js")}} {{
Html::script("js/search-engine.js")}} {!!
Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyAf8zmKIqxFXtKtgSLI_oC0nCIVcDfwCsQ&libraries=places')
!!}
<script type="text/javascript">

    $(document).ready(function () {


        $('.next').click(function () {
            setTimeout(function () {
                initAutocomplete();
            }, 400);
        });

        $.localise('ui-multiselect', {language: 'fr', path: '/js/multiselect/locale/'});
        $(".multiselect").multiselect();

        $('#name').on('click', function () {
            initAutocomplete();
        });


// This example adds a search box to a map, using the Google Place Autocomplete
// feature. People can enter geographical searches. The search box will return a
// pick list containing a mix of places and predicted search terms.

        function initAutocomplete() {
            var carte = document.getElementById('map');
            var map = new google.maps.Map(carte, {
                center: {lat: 0, lng: 0},
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            // Create the search box and link it to the UI element.
            var input = document.getElementById('name');
            var searchBox = new google.maps.places.SearchBox(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function () {
                searchBox.setBounds(map.getBounds());
            });

            var markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function () {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function (marker) {
                    marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {
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

                    if (!$('#mapblock').is(':visible')) {
                        $('#mapblock').removeClass('hidden');
                        google.maps.event.trigger(map, "resize");
                    }


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
</script>

<!-- Barre de recherche -->
<script type='text/javascript'>
    $(document).ready(function () {
        $('#search-engine').searchEngine();
    });
</script>

@stop
