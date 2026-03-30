@extends('admins.master')

@section('title', 'Promotional Banners')

@section('promotional_banner', 'active')


@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                @php
                    $bannerCount = isset($banners) ? $banners->count() : 0;
                    $canAddMore = isset($edit->id) || $bannerCount < 2;
                @endphp

                @if ($canAddMore)
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Promotional Banner Form</h5>
                            <small class="text-muted">(Maximum 2 banners allowed)</small>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" id="promotional_banner_form" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Banner Image
                                        <small class="text-muted">(625 x 200 px)</small>
                                    </label>
                                    <div class="col-lg-9">
                                        <input type="file" <?php echo isset($edit->id) ? '' : 'required'; ?> name="image" class="form-control"
                                            accept="image/*">
                                        @if (isset($edit->id) && $edit->image)
                                            <img style="width:150px; margin-top:10px;"
                                                src="{{ asset('img/promotional/' . $edit->image) }}" />
                                        @endif
                                        <p class="help-block"><small>This image will be automatically resized for optimal
                                                performance on all devices.</small></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Link URL</label>
                                    <div class="col-lg-9">
                                        <input value="<?php echo isset($edit->link) ? $edit->link : ''; ?>" name="link" class="form-control"
                                            placeholder="https://example.com/page">
                                        <small class="text-muted">Leave empty for no link</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Sort Order</label>
                                    <div class="col-lg-9">
                                        <input type="number" value="<?php echo isset($edit->sort_order) ? $edit->sort_order : '0'; ?>" name="sort_order"
                                            class="form-control" min="0">
                                        <small class="text-muted">Lower numbers appear first</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Status</label>
                                    <div class="col-lg-9">
                                        <select name="status" class="form-control">
                                            <option value="1"
                                                {{ isset($edit->status) && $edit->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0"
                                                {{ isset($edit->status) && $edit->status == 0 ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                @if (isset($edit->id))
                                    <input type="hidden" name="hidden_id" value="{{ $edit->id }}">
                                @endif

                                <div class="form-group">
                                    <label class="col-lg-3 control-label"></label>
                                    <div class="col-lg-9">
                                        <button class="btn btn-sm btn-primary" type="submit"><strong>Save</strong></button>
                                        @if (isset($edit->id))
                                            <a href="{{ route('admins.promotional_banner') }}"
                                                class="btn btn-sm btn-default">Cancel</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        @else
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> Maximum limit of 2 promotional banners reached. Delete an existing
                        banner to add a new one.
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Promotional Banners List</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Image</th>
                                    <th>Link</th>
                                    <th>Sort Order</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $sr = 1; @endphp
                                @foreach ($banners as $item)
                                    <tr>
                                        <td>{{ $sr++ }}</td>
                                        <td>
                                            @if ($item->image)
                                                <img style="width:120px;"
                                                    src="{{ asset('img/promotional/' . $item->image) }}" />
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->link)
                                                <a href="{{ $item->link }}" target="_blank" title="{{ $item->link }}">
                                                    {{ Str::limit($item->link, 30) }}
                                                </a>
                                            @else
                                                <span class="text-muted">No link</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->sort_order }}</td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="label label-primary">Active</span>
                                            @else
                                                <span class="label label-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)"
                                                data-href="{{ route('admins.promotional_banner') }}/{{ $item->id }}/delete"
                                                class="btn btn-danger btn-xs delete_record">Delete</a>
                                            <a href="{{ route('admins.promotional_banner') }}/{{ $item->id }}"
                                                class="btn btn-warning btn-xs">Edit</a>
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
