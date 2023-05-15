@extends('admin.index')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            @if(session('success'))
                <div class="alert alert-dark mb-0">{{session('success')}}</div>
            @endif
          <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

          <div class="row">
            <div class="col-md-12">
              <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <div class="card-body">
                  <div class="d-flex align-items-start align-items-sm-center gap-4">
                    @if ($admin->getFirstMediaUrl('avatar') != null)
                        <img src="{{$admin->getFirstMediaUrl('avatar')}}"alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                    @else
                    No Image
                    @endif
                    <div class="button-wrapper">
                        <input type="file" name="avatar" class="form-control" form="formAccountSettings">
                      </label>
                      <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                    </div>
                  </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                  <form id="formAccountSettings" method="POST" action="{{ route('admin.update', $admin->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$admin->id}}">
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="username" class="form-label">Username</label>
                            <input
                              class="form-control"
                              type="text"
                              id="username"
                              name="username"
                              value="{{$admin->username}}"
                              autofocus
                            />
                          </div>
                        <div class="mb-3 col-md-4">
                            <label for="email" class="form-label">Email</label>
                            <input
                              class="form-control"
                              type="email"
                              id="email"
                              name="email"
                              value="{{$admin->email}}"
                              autofocus
                            />
                          </div>
                        <div class="mb-3 col-md-4">
                            <label for="password" class="form-label">password</label>
                            <input
                              class="form-control"
                              type="password"
                              id="password"
                              name="password"
                              value=""
                              autofocus
                            />
                          </div>

                    </div>
                    <div class="mt-2">
                      <button type="submit" class="btn btn-primary me-2">Save changes</button>
                    </div>
                  </form>
                </div>
                <!-- /Account -->
              </div>
            </div>
          </div>
        </div>
        <!-- / Content -->


        <div class="content-backdrop fade"></div>
      </div>
      <!-- Content wrapper -->
@endsection
