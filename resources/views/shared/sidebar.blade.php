<div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
      <ul class="navbar-nav">

      
        
        <li class="nav-item">
          <a class="nav-link text-white {{Request::segment(1) == 'summary' ? 'active bg-gradient-primary': ''}}" href="{{route('summary')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">accessibility</i>
            </div>
            <span class="nav-link-text ms-1">Summary</span>
          </a>
        </li>
        

        @if(Auth::user()->hasRole('admin'))
        <li class="nav-item">
          <a class="nav-link text-white {{Request::segment(1) == 'users' ? 'active bg-gradient-primary': ''}}" href="{{route('users')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">account_circle</i>
            </div>
            <span class="nav-link-text ms-1">Accounts</span>
          </a>
        </li>
        @endif

        <li class="nav-item">
          <a class="nav-link text-white {{Request::segment(1) == 'inventory' ? 'active bg-gradient-primary': ''}}" href="{{route('inventory')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">accessibility</i>
            </div>
            <span class="nav-link-text ms-1">Inventory</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white {{Request::segment(1) == 'product' ? 'active bg-gradient-primary': ''}}" href="{{route('product')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">art_track</i>
            </div>
            <span class="nav-link-text ms-1">Product</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white {{Request::segment(1) == 'ordering' ? 'active bg-gradient-primary': ''}}" href="{{route('ordering')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">assignment</i>
            </div>
            <span class="nav-link-text ms-1">Ordered</span>
          </a>
        </li>
        @if(Auth::user()->hasRole('admin'))
        <li class="nav-item">
          <a class="nav-link text-white {{Request::segment(1) == 'sales' ? 'active bg-gradient-primary': ''}}" href="{{route('sales')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">announcement</i>
            </div>
            <span class="nav-link-text ms-1">Sales</span>
          </a>
        </li>

        @endif

         <li class="nav-item">
          <a class="nav-link text-white " href="{{route('logout')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">power_settings_new</i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>
    
      
      </ul>

    </div>