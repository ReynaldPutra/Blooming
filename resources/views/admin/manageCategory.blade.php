
@extends('layout')
@section('title','Update Item')
@section('style')
<link rel="stylesheet" href="{{ asset('/css/manageItem.css') }}"/>
@endsection

@section('content')
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-white" id="sidebar-wrapper">

        <div class="list-group list-group-flush my-3">

            <a href="/dashboard" class="list-group-item list-group-item-action bg-transparent nav-link select_nav"><i
                    class="fas fa-th-large me-2"></i>Dashboard</a>
            <a href="/viewOrder" class="list-group-item list-group-item-action bg-transparent  nav-link select_nav"><i
                    class="fas fa-truck-loading me-2"></i>Manage Order</a>
            <a href="/viewItem" class="list-group-item list-group-item-action bg-transparent  nav-link select_nav"><i
              class="fas fa-boxes me-2"></i>Manage Item</a>
            <a href="/addItem" class="list-group-item list-group-item-action bg-transparent   nav-link select_nav"><i
              class="fas fa-box me-2"></i>Add Item</a>
            <a href="/viewCategory" class="list-group-item list-group-item-action bg-transparent  nav-link select_nav"><i
                class="fas fa-layer-group me-2"></i>Manage Category</a>
            <a href="/addCategory" class="list-group-item list-group-item-action bg-transparent   nav-link select_nav"><i
                  class="fas fa-plus me-2"></i>Add Category</a>


        </div>
    </div>
    <div id="page-content-wrapper">
        <div class="d-flex align-items-center px-5  mt-5">
            <i class="fas fa-align-right primary-text fs-4 me-3" id="menu-toggle"></i>
        </div>


        <div class="container-fluid px-4">
          <h1 class=" fw-bold text-center text-uppercase">Manage Category</h1>
          @if(session()->has('success'))
          <div class="alert alert-dark alert-dismissible fade show d-flex" role="alert">
            <span>{{session('success')}}</span>
            <button type="button" class="close bg-danger text-light border-1 border-danger ms-auto px-2 rounded" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif

          <form action="/viewCategory" type="get" class="searchbar mx-auto mb-5 mt-4">
            <div class="input-group justify-content-center ">
              <input type="text" class="form-control " name="search" value = "{{request('search')}}" placeholder="Search product..." aria-label="Search product..." aria-describedby="button-addon2" >
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Search</button>
              </div>
            </div>
          </form>

            @if($category->count())
            <div class="table-responsive mt-4">
              <table class="table table-striped table-bordered table-sm">
                <thead class="table-dark">
                  <tr>
                    <th>No</th>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Category Description</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($category as $p)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$p->id}}</td>
                      <td>{{$p->name}}</td>
                      <td>{{$p->description}}</td>

                      <td class="update-delete" class="btn-group">
                        <a href="/updateCategory/{{$p->id}}" class="btn btn-sm btn-primary update ">Update</a>
                        <form action="/deleteCategory/{{$p->id}}" method="post" class="btn btn-sm " style="padding:0; margin-left:0">
                          @method('delete')
                          @csrf
                          <input type="hidden" name="id" value="{{$p->id}}" >
                          <button  onclick="return confirm('Are You Sure To Delete This Category? All the Item with this Category will be Delete !!')" type="submit"  class="btn btn-sm btn-danger delete">Delete</button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3 mb-5">
              {{ $category->links() }}
          </div>
          @else
          <div class="no-items mt-5">
            <h3 class="text-center">Oops!</h3>
            <h5 class="text-center">No items yet</h5>
            <p class="text-center"><a href="/addItem" class="text-decoration-none" >Add an item first 👉</a></p>
          </div>
        @endif

        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    var el = document.getElementById("wrapper");
    var toggleButton = document.getElementById("menu-toggle");

    function setInitialIcon() {
        if (window.innerWidth >= 768) {
            toggleButton.classList.remove("fa-align-left");
            toggleButton.classList.add("fa-align-right");
        } else {
            toggleButton.classList.remove("fa-align-right");
            toggleButton.classList.add("fa-align-left");
        }
    }

    window.onload = setInitialIcon;
    window.onresize = setInitialIcon;

    toggleButton.onclick = function () {
        el.classList.toggle("toggled");
        if (toggleButton.classList.contains("fa-align-left")) {
            toggleButton.classList.remove("fa-align-left");
            toggleButton.classList.add("fa-align-right");
        } else {
            toggleButton.classList.remove("fa-align-right");
            toggleButton.classList.add("fa-align-left");
        }
    };
</script>
@endsection