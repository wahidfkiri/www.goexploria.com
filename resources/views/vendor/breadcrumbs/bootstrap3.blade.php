{{--
    Gabarit Bootstrap 3, repris de davejamesmiller/laravel-breadcrumbs 3.x.
    diglactic/laravel-breadcrumbs ne fournit que Bootstrap 4 et 5, or le thème
    de l'application est basé sur Bootstrap 3.1.1 : ce gabarit conserve donc le
    balisage d'origine (<ol class="breadcrumb"> avec <li class="active">).
--}}
@unless ($breadcrumbs->isEmpty())
    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)

            @if ($breadcrumb->url && ! $loop->last)
                <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @else
                <li class="active">{{ $breadcrumb->title }}</li>
            @endif

        @endforeach
    </ol>
@endunless
