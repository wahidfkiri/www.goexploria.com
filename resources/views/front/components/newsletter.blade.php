@section('newsletter')
<div id="index_newsletter">
    <div class="container">
        <p>Inscrivez-vous à notre infolettre dès maintenant!</p>
        {{ Form::open(array('route' => array('front.company.newsletter.subscribe.post', $company->id), 'method' => 'POST', 'id' => 'signupForm', 'class' => 'form-horizontal form-groups-bordered', 'autocomplete' => 'off')) }}
        {{ Form::text('name', null, ['class' => 'form-control', 'min'=>3, 'placeholder' => 'Votre nom...', 'id' => 'name']) }}
        {{ Form::text('mail', null, ['class' => 'form-control', 'min'=>6, 'placeholder' => 'Votre adresse courriel...', 'id' => 'mail']) }}
        <br>
        {!! Form::submit('S\'abonner', array('class'=>'send-btn')) !!}
        {!! app('captcha')->render($lang = 'fr'); !!}
        {{ Form::close() }}
    </div>
</div>
@endsection
