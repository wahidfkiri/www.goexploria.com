@section('socialNetworks')
      @if (isset( $company->socialNetworks ) && $company->socialNetworks->hasNetworks() )
          <div class="socialNetworks">
          @foreach ($company->socialNetworks->getNetworks() as $network)
              <a href="{{$company->socialNetworks[$network[0]]}}" target="_blank">
                  <i class="fa {{$network[1]}} logo-{{$network[0]}}"
                     aria-hidden="true"></i>
              </a>
          @endforeach
      @endif
@endsection
