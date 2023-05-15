@extends('admin.index')
@section('content')
<style>
    .space-around{
        margin-bottom: 3%;
    }
</style>
<div class="container">
    <div class="card mb-4">
        <h5 class="card-header">Settings</h5>
        <div class="card-body">
        <div class="row">
            <!-- Custom content with heading -->
            <div class="col-lg-12 mb-12 mb-xl-0">
            <div class="mt-3">
                <form id="formAccountSettings" method="POST" action="{{ route('setting.update', $setting->id) }}" enctype="multipart/form-data">
                    @csrf
                <input type="hidden" name="id" value="{{$setting->id}}">
                <div class="row">
                <div class="col-md-2 col-12 mb-2 mb-md-2">
                    <div class="list-group">
                    <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list" href="#list-home" >Config</a >
                    </div>
                </div>
                    <div class="col-md-10 col-12">
                        <div class="tab-content p-0">
                        <div class="tab-pane fade show active" id="list-home">
                            <div class="row">
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="name_en"> Site Name English </label>
                                            <input type="text" name="name_en" value="{{$setting->name_en}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="name_ar"> Site Name Arabic </label>
                                            <input type="text" name="name_ar" value="{{$setting->name_ar}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="logo_image">Logo</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="button-wrapper">
                                                        <input type="file" name="logo_image" class="form-control" form="formAccountSettings">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    @if ($setting->getFirstMediaUrl('logo_image') != null)
                                                        <img src="{{$setting->getFirstMediaUrl('logo_image')}}"alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                                    @else
                                                    No Image
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="logo_image">Favicon</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="button-wrapper">
                                                        <input type="file" name="fav_image" class="form-control" form="formAccountSettings">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    @if ($setting->getFirstMediaUrl('fav_image') != null)
                                                        <img src="{{$setting->getFirstMediaUrl('fav_image')}}"alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                                    @else
                                                    No Image
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="description_en"> Site Description English </label>
                                            <textarea class="form-control" name="description_en" id="description_en" cols="10" rows="4">{{$setting->description_en}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="description_ar"> Site Description Arabic </label>
                                            <textarea class="form-control" name="description_ar" id="description_ar" cols="10" rows="4">{{$setting->description_ar}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="facebook_url"> facebook url </label>
                                            <input type="text" name="facebook_url" value="{{$setting->facebook_url}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="twitter_url"> twitter url </label>
                                            <input type="text" name="twitter_url" value="{{$setting->twitter_url}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="linkedin_url"> linkedin url </label>
                                            <input type="text" name="linkedin_url" value="{{$setting->linkedin_url}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="instgram_url"> instgram url </label>
                                            <input type="text" name="instgram_url" value="{{$setting->instgram_url}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="youtube_url"> youtube url </label>
                                            <input type="text" name="youtube_url" value="{{$setting->youtube_url}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="Help_number"> Help Phone number </label>
                                            <input type="phone" name="Help_number" value="{{$setting->Help_number}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="email"> email </label>
                                            <input type="email" name="email" value="{{$setting->email}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="currency"> currency </label>
                                            <input type="text" name="currency" value="{{$setting->currency}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="wallet_user"> wallet user </label>
                                            <input type="text" name="wallet_user" value="{{$setting->wallet_user}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="wallet_driver"> wallet driver </label>
                                            <input type="text" name="wallet_driver" value="{{$setting->wallet_driver}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-6">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="wallet_driver_completed"> driver percentage </label>
                                            <input type="number" name="wallet_driver_completed" value="{{$setting->wallet_driver_completed}}" class="form-control">
                                            <span style="font-size: 11px;">The percentage of the driver is a maximum of 100%.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                    </div>
                </div>
            </form>

            </div>
            </div>
            <!--/ Custom content with heading -->
        </div>
        </div>
    </div>
</div>
@endsection
