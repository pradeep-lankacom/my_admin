@extends('admin.layouts.admin')

@section('content')
    <div class='row'>
       <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ (!empty($permission->id))? "Update" : "Create" }} Permission</h3>
                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body">

                <form class="form-horizontal" action="{{ (!empty($permission->id)) ? "/admin/permissions/store" : "/admin/permissions/store" }}" method="POST" id="store-permission-form" autocomplete="off">
                    {{ csrf_field() }}
                    {{-- {{ method_field('PUT') }} --}}

                    <input type="hidden" name="permission_id" id="permission_id" value="{{ (!empty($permission->id))? $permission->id : "" }}">

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Name</label>
                        <div class="col-lg-10">
                            @if (!empty($permission->name))
                                <label class="form-control">{{ $permission->name }}</label>
                                <input type="hidden" name="name" id="name" value="{{ (!empty($permission->name))? $permission->name : "" }}">
                            @else
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Permission Name">
                                <span class="text-danger" for="name" id="name-error"></span>
                            @endif
                            {{-- <label class="form-control">{{ $permission->name ?: "" }}</label> --}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Description</label>
                        <div class="col-lg-10">
                            <input type="description" name="description" id="description" placeholder="Description" class="form-control" value="{{ (!empty($permission->description)) ? $permission->description : old('description') }}">
                            <span class="text-danger" for="description" id="description-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Slug</label>
                        <div class="col-lg-10">
                            <input type="text" name="slug" id="slug" placeholder="Slug" class="form-control" value="{{ (!empty($permission->slug)) ? $permission->slug : old('slug') }}">
                            <span class="text-danger" for="slug" id="slug-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Breadcrumb</label>
                        <div class="col-lg-10">
                            <input type="text" name="breadcrumb" id="breadcrumb" placeholder="Breadcrumb" class="form-control" value="{{ (!empty($permission->breadcrumb)) ? $permission->breadcrumb : old('breadcrumb') }}">
                            <span class="text-danger" for="breadcrumb" id="breadcrumb-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Title</label>
                        <div class="col-lg-10">
                            <input type="text" name="title" id="title" placeholder="Title" class="form-control" value="{{ (!empty($permission->title)) ? $permission->title : old('title') }}">
                            <span class="text-danger" for="title" id="title-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-sm btn-primary" type="button" id="store-permission">{{ (!empty($permission->id))? "Update" : "Save" }}</button>
                            <button class="btn btn-sm btn-primary" type="reset">Reset</button>
                        </div>
                    </div>

                </form>

            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- /.box-footer-->
        </div><!-- /.box -->
       </div>
    </div><!-- /.row -->
@endsection

@section('script')
    <script type="text/javascript" src="{{ URL::asset('js/custom/permission/form.js') }}"></script>
@endsection