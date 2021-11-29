
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
        
        

      </div>

      <div class="row mt-4">
        
        <div class="row">
           <div class="col-12">
            <div class="card my-4">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                  <h6 class="text-white text-capitalize ps-3">Inventory Lists</h6>
                </div>
              </div>
              <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                @include('shared.error_handler')
                @include('shared.notification')
                  @if(Auth::user()->hasRole('admin'))
                  <button class="btn btn-sm bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#myModal">Add Inventory</button>
                  @endif
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th class="text-uppercase ">Category</th>
                        <th class="text-uppercase ">ID</th>
                        <th class="text-uppercase text-uppercase">Name</th>
                        <th class="text-center ">Picture</th>
                       
                        <th class="text-secondary ">Quantity</th>
                        <th class="text-secondary ">Measurement</th>
                        <th class="text-secondary ">Unit Cost</th>
                        <th class="text-secondary ">Net Value</th>
                        <th class="text-secondary ">Actions</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($inventories as $inventory)
                      <tr>
                        <td class="align-middle text-center text-sm">
                          <span class="badge badge-sm bg-gradient-primary">{{$inventory->category->name}}</span>
                        </td>
                        <td class="align-middle text-center text-md">
                          <p class="text-xs font-weight-bold mb-0">{{$inventory->id}}</p>
                          
                        </td>
                        <td class="align-middle text-center text-md">
                          <p class="text-xs font-weight-bold mb-0">{{$inventory->name}}</p>
                          
                        </td>
                        <td class="align-middle text-center text-md">
                          <img src="{{asset('/inventory_images')}}/{{$inventory->picture}}" class="img-thumbnail" width="100px" height="100px">
                          
                        </td>
                        <td class="align-middle text-center text-md">
                          <p class="text-xs font-weight-bold mb-0">{{$inventory->quantity}}</p>
                          
                        </td>
                        <td class="align-middle text-center text-md">
                          <p class="text-xs font-weight-bold mb-0">{{$inventory->unit_measurement}}</p>
                          
                        </td>
                        <td class="align-middle text-center text-md">
                          <p class="text-xs font-weight-bold mb-0">{{$inventory->unit_cost}}</p>
                          
                        </td>
                        <td class="align-middle text-center text-md">
                          <p class="text-xs font-weight-bold mb-0">P{{number_format($inventory->net_value,2)}}</p>
                          
                        </td>
                        <td>
                          <button class="btn btn-info btn-sm update_inventory" value="{{$inventory->id}}" data-bs-toggle="modal" data-bs-target="#myModalEdit">Edit</button>
                          @if( $inventory->status_id == 1 )
                            <a href="{{route('inventory_suspend',['id'=> $inventory->id])}}" class="btn btn-danger btn-sm">Suspend</a>
                          @elseif($inventory->status_id == 0)
                            <a href="{{route('inventory_suspend',['id'=> $inventory->id])}}" class="btn btn-success btn-sm">Available</a>
                          @endif
                          <button class="btn btn-primary btn-sm update_stock" value="{{$inventory->id}}" data-bs-toggle="modal" data-bs-target="#myModal2">Update Stock</button>
                        </td>

                       

                      </tr>
                      @endforeach
                      
                     
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
       </div>
        
      </div>
      
      
    </div>
  </main>

  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Inventory Information</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
         
         <form action="{{route('inventory_check')}}" method="POST" enctype="multipart/form-data">
           
            @csrf
           <select class="form-select" required name="category_id">
            <option value="">SELECT CATEGORY</option>
            @foreach($categories as $category)
                
                <option value="{{$category->id}}">{{$category->name}}</option>
                
            @endforeach
            </select>         
          <div class="input-group input-group-outline my-3">
              <label class="form-label">Item Name</label>
              <input type="text" class="form-control" name="name" required>
          </div>

          <div class="input-group input-group-outline my-3">
              
              <input type="file" class="form-control" name="picture" placeholder="Item Image" required>
          </div>

          <div class="input-group input-group-outline my-3">
              <label class="form-label">Quantity</label>
              <input type="number" class="form-control" name="quantity" min="1" required>
          </div>

          <div class="input-group input-group-outline my-3">
              <label class="form-label">Unit Measurement</label>
              <input type="text" class="form-control" name="unit_measurement" min="1" required>
          </div>

          <div class="input-group input-group-outline my-3">
              <label class="form-label">Unit Cost</label>
              <input type="number" class="form-control" name="unit_cost" min="1" required>
          </div>

          <div class="input-group input-group-outline my-3">
              <label class="form-label">Net Value</label>
              <input type="number" class="form-control" name="net_value" min="1" required>
          </div>

          <button type="submt" class="btn btn-primary" >Submit</button>
          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>

         </form>
         
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          
        </div>

      </div>
    </div>
