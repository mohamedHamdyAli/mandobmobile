@extends('admin.index')
@section('content')
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<style>
    .space-around{
        margin-bottom: 3%;
    }
    .ck-editor__editable_inline {
        min-height: 400px;
    }
</style>
<div class="container">
    <div class="card mb-4">
        <h5 class="card-header">About</h5>
        <div class="card-body">
        <div class="row">
            <!-- Custom content with heading -->
            <div class="col-lg-12 mb-12 mb-xl-0">
            <div class="mt-3">
                <form id="formAccountSettings" method="POST" action="{{ route('about.update', $about->id) }}" enctype="multipart/form-data">
                    @csrf
                <input type="hidden" name="id" value="{{$about->id}}">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="tab-content p-0">
                        <div class="tab-pane fade show active" id="list-home">
                            <div class="row">
                                <div class="space-around col-md-12">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="title"> Arabic Title </label>
                                            <input type="text" name="title" value="{{$about->title}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-12">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="title"> English Title </label>
                                            <input type="text" name="title_en" value="{{$about->title_en}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="space-around col-md-12">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="text">Arabic Description  </label>
                                            <div class="... ck-editor__editable ck-editor__editable_inline ...">
                                                <textarea class="form-control" id="body" name="text" rows="12" cols="12">{{$about->text}}</textarea>
                                            </div>
                                        </div>
                                </div>
                                <div class="space-around col-md-12">
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <label for="text">English Description  </label>
                                            <div class="... ck-editor__editable ck-editor__editable_inline ...">
                                                <textarea class="form-control" id="body2" name="text_en" rows="12" cols="12">{{$about->text_en}}</textarea>
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
<script>
    ClassicEditor
    .create( document.querySelector( '#body' ) )
    .catch( error => {
    console.error( error );
    } );
    ClassicEditor
    .create( document.querySelector( '#body2' ) )
    .catch( error => {
    console.error( error );
    } );
    </script>

@endsection
