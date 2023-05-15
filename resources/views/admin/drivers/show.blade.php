@extends('admin.index')
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> User : {{$driver->username}}</h4>

      <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <!-- List group Flush (Without main border) -->
            <div class="col-lg-12 mb-12 mb-xl-0">
              <div class="demo-inline-spacing mt-3">
                <div class="list-group list-group-flush">
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    Driver Name : {{$driver->username}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    Phone Number : {{$driver->phone}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    Driver Rate : {{$final_rate}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    Email : {{$driver->email}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    Address : {{$driver->address}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    User Type : {{$driver->user_type}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    veichel : {{optional($driver->veichle_type)->name_en}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    vehicle brand : {{optional($driver->vehicle_brand)->name_en}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    vehicle model : {{optional($driver->vehicle_model)->name_en}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    vehicle color : {{optional($driver->vehicle_color)->name_en}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    vehicle color : {{$driver->vehicle_year}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    vehicle color : {{$driver->vehicle_plate_number}}</a>
                </div>
              </div>
            </div>
            <!--/ List group Flush (Without main border) -->
          </div>
        </div>
      </div>

    </div>
    <!-- / Content -->

    <!-- Footer -->
    <!-- / Footer -->

    <div class="content-backdrop fade"></div>
  </div>
  <!-- Content wrapper -->
@endsection
