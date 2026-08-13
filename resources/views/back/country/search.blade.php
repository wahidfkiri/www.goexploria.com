@extends('layouts.back.master')
@section('title', 'Pays')
@section('content')
{!! Breadcrumbs::render('country') !!}

<h3>Ajouter</h3>
{!! Formatter::addButton(route('country.add'))!!}

<h3>Activer</h3>
{!! Form::open(['route' => 'country.activate', 'method' => 'post']) !!}
<table class='row'>
    <tr>
        <td>{!! Form::label('pays', 'Pays') !!}</td>
        <td class='selectize-bar'>{!! Form::select('pays', ['' => "Choisir un pays"] + $pays, null, ['class' =>
            'selector']) !!} 
        </td>
        <td >{!! Form::button("<i class='entypo-check'></i> Activer", ['type' => 'submit', 'class'
            => 'btn btn-primary btn-sm btn-icon icon-left']) !!}
        </td>
    </tr>
</table>
{!! Form::close() !!}

<h3>Déjà activés</h3>
<!-- Outil de recherche -->
<div class="panel panel-primary" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            Rechercher
        </div>

        <div class="panel-options">
            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
        </div>
    </div>

    <div class="panel-body">
        <table class="table">
            <tr>
                <td>{{ Form::label('name', 'Nom') }}</td>
                <td>{{ Form::text('name', null, ["data-column"=>"0", 'id' => 'col0_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Nom']) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('continent', 'Continent') }}</td>
                <td>{{ Form::text('continent', null, ["data-column"=>"1", 'id' => 'col1_filter', 'class' => 'form-control column_filter', 'placeholder' => 'Continent']) }}</td>
            </tr>
        </table>
        {{ Form::button("<i class='entypo-search'></i> Rechercher", ['class'=>'btn btn-success btn-sm btn-icon icon-left', 'id' => 'search']) }}
        {{ Form::button("<i class='entypo-cancel'></i> Effacer", ['id'=> 'clear', 'class'=>'btn btn-primary btn-sm btn-icon icon-left']) }}
    </div>
</div>

<!-- Liste des résultats-->
<table class="table table-bordered table-striped datatable" id='table'>
    <thead>
        <tr>
            <th>Pays</th>
            <th>Continent</th>
            <th>Rang</th>
            <th>Pages</th>
            <th>Galeries</th>
            <th>Hierarchie</th>
            <th>Destinations</th>
            <th>Actions</th>
        </tr>
    </thead><tbody>
        @foreach ($paysOk as $country)
        <tr>
            <td class='search-name'>{{ $country->name }}</td>            
            <td class='search-continent'>{{ $country->continent->name }}</td>
            <td>{{ $country->rank }}</td>
            <td class='search-continent'>{{ $country->pages()->count() }}</td>
            <td class="search-gallery" align="center">@if( $country->galleries->count() > 0 )<a href="{{ route('country.gallery.search', ['cid' => $country->id]) }}"> {{ $country->galleries->count() }} </a> @endif</td>
            <td>{!! link_to_route('location.type.search', 'Hierarchie', [$country->code],
                ['class' => 'btn btn-info btn-sm', 'title' => 'Hierarchie']) !!}
            </td>
            <td>{!! link_to_route('location.search', 'Destinations', [$country->code],
                ['class' => 'btn btn-info btn-sm ', 'title' => 'Destinations']) !!}
            </td>
            <td>
                {!! link_to_route('front.country.id', 'Voir', [$country->id],
                ['class' => 'btn btn-info btn-sm', 'title' => 'Voir']) !!}

                {!! link_to_route('country.edit', 'Editer', [$country->id],
                ['class' => 'btn btn-default btn-sm', 'title' => 'Editer']) !!}
                
                {!! Formatter::button(route('country.page.search', $country->code), 'primary', 'fa-file-text fa', 'Pages')!!}
                
                {!! link_to_route('country.disable', 'Désactiver', [$country->id],
                ['class' => 'btn btn-warning btn-sm', 'title' => 'Désactiver']) !!}

                {!! link_to_route('country.delete', 'Supprimer', [$country->id],
                ['class' => 'delete btn btn-danger btn-sm', 'title' => 'Supprimer', 'data'=>"$country->id"]) !!}

                {!! Formatter::delete(route('country.delete', $country->id), $country->id, "Supprimer un pays", "Voulez-vous vraiment supprimer le pays " .$country->name ." ?" ) !!}

            </td>
        </tr>
        @endforeach
    </tbody>

</table>


<ul style='display:none'>
    @foreach($paysOk as $country)
    <li class='pays'>{!! $country->code !!}</li>
    @endforeach
</ul>

<div id="vmap" class="carte map"></div>
@stop

@section('js')
{{ Html::script('js/map/jquery.vmap.js') }}
{{ Html::script('js/map/jquery.vmap.world.js') }}
{{ Html::script('js/map/jquery.vmap.sampledata.js') }}    
{{ Html::style('js/map/jqvmap.css') }}
{{ Html::script('js/jquery/dataTables.min.js') }}  
{{ Html::style('css/selectize.css') }}  
{{ Html::script('js/selectize.js') }}  

<script type='text/javascript'>
    $(document).ready(function () {

        /*** Sélecteur **/
        $('.selector').selectize();

        /*** Carte */
        jQuery('#vmap').vectorMap({
            map: 'world_en',
            backgroundColor: '#333333',
            color: '#ffffff',
            hoverOpacity: 0.7,
            selectedColor: '#666666',
            enableZoom: true,
            showTooltip: true,
            normalizeFunction: 'polynomial'
        });
        $(".pays").each(function (code) {
            var country_colors = {};
            var country_name = $(this).text();
            country_colors[country_name] = '#8EE5EE';
            jQuery('#vmap').vectorMap('set', 'colors', country_colors);
        });

        /**************************************************************/
        /************************* SUPPRESSION ************************/
        /**************************************************************/
        function callback() {
            $(".delete").click(function () {
                var value = $(this).attr('data');
                $('#modal-delete-' + value).modal('show');
                return false;
            });
        }


        /**************************************************************/
        /************************* DATATABLE **************************/
        /**************************************************************/
        $('#table').DataTable({
            sDom: '<"top"l>rt<"bottom"ip><"clear">',
            "order": [[0, "asc"]],
            "drawCallback": function (settings) {
                callback();
            }
        });
        function filterColumn(i) {
            $('#table').DataTable().column(i).search(
                    $('#col' + i + '_filter').val()
                    ).draw();
        }

        // recherche
        $('input.column_filter').on('keyup click', function () {
            filterColumn($(this).attr('data-column'));
        });

        /** Clique sur le nom */
        $(".search-name").click(function () {
            var value = $(this).html();
            $('#col0_filter').val(value);
            search();
        });

        /** Clique sur le continent*/
        $(".search-continent").click(function () {
            var value = $(this).html();
            $('#col1_filter').val(value);
            search();

        });

        /** bouton de recherche  */
        $("#search").click(function () {
            search();
        });

        search();
        
        /** Recherhe */
        function search() {
            filterColumn($('#col0_filter').attr('data-column'));
            filterColumn($('#col1_filter').attr('data-column'));
        }

        /** Vidage des champs */
        $("#clear").click(function () {
            $('#col0_filter').val('');
            $('#col1_filter').val('');
            search();
        });


    });
</script>		                   
@stop
