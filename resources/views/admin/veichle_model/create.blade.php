@extends('admin.index')
@section('content')

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> {{$pageTitle}}</h4>
      {{ Form::model($veichle_modeldata,['method' => 'POST','route'=>'veichle_model.store', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'veichle_model'] ) }}
      {{ Form::hidden('id') }}

      <div class="row">
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('name_ar','Arabic Name'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                {{ Form::text('name_ar',old('name_ar'),['placeholder' => 'Arabic Name','class' =>'form-control', 'id' => 'defaultFormControlInput','aria-describedby' => 'defaultFormControlHelp','required']) }}
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('name_en','English Name'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                {{ Form::text('name_en',old('name_en'),['placeholder' => 'English Name','class' =>'form-control', 'id' => 'defaultFormControlInput','aria-describedby' => 'defaultFormControlHelp','required']) }}
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
              <div class="card-body">
                  {{ Form::label('vehicle_brand_id','vehicle brand'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                  <select class="form-control select2js" name="vehicle_brand_id">
                  @foreach ($vichle_brand as $item)
                    <option value="{{ $item->id }}" {{ ( $item->id == $veichle_modeldata->vehicle_brand_id) ? 'selected' : '' }}> {{ $item->name_en }} </option>
                  @endforeach    </select>
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
