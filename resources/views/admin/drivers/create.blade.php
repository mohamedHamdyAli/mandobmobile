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
      {{ Form::model($driverdata,['method' => 'POST','route'=>'drivers.store', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'user'] ) }}
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
        @if ($driverdata->id == null)
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
                  {{ Form::label('vehicle_plate_number','vehicle plate number',['class'=>'form-control-label'], false ) }}
                  {{ Form::text('vehicle_plate_number',old('vehicle_plate_number'),['placeholder' => 'car characters','class' =>'form-control']) }}
              </div>
              <div class="container"><small class="help-block with-errors text-danger"></small></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    {{ Form::label('vehicle_color_id','vehicle color',['class'=>'form-control-label'], false ) }}
                    <select class="form-control select2js" name="vehicle_color_id">
                        @foreach ($vehicle_colors as $item)
                          <option value="{{ $item->id }}" {{ ( $item->id == $driverdata->vehicle_color_id) ? 'selected' : '' }}> {{ $item->name_en }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="container"><small class="help-block with-errors text-danger"></small></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    {{ Form::label('vehicle_year','vehicle year',['class'=>'form-control-label'], false ) }}
                    {{ Form::text('vehicle_year',old('vehicle_year'),['placeholder' => 'vehicle year','class' =>'form-control']) }}
                </div>
                <div class="container"><small class="help-block with-errors text-danger"></small></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    {{ Form::label('vehicle_model_id','vehicle model',['class'=>'form-control-label'], false ) }}
                    <select class="form-control select2js" name="vehicle_model_id">
                        @foreach ($vehicle_model as $item)
                          <option value="{{ $item->id }}" {{ ( $item->id == $driverdata->vehicle_model_id) ? 'selected' : '' }}> {{ $item->name_en }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="container"><small class="help-block with-errors text-danger"></small></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    {{ Form::label('vehicle_brand_id','vehicle brand',['class'=>'form-control-label'], false ) }}
                    <select class="form-control select2js" name="vehicle_brand_id">
                        @foreach ($vehicle_brands as $item)
                          <option value="{{ $item->id }}" {{ ( $item->id == $driverdata->vehicle_brand_id) ? 'selected' : '' }}> {{ $item->name_en }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="container"><small class="help-block with-errors text-danger"></small></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    {{ Form::label('veichle_type_id','veichle',['class'=>'form-control-label'], false ) }}
                    <select class="form-control select2js" name="veichle_type_id">
                        @foreach ($veichles as $item)
                          <option value="{{ $item->id }}" {{ ( $item->id == $driverdata->veichle_type_id) ? 'selected' : '' }}> {{ $item->name_en }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="container"><small class="help-block with-errors text-danger"></small></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
              <div class="card-body">
                <label>profile image</label>
                  <div class="d-flex align-items-start align-items-sm-center gap-4">
                      @if ($driverdata->getFirstMediaUrl('profile_image') != null)
                          <img src="{{$driverdata->getFirstMediaUrl('profile_image')}}"alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                      @endif
                      <div class="button-wrapper">
                          <input type="file" name="profile_image" class="form-control">
                        </label>
                      </div>
                    </div>
              </div>
              <div class="container"><small class="help-block with-errors text-danger"></small></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
              <div class="card-body">
                <label>driver licnse</label>

                  <div class="d-flex align-items-start align-items-sm-center gap-4">
                      @if ($driverdata->getFirstMediaUrl('driver_licnse') != null)
                          <img src="{{$driverdata->getFirstMediaUrl('driver_licnse')}}"alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                      @endif
                      <div class="button-wrapper">
                          <input type="file" name="driver_licnse" class="form-control">
                        </label>
                      </div>
                    </div>
              </div>
              <div class="container"><small class="help-block with-errors text-danger"></small></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
              <div class="card-body">
                <label>registration sicker</label>
                  <div class="d-flex align-items-start align-items-sm-center gap-4">
                      @if ($driverdata->getFirstMediaUrl('registration_sicker') != null)
                          <img src="{{$driverdata->getFirstMediaUrl('registration_sicker')}}"alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                      @endif
                      <div class="button-wrapper">
                          <input type="file" name="registration_sicker" class="form-control">
                        </label>
                      </div>
                    </div>
              </div>
              <div class="container"><small class="help-block with-errors text-danger"></small></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
              <div class="card-body">
                <label>vehicle insurance</label>
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                      @if ($driverdata->getFirstMediaUrl('vehicle_insurance') != null)
                          <img src="{{$driverdata->getFirstMediaUrl('vehicle_insurance')}}"alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                      @endif
                      <div class="button-wrapper">
                          <input type="file" name="vehicle_insurance" class="form-control">
                        </label>
                      </div>
                    </div>
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
                  <option value="{{ $item->id }}" {{ ( $item->id == $driverdata->zone_id) ? 'selected' : '' }}> {{ $item->name_en }} </option>
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
