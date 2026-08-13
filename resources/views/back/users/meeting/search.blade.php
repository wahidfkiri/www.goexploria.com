@extends('layouts.back.master')
@section('title', 'Etablissements')


@section('content')        
    @if(auth()->user()->isAdmin())
    <form method="get" id="currentlySelectedUser">
        <div class="form-group">
            <label for="user_id" style="margin-right: 5px">Horaire de</label>
            <select name="user_id" onchange="currentlySelectedUser.submit();">
                @foreach($users as $user)
                    <option value="{{$user->id}}" {{$user->id==$user_id?'selected':''}}>{{$user->name}}</option>
                @endforeach
            </select>
        </div>
    </form>
    @else
        <h4>{{$user->name}}</h4>
    @endif

    {!! Formatter::addButton(route('users.meeting.add',['user_id'=>$user_id]))!!}
    {!! Formatter::button('', 'info', 'fa fa-print', 'Imprimer', ['id' => 'printer']) !!}
    <br/>
    <br/>
    {!! $calendar->calendar() !!}
    {!! $calendar->script() !!}


    <br/>
    <br/>

@stop
@section('js')
    {{ Html::script('js/moment.min.js') }}
    {{ Html::script('js/fullcalendar/fullcalendar.min.js') }}
    {{ Html::script('js/fullcalendar/lang/fr.js') }}
    {{ Html::style('js/fullcalendar/fullcalendar.min.css') }}
    <script type="text/javascript">
        var printRoute = '/admin/users/meetings/print?user_id={{$user_id}}';
        $('#printer').on('click', function (e) {
            e.preventDefault();
            var calendarId = '#calendar-' + '{{$calendar->getId()}}';
            var calendar = $(calendarId).fullCalendar('getCalendar');
            var view = calendar.view;
            var start = view.start._d;
            var end = view.end._d;
         //   console.log(start);return false;
            printRoute += '&start=' + Math.floor(start.getTime() / 1000);
            printRoute += '&end=' + Math.floor(end.getTime() / 1000);
            document.location.href = printRoute;
            return true;
        });
    </script>
@stop
