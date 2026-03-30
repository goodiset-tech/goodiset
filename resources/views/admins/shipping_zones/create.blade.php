@extends('admins.master')
@section('shipping_active_c1', 'active')
@section('shipping_zone', 'active')
@section('title', isset($edit) ? 'Edit Shipping Zone' : 'Add Shipping Zone')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ isset($edit) ? 'Edit' : 'Add' }} Shipping Zone</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" method="post" action="{{ isset($edit) ? route('admins.shipping-zones.update', $edit->id) : route('admins.shipping-zones.store') }}">
                            @csrf
                            @if(isset($edit))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Zone Name</label>
                                <div class="col-lg-9">
                                    <input type="text" required name="name" value="{{ isset($edit) ? $edit->name : old('name') }}" class="form-control">
                                    @error('name')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Countries</label>
                                <div class="col-lg-9">
                                    <select name="countries[]" class="form-control js-example-basic-multiple" multiple required>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->name }}" {{ (isset($edit) && in_array($country->name, json_decode($edit->countries))) ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('countries')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Cities (Optional)</label>
                                <div class="col-lg-9">
                                    <input type="text" name="cities" value="{{ isset($edit) ? implode(', ', json_decode($edit->cities)) : old('cities') }}" class="form-control" placeholder="Comma-separated cities">
                                    @error('cities')
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

    <script>
        $(document).ready(function() {

            $('.js-example-basic-multiple').select2();

        });
    </script>
@endsection