<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                {{ Auth::user()->name }}<i class="fa fa-sign-out"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                    Se deconnecter
                </a>
            </div>
        </li>
    </ul>
</nav>
