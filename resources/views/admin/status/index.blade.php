@extends('admin.index')
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        @if(session('success'))
            <div class="alert alert-dark mb-0">{{session('success')}}</div>
        @endif
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Status Table</h4>
            </div>
            <div class="col-6">
                <a href="{{route("status.create")}}" class="btn btn-primary" style="float: right;">Add New</a>
            </div>
        </div>


      <!-- Basic Bootstrap Table -->
      <div class="card">
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th>Arabic Name</th>
                <th>English Name</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @if($status->count() > 0)
            @foreach($status as $key => $value)
              <tr>
                <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>
                    {{ $value->name_ar }}</strong></td>
                <td>{{ $value->name_en }}</td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('status.edit', ['id'=> $value->id]) }}"
                            ><i class="bx bx-edit-alt me-1"></i> Edit</a>
                        <a class="dropdown-item" href="{{ route('status.show', ['id'=> $value->id]) }}"
                            ><i class="bx bx-show-alt me-1"></i> Show</a>
                    {{ Form::open(['route' => ['status.destroy', $value->id], 'method' => 'delete','data--submit'=>'user'.$value->id]) }}
                      <button class="dropdown-item"><i class="bx bx-trash me-1"></i> Delete</button>
                    {{ Form::close() }}

                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
            @else
            <tr>
                <td>No Data Available</td>
            </tr>
            @endif
            </tbody>
          </table>
        </div>
      </div>
      <!--/ Basic Bootstrap Table -->
    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->

@endsection

