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

@section('dynamic_pages_active', 'active')


@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Page Form</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ url('/') }}/admin/dynamic_page_form" id="page_form" class="form-horizontal" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group"><label class="col-sm-12 control-label">Page Heading:</label>
                                <div class="col-sm-12">
                                    <input type="text" readonly value="<?php echo isset($edit->name) ? htmlspecialchars($edit->name) : null; ?>" required class="form-control"
                                        name="name">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label"> Banner Image:</label>
                                <!--<input type="file" require  accept="image/png, image/gif, image/jpeg" class="form-control" <?php echo isset($edit->video_link) ? 'required' : ''; ?>   name="logo">-->
                                <div class="col-sm-12"><input type="file" accept="image/png, image/gif, image/jpeg"
                                        class="form-control" name="banner">
                                    @if ($edit)
                                        <img src="<?php echo isset($edit->banner) ? asset($edit->banner) : null; ?>" alt="" <?php echo isset($edit->banner) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>>
                                    @endif
                                </div>
                                
                            </div>

                            @if (isset($edit->id))
                                <input type="hidden" name="hidden_id" value="{{ $edit->id }}">
                            @endif
                            <div class="form-group">
                            <div class="col-sm-12" style="margin-top: 10px;">
                                
                                    <div class="col-sm-10"><button class="btn btn-md btn-primary"
                                            type="submit"><strong>Save</strong></button>
                                    </div>
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
