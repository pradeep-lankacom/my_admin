@extends('admin.layouts.admin')

@section('content')
    <div class='row'>
       <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Permission</h3>
                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body">
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <div class="row" style="margin-bottom: 10px">
                        <a class="btn btn-sm btn-primary" href="/admin/permissions/create">Create Permission</a>
                    </div>

                </div>
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table dataTables-example table-responsive route-table route-table-wb" id="route_table" width="100%">
                            <thead class="table_headers">
                            <tr>
                                <th>Route</th>
                                <th>Permission</th>
                                <th>Slug</th>
                                <th>Breadcrumb</th>
                                <th>Title</th>
                                <th></th>
                            </tr>
                            </thead>
                        </table>


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
    <script type="text/javascript" src="{{ URL::asset('js/custom/permission/list.js') }}"></script>
@endsection