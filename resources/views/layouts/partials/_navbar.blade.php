<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                @method("POST")
                <button type="submit" class="mr-2 border-0 bg-white"><i class="fa fa-sign-out-alt"></i> Log out</button>
            </form>
        </li>
    </ul>
</nav>
<!-- /.navbar -->