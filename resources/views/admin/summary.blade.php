
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{URL::to('/assets/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{URL::to('/assets/img/favicon.png')}}">
  <title>
    Dashboard
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="{{URL::to('/assets/css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{URL::to('/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="{{URL::to('/assets/css/material-dashboard.css?v=3.0.0')}}" rel="stylesheet" />

  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
   <style type="text/css">
    .product_align{
      padding-left: 25px !important;
    }
  </style>
</head>

<body class="g-sidenav-show  bg-gray-200">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      
    </div>
    <hr class="horizontal light mt-0 mb-2">

    @auth
       @include('shared.sidebar')
    @endauth
    
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        
        
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        @if(Auth::user()->hasRole('admin'))
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              
              <form method="get">
                   
                    <input type="date" name="start_date">
                    <input type="date" name="end_date">
                    <input type="submit" value="Generate">
              </form>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Total Inventory</p>
                <h4 class="mb-0">{{$total_inventory}}</h4>
                <p class="text-sm mb-0 text-capitalize">Total Transaction</p>
                <h4 class="mb-0">{{$total_transactions}}</h4>
                <p class="text-sm mb-0 text-capitalize">Total Deducted Items</p>
                <h4 class="mb-0">{{$total_deducted}}</h4>
                <p class="text-sm mb-0 text-capitalize">Total Added Items</p>
                <h4 class="mb-0">{{$total_added}}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              
            </div>
          </div>
        </div>
        @endif
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-header pb-0">
                <h6>Top Sold Items</h6>
                <p class="text-sm">
                  <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                  Top <span class="font-weight-bold">10</span>
                </p>
              </div>
              @foreach($top5_sales as $sale)
              <div class="card-body p-3">
                <div class="timeline timeline-one-side">
                  
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-icons text-danger text-gradient"></i>
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">Name: {{$sale->name}}</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Total Sales: {{$sale->total_sales}}</p>
                    </div>
                  </div>

                 
                </div>
              </div>
              @endforeach
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-header pb-0">
                <h6>Critical Stock Items below 10</h6>
                <p class="text-sm">
                  <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                  Top <span class="font-weight-bold">10</span>
                </p>
              </div>
              @foreach($top5_critical_inventories as $sale)
              <div class="card-body p-3">
                <div class="timeline timeline-one-side">
                  
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-icons text-danger text-gradient"></i>
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">Name: {{$sale->name}}</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Total Stocks: {{$sale->quantity}}</p>
                    </div>
                  </div>

                 
                </div>
              </div>
              @endforeach
            </div>
        </div>

       
        

        

        

      </div>
      <div class="row">
        @if(Auth::user()->hasRole('admin'))
          <div class="col-xl-4 col-sm-6 mb-xl-0 ">
            <div class="card h-100">
              <div class="card-header pb-0">
                <h6>Logged Personnel</h6>
                <p class="text-sm">
                  <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                  Top <span class="font-weight-bold">10</span>
                </p>
              </div>
              @foreach($logs as $log)
              <div class="card-body p-3">
                <div class="timeline timeline-one-side">
                  
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-icons text-danger text-gradient">{{$log->action}}</i>
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">{{$log->user->first_name}}</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{$log->created_at->diffForHumans()}}</p>
                    </div>
                  </div>

                 
                </div>
              </div>
              @endforeach
            </div>
        </div>

        @endif
        

      </div>

      
      
    </div>
  </main>
  
  <!--   Core JS Files   -->
  <script src="{{URL::to('/assets/js/core/popper.min.js')}}"></script>
  <script src="{{URL::to('/assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{URL::to('/assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{URL::to('/assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script src="{{URL::to('/assets/js/plugins/chartjs.min.js')}}"></script>
  
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{URL::to('/assets/js/material-dashboard.min.js?v=3.0.0')}}"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
   
</body>

</html>