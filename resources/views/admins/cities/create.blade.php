@extends('admins.master')
@section('shipping_active_c1', 'active')
@section('cities', 'active')
@section('title', isset($edit) ? 'Edit City' : 'Add City')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ isset($edit) ? 'Edit' : 'Add' }} City</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" method="post" action="{{ isset($edit) ? route('admins.cities.update', $edit->id) : route('admins.cities.store') }}">
                            @csrf
                            @if(isset($edit))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label class="col-lg-3 control-label">City Name</label>
                                <div class="col-lg-9">
                                    <input type="text" required name="name" value="{{ isset($edit) ? $edit->name : old('name') }}" class="form-control">
                                    @error('name')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Country</label>
                                <div class="col-lg-9">
                                    <select name="country_id" class="form-control" required>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ (isset($edit) && $edit->country_id == $country->id) ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Min Order Amount (AED)</label>
                                <div class="col-lg-9">
                                    <input type="number" required name="min_order" value="{{ isset($edit) ? $edit->min_order : old('min_order') }}" class="form-control">
                                    @error('min_order')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Shipping Cost (AED)</label>
                                <div class="col-lg-9">
                                    <input type="number" required name="shipping_cost" value="{{ isset($edit) ? $edit->shipping_cost : old('shipping_cost') }}" class="form-control">
                                    @error('shipping_cost')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Free Shipping After (AED)</label>
                                <div class="col-lg-9">
                                    <input type="number" required name="free_shipping" value="{{ isset($edit) ? $edit->free_shipping : old('free_shipping') }}" class="form-control">
                                    @error('free_shipping')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Shipping Time </label>
                                <div class="col-lg-9">
                                    <input type="text" required name="shipping_time" value="{{ isset($edit) ? $edit->shipping_time : old('shipping_time') }}" class="form-control">
                                    @error('shipping_time')
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