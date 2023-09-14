@extends('dashboard.layout.master')
@section('content')
<main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <h4 class="font-weight-bolder text-white mb-0">Products / Services</h4> </nav>
                    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner"> <i class="sidenav-toggler-line bg-white"></i> <i class="sidenav-toggler-line bg-white"></i> <i class="sidenav-toggler-line bg-white"></i> </div>
                            </a>
                        </li>
                        <li class="nav-item px-5 d-flex align-items-center">
                            <a href="{{route('logout')}}" class="btn btn-danger">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 c-header">
                        <h6>Products&nbsp;</h6>
                        @if(auth()->user()->role == 'admin')
                        <button type="button" class="btn-client" onclick="newProduct()"> Add New </button>
                        @else
                        <button type="button" class="btn-client" onclick="userAlert()"> Add New </button>
                        @endif
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">price</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">description</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr id="row_{{$product->id}}">
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{$product->name}}</p>
                                          </td>
                                        <td>
                                          <p class="text-xs font-weight-bold mb-0">Rs {{number_format($product->price, 0 ,'.' , ',')}}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{$product->description}}</p>
                                        </td>
                                        @if(auth()->user()->role == 'admin')
                                        <td class="align-middle">
                                            <a href="javascript:;" class="btn btn-outline-info btn-sm" onclick="editProduct({{$product}})">Edit</a>
                                            <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm" data-id={{$product->id}} onclick="deleteRow({{$product->id}})">Delete</a>
                                        </td>
                                        @else
                                        <td class="align-middle">
                                            <a href="javascript:void(0);" class="btn btn-outline-info btn-sm" onclick="userAlert()">Edit</a>
                                            <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm" onclick="userAlert()">Delete</a>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <br>
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- MODAL -->
@include('dashboard.modals.add-product')
@endsection
@section('scripts')
<script>
    $('#productForm').submit(function(e) {
         $(':input[type="submit"]').prop('disabled', true);
       e.preventDefault();
       //data
       var url = $(this).attr('action');
       //send request
       var submit_r = $.ajax({
           type: "POST",
           url: url,
           dataType: "json",
           data: $('form').serialize(),
            success: function(data) {
                Swal.fire(
                    data.msg,
                    '',
                    'success'
                    ).then((result) => {
                        location.reload();
                    }
                );
                    $('#productForm').trigger("reset");
                    $('#productModal').modal('toggle');
            },
            error: function(data, textStatus, xhr) {
                Swal.fire(
                    data.responseJSON.msg,
                    '',
                    'danger'
                );
            }
       });
  });
  function newProduct(){
    $('#productForm').trigger("reset");
    $('#productModal').modal('toggle');
    $('#product_modal_heading').text('Add Product / Service');
    $('#product_modal_btn').text('Save');
  }
  function deleteRow(entry_id) {
        if(confirm('Are you sure you want to delete this product ?')){
            var token = $("meta[name='csrf-token']").attr("content");
            var submit_r = $.ajax({
                url: "products/"+entry_id,
                type: 'DELETE',
                data: {
                    "id": entry_id,
                    "_token": token,
                },
                success: function(data) {
                    Swal.fire(
                        data.msg,
                        '',
                        'success'
                        ).then((result) => {
                            $('#row_'+entry_id).hide('slow');
                        });
                },
                error: function(data, textStatus, xhr) {
                    Swal.fire(
                        data.responseJSON.msg,
                        '',
                        'danger'
                    );
                }
            });
        }
  }
    let product;
    function editProduct(product){
        $('#productModal').modal('toggle');
        $('#product_modal_heading').text('Edit Product / Service');
        $('#product_modal_btn').text('Update');
        $("input[name=id]").val(product.id);
        $("input[name=name]").val(product.name);
        $("input[name=price]").val(product.price);
        $("textarea#product_description").val(product.description);
    }
   </script>
   <script src="{{asset('assets/js/plugins/sweat-alert.js')}}"></script>
@endsection