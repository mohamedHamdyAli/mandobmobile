@extends('admin.index')
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

      <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Username /</span> {{ optional($order->user)->username }}</h4>
        <div class="row mb-4">
          <!-- Basic Alerts -->
          <div class="col-md mb-4 mb-md-0">
            <div class="card">
              <h5 class="card-header">Order Details</h5>
              <div class="card-body">
                <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    Address From : {{$order->address_from}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    Note : {{$order->note}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    Status : {{$order->status}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    total cost : {{$order->total_cost}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    activity type : {{$order->activity_type->pluck('name_en')->implode(',')}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    veichle type : {{$order->veichle_type->name_en}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    Zone : @php
                        $order->zone == '' ? 'No Zone' : $order->zone->name_en
                    @endphp</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    order date : {{$order->order_date}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    order time : {{$order->order_time}}</a>
              </div>
            </div>
          </div>
          <!--/ Basic Alerts -->
          <!-- Dismissible Alerts -->
          <div class="col-md">
            <div class="card">
              <h5 class="card-header">Order Request Details <span> ({{$order_request->count()}} Orders) </span></h5>
              <div class="card-body">
                <div id="accordionIcon" class="accordion mt-3 accordion-without-arrow">
                @php $i = 0; @endphp
                @foreach ($order_request as $order_req)
                @php $i ++; @endphp
                <div class="accordion-item card">
                    <h2 class="accordion-header text-body d-flex justify-content-between" id="accordionIconOne">
                      <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                        data-bs-target="#accordionIcon-{{$i}}" aria-controls="accordionIcon-{{$i}}" > order {{$i}} </button>
                    </h2>
                    <div id="accordionIcon-{{$i}}" class="accordion-collapse collapse" data-bs-parent="#accordionIcon">
                      <div class="accordion-body">
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                                address to : {{$order_req->address_to}}</a>
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                                order name : {{$order_req->order_name}}</a>
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                                client name : {{$order_req->client_name}}</a>
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                                phone : {{$order_req->phone}}</a>
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                                block : {{$order_req->block}}</a>
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                                buliding num : {{$order_req->buliding_num}}</a>
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                                road : {{$order_req->road}}</a>
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                                flat office : {{$order_req->flat_office}}</a>
                          </div>
                    </div>
                </div>
                @endforeach
              </div>
              </div>
            </div>
          </div>
          <!--/ Dismissible Alerts -->
        </div>
      </div>


      {{-- <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <!-- List group Flush (Without main border) -->
            <div class="col-lg-12 mb-12 mb-xl-0">
              <div class="demo-inline-spacing mt-3">
                <div class="list-group list-group-flush">
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    Address From : {{$order->address_from}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    Note : {{$order->note}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    Status : {{$order->status}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    total cost : {{$order->total_cost}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    activity type : {{$order->activity_type->pluck('name_en')->implode(',')}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    veichle type : {{$order->veichle_type->name_en}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    Zone : {{$order->zone->name_en}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    order date : {{$order->order_date}}</a>
                  <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                    order time : {{$order->order_time}}</a>

                </div>
              </div>
            </div>
            <!--/ List group Flush (Without main border) -->
          </div>
        </div>
      </div> --}}

    </div>
    <!-- / Content -->

    <!-- Footer -->
    <!-- / Footer -->

    <div class="content-backdrop fade"></div>
  </div>
  <!-- Content wrapper -->
@endsection
