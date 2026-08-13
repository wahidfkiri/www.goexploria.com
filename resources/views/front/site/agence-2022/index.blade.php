@include("front.gallery")
@extends('layouts.front.site.' . $theme . '.master-with-breadcrumb')

{{-- @section('title', isset($company->name) ? ucfirst(Formatter::remove_accents($company->name)) : "Site")--}}

{{-- @section('breadcrumb-title')
    {{ strtoupper(Formatter::remove_accents($company->name)) }}
@stop--}}

@section('breadcrumb')
    {{-- {!! Breadcrumbs::render('front.site', $company) !!} --}}
@stop

@section('main-content')
    @if( isset($medias) )
        @if( $medias->where('gslider', 1)->count() > 0 )
            <div style="max-width:1920px;margin:auto;">
                <div id="carousel_index" class="carousel slide" data-ride="carousel" style="max-height:{{ $company->slideshow_height }}px!important;">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @for ($i = 0; $i < $medias->where('gslider', 1)->count(); $i++)
                            <li data-target="#carousel_index" data-slide-to="{{ $i }}"
                                class="@if ($i === 0) active @endif"></li>
                        @endfor
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
              <?php $itemIndex = 0; ?>
                        @foreach( $medias->where('gslider', 1) as $media)

                            <div class="item @if ($itemIndex === 0) active @endif" style="height:{{ $company->slideshow_height }}px!important;">
                                @if ($media->target != '')
                                    <a target="_blank" href="{{ $media->target }}">
                                @endif
                                @if ($media->photo)
                                    <img alt="{{ $media->name }}"
                                         title="{{ $media->name }} - {{ strtoupper($company->name) }}"
                                         src="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) !!}"
                                         alt="{{ $media->id }}" style="max-height:{{ $company->slideshow_height }}px!important;">
                                    @if ($media->target != '')</a>@endif
                                @else
                                    <!--<iframe class="carousel-video"
                                            src="{{ App\Helpers\Formatter::getYoutubeEmbed($media->slug) }}"
                                            allowfullscreen="" width="100%" height="100%" frameborder="0"></iframe>-->


                                        @if (App\Helpers\Formatter::getVideoType($media->slug) == 'youtube')
                                            <iframe class="carousel-video" src="{{ App\Helpers\Formatter::getYoutubeEmbed($media->slug) }}" allowfullscreen="" width="100%" height="100%" frameborder="0"></iframe>
                                        @elseif (App\Helpers\Formatter::getVideoType($media->slug) == 'vimeo')
                                            <img src="{{ App\Helpers\Formatter::getVimeoMiniature($media->slug, 'large') }}">
                                        <!--<iframe class="carousel-video" src="{{ App\Helpers\Formatter::getVimeoEmbed($media->slug) }}" allowfullscreen="" width="100%" height="100%" frameborder="0"></iframe>-->
                                        @endif

                                        <!-- Button HTML (to Trigger Modal) -->
                                        <a href="#homeModal{{ $itemIndex }}" class="video-carousel-modal-btn"
                                           data-toggle="modal"
                                           style="
                                            min-width: 100%;
                                            min-height: 100%;
                                            height: 100%;
                                            width: 100%;
                                            display: block;
                                            position: absolute;
                                            left: 0;
                                            top: 0;
                                            background: transparent;
                                            "
                                        ></a>
                                @endif
                                @if ($media->photo)
                                    <div class="carousel-caption">
                                        <h1>{{ $media->name }}</h1>
                                        <h4>@if( $media->content != '' ) {{ $media->content }}
                                            @endif
                                        </h4>
                                        @if( $media->target != '' )
                                            <h4>
                                                <a href="{{ $media->target }}" target="_blank"> En savoir plus </a>
                                            </h4>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <?php $itemIndex ++; ?>
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel_index" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel_index" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        @endif
    @endif


    <!-- Modal HTML -->
    <?php $itemIndex = 0; ?>
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
        <?php $itemIndex ++; ?>
    @endforeach

    <div class="container">
        <div class="row">

            <div id="main" class="col-md-12">

                <div class="" id="main-content">

                    {!! $company->home_content !!}




                    @if ($company->config_show_commands == 'true')
                        @if (!empty($products))
                            <style>
                                #products-tab .info-table {
                                    margin: 0 auto 24px;
                                }
                                #products-tab .info-table td {
                                    padding: 0 4px 12px;
                                }
                                #products-tab .invoice-table tr:nth-child(even) {
                                    background-color: rgba(0,0,0,0.1);
                                }
                                #products-tab .invoice-table th,
                                #products-tab .invoice-table td {
                                    width: 15%;
                                    padding: 6px 4px 6px;
                                }
                                #products-tab .invoice-table td + td {
                                    width: 40%;
                                }
                                #products-tab .invoice-table td + td + td {
                                    width: 15%;
                                }
                                #products-tab .invoice-table td + td + td + td {
                                    width: 15%;
                                }
                                #products-tab .invoice-table td + td + td + td + td {
                                    width: 15%;
                                }

                                body .amazonmenu > ul {
                                    @if (!empty($company->config_menu_back_color))
                                        background-color:{{ $company->config_menu_back_color }};
                                    @endif
                                }

                                body .amazonmenu > ul li a::before {
                                    @if (!empty($company->config_menu_link_color))
                                    color:{{ $company->config_menu_link_color }};
                                    @endif
                                }

                                body .amazonmenu > ul li a::after {
                                    @if (!empty($company->config_menu_link_hover_color))
                                        background:{{ $company->config_menu_link_hover_color }};
                                    @endif
                                }
                            </style>
                            <div id="products-tab" class="tab-pane">
                                <form method="post" action="{{ route('front.company.print', [ $company->id, $company->slug ]) }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    @if (!empty(trim($company->achats_marche_a_suivre)))
                                        <div>
                                            <div style="font-size: 16px;">
                                                <p><strong>Marche à suivre :</strong></p>
                                                {!! $company->achats_marche_a_suivre !!}
                                            </div>
                                        </div>
                                    @endif
                                    <table class="info-table">
                                        <tr>
                                            <td style="text-align: right"><strong>Nom complet : </strong></td>
                                            <td><input type="text" name="user[name]" value=""></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right"><strong>Compagnie : </strong></td>
                                            <td><input type="text" name="user[company]" value=""></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right"><strong>Adresse : </strong></td>
                                            <td><input type="text" name="user[address]" value=""></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right"><strong>Ville : </strong></td>
                                            <td><input type="text" name="user[city]" value=""></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right"><strong>Code postal : </strong></td>
                                            <td><input type="text" name="user[postalcode]" value=""></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right"><strong>Téléphone : </strong></td>
                                            <td><input type="text" name="user[phone]" value=""></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right"><strong>Courriel : </strong></td>
                                            <td><input type="text" name="user[email]" value=""></td>
                                        </tr>
                                    </table>
                                    <table class="invoice-table">
                                        <tr>
                                            <th>Photo</th>
                                            <th>Description</th>
                                            <th>Prix unitaire</th>
                                            <th>Quantité</th>
                                            <th>Coût</th>
                                        </tr>
                                        @foreach ($products as $keyProduct => $product)
                                            <tr>
                                                <td>
                                                    @if (!empty($product['image']))
                                                        @if (!empty($product['url']))
                                                            <a href="{{ $product['url'] }}" target="_blank" style="width: auto; max-height: 100px; max-width: 100px;" data-type="image" class="hover-effect">
                                                                <img class="img-fluid" alt="{{ $product['name'] }}" src="{!! URL::asset('uploads/achats/' . $product['image']) !!}" title="{{ $product['name'] }}">
                                                            </a>
                                                        @else
                                                            <a data-toggle="lightbox" style="width: auto; max-height: 100px; max-width: 100px;" data-type="image" class="hover-effect" data-title="{{ $product['name'] }}" href="#" data-remote="{!! URL::asset('uploads/achats/' . $product['image']) !!}">
                                                                <img class="img-fluid" alt="{{ $product['name'] }}" src="{!! URL::asset('uploads/achats/' . $product['image']) !!}" title="{{ $product['name'] }}">
                                                            </a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $product['name'] }}<input type="hidden" name="product[{{ $keyProduct }}][name]" value="{{ $product['name'] }}"></td>
                                                <td><span class="product-single-price" data-single="{{ $product['price'] }}">{{ number_format($product['price'], 2) }}</span>$</td>
                                                <td><input type="number" value="0" min="0" name="product[{{ $keyProduct }}][qty]"></td>
                                                <td style="text-align: right;"><span class="product-total-price" data-total="0">0.00</span>$</td>
                                            </tr>
                                        @endforeach
                                        @if (!empty($company->achats_frais_transport))
                                            <tr>
                                                <td colspan="4" style="text-align: right; font-weight: bold;">FRAIS DE TRANSPORT</td>
                                                <td style="text-align: right;"><span class="product-transport" data-transport="{{ $company->achats_frais_transport }}">{{ number_format(round($company->achats_frais_transport, 2), 2) }}</span>$</td>
                                            </tr>
                                        @endif
                                        @if (!empty($company->achats_frais_admin))
                                            <tr>
                                                <td colspan="4" style="text-align: right; font-weight: bold;">FRAIS D'ADMINISTRATION</td>
                                                <td style="text-align: right;"><span class="product-admin" data-admin="{{ $company->achats_frais_admin }}">{{ number_format(round($company->achats_frais_admin, 2), 2) }}</span>$</td>
                                            </tr>
                                        @endif
                                        @if (!empty($company->achats_reduction))
                                            <tr>
                                                <td colspan="4" style="text-align: right; font-weight: bold;">RÉDUCTION ({{ $company->achats_reduction }}%)</td>
                                                <td style="text-align: right;"><span class="product-rebate" data-reduction="{{ $company->achats_reduction }}">0.00</span>$</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td colspan="4" style="text-align: right; font-weight: bold;">SOUS-TOTAL</td>
                                            <td style="text-align: right;"><span class="product-subtotal">0.00</span>$</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align: right; font-weight: bold;">TPS 5,0%</td>
                                            <td style="text-align: right;"><span class="product-tps">0.00</span>$</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align: right; font-weight: bold;">TVQ 9,975%</td>
                                            <td style="text-align: right;"><span class="product-tvq">0.00</span>$</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align: right; font-weight: bold;">TOTAL</td>
                                            <td style="text-align: right;"><span class="product-total">0.00</span>$</td>
                                        </tr>
                                    </table>
                                    <!-- Versements -->
                                    @if($company->versements)
                                        <table id="company_versements" data-versements="{{ $company->versements }}">
                                            @for($ctr = 0; $ctr < (int)$company->versements; $ctr++)
                                                <tr>
                                                    <td style="text-align: right"><strong>Versement #{{ $ctr+1 }} : </strong></td>
                                                    <td><input type="text" id="payment_price_{{ $ctr }}" name="user[payment][{{ $ctr }}][price]" value="" disabled="disabled"></td>
                                                    <td style="text-align: right"><strong>Date du paiement : </strong></td>
                                                    <td><input type="date" name="user[payment][{{ $ctr }}][date]"
                                                               value="<?php echo date('Y-m-d'); ?>"
                                                               min="<?php echo date('Y-m-d'); ?>"></td>
                                                </tr>
                                            @endfor
                                        </table>
                                    @endif
                                    <div style="text-align: center; padding-top: 24px; font-size: 16px;">
                                        <p>{{ $company->achats_note }}</p>
                                        <input type="submit" name="submit" value="Obtenir la facture à transmettre par courriel" style="
                                        @if (!empty($company->config_menu_back_color))
                                            background-color:{{ $company->config_menu_back_color }};
                                        @else
                                            background-color: #ef7724;
                                        @endif

                                        @if (!empty($company->config_menu_link_color))
                                            color:{{ $company->config_menu_link_color }};
                                        @else
                                            color: #fff;
                                        @endif
                                        font-weight: bold;
                                        border: 0;
                                        padding: 10px 20px;">
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endif

                    <!-- Tourisme -->
                {{--@if (isset($activities) && $activities->where('type_id', 1)->count() > 0)
                        <div id="tourisme-tab" class="tab-pane">
                            <table class='table table-striped'>
                                <tr>
                                    <th>Activité</th>
                                    <th>Catégorie</th>
                                </tr>
                                @foreach($activities->where('type_id', 1)->sortBy('category_name')->all() as $activity)
                                    <tr>
                                        <td>{{$activity->name}}</td>
                                        <td>{{$activity->category_name}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif --}}
                <!-- Sliders -->



                <!-- <div id="index_newsletter">
        <h3>Infolettre</h3>
        <p>Inscrivez-vous à notre infolettre dès maintenant!</p>
{{-- {{ Form::open(array('route' => array('front.company.newsletter.subscribe.post', $company->id), 'method' => 'POST', 'id' => 'signupForm', 'class' => 'form-horizontal form-groups-bordered', 'autocomplete' => 'off')) }}
          {{ Form::text('name', null, ['class' => 'form-control', 'min'=>3, 'placeholder' => 'Votre nom...', 'id' => 'name']) }}
          {{ Form::text('mail', null, ['class' => 'form-control', 'min'=>6, 'placeholder' => 'Votre adresse courriel...', 'id' => 'mail']) }}
          <br>
          {!! Form::submit('S\'abonner à notre infolettre', array('class'=>'send-btn')) !!}
          {!! app('captcha')->render($lang = 'fr'); !!}
        {{ Form::close() }} --}}

                        </div>-->

                    <div class="clearfix"></div>

                    <!-- Medias -->
                    <div class="wrap-galerie">
                        @if ($company->gallery_home == 0)
                            @if (isset($medias) && $medias->where('gslider', null)->count() > 0 )
                                <h2 class="separator">Galeries</h2>
                                @yield('gallery')
                            @endif
                        @endif
                    </div>

                    <!-- Affaire -->
                    @if (isset($activities) && $activities->where('type_id', 2)->count() > 0)
                        <div id="affaire-tab" class="tab-pane">
                            <table class='table table-striped'>
                                <tr>
                                    <th>Activité</th>
                                    <th>Catégorie</th>
                                </tr>
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
            </div>
        </div>
    </div>
@stop
@section('js')

    <script type="text/javascript">
        jQuery(document).ready(function () {

            $('#signupForm').submit(function (e) {
                if ($(this).find('#email').val() == '') {
                    e.preventDefault();
                    alert('Erreur: veuillez entrer votre adresse courriel valide.');
                }
            });

        });
        jQuery(document).ready(function () {
            amazonmenu.init({
                menuid: 'demo'
            })
        })
        jQuery(document).ready(function () {
            amazonmenu.init({
                animateduration: 100,
                showhidedelay: [100, 100],
                hidemenuonclick: true
            });
        });
        jQuery(document).ready(function () {

            $('.center').slick({
                centerMode: true,
                centerPadding: '15px',
                slidesToShow: 6,
                autoplay: true,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 1
                        }
                    }
                ]
            });

        });

    </script>


    <style type="text/css">
        /*   address {
                color: #333;
                font-size: 1.2em;
            }

            .page_content_container {
                padding: 15px;
            }

            .btn-dark {
                background-color: #888 !important;
                color: #fff !important;
            }

            li .btn-dark:hover {
                background-color: #01b7f2 !important;
                color: #fff !important;
            }

            li.active .btn-dark {
                background-color: #01b7f2 !important;
                color: #fff !important;
            }

            #carousel_index .item img {
                min-width: 75%;
            }

            #medias-photo-tab .media img {
                max-height: 140px !important;
            } */

    </style>

@stop
