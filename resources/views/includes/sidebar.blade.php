<!-- Sidebar -->
<style>
    .forAnimate{
        position: relative;
        /*left: 50px;*/
        width: 400px;
        background: #000;
        border: 1px solid silver;
    }
</style>
<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="{{ route('mainpage') }}">
                Főoldal
            </a>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Termék kezelés<span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a>
            <ul class="dropdown-menu forAnimate" role="menu">
                <li><a href="{{ route('new_product') }}">Termék felvétel</a></li>
                <li class="divider"></li>
                <li><a href="{{ route('all_products') }}">Összes termék</a></li>
                <li class="divider"></li>
                <li><a href="{{ route('neworder') }}">Termék eladása</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ route('expense') }}">Kiadások kezelése</a>
        </li>
        <li>
            <a href="{{ route('clients') }}">Kliensek kezelése</a>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Kimutatások<span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a>
            <ul class="dropdown-menu forAnimate" role="menu">
                <li><a href="{{ route('balance') }}">Bevétel-Kiadás</a></li>
                <li class="divider"></li>
                <li><a href="{{ route('income') }}">Bevétel</a></li>
                <li class="divider"></li>
                <li><a href="{{ route('biznotpaid') }}">Fizetetlen bizományos</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ route('email') }}">Promóciók</a>
        </li>
        <li>
            <a href="{{ route('tasks') }}">Teendők kezelése</a>
        </li>
    @if(Auth::user() -> isAdmin())
        <li>
            <a href="{{ route('users') }}">Felhasználók</a>
        </li>
        @endif
    </ul>
</div>
<!-- /#sidebar-wrapper -->
