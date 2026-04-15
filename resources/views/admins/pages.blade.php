<style>
    td {
        vertical-align: middle !important;
    }

    td img {
        width: 50px;
    }
</style>
@extends('admins.master')
@section('title', 'Pages')
@section('pages_active', 'active')
<?php
use App\Models\Admins\Category;
use App\Models\Admins\SubCategory;
use App\Models\Childcatagorie;
use App\Models\product;
use App\Models\Admins\Gallerie;
use App\Models\Admins\Brand;
?>

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Page List</h5>
                        <div class="ibox-tools">
                            <a href="{{ route('admins.page_form') }}" class="btn btn-primary btn-xs">Add Page</a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Page</th>
                                        <th>Visits</th>
                                        <th>Show in Header</th> {{-- NEW --}}
                                        <th>Page type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pages as $key => $page)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $page->name }}</td>
                                            <td>{{ $page->view }}</td>

                                            {{-- Toggle switch (onoffswitch style) --}}
                                            <td>
                                                <div class="switch">
                                                    <div class="onoffswitch">
                                                        <input type="checkbox" name="is_show_in_header"
                                                            data-id="{{ $page->id }}"
                                                            class="onoffswitch-checkbox toggle-header"
                                                            id="header-{{ $page->id }}"
                                                            {{ $page->is_show_in_header ? 'checked' : '' }}>
                                                        <label class="onoffswitch-label" for="header-{{ $page->id }}">
                                                            <span class="onoffswitch-inner"></span>
                                                            <span class="onoffswitch-switch"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>{{ $page->page_type ?: '—' }}</td>

                                            <td>
                                                <a href="{{ route('admins.page_form', $page->id) }}"
                                                    class="btn btn-success btn-sm">
                                                    <i class="fa fa-edit"></i>&nbsp;Edit
                                                </a>
                                                <a data-href="{{ route('admins.page_delete', ['id' => $page->id]) }}"
                                                    class="btn btn-danger btn-sm delete_record" href="javascript:void(0)">
                                                    <i class="fa fa-times"></i>&nbsp;Delete
                                                </a>
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
@push('scripts')
    <script>
        function updateHeader(status, page_id) {
            if (!page_id) return;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{ route('admins.toggle_page_header') }}", // make sure this route exists
                type: "POST",
                data: {
                    page_id: page_id,
                    status: status ? 1 : 0
                },
                success: function(response) {
                    if (typeof showToastr === 'function') {
                        showToastr(response.msg, response.msg_type);
                    } else {
                        console.log(response.msg);
                    }
                },
                error: function() {
                    alert('Failed to update. Please try again.');
                }
            });
        }

        $(document).ready(function() {
            $(document).on('change', '.toggle-header', function() {
                const checked = $(this).is(':checked');
                const id = $(this).data('id');
                updateHeader(checked, id);
            });
        });
    </script>
@endpush
