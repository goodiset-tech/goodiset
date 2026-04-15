@extends('admins.master')
<style>
    label {
        text-align: left !important;
    }

    .bootstrap-tagsinput {
        width: 100% !important;
    }
</style>
@section('title', 'Page Form')

@section('page_active', 'active')


@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Page Form</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ url('/') }}/admin/page_form" id="page_form" class="form-horizontal" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group"><label class="col-sm-12 control-label">Page Heading:</label>
                                <div class="col-sm-12">
                                    <input type="text" value="<?php echo isset($edit->name) ? htmlspecialchars($edit->name) : null; ?>" required class="form-control"
                                        name="name">

                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-12 control-label">Page Heading Ar:</label>
                                <div class="col-sm-12">
                                    <input type="text" value="<?php echo isset($edit->name_ar) ? htmlspecialchars($edit->name_ar) : null; ?>" required class="form-control"
                                        name="name_ar">

                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-12 control-label">Page Sub Title:</label>
                                <div class="col-sm-12">
                                    <input type="text" value="<?php echo isset($edit->sub_title) ? htmlspecialchars($edit->sub_title) : null; ?>" required class="form-control"
                                        name="sub_title">

                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-12 control-label">Page Sub Title Ar:</label>
                                <div class="col-sm-12">
                                    <input type="text" value="<?php echo isset($edit->sub_title_ar) ? htmlspecialchars($edit->sub_title_ar) : null; ?>" required class="form-control"
                                        name="sub_title_ar">

                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-12 control-label">Page Slug:</label>
                                <div class="col-sm-12">
                                    <input type="text" <?php echo isset($edit->slug) ? '' : null; ?> value="<?php echo isset($edit->slug) ? htmlspecialchars($edit->slug) : null; ?>"
                                        class="form-control" name="slug">
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-12 control-label">Page type (navigation):</label>
                                <div class="col-sm-12">
                                    <select name="page_type" class="form-control">
                                        <option value=""
                                            {{ !isset($edit->page_type) || $edit->page_type === null || $edit->page_type === '' ? 'selected' : '' }}>
                                            Normal — show only in main header if enabled below</option>
                                        <option value="partner"
                                            {{ isset($edit->page_type) && $edit->page_type === 'partner' ? 'selected' : '' }}>
                                            Partner submenu — appears under “Partner” only (not in main header row)</option>
                                    </select>
                                    <p class="help-block m-b-none text-muted" style="margin-top:8px;">Partner pages use
                                        each row’s <strong>slug</strong> as the URL (same as other pages). The
                                        <strong>lowest Sort No</strong> among partner pages is the main “Partner” click
                                        target; all partner pages appear in the dropdown. Main header still hides
                                        <code>page_type = partner</code> from the top page row.</p>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-12 control-label">Sort No</label>
                                <div class="col-sm-12">
                                    <input type="text" value="<?php echo isset($edit->sort_no) ? htmlspecialchars($edit->sort_no) : null; ?>" required class="form-control"
                                        name="sort_no">

                                </div>
                            </div>
                            {{-- Banner Image --}}
                            <div class="form-group">
                                <label class="col-sm-12 control-label"> Banner Image:</label>
                                <!--<input type="file" require  accept="image/png, image/gif, image/jpeg" class="form-control" <?php echo isset($edit->video_link) ? 'required' : ''; ?>   name="logo">-->
                                <div class="col-sm-12"><input type="file" accept="image/png, image/gif, image/jpeg"
                                        class="form-control" name="page_image_one">
                                    @if ($edit)
                                        <img src=" {{ asset('') }}img/slider/{{ $edit->page_image }}" alt=""
                                            <?php echo $edit->page_image != null ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>>
                                    @endif
                                </div>
                            </div>

                            {{-- Icon (SVG) --}}
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Icon (SVG 50x50 px):</label>
                                <div class="col-sm-12">
                                    <input type="file" accept="image/png, image/gif, image/jpeg, image/svg+xml"
                                        class="form-control" name="icon_svg">

                                    @if (!empty($edit?->icon_svg))
                                        {{-- If you stored icons in storage/app/public/icons via storage:link --}}
                                        <img src="{{ asset('img/slider/' . $edit->icon_svg) }}" alt="icon"
                                            style="width:50px;height:50px;">
                                        {{-- If you still store next to slider, use: asset('img/slider/'.$edit->icon_svg) --}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-12 control-label">Show in Header:</label>
                                <div class="col-sm-12">
                                    <label style="display:inline-flex;align-items:center;gap:.5rem;">
                                        <select name="is_show_in_header" id="" class="form-control">
                                            <option value="1"
                                                {{ isset($edit->is_show_in_header) && $edit->is_show_in_header == 1 ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="0"
                                                {{ isset($edit->is_show_in_header) && $edit->is_show_in_header == 0 ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                    </label>
                                </div>
                            </div>


                            @if (isset($edit->id))
                                <input type="hidden" name="hidden_id" value="{{ $edit->id }}">
                            @endif
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-md btn-primary" type="submit"><strong>Save</strong></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $('.get_route').change(function() {
            // alert($(this).val());
            $('#route').val($(this).val());


        });
        $('#menu_type').change(function() {
            var mid = "#" + $(this).val();
            $('.all_typs').each(function(i, obj) {
                $(this).hide();
            });
            $(mid).show();


        });

        function menu_type() {
            alert($(this).val());
        }
        $(document).ready(function() {
            $(document).on("submit", "#page_form", function(e) {
                $("#content").val($('#content').summernote('code'));

                return true;
                // e.preventDefault();
            });

            $(document).on("submit", "#page_form", function(e) {
                if ($('#content').summernote('codeview.isActivated')) {
                    $('#content').summernote('codeview.deactivate');
                }
            });
        });
    </script>
@endpush
