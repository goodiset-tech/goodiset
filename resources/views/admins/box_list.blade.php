@extends('admins.master')

@section('title', 'Box List')

@section('box_cal_active_c1', 'active')
@section('box_cal_active_c1', 'collapse in')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Saved Boxes</h5>
                        <div class="ibox-tools">
                            <a href="{{ route('admins.box.calculator') }}" class="btn btn-primary btn-sm">Create New Box</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Box Name</th>
                                    <th>Box Weight (g)</th>
                                    <th>Max Boxes</th>
                                    <th>Products</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($boxes as $box)
                                    <tr>
                                        <td>{{ $box->box_name }}</td>
                                        <td>{{ $box->box_weight }}</td>
                                        <td>{{ $box->max_boxes }}</td>
                                        <td>
                                            @foreach ($box->products as $bp)
                                                {{ $bp->product->product_name }} ({{ $bp->percentage }}%, {{ $bp->pieces }} pieces)<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('admins.box.edit', $box->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('admins.box.delete', $box->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this box?')">Delete</button>
                                            </form>
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

@endsection