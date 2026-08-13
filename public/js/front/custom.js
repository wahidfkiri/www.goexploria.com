window.onload = function () {
    /*logout = document.querySelector("[data-target='#custom-logout']");*/
    logout = document.querySelectorAll("[href='#custom-logout']");
    panelControl = document.querySelectorAll("[href='#custom-panel']");
    for (i = 0; i < 2; i++) {
        if (logout[i] != undefined) {
            logout[i].addEventListener("click", function () {
                location.href = "auth/logout";
            });
        }
    }
    for (i = 0; i < 2; i++) {
        if (panelControl[i] != undefined) {
            panelControl[i].addEventListener("click", function () {
                location.href = "/admin";
            });
        }
    }
}

function closeOpenedMenus($elem, id) {
    var $bars = $elem.parents('.topnav').first().siblings('.menu-single-bar');

    $bars.each(function(e) {
        var $this = $(this);
        if (!$this.is(id)) {
            console.log($this);
            $this.slideUp(100);
        }
    });
}
focus();
var listener = window.addEventListener('blur', function() {
    if (document.activeElement === document.getElementById('iframe')) {
        console.log('in iframe');
    }
    window.removeEventListener('blur', listener);
});

$(document).ready(function () {

    $('.carousel-has-video .video-carousel-modal-btn').click(function() {
        $('.carousel').carousel('pause');
    });
    $('.carousel-has-video .video-carousel-modal .modal-content .modal-header .close').click(function() {
        $('.carousel').carousel('cycle');
    });
    $('.modal-backdrop').click(function() {
        $('.carousel').carousel('cycle');
    });


    // Barre de recherche
    $('#search-engine').searchEngine();

    $('#a_search').click(function (e) {
        e.preventDefault();
        closeOpenedMenus($(this), '#search-bar');
        $('#search-bar').slideToggle(200, function () {
            $(this).find('input').focus();
        });
    });

    $('.search-bar-close').click(function (e) {
        e.preventDefault();
        $('#search-bar').slideUp(100);
    });

    $('#a_tourisme').click(function (e) {
        e.preventDefault();
        closeOpenedMenus($(this), '#search-company-bar');
        $('#search-company-bar').slideToggle(200, function () {});
    });

    $('.search-company-bar-close').click(function (e) {
        e.preventDefault();
        $('#search-company-bar').slideUp(100);
    });

    $('#a_business').click(function (e) {
        e.preventDefault();
        closeOpenedMenus($(this), '#search-business-bar');
        $('#search-business-bar').slideToggle(200, function () {});
    });

    $('.search-business-bar-close').click(function (e) {
        e.preventDefault();
        $('#search-business-bar').slideUp(100);
    });

    $('#a_local').click(function (e) {
        e.preventDefault();
        closeOpenedMenus($(this), '#search-local-bar');
        $('#search-local-bar').slideToggle(200, function () {});
    });

    $('.search-local-bar-close').click(function (e) {
        e.preventDefault();
        $('#search-local-bar').slideUp(100);
    });

    $('#a_prime').click(function (e) {
        e.preventDefault();
        closeOpenedMenus($(this), '#search-prime-bar');
        $('#search-prime-bar').slideToggle(200, function () {});
    });

    $('.search-prime-bar-close').click(function (e) {
        e.preventDefault();
        $('#search-prime-bar').slideUp(100);
    });

    $('#a_videos').click(function (e) {
        e.preventDefault();
        closeOpenedMenus($(this), '#search-videos-bar');
        $('#search-videos-bar').slideToggle(200, function () {});
    });

    $('.search-videos-bar-close').click(function (e) {
        e.preventDefault();
        $('#search-videos-bar').slideUp(100);
    });

    $('#a_photos').click(function (e) {
        e.preventDefault();
        closeOpenedMenus($(this), '#search-photos-bar');
        $('#search-photos-bar').slideToggle(200, function () {});
    });

    $('.search-photos-bar-close').click(function (e) {
        e.preventDefault();
        $('#search-photos-bar').slideUp(100);
    });

    $('#a_forfaits').click(function (e) {
        e.preventDefault();
        closeOpenedMenus($(this), '#search-forfaits-bar');
        $('#search-forfaits-bar').slideToggle(200, function () {});
    });

    $('.search-forfaits-bar-close').click(function (e) {
        e.preventDefault();
        $('#search-forfaits-bar').slideUp(100);
    });

    $('#a_produits').click(function (e) {
        e.preventDefault();
        closeOpenedMenus($(this), '#search-produits-bar');
        $('#search-produits-bar').slideToggle(200, function () {});
    });

    $('.search-produits-bar-close').click(function (e) {
        e.preventDefault();
        $('#search-produits-bar').slideUp(100);
    });

    $('#a_plus').click(function (e) {
        e.preventDefault();
        closeOpenedMenus($(this), '#search-plus-bar');
        $('#search-plus-bar').slideToggle(200, function () {});
    });

    $('.search-plus-bar-close').click(function (e) {
        e.preventDefault();
        $('#search-plus-bar').slideUp(100);
    });

    $('a.list_item').click(function (e) {
        e.preventDefault();
        $('.sub').hide();
        $(this).parent().find('.sub').slideToggle(100);
    });

    /*
     $('.self-select').click(function(e){
     e.preventDefault();
     $(this).toggleClass('selected');
     });
     */

    var timShowLocationBar;
    var timHideLocationBar;
    var subnav_status = 'hidden';

    // Main menu

    // Subnav
    $('body').click(function () {
        clearTimeout(timShowLocationBar);
        timerHideLocationBar();
    });

    $('.subnav').on('mouseenter', function () {

        if (subnav_status == 'hidden' && $('.topnav').css('display') == 'block') {
            clearTimeout(timHideLocationBar);
            timerShowLocationBar();
        }
    });

    $('.subnav').on('mouseleave', function () {
        if ($('.topnav').css('display') == 'block') {
            clearTimeout(timShowLocationBar);
            timerHideLocationBar();
        }
    });

    $('.subnav .nav-item a').click(function (e) {
        if ($(this).attr("href") != '#') {
            $('.subnav .nav-item a').css('box-shadow', '0 150px rgba(0, 0, 0, 0.75) inset');
            $(this).css('box-shadow', '0 150px rgba(0, 0, 0, 0.2) inset');

            //hideLocationBar();
        } else {
            e.preventDefault();
            console.log($(this).attr('id'));
        }
    });

    $('.subnav #li-amerique').mouseover(function () {
        if ($('.subnav').offset().top > 0) {
            $(this).find('.nav-subitem').slideDown(50);
        }

    });

    $('.subnav #li-amerique').mouseleave(function () {
        //$(this).find('.nav-subitem').hide();
        $(this).find('.nav-subitem').slideUp(300);
    });

    /*

     <tr>
     <td colspan="3" style="text-align: right; font-weight: bold;">SOUS-TOTAL</td>
     <td><span class="product-subtotal">0.00</span>$</td>
     </tr>
     <tr>
     <td colspan="3" style="text-align: right; font-weight: bold;">TPS 5,0%</td>
     <td><span class="product-tps">0.00</span>$</td>
     </tr>
     <tr>
     <td colspan="3" style="text-align: right; font-weight: bold;">TVQ 9,975%</td>
     <td><span class="product-tvq">0.00</span>$</td>
     </tr>
     <tr>
     <td colspan="3" style="text-align: right; font-weight: bold;">TOTAL</td>
     <td><span class="product-total">0.00</span>$</td>
     </tr>
     */

    if ($('#products-tab').length > 0) {
        $('body').on('change', '#products-tab input[type="number"]', function () {
            var $this = $(this);

            var $singlePricing = $this.parents('tr').first().find('td .product-single-price').first();
            var $pricing = $this.parents('tr').first().find('td .product-total-price').first();

            var singlePrice = parseFloat($singlePricing.attr('data-single')) * 100;
            var qty = parseInt($this.val());

            var newPrice = singlePrice * qty;
            newPrice = newPrice / 100;
            $pricing.html(newPrice.toFixed(2));
            $pricing.attr('data-total', newPrice);

            var subtotalPrice = 0;
            var $parentTable = $this.parents('table').first();
            var allTotals = $parentTable.find('td .product-total-price');
            allTotals.each(function() {
                subtotalPrice += parseFloat($(this).attr('data-total'))* 100;
            });

            var transport = 0;
            if ($parentTable.find('td .product-transport').length > 0) {
                transport = parseFloat($parentTable.find('td .product-transport').first().attr('data-transport')) * 100;
            }
            subtotalPrice = parseFloat(subtotalPrice + transport);

            var admin = 0;
            if ($parentTable.find('td .product-admin').length > 0) {
                admin = parseFloat($parentTable.find('td .product-admin').first().attr('data-admin')) * 100;
            }
            subtotalPrice = parseFloat(subtotalPrice + admin);

            var minus = 0;
            if ($parentTable.find('td .product-rebate').length > 0) {
                var $reduction = $parentTable.find('td .product-rebate').first();
                var reduction = parseFloat($reduction.attr('data-reduction'));
                minus = ((subtotalPrice * reduction) / 100);
                $reduction.html('-' + (Math.round(minus)/100).toFixed(2))
            }
            subtotalPrice = Math.round(subtotalPrice - minus);

            var $subtotalField = $parentTable.find('.product-subtotal').first();
            var $tpsField = $parentTable.find('.product-tps').first();
            var $tvqField = $parentTable.find('.product-tvq').first();
            var $totalField = $parentTable.find('.product-total').first();
            var $versements = $('#company_versements').first();

            var tpsPrice = Math.round(subtotalPrice*0.05);
            var tvqPrice = Math.round(subtotalPrice*0.09975);
            var totalPrice = Math.round(subtotalPrice+tpsPrice+tvqPrice);

            $subtotalField.html((Math.round(subtotalPrice)/100).toFixed(2));
            $tpsField.html((Math.round(tpsPrice)/100).toFixed(2));
            $tvqField.html((Math.round(tvqPrice)/100).toFixed(2));
            $totalField.html((Math.round(totalPrice)/100).toFixed(2));

            if ($versements) {
                var nbVersements = $versements.attr('data-versements');

                if (nbVersements) {
                    var intTotalPrice = totalPrice.toFixed(2);
                    var pricePerPayment = Math.floor(intTotalPrice/nbVersements);
                    var diffFirstPayment = Math.floor(intTotalPrice%nbVersements);
                    for (var ctr = 0; ctr < nbVersements; ctr++) {
                        var $currentPayment = $versements.find('#payment_price_' + ctr).first();

                        if ($currentPayment) {
                            if (ctr == 0) {
                                $currentPayment.val((Math.floor(pricePerPayment+diffFirstPayment)/100).toFixed(2));
                            } else {
                                $currentPayment.val((Math.floor(pricePerPayment)/100).toFixed(2));
                            }
                        }
                    }
                }
            }
        });
    }

    function timerShowLocationBar() {
        timShowLocationBar = setTimeout(showLocationBar, 1500);
    }

    function timerHideLocationBar() {
        //timHideLocationBar = setTimeout(hideLocationBar, 200);
        hideLocationBar();
    }

    function showLocationBar() {
        //clearTimeout(timHideLocationBar);
        //if( timHideLocationBar !== null )
        //$('.subnav').animate({'top': '108px'}, 250);
        $('body .subnav > .nav-item > a').animate({'height': '150px'});
        subnav_status = 'visible';
    }

    function hideLocationBar() {
        clearTimeout(timShowLocationBar);
        //$('.subnav').animate({'top': '-6px'}, 100);
        $('body .subnav > .nav-item > a').animate({'height': '36px'});
        subnav_status = 'hidden';
    }

    // Fix bar
    if ($('.page-title-container').length) {
        var myElement = $('.page-title-container').offset().top;
        fixElement(myElement);
        $(window).bind('scroll', function () {
            fixElement(myElement);
        });

    }

    function fixElement(myElement) {
        if (!$('#main_navbar').hasClass('navbar-fixed-bottom')) {
            if ($(window).scrollTop() > myElement) {
                $('.page-title-container').addClass('fixed-top')
            } else {
                $('.page-title-container').removeClass('fixed-top');
                //$('body').css({'margin-top': ''});
            }
        }
    }

});

// LIGHTBOX galeries
$(document).on('click', '[data-toggle="lightbox"]', function (event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});


/* New Header */

var subtitleIndex = 0;

var subtitles = [
    'Affaires',
    'Attraits',
    'Chasse et pêche',
    'Culturel',
    'Designer',
    'Divertissement',
    'Plein air',
    'Restaurants',
    'Santé',
    'Terroir',
    'Vidéos drone'
];

setInterval(function () {
    $('.site-logo .subtitle').removeClass('tracking-in-expand').addClass('tracking-out-contract');

    setTimeout(function () {
        subtitleIndex++;

        if (subtitleIndex == subtitles.length) {
            subtitleIndex = 0;
        }

        $('.site-logo .subtitle').text(subtitles[subtitleIndex]);
        $('.site-logo .subtitle').removeClass('tracking-out-contract').addClass('tracking-in-expand');
    }, 800);
}, 5800);
