window.onload = function(){
  /*logout = document.querySelector("[data-target='#custom-logout']");*/
  logout = document.querySelectorAll("[href='#custom-logout']");
  panelControl = document.querySelectorAll("[href='#custom-panel']");
  for(i = 0; i < 2; i++){
      if(logout[i] != undefined){
          logout[i].addEventListener("click", function(){
              location.href = "auth/logout";
          });
      }
  }
  for(i = 0; i < 2; i++){
      if(panelControl[i] != undefined){
          panelControl[i].addEventListener("click", function(){
              location.href = "/admin";
          });
      }
  }
}

$(document).ready(function()
{
  $('a.list_item').click(function(e){
    e.preventDefault();
	  $('.sub').hide();
	  $(this).parent().find('.sub').slideToggle(100);
	});

	// Fix bar
	if( $('.page-title-container').length ){
	  var myElement = $('.page-title-container').offset().top;
	  fixElement(myElement);
	  $(window).bind('scroll', function () {
	      fixElement(myElement);
	  });

	}

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

	/* Mobile menu */
	var theToggle = document.getElementById('toggle');

  // based on Todd Motto functions
  // http://toddmotto.com/labs/reusable-js/

  // hasClass
  function hasClass(elem, className) {
  	return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
  }
  // addClass
  function addClass(elem, className) {
      if (!hasClass(elem, className)) {
      	elem.className += ' ' + className;
      }
  }
  // removeClass
  function removeClass(elem, className) {
  	var newClass = ' ' + elem.className.replace( /[\t\r\n]/g, ' ') + ' ';
  	if (hasClass(elem, className)) {
          while (newClass.indexOf(' ' + className + ' ') >= 0 ) {
              newClass = newClass.replace(' ' + className + ' ', ' ');
          }
          elem.className = newClass.replace(/^\s+|\s+$/g, '');
      }
  }
  // toggleClass
  function toggleClass(elem, className) {
  	var newClass = ' ' + elem.className.replace( /[\t\r\n]/g, " " ) + ' ';
      if (hasClass(elem, className)) {
          while (newClass.indexOf(" " + className + " ") >= 0 ) {
              newClass = newClass.replace( " " + className + " " , " " );
          }
          elem.className = newClass.replace(/^\s+|\s+$/g, '');
      } else {
          elem.className += ' ' + className;
      }
  }

  theToggle.onclick = function() {
     toggleClass(this, 'on');
     return false;
  }

});

// LIGHTBOX galeries
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
  event.preventDefault();
  $(this).ekkoLightbox();
});
