@extends('admin.layouts.admin')

@section('content')
    <div class='row'>
       <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ (!empty($user->id))? "Update" : "Create" }} User</h3>
                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body">

                <form method="post" class="form-horizontal" action="{{ (!empty($user->id)) ? "/admin/user/update" : "/admin/user/store" }}" id="store-user-form" autocomplete="off">
                    {{ csrf_field() }}

                    <input type="hidden" name="id" id="id" value="{{ (!empty($user->id)) ? $user->id : "" }}">
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Name <font color="red">*</font></label>
                        <div class="col-lg-8">
                            <input type="text" id="name" name="name" class="form-control" value="{{ (!empty($user->name)) ? $user->name : old('name') }}" placeholder="Name">
                            <span class="text-danger" for="name" id="name-error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label">Email Address <font color="red">*</font></label>
                        <div class="col-lg-8">
                            <input type="email" id="email" name="email" class="form-control" value="{{ (!empty($user->email)) ? $user->email : old('email') }}" placeholder="Email Address">
                            <span class="text-danger" for="email" id="email-error"></span>
                        </div>
                    </div>

                    @if (empty($user->id))
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Role(s) <font color="red">*</font></label>
                            <div class="col-lg-8">
                                <select name="role_id" id="role_id" class="form-control">
                                    @foreach ($roles as $key => $value)
                                        <option value="{{$value->id}}" {{(!empty($user->role_id)) ? in_array($value->id, (array) $user->role_id)? "selected":"" : old('role_id')}}>{{$value->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" for="role_id" id="role_id-error"></span>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="col-lg-4 control-label">Profile Image </label>
                        <div class="col-lg-8">
                            <input type="file" id="image" name="image" class="form-control" value="{{ (!empty($user->image)) ? $user->image : old('image') }}">
                            <span class="text-danger" for="image" id="image-error"></span>
                            <img id="preview_profile_image" src="@if (!empty($user->image)) /images/user/profile_image/{{$user->image}} @else /images/user/profile_image/default.png @endif" style="width: 73px;height: 67px;" alt="Profile Image" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <button class="btn btn-sm btn-primary" type="button" id="store-user">{{ (!empty($user->id))? "Update" : "Save" }}</button>
                            <button class="btn btn-sm btn-white" type="reset">Reset</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="messages"></div>
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
    <script type="text/javascript" src="{{ URL::asset('js/custom/user/form.js') }}"></script>
@endsection