@extends('admin.index')
@section('content')
<div class="content-wrapper">
    <!-- Content -->


    <div class="container-xxl flex-grow-1 container-p-y">
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> {{$pageTitle}}</h4>
      {{ Form::model($userdata,['method' => 'POST','route'=>'users.store', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'user'] ) }}
      {{ Form::hidden('id') }}

      <div class="row">
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('first_name','Firstname',['class'=>'form-control-label'], false ) }}
                {{ Form::text('first_name',old('first_name'),['placeholder' => 'Firstname','class' =>'form-control', 'id' => 'defaultFormControlInput','aria-describedby' => 'defaultFormControlHelp']) }}
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('last_name','Last Name',['class'=>'form-control-label'], false ) }}
                {{ Form::text('last_name',old('last_name'),['placeholder' => 'Last Name','class' =>'form-control', 'id' => 'defaultFormControlInput','aria-describedby' => 'defaultFormControlHelp']) }}
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('username','Username'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                {{ Form::text('username',old('username'),['placeholder' => 'Username','class' =>'form-control', 'id' => 'defaultFormControlInput','aria-describedby' => 'defaultFormControlHelp','required']) }}
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('email','Email'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                {{ Form::text('email',old('email'),['placeholder' => 'Email','class' =>'form-control', 'id' => 'defaultFormControlInput','aria-describedby' => 'defaultFormControlHelp','required']) }}
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('phone','Phone'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                {{ Form::text('phone',old('phone'),['placeholder' => 'Phone','class' =>'form-control', 'id' => 'defaultFormControlInput','aria-describedby' => 'defaultFormControlHelp','required']) }}
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        @if ($userdata->id == null)
            <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    {{ Form::label('password','Password'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required']) }}
                </div>
                <div class="container"><small class="help-block with-errors text-danger"></small></div>
            </div>
            </div>
        @endif
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('contact_number','Contact Number',['class'=>'form-control-label'], false ) }}
                {{ Form::text('contact_number',old('contact_number'),['placeholder' => 'Contact Number','class' =>'form-control']) }}
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('status','status'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                {{ Form::select('status',['1' => 'Active' , '0' => 'Inactive' ],old('status'),[ 'id' => 'role' ,'class' =>'form-control select2js','required']) }}
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-body">
                {{ Form::label('zone_id','Zone'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                <select class="form-control select2js" name="zone_id">
                @foreach ($zones as $item)
                  <option value="{{ $item->id }}" {{ ( $item->id == $userdata->zone_id) ? 'selected' : '' }}> {{ $item->name_en }} </option>
                @endforeach    </select>
            </div>
            <div class="container"><small class="help-block with-errors text-danger"></small></div>
          </div>
        </div>
        <div class="col-md-12">
            <div class="card mb-4">
              <div class="card-body">
                  {{ Form::label('address','Address'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                  {{ Form::textarea('address', null, ['class'=>"form-control textarea" , 'rows'=>3  , 'placeholder'=>'Address' ]) }}
              </div>
              <div class="container"><small class="help-block with-errors text-danger"></small></div>
            </div>
        </div>
      </div>
      {{ Form::submit( 'Save', ['class'=>'btn btn-md btn-primary float-right']) }}
      {{ Form::close() }}


    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
</div>
  <!-- Content wrapper -->
@endsection
