@extends('admin.index')
@section('content')

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Edit Order</h4>
      {{ Form::model($order,['method' => 'POST','route' => array('order.update', $order->id), 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'order'] ) }}
      {{ Form::hidden('id') }}

      <div class="row">
        <div class="col-md-6">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('address_from','Address From'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                {{ Form::text('address_from',old('address_from'),['placeholder' => 'Address From','class' =>'form-control', 'id' => 'defaultFormControlInput','aria-describedby' => 'defaultFormControlHelp','required', 'disabled']) }}
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('username','Username'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                <input type="text" value="{{optional($order->user)->username}}" class="form-control" id="defaultFormControlInput" aria-describedby="defaultFormControlHelp" name="user_id" disabled>
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('Activity Type','Activity Type'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                <input type="text" value="{{$order->activity_type->pluck('name_en')->implode(',')}}" class="form-control" id="defaultFormControlInput" aria-describedby="defaultFormControlHelp" name="activity_type_ids" disabled>
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('veichle type','veichle type'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                <input type="text" value="{{$order->veichle_type->name_en}}" class="form-control" id="defaultFormControlInput" aria-describedby="defaultFormControlHelp" name="veichle_type_id" disabled>
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('veichle type','veichle type'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                <input type="text" value="{{$order->veichle_type->name_en}}" class="form-control" id="defaultFormControlInput" aria-describedby="defaultFormControlHelp" name="veichle_type_id" disabled>
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
              <div class="card-body">
                  {{ Form::label('status','status'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                  <select class="form-control" name="status">
                    @foreach ($status as $sta)
                        <option value="{{ $sta->name_en }}" {{ ( $sta->name_en == $order->status) ? 'selected' : '' }}> {{ $sta->name_en }} </option>

                    @endforeach
                  </select>
              </div>
              <div class="container"><small class="help-block with-errors text-danger"></small></div>
            </div>
        </div>
        <div class="col-3">
            {{ Form::submit( 'Save', ['class'=>'btn btn-md btn-primary float-right']) }}
        </div>
            {{ Form::close() }}


    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
</div>
  <!-- Content wrapper -->
@endsection
