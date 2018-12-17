@extends('admin.layouts.admin')

@section('content')
    <div class='row'>
       <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Users</h3>
                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body">

                    <a class="btn btn-sm btn-primary" href="/admin/user/create">Create New User</a>

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <div class="table-responsive">
                            <table id="users_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="table_headers">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role(s)</th>
                                    <th>Member Since</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- /.box-footer-->
        </div><!-- /.box -->
       </div>
    </div><!-- /.row -->
@endsection

@section('script')
    <script type="text/javascript" src="{{ URL::asset('js/custom/user/list.js') }}"></script>
@endsection