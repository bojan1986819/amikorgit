<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>@yield('title')</title>
    <link href="{{ URL::to('src/css/Layout.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('src/css/Menu.css')}}" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="{{ URL::to('src/js/phpgrid/jquery.min.js')}}"></script>
    <script src="https://s3.amazonaws.com/menumaker/menumaker.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

</head>
<body>
<div class="Holder">
    <div class="Header"></div>
    <div class="NavBar">
        <div id="cssmenu" class="align-left">
            <ul>
                <li><a href="#"><i class="fa fa-fw fa-cog"></i> Amikor CRM</a></li>
            </ul>
        </div>
    </div>
    <div class="Content">
        <div class="PageHeading">
            <h1>@yield('header')</h1>
        </div>
        @yield('content')

    </div>
    <div class="Footer"></div>
</div>
</body>
</html>

