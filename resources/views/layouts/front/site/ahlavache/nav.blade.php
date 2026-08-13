@if( isset($company) )

  @if (isset( $company->socialNetworks ) && $company->socialNetworks->hasNetworks() )
  <div class="topbar">
    <div class="container">
      <div class="right">
       <a href="">CONNEXION</a>
        @foreach ($company->socialNetworks->getNetworks() as $network)
        <a href="{{$company->socialNetworks[$network[0]]}}" target="_blank">
          <i class="fa {{$network[1]}} logo-{{$network[0]}}" aria-hidden="true"></i>
        </a>
        @endforeach
      </div>
    </div>
  </div>
  @endif

  @if( isset($company_logo) && !empty($company_logo) )
  <div class="container">
		<div id="logo_company_site" class="">
      <a href="/"><img class="img-responsive" alt="Logo {{ $company->name }}" src="{{ URL::asset('uploads/companies/'.$company->id.'/'. $company_logo) }}"></a>
    </div>
  </div>
  @endif

  @if( isset($company_headImage) && !empty($company_headImage) )
  <div class="container">
    <div id="headImage">
        <img src="{{ URL::asset('uploads/companies/'.$company->id.'/'. $company_headImage) }}">
    </div>
  </div>
  @endif


  <div class="container">
    <a href="#menu" id="toggle"><span></span></a>
		<ul id="menu" class="nav navbar-nav navbar-right">
		  <li class="btn-primary @if( $page->slug == 'accueil' ) active @endif">
		    <a href="{{ url('/') }}">Accueil</a>
		  </li>

      @if( isset( $pages ) )
        @foreach( $pages as $key => $p )
          @php
            $children = $p->children;

          @endphp
          @if( $children->count() > 0 )
            <li class="
              dropdown
              btn-primary
              @if( $page->slug == $p->slug ) active @endif"
              role="presentation"
            >
              <a href="
                @if( $p->content != null || $p->content != '' )
                  {{ url($p->slug) }}
                @else
                  #
                @endif"

                class="dropdown-toggle"
                data-toggle="dropdown"
                role="button"
              >
                {{ $p->name }}
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                @foreach($children as $sp)
                  <li class="btn-primary @if( $page->slug == $sp->slug ) active @endif">
                    <a href="{{ url($sp->slug) }}">{{ $sp->name }}</a>
                  </li>
                @endforeach

              </ul>

          @else
            <li class="btn-primary @if( $page->slug == $p->slug ) active @endif">
              <a href="{{ url($p->slug) }}">{{ $p->name }}</a>
            </li>

          @endif
        @endforeach
      @endif

		  <li class="btn-primary @if( $page->slug == 'contact' ) active @endif">
		    <a href="{{ url('contact') }}">Contact</a>
		  </li>
		</ul>
  </div>

  <div class="clearfix"></div>
@else
  {{ dd('Error with company') }}
@endif
