<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-text font-weight-light">Lumimories</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                {{--<img src="" class="img-circle elevation-2" alt="User Image">--}}
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/admin/profils') }}">
                        <i class="nav-icon fa fa-users"></i>
                        <p>Profils</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">
                        <i class="nav-icon fa fa-globe"></i>
                        <p>
                            Anecdotes
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/admin/anecdotes-valides')}}" class="nav-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Validés</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/anecdotes-invalides')}}" class="nav-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Non validés</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link">
                        <i class="nav-icon fa fa-photo"></i>
                        <p>
                            Photos
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/admin/photos-valides') }}" class="nav-link">
                                <i class="fa fa-check nav-icon"></i>
                                <p>Validés</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url("/admin/photos-invalides") }}" class="nav-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Non validés</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/admin/utilisateurs') }}">
                        <i class="nav-icon fa fa-users"></i>
                        <p>Utilisateurs</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
