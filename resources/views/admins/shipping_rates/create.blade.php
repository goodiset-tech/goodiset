@extends('admins.master')

@section('shipping_active_c1', 'active')
@section('shipping_rate', 'active')
@section('title', isset($edit) ? 'Edit Shipping Rate' : 'Add Shipping Rate')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ isset($edit) ? 'Edit' : 'Add' }} Shipping Rate</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" method="post" action="{{ isset($edit) ? route('admins.shipping-rates.update', $edit->id) : route('admins.shipping-rates.store') }}">
                            @csrf
                            @if(isset($edit))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Shipping Zone</label>
                                <div class="col-lg-9">
                                    <select name="shipping_zone_id" class="form-control" required>
                                        @foreach($zones as $zone)
                                            <option value="{{ $zone->id }}" {{ (isset($edit) && $edit->shipping_zone_id == $zone->id) ? 'selected' : '' }}>{{ $zone->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('shipping_zone_id')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Shipping Method</label>
                                <div class="col-lg-9">
                                    <select name="shipping_method_id" class="form-control" required>
                                        @foreach($methods as $method)
                                            <option value="{{ $method->id }}" {{ (isset($edit) && $edit->shipping_method_id == $method->id) ? 'selected' : '' }}>{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('shipping_method_id')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Condition Type</label>
                                <div class="col-lg-9">
                                    <select name="condition_type" class="form-control">
                                        <option value="none" {{ (isset($edit) && $edit->condition_type == 'none') ? 'selected' : '' }}>None</option>
                                        <option value="weight" {{ (isset($edit) && $edit->condition_type == 'weight') ? 'selected' : '' }}>Weight</option>
                                        <option value="price" {{ (isset($edit) && $edit->condition_type == 'price') ? 'selected' : '' }}>Price</option>
                                    </select>
                                    @error('condition_type')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Min Value</label>
                                <div class="col-lg-9">
                                    <input type="number" name="min_value" value="{{ isset($edit) ? $edit->min_value : old('min_value') }}" class="form-control">
                                    @error('min_value')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Max Value</label>
                                <div class="col-lg-9">
                                    <input type="number" name="max_value" value="{{ isset($edit) ? $edit->max_value : old('max_value') }}" class="form-control">
                                    @error('max_value')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Rate</label>
                                <div class="col-lg-9">
                                    <input type="number" name="rate" value="{{ isset($edit) ? $edit->rate : old('rate') }}" class="form-control" required>
                                    @error('rate')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label"></label>
                                <div class="col-lg-9">
                                    <button class="btn btn-sm btn-primary" type="submit"><strong>Save</strong></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection