@extends('admins.master')

@section('title', 'Currency')

@section('currency_active', 'active')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Currency Form</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group"><label class="col-lg-3 control-label">Name</label>
                                <div class="col-lg-9"><input type="text" required name="name"
                                        value="{{ isset($edit->name) ? $edit->name : '' }}" class="form-control">
                                    @error('name')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-3 control-label">Symbol</label>
                                <div class="col-lg-9"><input type="text" required name="symbol"
                                        value="{{ isset($edit->symbol) ? $edit->symbol : '' }}" class="form-control">
                                    @error('name')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
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
                        <h5>Currency List</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Symbol</th>
                                        <th>Creation Ago</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr=1; @endphp
                                    @foreach ($currency as $item)
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->symbol }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('admins.currency') }}/{{ $item->id }}"
                                                    class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0)"
                                                    data-href="{{ route('admins.currency') }}/{{ $item->id }}/{{ 'delete' }}"
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
