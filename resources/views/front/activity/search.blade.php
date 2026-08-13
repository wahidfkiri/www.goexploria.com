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
                    <li class="active"><a data-toggle="tab" href="#etablissement-tab">Établissements par activité</a>
                    </li>

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
                                <th colspan="3">{{ $activity->category->name }} &nbsp; -
                                    &nbsp; {{ $activity->name }}</th>
                            </tr>
                            <tr>
                                <th>Localisation</th>
                                <th>Entreprise</th>
                                <th>Site web</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $itemIndex = 0; ?>
                            @foreach( $companies as $company )
                                <?php $itemIndex++; ?>

                                <tr>
                                    <td>{{ $company->location->country->name }}
                                        -> {{ $company->location->head ? $company->location->head->name.' ->' : '' }} <a
                                                href="/{{ trans('front.locale_url') }}location/{{ \App\Models\Location::createSlug($company->location) }}">{{ $company->location->name }}</a>
                                    </td>
                                    <td>{{ $company->name }}</td>
                                    <td><a href="{{ $company->coordinate->website }}"
                                           target="_blank">{{ str_is('http*/', $company->coordinate->website) ? substr($company->coordinate->website, 0, -1) : $company->coordinate->website }}</a>
                                    </td>
                                </tr>
                                @if ($company->getListImageFilename())
                                    <tr class="activity-list-image">
                                        <td colspan="3">
                                            <img src="{{ URL::asset('uploads/list_images/' . $company->id . '/' . $company->getListImageFilename()) }}">
                                            @if ($company->list_image_title)
                                                @if ($company->list_image_link)
                                                    <a href="{{ $company->list_image_link }}" target="_blank">{{ $company->list_image_title }}</a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endif
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
                            <tfoot>
                            <tr>
                                <td colspan="4">
                                    {!! $companies->render() !!}
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div class="sidebar col-md-3">

            @if( isset($pubs_slider) )
                @if( $pubs_slider->count() > 0 )
                    <article class="detailed-logo">
                        <h2>Espace pub</h2>
                        <div id="carousel_home" class="pub-carousel carousel slide" data-ride="carousel">

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <?php $itemIndex=0; ?>
                                @foreach( $pubs_slider as $gallery)
                                    @foreach( $gallery->medias->sortBy('rank') as $l => $media)
                                        <div class="item @if ($itemIndex === 0) active @endif @if (!$media->photo) carousel-has-video @endif"
                                             @if ($media->photo)
                                             style="background-image: url({!! URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) !!});"
                                                @endif
                                        >
                                            @if ($media->target != '')
                                                <a target="_blank" href="{{ $media->target }}">
                                                    @endif
                                                    @if ($media->photo)
                                                            <!--<img alt="{{ $media->name }}" title="{{ $media->name }}" src="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) !!}" alt="{{ $media->id }}">-->
                                                    @else
                                                        <iframe class="carousel-video" src="{{ App\Helpers\Formatter::getYoutubeEmbed($media->slug) }}" allowfullscreen="" width="100%" height="100%" frameborder="0"></iframe>

                                                        <!-- Button HTML (to Trigger Modal) -->
                                                        <a href="#homeModal{{ $itemIndex }}" class="video-carousel-modal-btn" data-toggle="modal"></a>

                                                        <!-- Modal HTML -->
                                                        <div id="homeModal{{ $itemIndex }}" class="modal fade">
                                                            <div class="modal-dialog video-carousel-modal">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    </div>
                                                                    <div class="video-modal-body">
                                                                        <iframe class="video-modal-frame" src="{{ App\Helpers\Formatter::getYoutubeEmbed($media->slug) }}" allowfullscreen="" frameborder="0"></iframe>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($media->target != '')</a>@endif

                                            @if ($media->photo)
                                                <div class="carousel-caption">
                                                    @if( $media->name != '' )
                                                        <h1>{{ $media->name }}</h1>
                                                    @endif
                                                    @if( $media->content != '' )
                                                        <h4>{{ $media->content }}</h4>
                                                    @endif
                                                    @if( strlen($media->target) > 0 )
                                                        <h4><a href="{{ $media->target }}" target="_blank">En savoir plus &gt;</a></h4>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <?php $itemIndex++; ?>
                                    @endforeach
                                @endforeach
                            </div>

                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                @for ($i = 0; $i < $itemIndex; $i++)
                                    <li data-target="#carousel_home" data-slide-to="{{ $i }}" class="@if ($i === 0) active @endif"></li>
                                @endfor
                            </ol>

                            <!-- Controls -->
                            <a class="left carousel-control" href="#carousel_home" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carousel_home" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </article>
                @endif
            @endif
        </div>
    </div>

    <style type="text/css">
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #map {
            height: 100%;
        }
    </style>

@stop