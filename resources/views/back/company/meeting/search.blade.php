@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
{!! Breadcrumbs::render('company.meeting', $company) !!}
@stop
@section('left-menu')
@include('back.company.menu')
@stop

@section('right-content')
<h4>{{$company->name}} : Rendez-vous </h4>
{!! Formatter::addButton(route('company.meeting.add', $company->id))!!}
{!! Formatter::button('', 'info', 'fa fa-print', 'Imprimer', ['id' => 'printer']) !!}
<br />
<br />
{!! $calendar->calendar() !!}
{!! $calendar->script() !!}


<br />
<br />

@stop
@section('js')
{{ Html::script('js/moment.min.js') }}
{{ Html::script('js/fullcalendar/fullcalendar.min.js') }}
{{ Html::script('js/fullcalendar/lang/fr.js') }}
{{ Html::style('js/fullcalendar/fullcalendar.min.css') }}
<script type="text/javascript">
  var printRoute = '/admin/company/meetings/mod/{{$company->id}}/print?';
  $('#printer').on('click', function (e) {
    e.preventDefault();
    var calendarId = '#calendar-' + '{{$calendar->getId()}}';
    var calendar = $(calendarId).fullCalendar('getCalendar');
    var view = calendar.view;
    var start = view.start._d;
    var end = view.end._d;
    //   console.log(start);return false;
    printRoute += 'start=' + Math.floor(start.getTime() / 1000);
    printRoute += '&end=' + Math.floor(end.getTime() / 1000);
    document.location.href = printRoute;
    return true;
  });
</script>
@stop
