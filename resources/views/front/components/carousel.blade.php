{{--  TODO: Manque condition pour l'affichage ou pas du carousel --}}

@section("slider")
<section class="add_slider">
    <div class="center">
        <div class=""><a href="#"><img  class="img-responsive" src="https://dummyimage.com/600x400/000/fff" alt=""></a></div>
        <div class=""><a href="#"><img  class="img-responsive" src="https://dummyimage.com/600x400/000/fff" alt=""></a></div>
        <div class=""><a href="#"><img  class="img-responsive" src="https://dummyimage.com/600x400/000/fff" alt=""></a></div>
        <div class=""><a href="#"><img  class="img-responsive" src="https://dummyimage.com/600x400/000/fff" alt=""></a></div>
        <div class=""><a href="#"><img  class="img-responsive" src="https://dummyimage.com/600x400/000/fff" alt=""></a></div>
        <div class=""><a href="#"><img  class="img-responsive" src="https://dummyimage.com/600x400/000/fff" alt=""></a></div>
        <div class=""><a href="#"><img  class="img-responsive" src="https://dummyimage.com/600x400/000/fff" alt=""></a></div>
        <div class=""><a href="#"><img  class="img-responsive" src="https://dummyimage.com/600x400/000/fff" alt=""></a></div>
        <div class=""><a href="#"><img  class="img-responsive" src="https://dummyimage.com/600x400/000/fff" alt=""></a></div>
        <div class=""><a href="#"><img  class="img-responsive" src="https://dummyimage.com/600x400/000/fff" alt=""></a></div>
        <div class=""><a href="#"><img  class="img-responsive" src="https://dummyimage.com/600x400/000/fff" alt=""></a></div>
        <div class=""><a href="#"><img  class="img-responsive" src="https://dummyimage.com/600x400/000/fff" alt=""></a></div>
    </div>
</section>

@section('js')
@parent
  {{ Html::script('slick/slick.js') }}
  <script>
  jQuery(document).ready(function(){

      $('.add_slider > .center').slick({
          centerMode: true,
          centerPadding: '15px',
          slidesToShow: 6,
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
@stop

@section('css')
@parent
  {{ Html::style('slick/slick.css') }}
  {{ Html::style('slick/slick-theme.css') }}
@stop

@endsection