</div>

<div class="modal" id="myModal2">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="order_title"></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
         
         <form action="{{route('inventory_stock_update')}}" method="POST">
           
            @csrf
           <input type="hidden" name="inventory_id" id="inventory_id">

          <div class="input-group input-group-outline my-3">
              <label class="form-label">Enter Quantity</label>
              <input type="number" class="form-control" name="quantity" min="1" required>
          </div>

          <button type="submt" class="btn btn-primary" >Update Stock</button>
          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>

         </form>
         
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          
        </div>

      </div>
    </div>
</div>

<div class="modal" id="myModalEdit">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update Inventory Information</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
         
         <form action="{{route('inventory_update')}}" method="POST" enctype="multipart/form-data">
           
            @csrf
            <input type="hidden" name="inventory_id" id="inventory_id_update">
           <select class="form-select" required name="category_id" id="category_id">
            <option value="">SELECT CATEGORY</option>
            @foreach($categories as $category)
                
                <option value="{{$category->id}}">{{$category->name}}</option>
                
            @endforeach
            </select>         
          <div class="input-group input-group-outline my-3">
              <label class="form-label">Name</label>
              <input type="text" class="form-control" name="name" required id="name" >
          </div>

          <!-- <div class="input-group input-group-outline my-3">
              
              <input type="file" class="form-control" name="picture" placeholder="Item Image" required>
          </div> -->

          <div class="input-group input-group-outline my-3">
              <label class="form-label">Quantity</label>
              <input type="number" class="form-control" name="quantity" min="1" required id="quantity">
          </div>

          <div class="input-group input-group-outline my-3">
              <label class="form-label">Unit Measurement</label>
              <input type="text" class="form-control" name="unit_measurement" min="1" required id="unit_measurement">
          </div>

          <div class="input-group input-group-outline my-3">
              <label class="form-label">Unit Cost</label>
              <input type="number" class="form-control" name="unit_cost" min="1" required id="unit_cost">
          </div>

          <div class="input-group input-group-outline my-3">
              <label class="form-label">Net Value</label>
              <input type="number" class="form-control" name="net_value" min="1" required id="net_value">
          </div>

          <button type="submt" class="btn btn-primary" >Update</button>
          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>

         </form>
         
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          
        </div>

      </div>
    </div>
</div>
  
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
  <script type="text/javascript">
    $(document).ready(function(){
      $(".update_stock").click(function(){
        
        var inventory_id = $(this).val();
        var url = '{{route("inventory_get")}}';
        var token = '{{Session::token()}}';

          $.ajax({
            method:'POST',
            url:url,
            data:{_token : token,inventory_id: inventory_id},
              success:function(data) {
                  console.log(data);
                  $("#order_title").text(data.name);
                  $("#inventory_id").val(data.id);
              }
          });
        

        });

      $(".update_inventory").click(function(){
        
        var inventory_id = $(this).val();
        var url = '{{route("inventory_get")}}';
        var token = '{{Session::token()}}';

          $.ajax({
            method:'POST',
            url:url,
            data:{_token : token,inventory_id: inventory_id},
              success:function(data) {
                  console.log(data);
                  $("#inventory_id_update").val(data.id);
                  $("#category_id").val(data.category_id);
                  $("#name").val(data.name);
                  $("#quantity").val(data.quantity);
                  $("#unit_measurement").val(data.unit_measurement);
                  $("#unit_cost").val(data.unit_cost);
                  $("#net_value").val(data.net_value);
                  
              }
          });
        

        });
      
    });
  </script>
</body>

</html>