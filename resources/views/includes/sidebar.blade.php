<!-- Sidebar -->
<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="#">
                Főoldal
            </a>
        </li>
        <li>
            <a href="{{ route('new_product') }}">Termék felvétel</a>
        </li>
        <li>
            <a href="{{ route('products') }}">Termék kezelés</a>
        </li>
        <li>
            <a href="{{ route('clients') }}">Kliensek kezelése</a>
        </li>
        <li>
            <a href="{{ route('balance') }}">Kimutatások</a>
        </li>
        <li>
            <a href="{{ route('email') }}">Promóciók</a>
        </li>
        <li>
            <a href="#">Teendők kezelése</a>
        </li>
        @if(Auth::user() -> isAdmin())
        <li>
            <a href="{{ route('users') }}">Felhasználók</a>
        </li>
        @endif
    </ul>
</div>
<!-- /#sidebar-wrapper -->
