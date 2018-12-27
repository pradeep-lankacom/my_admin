@extends('admin.layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('bower_components/jqTree/jqtree.css') }}">
    <style>

        ul.jqtree-tree {
            border-top: 1px solid rgba(255, 255, 255, .125)
        }

        ul.jqtree-tree li.jqtree-selected>.jqtree-element {
            transition: background-color .2s, border-color .2s;
            border-color: transparent
        }

        ul.jqtree-tree li.jqtree-selected>.jqtree-element,
        ul.jqtree-tree li.jqtree-selected>.jqtree-element:hover {
            background: rgba(255, 255, 255, .125);
            text-shadow: none
        }

        ul.jqtree-tree li:not(.jqtree-selected)>.jqtree-element:hover {
            background-color: rgba(255, 255, 255, .02)
        }

        ul.jqtree-tree li.jqtree-folder {
            margin-bottom: 0
        }

        ul.jqtree-tree li.jqtree-folder:not(.jqtree-closed)+li.jqtree_common {
            position: relative
        }

        ul.jqtree-tree li.jqtree-folder:not(.jqtree-closed)+li.jqtree_common:before {
            content: '';
            position: absolute;
            top: -1px;
            left: 0;
            width: 30px;
            background-color: rgba(255, 255, 255, .125);
            height: 1px
        }

        ul.jqtree-tree li.jqtree-folder.jqtree-closed {
            margin: 0
        }

        ul.jqtree-tree li.jqtree-ghost span.jqtree-line {
            background-color: #00f7ff
        }

        ul.jqtree-tree li.jqtree-ghost span.jqtree-circle {
            border-color: #85f2ff
        }

        ul.jqtree-tree .jqtree-moving>.jqtree-element .jqtree-title {
            outline: 0
        }

        ul.jqtree-tree span.jqtree-border {
            border-radius: 0;
            border-color: #54faff
        }

        ul.jqtree-tree .jqtree-toggler {
            position: absolute;
            height: 16px;
            width: 16px;
            background: rgba(255, 255, 255, .75);
            color: #131313;
            padding: 0 0 0 1px;
            font-size: 1rem;
            border-radius: 50%;
            top: 12px;
            left: -8px;
            line-height: 16px;
            text-align: center;
            transition: background-color .3s, color .3s
        }

        ul.jqtree-tree .jqtree-toggler:hover {
            background-color: #3affff;
            color: #000
        }

        ul.jqtree-tree .jqtree-element {
            position: relative;
            padding: 10px 20px;
            border: 1px solid rgba(1, 1, 1, .1);
            border-top: 0;
            margin-bottom: 0;
            background-color: #f3f2f1;
        }

        ul.jqtree-tree .jqtree-title {
            color: #337ab7;
            margin-left: 0
        }

        ul.jqtree-tree ul.jqtree_common {
            margin-left: 22px;
            padding-left: 8px
        }

        ul.jqtree-tree li.jqtree-selected>.jqtree-element, ul.jqtree-tree li.jqtree-selected>.jqtree-element:hover {
            background: rgba(56, 50, 50, 0.125);
            text-shadow: none;
        }
        .jqtree_common .edit {
            float: right;
            padding: 5px;
        }
        .jqtree_common .delete {
            float: right;
            padding: 5px;
        }

    </style>
@endsection
@section('content')
    <div class='row'>
       <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Category</h3>
                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body">
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <div class="row" style="margin-bottom: 10px">
                        <a class="btn btn-sm btn-primary" href="/admin/category/create">Create New User</a>
                    </div>

                </div>


                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <div class="table-responsive">
                            {{--@foreach($categories as $item)--}}
                                {{--<li class="treeview">--}}
                                    {{--<a href="{{ $item->id }}"><i class="fa fa-link"></i> <span>{{ $item->title }}</span> <i class="fa fa-angle-left pull-right"></i></a>--}}
                                    {{--<ul class="treeview-menu">--}}
                                        {{--@foreach($item['children'] as $child)--}}
                                            {{--<li><a href="{{ $child->id }}">{{ $child->title }}</a></li>--}}
                                        {{--@endforeach--}}
                                    {{--</ul>--}}
                                {{--</li>--}}
                            {{--@endforeach--}}
                        </div>
                        <div id="tree1" data-url="/admin/category/get_category_list"></div>
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
    {{--<script type="text/javascript" src="{{ URL::asset('js/custom/user/list.js') }}"></script>--}}
    <script type="text/javascript" src="{{ URL::asset('bower_components/jqTree/tree.jquery.js') }}"></script>
<script>
    var data = [
        {
            name: 'node1', id: 1,
            children: [
                { name: 'child1', id: 2 },
                { name: 'child2', id: 3 }
            ]
        },
        {
            name: 'node2', id: 4,
            children: [
                { name: 'child3', id: 5 }
            ]
        }
    ];


    $(function() {
        var $tree = $('#tree1');

        $tree.tree({
            autoOpen: 1,
            onCreateLi: function(node, $li) {
                // Append a link to the jqtree-element div.
                // The link has an url '#node-[id]' and a data property 'node-id'.
                $li.find('.jqtree-element').append(
                    '<a class="delete" data-toggle="tooltip_delete"  data-node-id="'+node.id+'"  title="Delete" style="display: block;margin-right: 3px;" href="#"><button id="delete" userid="3" type="button" class="btn btn-danger btn-xs dt-delete"><i class="fa fa-remove"></i></button></a>'+
                    '<a class="edit" data-toggle="tooltip_edit" data-node-id="'+node.id+'" title="Edit" style="display: block;margin-right: 3px;" href="/category/'+node.id+'/edit"><button type="button" class="btn btn-primary btn-xs dt-edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></a>'

                );
            }
        });

        // Handle a click on the edit link
        $tree.on(
            'click', '.edit',
            function(e) {
                // Get the id from the 'node-id' data property
                var node_id = $(e.target).data('node-id');

                // Get the node from the tree
                var node = $tree.tree('getNodeById', node_id);

                if (node) {
                    // Display the node name
                    alert(node.name);
                }
            }
        );
    });
</script>
@endsection