@extends('layouts.front.master-with-breadcrumb')
@section('title', isset($location->name) ? ucfirst(Formatter::remove_accents($location->name)) : "Monde")

@section('breadcrumb-title')
    @if (isset($location->name))
        <label title="{{ $location->id }}"> {{ strtoupper(Formatter::remove_accents($location->name)) }}</label>
    @else
        MONDE
    @endif
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
        {{-- @if (count_of($fils) > 0) --}}
        <div id="main" class="col-md-9">
            {{-- @else
              <div id="main" class="col-md-12">
            @endif --}}

            <h1>@if( isset($location->type->name) ) {{ Formatter::remove_accents($location->type->name) . ' ' }}@endif {{ Formatter::remove_accents($location->name) }}</h1>

            <!-- Sliders -->

            @if( isset($medias) )
                @if( $medias->where('gslider', 1)->count() > 0 )
                    <div id="carousel_location" class="company-carousel carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            @for ($i = 0; $i < $medias->where('gslider', 1)->count(); $i++)
                                <li data-target="#carousel_location" data-slide-to="{{ $i }}" class="@if ($i === 0) active @endif"></li>
                            @endfor
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <?php $itemIndex=0; ?>
                            @foreach( $medias->where('gslider', 1) as $media)
                                <div class="item @if ($itemIndex === 0) active @endif @if (!$media->photo) carousel-has-video @endif">
                                    @if ($media->target != '')
                                        <a target="_blank" href="{{ $media->target }}">
                                            @endif
                                            @if ($media->photo)
                                                <img alt="{{ $media->name }}" title="{{ $media->name }} - {{ strtoupper($location->name) }}"
                                                     src="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) !!}" alt="{{ $media->id }}">
                                                @if ($media->target != '')</a>@endif
                                    @else
                                        @if (App\Helpers\Formatter::getVideoType($media->slug) == 'youtube')
                                            <iframe class="carousel-video" src="{{ App\Helpers\Formatter::getYoutubeEmbed($media->slug) }}" allowfullscreen="" width="100%" height="100%" frameborder="0"></iframe>
                                        @elseif (App\Helpers\Formatter::getVideoType($media->slug) == 'vimeo')
                                            <img src="{{ App\Helpers\Formatter::getVimeoMiniature($media->slug, 'large') }}">
                                        <!--<iframe class="carousel-video" src="{{ App\Helpers\Formatter::getVimeoEmbed($media->slug) }}" allowfullscreen="" width="100%" height="100%" frameborder="0"></iframe>-->
                                        @endif

                                        <!-- Button HTML (to Trigger Modal) -->
                                        <a href="#homeModal{{ $itemIndex }}" class="video-carousel-modal-btn" data-toggle="modal"></a>

                                    @endif
                                    <div class="carousel-caption">
                                        <h1>{{ $media->name }}</h1>
                                        <h4>@if( $media->content != '' ) {{ $media->content }} @endif</h4>
                                        @if( strlen($media->target) > 0 ) <h4><a href="{{ $media->target }}" target="_blank">En savoir plus &gt;</a></h4>@endif
                                    </div>
                                </div>
                                <?php $itemIndex++; ?>
                            @endforeach

                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel_location" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel_location" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                @endif
            @endif


            <!-- Modal HTML -->
            <?php $itemIndex=0; ?>
            @foreach( $medias->where('gslider', 1) as $media)
                <div id="homeModal{{ $itemIndex }}" class="modal fade">
                    <div class="modal-dialog video-carousel-modal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="video-modal-body">

                                @if (App\Helpers\Formatter::getVideoType($media->slug) == 'youtube')
                                    <iframe class="video-modal-frame" src="{{ App\Helpers\Formatter::getYoutubeEmbed($media->slug) }}" allowfullscreen="" frameborder="0"></iframe>
                                @elseif (App\Helpers\Formatter::getVideoType($media->slug) == 'vimeo')
                                    <iframe class="video-modal-frame" src="{{ App\Helpers\Formatter::getVimeoEmbed($media->slug) }}" allowfullscreen="" frameborder="0"></iframe>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            <?php $itemIndex++; ?>
        @endforeach

        <!--  Map -->
            <div class="tab-container style1" id="hotel-main-content">
                <ul class="tabs">
                    <li class="active"><a data-toggle="tab" href="#map-tab">Carte</a></li>

                    @if (method_exists($location, 'hasDetails') && $location->hasDetails())
                        <li><a data-toggle="tab" href="#details-tab">Détails</a></li>
                    @endif
                    @if (isset($medias) && $medias->where('gslider', null)->count() > 0 )
                        <?php $have_medias = true; ?>
                        <li><a data-toggle="tab" href="#medias-photo-tab">Photos</a></li>
                    @endif
                    @if (isset($activities) &&  $activities->where('type_id', 1)->count() > 0)
                        <li><a data-toggle="tab" href="#tourisme-tab">Tourisme</a></li>
                    @endif
                    @if (isset($activities) &&  $activities->where('type_id', 2)->count() > 0)
                        <li><a data-toggle="tab" href="#affaire-tab">Affaire</a></li>
                    @endif
                    @if (isset($activities) &&  $activities->where('type_id', 3)->count() > 0)
                        <li><a data-toggle="tab" href="#local-tab">Local</a></li>
                    @endif
                    @if (isset($activities) &&  $activities->where('type_id', 4)->count() > 0)
                        <li><a data-toggle="tab" href="#primetime-tab">Prime Time</a></li>
                    @endif
                    @if (isset($activities) &&  $activities->where('type_id', 5)->count() > 0)
                        <li><a data-toggle="tab" href="#videos-tab">Web TV</a></li>
                    @endif
                    @if (isset($activities) &&  $activities->where('type_id', 6)->count() > 0)
                        <li><a data-toggle="tab" href="#photos-tab">Photos</a></li>
                    @endif
                    @if (isset($activities) &&  $activities->where('type_id', 7)->count() > 0)
                        <li><a data-toggle="tab" href="#forfaits-tab">Certificats Cadeaux Québec</a></li>
                    @endif
                    @if (isset($activities) &&  $activities->where('type_id', 8)->count() > 0)
                        <li><a data-toggle="tab" href="#produits-tab">Marketplace</a></li>
                    @endif
                    @if (isset($activities) &&  $activities->where('type_id', 9)->count() > 0)
                        <li><a data-toggle="tab" href="#plus-tab">Book Direct</a></li>
                    @endif
                    @if(isset($mainCity) && count_of($mainCity) > 0)
                        <li><a data-toggle="tab" href="#city">Principales villes</a></li>
                    @endif
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

                    <!-- Carte -->
                    <div id="map-tab" class="tab-pane fade in active">
                        {{-- <iframe class="carte" src="https://maps.google.com/maps?q={{isset($hierarchie) ? Formatter::mapFromSlug($hierarchie) : ''}}&amp;num=1&amp;ie=UTF8&amp;t=m&amp;output=embed"></iframe> --}}

                        <iframe class="carte"
                                src="https://maps.google.com/maps?q={{ $location->name }}{{ (isset($location->country) && $location->country->name != $location->name) ? ','.$location->country->name : '' }}&amp;num=1&amp;ie=UTF8&amp;t=m&amp;output=embed"></iframe>
                    </div>

                    <!-- Principales villes -->
                    @if(isset($mainCity) && count_of($mainCity) > 0)
                        <div id="city" class="tab-pane">
                            <table class="table table-striped">
                                <tr>
                                    <th>Ville</th>
                                    <th>Population</th>
                                </tr>
                                @foreach($mainCity->take(10) as $city)
                                    <tr>
                                        <td>{{$city->name}}</td>
                                        <td>{{ number_format($city->population, 0, '', ' ') }} habitants</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif

                <!-- Pages -->
                    @if(isset($pages))
                        @foreach($pages as $key => $page)
                            <div id="page{{$key}}-tab" class="tab-pane">
                                {!!$page->content!!}
                            </div>
                        @endforeach
                    @endif

                <!-- Medias -->
                    @if( isset($have_medias) )
                        <div id="medias-photo-tab" class="tab-pane">
                            <?php $last_gallery_id = 0; ?>
                            @foreach( $medias as $i => $media)
                                @if( !$media->gslider )
                                    <?php
                                    $author = !empty($media->content) ? '<br>' . $media->content : '';
                                    ?>
                                    @if( $media->gid != $last_gallery_id )
                                        <?php
                                        $last_gallery_id = $media->gid;
                                        ?>
                                        <div class="media">

                                            {{-- http://ashleydw.github.io/lightbox/ --}}
                                            <a data-toggle="lightbox" data-gallery="gallery-{{ $media->gname }}"
                                               data-type="image" class="hover-effect"
                                               data-title="{{ $media->name . $author }}" href="#"
                                               data-remote="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/'. $media->slug) !!}"><img
                                                        class="img-fluid" alt="{{ $media->name }}"
                                                        src="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) !!}"
                                                        alt="{{ $media->name }}"
                                                        title="{{ $media->name }} - {{ strtoupper($location->name) }}"></a>

                                            <div class="caption">
                                                <h5 class="title">{{ $media->gname }}</h5>
                                            </div>

                                        </div>
                                    @else
                                        {{-- Les autres photos de la même galerie photos --}}
                                        <a style="display: none;" data-title="{{ $media->name . $author }}"
                                           data-toggle="lightbox" data-gallery="gallery-{{ $media->gname }}"
                                           data-type="image"
                                           data-remote="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/'. $media->slug) !!}"><img
                                                    class="img-fluid" alt="{{ $media->name }}"
                                                    src="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) !!}"
                                                    alt="{{ $media->name }}"
                                                    title="{{ $media->name }} - {{ strtoupper($location->name) }}"></a>
                                    @endif
                                @endif
                            @endforeach
                            <br><br>
                        </div>
                    @endif

                <!-- Coordonnées -->
                    @if (isset($coordinate) && count_of($coordinate) > 0)
                        <div id="coordonnees" class="tab-pane">
                            <address>
                                <strong>Point d'informations</strong><br>
                                @if (isset($coordinate->adresse))
                                    {{$coordinate->adresse}}<br>
                                @endif
                                @if (isset($coordinate->code_postal))
                                    {{$coordinate->code_postal}}
                                @endif
                                @if (isset($coordinate->location->name))
                                    {{$coordinate->location->name}}
                                @endif
                                <br><br>
                                @if (isset($coordinate->tel))
                                    <abbr title="Téléphone">Tel :</abbr> {{$coordinate->tel}}<br>
                                @endif
                                @if (isset($coordinate->fax))
                                    <abbr title="Télécopieur">Fax :</abbr> {{$coordinate->fax}}<br>
                                @endif
                                @if (isset($coordinate->mail))
                                    <abbr title="Adresse email">Mail :</abbr> {{$coordinate->mail}}<br>
                                @endif
                                @if (isset($coordinate->website))
                                    <abbr title="Site web">Web :</abbr> <a href="{{$coordinate->website}}"
                                                                           target="blank">{{$coordinate->website}}</a>
                                    <br>
                                @endif
                            </address>
                        </div>
                    @endif

                <!-- Tourisme -->
                    @if (isset($activities) && $activities->where('type_id', 1)->count() > 0)
                        <div id="tourisme-tab" class="tab-pane">
                            <table class='table table-striped'>
                                <tr>
                                    <th>Activité</th>
                                    <th></th>
                                    <th>Entreprise</th>
                                </tr>
                                    @foreach($activities->where('type_id', 1)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->name);
                                        })->all() as $activity)

                                        <?php $itemIndex = 0; ?>
                                        @foreach( $activity->companies()->whereRaw('prime_time = 1 AND (is_deactivated IS NULL OR is_deactivated = 0)')->locationId($location->id)->get() as $company )
                                            <?php $itemIndex++; ?>

                                            @if( $itemIndex == 1 )
                                                <tr>
                                                    <td>
                                                        <strong>{{$activity->name}}</strong><br>{{$activity->category_name}}</strong>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            @endif

                                            <tr>
                                                <td></td>
                                                <td>{{ $company->location->country->name }}
                                                    -> {{ $company->location->head ? $company->location->head->name.' ->' : '' }}
                                                    <a href="/{{ trans('front.locale_url') }}location/{{ \App\Models\Location::createSlug($company->location) }}">{{ $company->location->name }}</a>
                                                </td>
                                                <td><a href="{{ $company->coordinate->website }}"
                                                       target="_blank">{{ $company->name }}</a></td>
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


                                    @endforeach
                            </table>
                        </div>
                    @endif

                <!-- Affaire -->
                    @if (isset($activities) && $activities->where('type_id', 2)->count() > 0)
                        <div id="affaire-tab" class="tab-pane">
                            <table class='table table-striped'>
                                <tr>
                                    <th>Activité</th>
                                    <th></th>
                                    <th>Entreprise</th>
                                </tr>
                                    @foreach($activities->where('type_id', 2)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->name);
                                        })->all() as $activity)

                                        <?php $itemIndex = 0; ?>
                                        @foreach( $activity->companies()->whereRaw('prime_time = 1 AND (is_deactivated IS NULL OR is_deactivated = 0)')->locationId($location->id)->get() as $company )
                                            <?php $itemIndex++; ?>

                                            @if( $itemIndex == 1 )
                                                <tr>
                                                    <td>
                                                        <strong>{{$activity->name}}</strong><br>{{$activity->category_name}}</strong>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            @endif

                                            <tr>
                                                <td></td>
                                                <td>{{ $company->location->country->name }}
                                                    -> {{ $company->location->head ? $company->location->head->name.' ->' : '' }}
                                                    <a href="/{{ trans('front.locale_url') }}location/{{ \App\Models\Location::createSlug($company->location) }}">{{ $company->location->name }}</a>
                                                </td>
                                                <td><a href="{{ $company->coordinate->website }}"
                                                       target="_blank">{{ $company->name }}</a></td>
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


                                    @endforeach
                            </table>
                        </div>
                    @endif

                            <!-- Local -->
                                                @if (isset($activities) && $activities->where('type_id', 3)->count() > 0)
                                                    <div id="local-tab" class="tab-pane">
                                                        <table class='table table-striped'>
                                                            <tr>
                                                                <th>Activité</th>
                                                                <th></th>
                                                                <th>Entreprise</th>
                                                            </tr>
                                                            @foreach($activities->where('type_id', 3)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->name);
                                        })->all() as $activity)

                                                                <?php $itemIndex = 0; ?>
                                                                @foreach( $activity->companies()->whereRaw('prime_time = 1 AND (is_deactivated IS NULL OR is_deactivated = 0)')->locationId($location->id)->get() as $company )
                                                                    <?php $itemIndex++; ?>

                                                                    @if( $itemIndex == 1 )
                                                                        <tr>
                                                                            <td>
                                                                                <strong>{{$activity->name}}</strong><br>{{$activity->category_name}}</strong>
                                                                            </td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    @endif

                                                                    <tr>
                                                                        <td></td>
                                                                        <td>{{ $company->location->country->name }}
                                                                            -> {{ $company->location->head ? $company->location->head->name.' ->' : '' }}
                                                                            <a href="/{{ trans('front.locale_url') }}location/{{ \App\Models\Location::createSlug($company->location) }}">{{ $company->location->name }}</a>
                                                                        </td>
                                                                        <td><a href="{{ $company->coordinate->website }}"
                                                                               target="_blank">{{ $company->name }}</a></td>
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


                                                            @endforeach
                                                        </table>
                                                    </div>
                                                    @endif

                                                            <!-- Prime Time -->
                                                    @if (isset($activities) && $activities->where('type_id', 4)->count() > 0)
                                                        <div id="primetime-tab" class="tab-pane">
                                                            <table class='table table-striped'>
                                                                <tr>
                                                                    <th>Activité</th>
                                                                    <th></th>
                                                                    <th>Entreprise</th>
                                                                </tr>
                                                                @foreach($activities->where('type_id', 4)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->name);
                                        })->all() as $activity)

                                                                    <?php $itemIndex = 0; ?>
                                                                    @foreach( $activity->companies()->whereRaw('prime_time = 1 AND (is_deactivated IS NULL OR is_deactivated = 0)')->locationId($location->id)->get() as $company )
                                                                        <?php $itemIndex++; ?>

                                                                        @if( $itemIndex == 1 )
                                                                            <tr>
                                                                                <td>
                                                                                    <strong>{{$activity->name}}</strong><br>{{$activity->category_name}}</strong>
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        @endif

                                                                        <tr>
                                                                            <td></td>
                                                                            <td>{{ $company->location->country->name }}
                                                                                -> {{ $company->location->head ? $company->location->head->name.' ->' : '' }}
                                                                                <a href="/{{ trans('front.locale_url') }}location/{{ \App\Models\Location::createSlug($company->location) }}">{{ $company->location->name }}</a>
                                                                            </td>
                                                                            <td><a href="{{ $company->coordinate->website }}"
                                                                                   target="_blank">{{ $company->name }}</a></td>
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


                                                                @endforeach
                                                            </table>
                                                        </div>
                                                        @endif

                                                                <!-- Vidéos -->
                                                        @if (isset($activities) && $activities->where('type_id', 5)->count() > 0)
                                                            <div id="videos-tab" class="tab-pane">
                                                                <table class='table table-striped'>
                                                                    <tr>
                                                                        <th>Activité</th>
                                                                        <th></th>
                                                                        <th>Entreprise</th>
                                                                    </tr>
                                                                    @foreach($activities->where('type_id', 5)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->name);
                                        })->all() as $activity)

                                                                        <?php $itemIndex = 0; ?>
                                                                        @foreach( $activity->companies()->whereRaw('prime_time = 1 AND (is_deactivated IS NULL OR is_deactivated = 0)')->locationId($location->id)->get() as $company )
                                                                            <?php $itemIndex++; ?>

                                                                            @if( $itemIndex == 1 )
                                                                                <tr>
                                                                                    <td>
                                                                                        <strong>{{$activity->name}}</strong><br>{{$activity->category_name}}</strong>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                </tr>
                                                                            @endif

                                                                            <tr>
                                                                                <td></td>
                                                                                <td>{{ $company->location->country->name }}
                                                                                    -> {{ $company->location->head ? $company->location->head->name.' ->' : '' }}
                                                                                    <a href="/{{ trans('front.locale_url') }}location/{{ \App\Models\Location::createSlug($company->location) }}">{{ $company->location->name }}</a>
                                                                                </td>
                                                                                <td><a href="{{ $company->coordinate->website }}"
                                                                                       target="_blank">{{ $company->name }}</a></td>
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


                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                            @endif

                                                                    <!-- Photos -->
                                                            @if (isset($activities) && $activities->where('type_id', 6)->count() > 0)
                                                                <div id="photos-tab" class="tab-pane">
                                                                    <table class='table table-striped'>
                                                                        <tr>
                                                                            <th>Activité</th>
                                                                            <th></th>
                                                                            <th>Entreprise</th>
                                                                        </tr>
                                                                        @foreach($activities->where('type_id', 6)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->name);
                                        })->all() as $activity)

                                                                            <?php $itemIndex = 0; ?>
                                                                            @foreach( $activity->companies()->whereRaw('prime_time = 1 AND (is_deactivated IS NULL OR is_deactivated = 0)')->locationId($location->id)->get() as $company )
                                                                                <?php $itemIndex++; ?>

                                                                                @if( $itemIndex == 1 )
                                                                                    <tr>
                                                                                        <td>
                                                                                            <strong>{{$activity->name}}</strong><br>{{$activity->category_name}}</strong>
                                                                                        </td>
                                                                                        <td></td>
                                                                                        <td></td>
                                                                                    </tr>
                                                                                @endif

                                                                                <tr>
                                                                                    <td></td>
                                                                                    <td>{{ $company->location->country->name }}
                                                                                        -> {{ $company->location->head ? $company->location->head->name.' ->' : '' }}
                                                                                        <a href="/{{ trans('front.locale_url') }}location/{{ \App\Models\Location::createSlug($company->location) }}">{{ $company->location->name }}</a>
                                                                                    </td>
                                                                                    <td><a href="{{ $company->coordinate->website }}"
                                                                                           target="_blank">{{ $company->name }}</a></td>
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


                                                                        @endforeach
                                                                    </table>
                                                                </div>
                                                                @endif

                                                                        <!-- Forfaits -->
                                                                @if (isset($activities) && $activities->where('type_id', 7)->count() > 0)
                                                                    <div id="forfaits-tab" class="tab-pane">
                                                                        <table class='table table-striped'>
                                                                            <tr>
                                                                                <th>Activité</th>
                                                                                <th></th>
                                                                                <th>Entreprise</th>
                                                                            </tr>
                                                                            @foreach($activities->where('type_id', 7)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->name);
                                        })->all() as $activity)

                                                                                <?php $itemIndex = 0; ?>
                                                                                @foreach( $activity->companies()->whereRaw('prime_time = 1 AND (is_deactivated IS NULL OR is_deactivated = 0)')->locationId($location->id)->get() as $company )
                                                                                    <?php $itemIndex++; ?>

                                                                                    @if( $itemIndex == 1 )
                                                                                        <tr>
                                                                                            <td>
                                                                                                <strong>{{$activity->name}}</strong><br>{{$activity->category_name}}</strong>
                                                                                            </td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    @endif

                                                                                    <tr>
                                                                                        <td></td>
                                                                                        <td>{{ $company->location->country->name }}
                                                                                            -> {{ $company->location->head ? $company->location->head->name.' ->' : '' }}
                                                                                            <a href="/{{ trans('front.locale_url') }}location/{{ \App\Models\Location::createSlug($company->location) }}">{{ $company->location->name }}</a>
                                                                                        </td>
                                                                                        <td><a href="{{ $company->coordinate->website }}"
                                                                                               target="_blank">{{ $company->name }}</a></td>
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


                                                                            @endforeach
                                                                        </table>
                                                                    </div>
                                                                    @endif

                                                                            <!-- Marketplace -->
                                                                    @if (isset($activities) && $activities->where('type_id', 8)->count() > 0)
                                                                        <div id="produits-tab" class="tab-pane">
                                                                            <table class='table table-striped'>
                                                                                <tr>
                                                                                    <th>Activité</th>
                                                                                    <th></th>
                                                                                    <th>Entreprise</th>
                                                                                </tr>
                                                                                @foreach($activities->where('type_id', 8)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->name);
                                        })->all() as $activity)

                                                                                    <?php $itemIndex = 0; ?>
                                                                                    @foreach( $activity->companies()->whereRaw('prime_time = 1 AND (is_deactivated IS NULL OR is_deactivated = 0)')->locationId($location->id)->get() as $company )
                                                                                        <?php $itemIndex++; ?>

                                                                                        @if( $itemIndex == 1 )
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <strong>{{$activity->name}}</strong><br>{{$activity->category_name}}</strong>
                                                                                                </td>
                                                                                                <td></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        @endif

                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td>{{ $company->location->country->name }}
                                                                                                -> {{ $company->location->head ? $company->location->head->name.' ->' : '' }}
                                                                                                <a href="/{{ trans('front.locale_url') }}location/{{ \App\Models\Location::createSlug($company->location) }}">{{ $company->location->name }}</a>
                                                                                            </td>
                                                                                            <td><a href="{{ $company->coordinate->website }}"
                                                                                                   target="_blank">{{ $company->name }}</a></td>
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


                                                                                @endforeach
                                                                            </table>
                                                                        </div>
                                                                        @endif

                                                                                <!-- Book Direct -->
                                                                        @if (isset($activities) && $activities->where('type_id', 9)->count() > 0)
                                                                            <div id="plus-tab" class="tab-pane">
                                                                                <table class='table table-striped'>
                                                                                    <tr>
                                                                                        <th>Activité</th>
                                                                                        <th></th>
                                                                                        <th>Entreprise</th>
                                                                                    </tr>
                                                                                    @foreach($activities->where('type_id', 9)->sortBy(function($adm){
                                            return \App\Helpers\Utils::ht_translit($adm->name);
                                        })->all() as $activity)

                                                                                        <?php $itemIndex = 0; ?>
                                                                                        @foreach( $activity->companies()->whereRaw('prime_time = 1 AND (is_deactivated IS NULL OR is_deactivated = 0)')->locationId($location->id)->get() as $company )
                                                                                            <?php $itemIndex++; ?>

                                                                                            @if( $itemIndex == 1 )
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <strong>{{$activity->name}}</strong><br>{{$activity->category_name}}</strong>
                                                                                                    </td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                </tr>
                                                                                            @endif

                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td>{{ $company->location->country->name }}
                                                                                                    -> {{ $company->location->head ? $company->location->head->name.' ->' : '' }}
                                                                                                    <a href="/{{ trans('front.locale_url') }}location/{{ \App\Models\Location::createSlug($company->location) }}">{{ $company->location->name }}</a>
                                                                                                </td>
                                                                                                <td><a href="{{ $company->coordinate->website }}"
                                                                                                       target="_blank">{{ $company->name }}</a></td>
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


                                                                                    @endforeach
                                                                                </table>
                                                                            </div>
                                                                            @endif




                <!-- Présentation -->
                    @if (method_exists($location, 'hasDetails') && $location->hasDetails())
                        <div id="details-tab" class="tab-pane">
                            <h2>Présentation</h2>
                            <table class='table table-striped'>
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
                                        <td>{{round($location->population / $location->superficie, 2)}}
                                            habitants/km*km
                                        </td>
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
                                        <th>Fondé le</th>
                                        <td>{{formatter::convertdate($location->fondation)}}</td>
                                    </tr>
                                @endif
                                @if (isset($location->drapeau))
                                    <tr>
                                        <th>Blason</th>
                                        <Td>{!! html::decode(Html::link($location->drapeau, html::image($location->drapeau, $location->name, ['class' => 'drapeAu']), ['title' => 'cliquez pour agrandir', 'target' => '_blank'])) !!}</td>
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

                            @if (isset($location->description) && strlen(trim($location->description))> 0)
                                <h2>Plus d'informations</h2>
                                {!! $location->description !!}
                            @endif
                        </div>
                    @endif
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

                                                        @if (App\Helpers\Formatter::getVideoType($media->slug) == 'youtube')
                                                            <iframe class="carousel-video" src="{{ App\Helpers\Formatter::getYoutubeEmbed($media->slug) }}" allowfullscreen="" width="100%" height="100%" frameborder="0"></iframe>
                                                        @elseif (App\Helpers\Formatter::getVideoType($media->slug) == 'vimeo')
                                                            <img src="{{ App\Helpers\Formatter::getVimeoMiniature($media->slug, 'large') }}">
                                                        <!--<iframe class="carousel-video" src="{{ App\Helpers\Formatter::getVimeoEmbed($media->slug) }}" allowfullscreen="" width="100%" height="100%" frameborder="0"></iframe>-->
                                                        @endif

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
                                                                        @if (App\Helpers\Formatter::getVideoType($media->slug) == 'youtube')
                                                                            <iframe class="video-modal-frame" src="{{ App\Helpers\Formatter::getYoutubeEmbed($media->slug) }}" allowfullscreen="" frameborder="0"></iframe>
                                                                        @elseif (App\Helpers\Formatter::getVideoType($media->slug) == 'vimeo')
                                                                            <iframe class="video-modal-frame" src="{{ App\Helpers\Formatter::getVimeoEmbed($media->slug) }}" allowfullscreen="" frameborder="0"></iframe>
                                                                        @endif
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


            <!-- Destinations populaires -->
            @if( isset($mainDestination) && count_of($mainDestination) > 0 && count_of($fils) > 5 )
                <h2>Destinations populaires</h2>
                <div class="widget detailed-popular-locations">
                    @foreach( $mainDestination as $Destination)
                        <a class="custom-block"
                           href="{!! \Request::url(); !!}/{{ $Destination->slug}}">{{ $Destination->name }}</a>
                    @endforeach
                </div>
            @endif

            @if (count_of($fils) > 0)
                <article class="detailed-logo">
                    <h2>{{ strcmp($type, "Pays") == 0 ? $type : ($type."s") }}</h2>
                    <ul class="grow">
                        @foreach($fils as $destination)
                            <li><a class="custom-block"
                                   href="{!! \Request::url(); !!}/{{$destination->slug}}">{{$destination->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </article>
            @else
            @endif

        </div>

    </div>

@stop
@section('js')

    {{ Html::script('js/front/stroll.js') }}

    <script>
        //stroll.bind( '.grow' );
    </script>

    <style type="text/css">
        .carousel .item {
            /*height: 380px !important;*/
        }
    </style>
@stop
