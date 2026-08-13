@section('css')
    {{ Html::style('css/bootstrap.css') }}
    {{ Html::style('css/back/neon-core.css') }}
    {{ Html::style('css/back/neon-theme.css') }}
    {{ Html::style('css/back/neon-forms.css') }}
    {{ Html::style('css/toastr.css') }}
    {{ Html::style('css/entypo.css') }}
    {{ Html::style('css/font-awesome.css') }}
    {{ Html::style('css/common.css') }}
    {{ Html::style('css/back/custom.css?v=2') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css') }}
    @show
@section('javascript')
    {{ Html::script('js/jquery/jquery-2.0.2.min.js') }}
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js') }}
    <script>
        $('.colorpicker').colorpicker();
    </script>
    {{ Html::script('js/bootstrap/bootstrap.js') }}
    {{ Html::script('ckeditor/ckeditor.js') }}
    {{ Html::script('js/back/TweenMax.min.js') }}
    {{ Html::script('js/back/joinable.js') }}
    {{ Html::script('js/back/neon-custom.js') }}
    {{ Html::script('js/back/neon-chat.js') }}
    {{ Html::script('js/back/resizeable.js') }}
    {{ Html::script('js/back/neon-api.js') }}
    {{ Html::script('ckeditor/adapters.js') }}
    {{ Html::script('js/toastr.js') }}
    {{ Html::script('js/validation/jsvalidation.js') }}
    {{ Html::script('js/back/custom.js') }}
    {{ Html::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js') }}

@show
