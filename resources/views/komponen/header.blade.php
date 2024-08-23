
<!-- Header -->
<header class="header-v4">

     <div class="container-menu-desktop">
			<!-- Topbar -->
			                  <div class="wrap-menu-desktop">
                <nav class="limiter-menu-desktop container">

                     <!-- Logo desktop -->
                     <a href="#" class="logo">
                        <img src="{{ asset('coza') }}/images/icons/BUTIK BELV.JPG" alt="IMG-LOGO">
                     </a>


                    <!-- Menu desktop -->
                    <div class="menu-desktop">
                         <ul class="main-menu">
                            <li><a href="{{ url('/') }}" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                            <li><a href="{{ url('/shop') }}" class="nav-item nav-link {{ request()->is('shop') ? 'active' : '' }}">Shop</a></li>
                            <li><a href="{{ url('/cart') }}" class="nav-item nav-link {{ request()->is('cart') ? 'active' : '' }}">Cart</a></li>
                            <li><a href="{{ url('/about') }}" class="nav-item nav-link {{ request()->is('about') ? 'active' : '' }}">About</a></li>
                            <li><a href="{{ url('/contact') }}" class="nav-item nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a></li>
                            <li><a href="{{ url('/kategori') }}" class="nav-item nav-link {{ request()->is('kategori') ? 'active' : '' }}">Category</a></li>
                            <li><a href="{{ url('/category/{id}') }}" class="nav-item nav-link {{ request()->is('kategori') ? 'active' : '' }}"></a></li>

                        </ul>
                    </div>



                    <!-- Icon header -->
                            <li class="navbar-nav ml-auto py-0" >
                         @guest('customer')
                                          @if (Route::has('login'))
                                          <a href="{{ route('login') }}" style="color: #000">Login</a>
                            </li>
                                @endif
                            <li class="navbar-nav ml-2 py-0">
                                 @if (Route::has('register'))
                                    <a href="{{ route('showRegister') }}"style="color: #000">Register</a>
                            </li>
                                @endif
                        @else
                    <div class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"aria-haspopup="true" aria-expanded="false" v-pre>
<img src="{{ Auth::guard('customer')->user()->foto ? asset('uploads/profile_pictures/' . Auth::guard('customer')->user()->foto) : asset('uploads/profile_pictures/' . Auth::guard('customer')->user()->img) }}" alt="Foto Profil" class="rounded-circle mr-2" width="30" height="30">                            {{ Auth::guard('customer')->user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}" onclick="event.preventDefault();
                                                                             document.getElementById('profile-form').submit();">
                                 Profile
                                 </a>
                                 <a class="dropdown-item" href="{{ route('orderHistory') }}" onclick="event.preventDefault();
                                                                            document.getElementById('order-history-form').submit();">
                                  Order History
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                                </a>

                                <form id="order-history-form" action="{{ route('orderHistory') }}" method="GET" class="d-none">
                                @csrf
                                </form>
                                <form id="profile-form" action="{{ route('profile') }}" method="GET" class="d-none">
                                @csrf
                                </form>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                                </form>
                            </div>
                        @endguest
                    </div>
                </nav>
            </div>
        </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="index.html"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>

            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
                data-notify="2">
                <i class="zmdi zmdi-shopping-cart"></i>
            </div>

            <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti"
                data-notify="0">
                <i class="zmdi zmdi-favorite-outline"></i>
            </a>
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>




    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="images/icons/icon-close2.png" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>
    <style>
        .nav-item.active {
    font-weight: bold;
    color: #ee7f0f; /* Warna untuk menu yang aktif */
}
</style>
</header>
