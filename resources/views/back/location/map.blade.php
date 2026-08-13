@extends('layouts.back.master')
@section('title', 'Destinations')
@section('content')
    {!! Breadcrumbs::render('location') !!}
    <h3>Carte des pays</h3>
    <ul style='display:none'>
        @foreach($code as $pays)
            <li class='pays'>{!! $pays->code !!}</li>
        @endforeach
    </ul>
    <div id="vmap" class="carte map"></div>
@stop

@section('js')
    {{ Html::script('js/map/jquery.vmap.js') }}
    {{ Html::script('js/map/jquery.vmap.world.js') }}
    {{ Html::script('js/map/jquery.vmap.sampledata.js') }}    
    {{ Html::style('js/map/jqvmap.css') }}

    <script type='text/javascript'>
      $(document).ready(function () {
        var ccode = [];
        $('#vmap').vectorMap({
          map: 'world_en',
          backgroundColor: '#333333',
          color: '#ffffff',
          hoverOpacity: 0.7,
          selectedColor: '#666666',
          enableZoom: true,
          showTooltip: true,
          onRegionClick: function (event, code) {
        	  var url = '{{ route("location.search", ":id") }}';
        	  if (ccode.indexOf(code) >= 0) {
        	    location.href = url.replace(':id', code);
        	  }
		        	},
          normalizeFunction: 'polynomial'
        });
        $( ".pays" ).each(function( code ) {
        	var country_colors = {};
            var country_name = $( this ).text();
            ccode.push(country_name);
            country_colors[country_name] = '#8EE5EE';
        	jQuery('#vmap').vectorMap('set', 'colors', country_colors);
        });
        
      });
    </script>
@stop
