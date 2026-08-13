<title><?php echo e($__env->yieldContent('title')); ?> | GoExploria</title>
@if (isset($config_content))
@if ($config_content->meta_description)
    <meta name="description" content="{{ $config_content->meta_description }}" />
@else
    <meta name="description" content="" />
@endif
@endif
<meta name="viewport"	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta http-equiv="Content-Type" content="text/Html; charset=utf-8" />
<meta name="google-site-verification" content="baMQBu-Vh6WiNQ256Cuk8uAcQTD-0zSbeQ20-_1n1Qo" />
