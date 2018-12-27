@extends('admin.layouts.admin')

@section('content')
    <div class='row'>
       <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ (!empty($category->id))? "Update" : "Create" }} Category</h3>
                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body">

                <form method="post" class="form-horizontal" action="{{ (!empty($category->id)) ? "/admin/category/update" : "/admin/category/store" }}" id="store-category-form" autocomplete="off">
                    {{ csrf_field() }}

                    <input type="hidden" name="id" id="id" value="{{ (!empty($category->id)) ? $category->id : "" }}">
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Title <font color="red">*</font></label>
                        <div class="col-lg-8">
                            <input type="text" id="title" name="title" class="form-control" value="{{ (!empty($category->title)) ? $category->title : old('title') }}" placeholder="Title">
                            <span class="text-danger" for="title" id="title-error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label">Description </label>
                        <div class="col-lg-8">
                            <textarea  id="description" name="description" class="form-control" >{{ (!empty($category->description)) ? $category->description : old('description') }}</textarea>
                            <span class="text-danger" for="description" id="description-error"></span>
                        </div>
                    </div>


                        <div class="form-group">
                            <label class="col-lg-4 control-label">Parent Category</label>
                            <div class="col-lg-8">
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="0">Select</option>
                                    @if(count($mainCategory)>0)
                                    @foreach ($mainCategory as $key => $value)
                                        <option value="{{$value->id}}" {{(!empty($category->id))? ($category->parent_id==$value->id)? "selected":"" :""}} >{{$value->title}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <span class="text-danger" for="parent_id" id="parent_id-error"></span>
                            </div>
                        </div>


                    <div class="form-group">
                        <label class="col-lg-4 control-label">Category Image </label>
                        <div class="col-lg-8">
                            <input type="file" id="image" name="image" class="form-control" value="{{ (!empty($category->image)) ? $category->image : old('image') }}">
                            <span class="text-danger" for="image" id="image-error"></span>
                            <img id="preview_profile_image" src="@if (!empty($category->image)) /images/category/{{$category->image}} @else /images/category/default.png @endif" style="width: 73px;height: 67px;" alt="Category Image" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <button class="btn btn-sm btn-primary" type="button" id="store-category">{{ (!empty($category->id))? "Update" : "Save" }}</button>
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
    <script type="text/javascript" src="{{ URL::asset('js/custom/category/form.js') }}"></script>
@endsection