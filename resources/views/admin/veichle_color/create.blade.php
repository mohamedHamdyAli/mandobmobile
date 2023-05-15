@extends('admin.index')
@section('content')

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> {{$pageTitle}}</h4>
      {{ Form::model($veichle_colordata,['method' => 'POST','route'=>'veichle_color.store', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'veichle_color'] ) }}
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
                  <div class="d-flex align-items-start align-items-sm-center gap-4">
                      @if ($veichle_colordata->getFirstMediaUrl('veichle_color') != null)
                          <img src="{{$veichle_colordata->getFirstMediaUrl('veichle_color')}}"alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                      @endif
                      <div class="button-wrapper">
                          <input type="file" name="veichle_color" class="form-control">
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
