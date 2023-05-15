@extends('admin.index')
@section('content')

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> {{$pageTitle}}</h4>
      {{ Form::model($veichledata,['method' => 'POST','route'=>'veichle.store', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'veichle'] ) }}
      {{ Form::hidden('id') }}

      <div class="row">
        <div class="col-md-6">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('name_ar','Arabic Name'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                {{ Form::text('name_ar',old('name_ar'),['placeholder' => 'Arabic Name','class' =>'form-control', 'id' => 'defaultFormControlInput','aria-describedby' => 'defaultFormControlHelp','required']) }}
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('name_en','English Name'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                {{ Form::text('name_en',old('name_en'),['placeholder' => 'English Name','class' =>'form-control', 'id' => 'defaultFormControlInput','aria-describedby' => 'defaultFormControlHelp','required']) }}
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('max_num_km','max number of km'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                {{ Form::number('max_num_km',old('max_num_km'),['placeholder' => 'max_num_km','class' =>'form-control', 'id' => 'defaultFormControlInput','aria-describedby' => 'defaultFormControlHelp','required']) }}
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('extra_price','extra price'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                {{ Form::number('extra_price',old('extra_price'),['placeholder' => 'extra_price','class' =>'form-control', 'id' => 'defaultFormControlInput','aria-describedby' => 'defaultFormControlHelp','required']) }}
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('amount','Amount'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                {{ Form::number('amount',old('amount'),['placeholder' => 'Amount','class' =>'form-control', 'id' => 'defaultFormControlInput','aria-describedby' => 'defaultFormControlHelp','required']) }}
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    @if ($veichledata->getFirstMediaUrl('veichle_image') != null)
                        <img src="{{$veichledata->getFirstMediaUrl('veichle_image')}}"alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                    @endif
                    <div class="button-wrapper">
                        <input type="file" name="veichle_image" class="form-control">
                      </label>
                      <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                    </div>
                  </div>
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
