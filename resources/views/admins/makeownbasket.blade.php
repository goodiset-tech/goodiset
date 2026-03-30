@extends('admins.master')

@section('title', 'Box Customize')

@section('box_active_c1', 'active')

@section('box_active_c1', 'collapse in')

@section('box_active_c1', 'active')

@php
    use App\Models\PackageType;
    use App\Models\BoxSize;
@endphp

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Box Customize Form</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group"><label class="col-lg-3 control-label">Package</label>
                                <div class="col-lg-9">
                                    <select name="package_id" id="" class="form-control">
                                        @foreach ($PackageType as $v)
                                            <option value="{{$v->id}}" {{ isset($edit->size_id) && $edit->package_id == $v->id ? 'selected' : '' }}>{{$v->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-3 control-label">Size</label>
                                <div class="col-lg-9">
                                    <select name="size_id" id="" class="form-control">
                                        @foreach ($BoxSize as $v)
                                            <option value="{{$v->id}}" {{ isset($edit->size_id) && $edit->size_id == $v->id ? 'selected' : '' }}>{{$v->name}}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-3 control-label">Price:</label>
                                <div class="col-lg-9"><input type="text" required name="price"
                                        value="{{ isset($edit->price) ? $edit->price : '' }}" class="form-control">
                                    @error('price')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-3 control-label">Weight (In grams):</label>
                                <div class="col-lg-9"><input type="text" required name="weight"
                                        value="{{ isset($edit->weight) ? $edit->weight : '' }}" class="form-control">
                                    @error('weight')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group"><label class="col-lg-3 control-label">Upload Image</label>

                                <div class="col-lg-9">
                                    <input type="file" accept="image/*"  <?php echo isset($edit->id) ? '' :  'required'; ?> width="100px" name="image" id="">
                                    @error('name')
                                    <span class="help-block m-b-none text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
    
                            @if(isset($edit->id))
                            <div class="form-group"><label class="col-lg-3 control-label">Already Uploaded Image</label>
                                <div class="col-lg-9">
                                    <img src="{{asset($edit->image)}}" width="100px" alt="">
                                </div>
                            </div>
                            @endif

                            @if (isset($edit->id))
                                <input type="hidden" name="hidden_id" value="{{ $edit->id }}">
                            @endif



                            <div class="form-group"><label class="col-lg-3 control-label"></label>

                                <div class="col-lg-9"> <button class="btn btn-sm btn-primary"
                                        type="submit"><strong>Save</strong></button>
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
                        <h5>Box Customize List</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Size</th>
                                        <th>Price</th>
                                        <th>Creation Ago</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr=1; @endphp
                                    @foreach ($BoxCustomize as $item)
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <td>
                                                @php
                                                    $package = PackageType::where('id',$item->package_id)->first();
                                                @endphp
                                                @if($package)
                                                {{ ($package->name != null ? $package->name : '') }}
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $boxsize = BoxSize::where('id',$item->size_id)->first();
                                                @endphp
                                                @if($boxsize)
                                                {{ ($boxsize->name != null ? $boxsize->name: '')  }}
                                                @endif
                                            </td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('admins.box_customize') }}/{{ $item->id }}"
                                                    class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0)"
                                                    data-href="{{ route('admins.box_customize') }}/{{ $item->id }}/{{ 'delete' }}"
                                                    class="btn btn-danger delete_record">Delete</a>
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
