@extends('admin.layouts.admin')

@section('content')
    <div class='row'>
       <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Role Tasks</h3>
                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body">

                <form method="post" class="form-horizontal" action="{{ (!empty($id)) ? "/admin/roles/update" : "/admin/roles/store" }}" id="store-role-form" autocomplete="off">

                    {{csrf_field()}}
                    {{ (!empty($id))? method_field('PUT') : method_field('POST') }}

                    <input type="hidden" id="id" name="id" value="{{ (!empty($id)) ? $id : '' }}">

                    <div class="col-sm-4">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Name <span style="color: red;">*</span></label>
                                <input {{ (!empty($id)) ? "disabled" : "" }} type="text" value="{{ (!empty($role)? $role->name:'') }}" class="form-control" name="name" id="name" placeholder="Enter Role Name">
                                <span id="name-error" class="text-danger" for="name"></span>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description <span style="color: red;"></span></label>
                                <textarea class="form-control" placeholder="Enter description for this role" name="description" cols="50" rows="10" id="description">{{ (!empty($role)? $role->description:'') }}</textarea>
                                <span id="description-error" class="text-danger" for="email"></span>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-8">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Permissions(s) <span style="color: red;">*</span></label>

                                <label id="permission_id-error" class="text-danger" for="permission_id"></label><br>
                                @foreach ($permissions  as $permission)

                                    <div class="">
                                        <input type="checkbox" name="permission_id[]" style="cursor: pointer;" value="{{$permission->id}}" {{in_array($permission->id,$userPermission)?"checked":""}}>
                                        <label for="permission_id" style='{{ (!empty($userPermission) ? in_array($permission->id,$userPermission)?"color:#999999":"color:#000;cursor:pointer" : '' )}}'>{{$permission->description}}</label>
                                    </div>
                                @endforeach

                                {{-- @foreach ($permissions  as $permission)
                                  <div class="col-md-12">
                                    <input type="checkbox" name="permission_id[]" style="cursor: pointer;" value="{{$permission->id}}"
                                    {{in_array($permission->id,$userPermission)?"checked":""}}>
                                    <label for="permission_id" style='{{in_array($permission->id,$userPermission)?"color:#999999":"color:#000;cursor:pointer"}}'>{{$permission->display_name}}</label>
                                  </div>
                                @endforeach --}}

                            </div>
                        </div>

                        @if ($show)
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-primary" type="button" id="store-role">
                                        {{ (!empty($id)) ? "Update" : "Save" }}
                                    </button>
                                    <button class="btn btn-danger" type="reset">Cancel</button>

                                </div>
                            </div>
                        @endif

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
    <script type="text/javascript" src="{{ URL::asset('js/custom/role/form.js') }}"></script>
@endsection