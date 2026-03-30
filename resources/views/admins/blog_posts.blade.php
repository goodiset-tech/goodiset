@extends('admins.master')

@section('title','Blog')

@section('blog_active','active')

@section('blog_category_active_c1','collapse in')

@section('blog_category_child_1_active','active')


@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Post Form</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group"><label class="col-lg-4 control-label">Title</label>
                            <div class="col-lg-8"><input type="text" required name="title_english" value="{{isset($edit->title_english) ? $edit->title_english : ""}}"  class="form-control">
                                @error('title_english')
                                <span class="help-block m-b-none text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-4 control-label">Description</label>
                        <div class="col-lg-8">
                        <textarea class="summernote" name="description" rows="5">
                            <?php echo isset($edit->description_english) ? htmlspecialchars($edit->description_english) : null; ?>
                        </textarea>
                            <!--<input type="text" required name="description" value="{{isset($edit->description_english) ? $edit->description_english : ""}}"  class="form-control">-->
                                @error('description_english')
                                <span class="help-block m-b-none text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-lg-4 control-label">Featured image (Main Thumbnail):</label>
                            <div class="col-lg-8">
                            <input type="file" onchange="readURL(this);" <?php echo isset($edit->id) ? null : "required"; ?> accept="image/png, image/gif, image/jpeg" class="form-control" name="image">
                            </div>
                            <img src="<?php echo isset($edit->image) ? asset($edit->image) : null; ?>"  alt="" <?php echo isset($edit->image) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>>
                       
                        </div>
                        <div class="form-group" >
                            <label class="col-lg-4 control-label">Category</label>
                            <div class="col-lg-8">
                            <select name="category" class="form-control" required>
                                <?php $cate = DB::table('post_categories')->get();
                                foreach($cate as $v){
                                ?>
                                <option value="{{$v->id}}" <?=  (isset($edit->category_id) && $edit->category_id == $v->id)?'selected':''; ?>>{{$v->title_english}}</option>
                                <?php }?>
                            </select></div>
                        </div>
                        <div class="form-group"><label class="col-lg-4 control-label">Seo Title</label>
                            <div class="col-lg-8"><input type="text" required name="title" value="{{isset($edit->title) ? $edit->title : ""}}"  class="form-control">
                                @error('title_english')
                                <span class="help-block m-b-none text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-4 control-label">Seo Description</label>
                            <div class="col-lg-8"><input type="text" required name="seo_des" value="{{isset($edit->description) ? $edit->description : ""}}"  class="form-control">
                                @error('title_english')
                                <span class="help-block m-b-none text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-4 control-label">Seo Keywords</label>
                            <div class="col-lg-8"><input type="text" required name="seo_key" value="{{isset($edit->keywords) ? $edit->keywords : ""}}"  class="form-control">
                                @error('title_english')
                                <span class="help-block m-b-none text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        @if(isset($edit->id))
                        <input type="hidden" name="hidden_id" value="{{$edit->id}}">
                        @endif
                        <div class="form-group"><label class="col-lg-3 control-label"></label>

                            <div class="col-lg-9">                  <button class="btn btn-sm btn-primary" type="submit"><strong>Save</strong></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Blog List</h5>
            </div>
            <div class="ibox-content">
  
                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
                <th>Sr.No</th>
                <th>Title</th>
                <th>Description</th>
                <th>Creation Ago</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
              @php $sr=1; @endphp
              @foreach ($categories as $item)
                  <tr>
                    <td>{{$sr++}}</td>
                    <td>{{$item->title_english}}</td>
                    <td>{{$item->description_english}}</td>
                    <td>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</td>
            
                    <td>
                      <a href="{{route('admins.blog')}}/{{$item->id}}" class="btn btn-warning">Edit</a>
                      <a href="javascript:void(0)" data-href="{{route('admins.blog')}}/{{$item->id}}/{{'delete'}}"  class="btn btn-danger delete_record">Delete</a>
                    </td>
                  </tr>
              @endforeach
            </tbody>
            </table>
                </div>
  
            </div>
        </div>
    </div>
    </div>
  </div>
@endsection