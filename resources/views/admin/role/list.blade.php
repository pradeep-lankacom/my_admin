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

                    <a class="btn btn-sm btn-primary" href="/admin/roles/create">Create New Role</a>

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table dataTables-example" id="role-table" width="100%">
                                <thead class="table_headers">
                                <tr>
                                    <th>Role Name</th>
                                    <th>Description</th>
                                    <th>Created at</th>
                                    <th></th>

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
    <script type="text/javascript" src="{{ URL::asset('js/custom/role/list.js') }}"></script>
@endsection