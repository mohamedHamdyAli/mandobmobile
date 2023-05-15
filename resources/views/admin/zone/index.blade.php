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
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Zone Table</h4>
            </div>
            <div class="col-6">
                <small class="text-light fw-semibold">Default</small>
                <div class="mt-3" style="float: right;">
                <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal" >
                        Import zone
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                            </div>
                            <div class="modal-body">
                            <div class="row">
                                <form id="formAccountSettings" action="{{ route('zone.import') }}" method="POST" enctype="multipart/form-data"style="float: right;">
                                    @csrf
                                    <div class="form-group mb-4">
                                        <div class="custom-file text-left">
                                            <input type="file" name="file" class="form-control" id="customFile" required>
                                            {{-- <label class="custom-file-label" for="customFile">Choose file</label> --}}
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button class="btn btn-primary">Import Zones</button>
                                </form>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <a class="btn btn-success" href="{{ route('zone.export') }}">Export Zones</a>
                    <a href="{{route("zone.create")}}" class="btn btn-primary" >Add New</a>

                </div>

            </div>
        </div>

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
          ajax: "{{ route('zone.index') }}",
          columns: [
              {data: 'name_en', name: 'name_en'},
              {data: 'name_ar', name: 'name_ar'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });
  </script>
@endsection

