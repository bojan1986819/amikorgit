<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>@yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::to('src/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ URL::to('src/css/simple-sidebar.css')}}" rel="stylesheet">
    <link href="{{ URL::to('src/css/main.css')}}" rel="stylesheet">


    <link rel="stylesheet" type="text/css" media="screen" href="{{ URL::to('src/js/phpgrid/themes/blitzer/jquery-ui.custom.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ URL::to('src/js/phpgrid/jqgrid/css/ui.jqgrid.css')}}">
    <script src="{{ URL::to('src/js/phpgrid/jquery.min.js')}}"></script>
    {{--<script type="text/javascript" src="{{ URL::to('src/js/jquery.touchSwipe.min.js')}}"></script>--}}
{{--    <script src="{{ URL::to('src/js/phpgrid/jqgrid/js/i18n/grid.locale-en.js')}}" type="text/javascript"></script>--}}
    <script src="{{ URL::to('src/js/phpgrid/jqgrid/js/i18n/grid.locale-hu.js')}}" type="text/javascript"></script>
    <script src="{{ URL::to('src/js/phpgrid/jqgrid/js/jquery.jqGrid.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::to('src/js/phpgrid/themes/jquery-ui.custom.min.js')}}" type="text/javascript"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="//cdn.jsdelivr.net/tag-it/2.0/css/jquery.tagit.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/tag-it/2.0/js/tag-it.min.js"></script>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/select2/3.5.2/select2.css">
    <script src="//cdn.jsdelivr.net/select2/3.5.2/select2.min.js"></script>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

</head>
<body>
<div id="wrapper">
@include('includes.header')

<div class="container-fluid">
    <br><br>
    @include('includes.sidebar')

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="swipe-area"></div>
        <div class="container-fluid">

            <br>
                @yield('content')

        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->
</div>


<script src="{{ URL::to('src/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::to('src/js/app.js') }}"></script>
@stack('client-scripts')
</body>
</html>

