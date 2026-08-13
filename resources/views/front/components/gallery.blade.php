  @section("gallery" )
  <div id="medias-photo-tab" class="tab-pane">
    <?php
      $last_gallery_id = 0;
      $count = 0;
    ?>

    @foreach( $medias as $i => $media)

      @if( !$media->gslider )
        <?php
          $author = !empty($media->content) && $media->photo == true ? '<br>' . $media->content : '';

          $media_title = $media->name;


          if( !empty($media->target) ) {
            preg_match("/[a-z0-9\-]{1,63}\.[a-z\.]{2,6}$/", parse_url($media->target, PHP_URL_HOST), $domain);
#            $media_title = '<a title="Cliquez pour en savoir plus sur '.$domain[0].'" target="_blank" href="'.$media->target.'">'.$media->name.' &nbsp; <i class="fa fa-external-link" aria-hidden="true"></i></a>';
            $media_title = '<a title="Cliquez pour en savoir plus" target="_blank" href="'.$media->target.'">'.$media->name.' &nbsp; <i class="fa fa-external-link" aria-hidden="true"></i></a>';
          }

        ?>
        @if($media->photo)
        @if( $media->gid != $last_gallery_id )
          <?php
            $last_gallery_id = $media->gid;
            $count++;
          ?>
          <div class="media">

            {{-- http://ashleydw.github.io/lightbox/ --}}

              <a
                data-type="image"
                class="hover-effect"
                data-toggle="lightbox"
                data-gallery="gallery-{{ $media->gslug }}"
                data-title="{{ $media_title . $author }}"
                data-footer="
                @php
                  if(isset($medias_attr[$media->id])) {
                    echo htmlentities('<div class="attrs">');
                      foreach($medias_attr[$media->id] as $attr) {
                        echo htmlentities('<div class="attr">');
                        echo $attr["attr"];
                        echo htmlentities('</div>');
                        echo htmlentities('<div class="value">');
                        echo $attr["value"];
                        echo htmlentities('</div>');
                      }
                    echo htmlentities('</div>');
                  }
                @endphp"
                href="#"
                data-remote="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/'. $media->slug) !!}"
                >
                  <img
                    class="img-fluid"
                    src="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/' . $media->slug) !!}"
                    alt="{{ $media->name }}"
                    title="{{ $media->name }} - {{ strtoupper($company->name) }}">
              </a>

              <div class="caption">
                <h5 class="title">{{ $media->gname }}</h5>
              </div>

          </div>
	    @if ($count == 2)
	      <div class="clearfix visible-xs visible-sm"></div>
	    @endif

            @if ($count == 4)
              <?php $count = 0; ?>
              <div class="clearfix"></div>
            @endif

          @else
          {{-- Les autres photos de la même galerie photos --}}
          <a
            style="display: none;"
            data-type="image"
            data-title="{{ $media_title . $author }}"
            data-toggle="lightbox"
            data-gallery="gallery-{{ $media->gslug }}"
            data-footer="
            @php
              if(isset($medias_attr[$media->id])) {
                echo htmlentities('<div class="attrs">');
                  foreach($medias_attr[$media->id] as $attr) {
                    echo htmlentities('<div class="attr">');
                    echo $attr["attr"];
                    echo htmlentities('</div>');
                    echo htmlentities('<div class="value">');
                      echo $attr["value"];
                    echo htmlentities('</div>');
                  }
                echo htmlentities('</div>');
              }
            @endphp"
            data-remote="{!! URL::asset('uploads/galleries/' . $media->gallery_id . '/'. $media->slug) !!}"
          >
          </a>
          @endif
          @else <!-- les vidéos -->
          @if( $media->gid != $last_gallery_id )
          <?php
            $last_gallery_id = $media->gid;
            $count++;
          ?>
          <div class="media">
            <a
              class="hover-effect"
              data-toggle="lightbox"
              data-gallery="gallery-{{ $media->gslug }}"
              data-title="{{ $media_title . $author }}"
              data-footer="
              @php
                if(isset($medias_attr[$media->id])) {
                  echo htmlentities('<div class="attrs">');
                    foreach($medias_attr[$media->id] as $attr) {
                      echo htmlentities('<div class="attr">');
                      echo $attr["attr"];
                      echo htmlentities('</div>');
                      echo htmlentities('<div class="value">');
                      echo $attr["value"];
                      echo htmlentities('</div>');
                    }
                  echo htmlentities('</div>');
                }
              @endphp"
              href="#"
              data-remote="{{$media->slug}}"
            >
              <img
                class="img-fluid"
                src="{{ App\Helpers\Formatter::getYoutubeMiniature($media->slug) }}"
                alt="{{ $media->name }}"
                title="{{ $media->name }} - {{ strtoupper($company->name) }}">
              </a>

            <div class="caption">
              <h5 class="title">{{ $media->gname }}</h5>
            </div>

          </div>

            @if ($count == 2)
	      <div class="clearfix visible-xs visible-sm"></div>
	    @endif
            @if ($count == 4)
            <?php $count = 0; ?>
              <div class="clearfix"></div>
            @endif
          @else
          {{-- Les autres photos de la même galerie photos --}}
          <a
            style="display: none;"
            data-title="{{ $media_title . $author }}"
            data-toggle="lightbox"
            data-gallery="gallery-{{ $media->gslug }}"
            data-footer="
            @php
              if(isset($medias_attr[$media->id])) {
                echo htmlentities('<div class="attrs">');
                  foreach($medias_attr[$media->id] as $attr) {
                    echo htmlentities('<div class="attr">');
                    echo $attr["attr"];
                    echo htmlentities('</div>');
                    echo htmlentities('<div class="value">');
                      echo $attr["value"];
                    echo htmlentities('</div>');
                  }
                echo htmlentities('</div>');
              }
            @endphp"
            data-remote="{{$media->slug}}"
            href="{{$media->slug}}">
          </a>




        @endif
        @endif
      @endif
    @endforeach

  </div>

  @endsection
