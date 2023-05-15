@extends('admin.indexdata')
@section('content')
<style>
    table tbody tr {
        border-color: #d9dee3 !important;
    }
    table.dataTable.no-footer {
        border-color: #d9dee3 !important;
    }
    .dataTables_wrapper .row:first-child,
    .dataTables_wrapper .row:last-child {
        padding: 0 20px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover{
        background: transparent !important;
        border-color: transparent !important;
    }
    table thead tr{
        background-color: #f5f5f9;
    }
</style>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        @if(session('success'))
            <div class="alert alert-dark mb-0">{{session('success')}}</div>
        @endif
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> cancell Table</h4>
            </div>
            <div class="col-6">
                <a href="{{route("cancell.create")}}" class="btn btn-primary" style="float: right;">Add New</a>
            </div>
        </div>


      <!-- Basic Bootstrap Table -->
    <div class="container">
        <div class="row">
            <div class="card" style="padding: 20px 0px;">
                <div class="col-12 table-responsive">
                    <table class="table user_datatable">
                        <thead class="table-border-bottom-0">
                            <tr>
                                <th>English Name</th>
                                <th>Arabic Name</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0"></tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>


      <!--/ Basic Bootstrap Table -->
    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
<script type="text/javascript">
    $(function () {
      var table = $('.user_datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('cancell.index') }}",
          columns: [
              {data: 'name_en', name: 'name_en'},
              {data: 'name_ar', name: 'name_ar'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });
  </script>
@endsection

