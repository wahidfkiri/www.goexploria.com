@extends('layouts.back.master-with-left-menu')
@section('title', 'Destination')
@section('breadcrumb')
	{!! Breadcrumbs::render('location.details', $country, $location) !!}
@stop
@section('left-menu')
	@include('back.location.menu')
@stop

@section('right-content')
<h4>{{ Formatter::slugToNames($location->slugify()) }}</h4>
<p>
    {!! Formatter::seeButton(route('front.location.id', [$location->id]))!!}

    {!! Formatter::button(route('location.page.search', [$country->code, $location->id]), 'primary', 'fa-file-text fa', 'Pages')!!}

    {!! Formatter::button(route('location.statut', [$country->code, $location->id]), 'warning', 'fa fa-'.($location->is_activated ? 'ban' : 'check'), $location->statut()->action)!!}

    {!! Formatter::deleteButton($location->id)!!}

    {!! Formatter::delete(route('location.delete', [$country->code, $location->id]), $location->id, "Supprimer une destination", "Voulez-vous vraiment supprimer le destination " .$location->name ." ?" ) !!}
</p>

<div class='row'>

	<!--Infos -->
	@if ($location->hasDetails())
	<div class='col-md-4'>
		<div class="seperator"><label>Généralités</label></div>
        <table class='table user'>
        	@if (isset($location->population))
                    <tr>
                        <th>Population</th>
                        <td>{{$location->population}} habitants</td>
                    </tr>
                @endif
                @if (isset($location->superficie))
                    <tr>
                        <th>Superficie</th>
                        <td>{{$location->superficie}} km*km</td>
                    </tr>
                @endif
                @if (isset($location->population) && isset($location->superficie))
                    <tr>
                        <th>Densite</th>
                        <td>{{round($location->population / $location->superficie, 2)}} habitants/km*km</td>
                    </tr>
                @endif
                @if (isset($location->latitude))
                    <tr>
                        <th>Latitude</th>
                        <td>{{round($location->latitude, 3)}} °</td>
                    </tr>
                @endif
                @if (isset($location->longitude))
                    <tr>
                        <th>Longitude</th>
                        <td>{{round($location->longitude, 3)}} °</td>
                    </tr>
                @endif
                @if (isset($location->gentile))
                    <tr>
                        <th>Gentilé</th>
                        <td>{{$location->gentile}}</td>
                    </tr>
                @endif
                @if (isset($location->fondation))
                    <tr>
                        <th>Fondé le </th>
                        <td>{{formatter::convertdate($location->fondation)}}</td>
                    </tr>
                @endif
                @if (isset($location->drapeau))
                    <tr>
                        <th>Blason</th>
                        <Td>{!! Html::decode(Html::link($location->drapeau, Html::image($location->drapeau, $location->name, ['class' => 'drapeAu']), ['title' => 'cliquez pour agrandir', 'target' => '_blank'])) !!}</td>      
                    </tr>
                @endif
                @if (isset($location->languages) && count_of($location->languages) > 0)
                    <tr>
                        <th>Langues principales</th>
                        <td>
                            <ul>
                                @foreach($location->languages as $langue)
                                    <li>{{$langue->name}}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endif
        </table>
	</div>
	@endif

	<!-- Informations -->
	@if(count_of($coordinate) > 0)
	<div class='col-md-4'>

        <!-- Informations de contact -->
        <div class="seperator"><label>Contact</label></div>
        <table class='table user'>
       	 	@if (isset($coordinate->location))
        	<tr>
		        <th>Ville</th>
                <td>{{ $coordinate->location->name }}</td>
            </tr>
            @endif
			@if (isset($coordinate->code_postal))
	        <tr>
	            <th>Code postal</th>
	            <td>{{ $coordinate->code_postal }}</td>
            </tr>
            @endif
            @if (isset($coordinate->adresse))
	        <tr>
	            <th>Adresse</th>
	            <td>{{ $coordinate->adresse }}</td>
            </tr>
            @endif
			@if (isset($coordinate->tel))
	        <tr>
	            <th>Téléphone</th>
	            <td>{{ $coordinate->tel }}</td>
            </tr>
    		@endif

			@if (isset($coordinate->fax))
	        <tr>
	            <th>Télécopieur</th>
	            <td>{{ $coordinate->fax }}</td>
            </tr>
    		@endif

			@if (isset($coordinate->mail))
            <tr>
	            <th>Email</th>
	            <td>{{ $coordinate->mail }}</td>
            </tr>
    		@endif

			@if (isset($coordinate->website))
	        <tr>
	            <th>Site web</th>
	            <td>{{ link_to($coordinate->website, $coordinate->website) }}</td>
            </tr>
   			@endif


        </table>
    </div>
    @endif
    <div class='col-md-4'>
		<iframe class="map" src="https://maps.google.com/maps?q={{$location->map}}&amp;num=1&amp;ie=UTF8&amp;t=m&amp;output=embed"></iframe>
		@if($location->latitude != null && $location->longitude != null)
			<iframe class="map" src="https://maps.google.com/maps?q={{$location->latitude}},{{$location->longitude}}&amp;num=1&amp;ie=UTF8&amp;t=m&amp;output=embed"></iframe>
		@endif
	</div>
</div>


<!-- Activités -->
@if (count_of($activities) > 0)
<div class='row'>
<div class="seperator"><label>Activités</label></div>

	<!-- Tourisme -->
	@if ($activities->where('type_id', 1)->count() > 0)
	<div class='col-md-6'>	
		<div class="seperator"><label>Tourisme</label></div>
		<table class='table table-striped'>
			@foreach($activities->where('type_id', 1)->sortBy('category_name')->all() as $activity)
                <tr>
                    <td>{{$activity->name}}</td>
                    <td>{{$activity->category_name}}</td>
                </tr>
            @endforeach
		</table>
	</div>
	@endif

	<!-- Affaire -->
	@if ($activities->where('type_id', 2)->count() > 0)
	<div class='col-md-6'>	
		<div class="seperator"><label>Affaire</label></div>
		<table class='table table-striped'>
			@foreach($activities->where('type_id', 2)->sortBy('category_name')->all() as $activity)
                <tr>
                    <td>{{$activity->name}}</td>
                    <td>{{$activity->category_name}}</td>
                </tr>
            @endforeach
		</table>
	</div>
	@endif
</div>
@endif

<!-- Pages -->
@if (count_of($location->pages) > 0)
<div class="seperator"><label>Pages</label></div>

<table class='table table-striped'>
	<tr>
		<th>Nom</th>
		<th>Statut</th>
	</tr>
	@foreach($location->pages()->orderBy('rank', 'desc')->orderBy('name')->get() as $page)
        <tr>
            <td>{{$page->name}}</td>
            <td>{{$page->statut()}}</td>
        </tr>
    @endforeach
</table>

@endif

@stop
		
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $(".delete").click(function(){
            var value = $(this).attr('data');
            $('#modal-delete-'+value).modal('show');
                    
            return false;
        });
    });
</script>
@stop
