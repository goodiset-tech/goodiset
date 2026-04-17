<style>
    td{
        vertical-align: middle !important;
    }
    td img{
        width: 50px;
    }
</style>
@extends('admins.master')

@section('title','Orders')
@section('order','active')
@section('orderc1','collapse in')
@section('order_log','active')



@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Log Report</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th scope="col">Sr #</th>
                                        <th scope="col">Context</th>
                                        <th scope="col">IP Address</th>
                                        <th scope="col">URL</th>
                                        <th scope="col">Old Values</th>
                                        <th scope="col">Current Values</th>
                                        <th scope="col">TimeStamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 1;
                                @endphp
                                @if ($data)
                                    @foreach ($data as $key => $value)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{!! $value->message !!}</td>
                                            <td>{{ $value->ip_address }}</td>
                                            <td>{{ $value->url }}</td>
                                                <td>
                                                    @php
                                                        $changes = json_decode($value->changes, true); // Convert text to JSON
                                                    @endphp
    
                                                    @if (isset($changes['old']))
                                                        @foreach ($changes['old'] as $title => $oldValue)
                                                            @if ($title !== 'updated_at')
                                                                @if (($title == 'dstatus') && $oldValue != 'delete')
                                                                    <strong>Status:</strong>
                                                                    @switch($oldValue)
                                                                        @case(0)
                                                                            Pending
                                                                        @break
    
                                                                        @case(1)
                                                                            Confirmed
                                                                        @break
    
                                                                        @case(2)
                                                                            Delivered
                                                                        @break
    
                                                                        @case(3)
                                                                            Cancelled
                                                                        @break
    
                                                                        @case(4)
                                                                            Dispatched
                                                                        @break
    
                                                                        @default
                                                                            Unknown
                                                                    @endswitch
                                                                @elseif ($title !== 'status')
                                                                    <strong>{{ $title }}:</strong> {{ $oldValue }}
                                                                    <br>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $changes = json_decode($value->changes, true); // Convert text to JSON
                                                    @endphp
    
                                                    @if (isset($changes['new']))
                                                        @foreach ($changes['new'] as $title => $oldValue)
                                                            @if ($title !== 'updated_at')
                                                                @if (($title == 'dstatus') && $oldValue != 'delete')
                                                                    <strong>Status:</strong>
                                                                    @switch($oldValue)
                                                                        @case(0)
                                                                            Pending
                                                                        @break
    
                                                                        @case(1)
                                                                            Confirmed
                                                                        @break
    
                                                                        @case(2)
                                                                            Delivered
                                                                        @break
    
                                                                        @case(3)
                                                                            Cancelled
                                                                        @break
    
                                                                        @case(4)
                                                                            Dispatched
                                                                        @break
    
                                                                        @default
                                                                            Unknown
                                                                    @endswitch
                                                                @elseif ($title !== 'status')
                                                                    <strong>{{ $title }}:</strong> {{ $oldValue }}
                                                                    <br>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td>{{ date('F j, Y h:i:s A', strtotime($value->created_at)) }}</td>
                                            </tr>
                                        @endforeach
    
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.toggle-row').forEach(row => {
            row.addEventListener('click', () => {
                const detailsId = row.getAttribute('data-id');
                const detailsRow = document.getElementById(`details-${detailsId}`);
                if (detailsRow.style.display === 'none') {
                    detailsRow.style.display = 'table-row';
                } else {
                    detailsRow.style.display = 'none';
                }
            });
        });

        document.querySelectorAll('.toggle-row-1').forEach(row => {
            row.addEventListener('click', () => {
                const detailsId = row.getAttribute('data-id');
                const detailsRow = document.getElementById(`bundle-detail-${detailsId}`);
                if (detailsRow.style.display === 'none') {
                    detailsRow.style.display = 'table-row';
                } else {
                    detailsRow.style.display = 'none';
                }
            });
        });

        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(input).parent().find('img').attr('src', e.target.result).show();
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(function() {
            let sub_cat_id = $('input[name="sub_cat_id"]').val();
            let cat_id = $('select[name="category_id"]').val();
            getSubCats(cat_id, sub_cat_id);
            $('select[name="category_id"]').change(function() {
                getSubCats($(this).val(), 0);
            });

            function getSubCats(cat_id, sub_cat_id) {
                var cid = (cat_id === undefined || cat_id === null) ? '' : String(cat_id).trim();
                if (!cid || cid === 'undefined' || !/^\d+$/.test(cid)) {
                    return;
                }
                $.ajax({
                        url: "{{ route('admins.get_subCategory_html') }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        type: "POST",
                        data: "category_id=" + cid + "&sub_category_id=" + sub_cat_id,
                        success: function(response) {
                            console.log(response);
                            $('select[name="subcategory_id"]').html("").html(response);
                        }
                    });

            }

        });



        $(document).ready(function() {
            $(document).on("submit", "#product_form", function(e) {
                // alert( $('#short_discriiption').summernote('code'));
                $("#short_discriiption").val($('#short_discriiption').summernote('code'));
                $("#product_details").val($('#product_details').summernote('code'));

                return true;
                // e.preventDefault();
            });

            $(document).on("submit", "#product_form", function(e) {
                if ($('#product_details').summernote('codeview.isActivated')) {
                    $('#product_details').summernote('codeview.deactivate');
                }
                if ($('#short_discriiption').summernote('codeview.isActivated')) {
                    $('#short_discriiption').summernote('codeview.deactivate');
                }
            });
            document.getElementById('pro-image').addEventListener('change', readImage, false);

            $(".preview-images-zone").sortable();

            $(document).on('click', '.image-cancel', function() {

                let no = $(this).data('no');

                let image_id = $(this).attr('id');
                console.log(image_id);

                deleteimagevalue = $('#delete_gallary_images').val()
                newdeleteimagevalue = deleteimagevalue + "," + image_id;
                $('#delete_gallary_images').val(newdeleteimagevalue);


                //   var img = $(".preview-image.preview-show-"+no).find('img').attr('src');
                //   console.log(imagevalue);
                //   console.log(img);

                //   let result = imagevalue.includes("_____"+img);
                // //   console.log(result);
                //   if(result){
                //       newimagetext = imagevalue.replace('_____'+img,'');
                //   }else{
                //       let result2 = imagevalue.includes(img+"_____");
                //       if(result2){
                //           newimagetext = imagevalue.replace(img+'_____','');
                //       }

                //   }
                //   console.log(newimagetext);

                //   $('#gallary_images').val(imagevalue);

                $(".preview-image.preview-show-" + no).remove();
                //   console.log($(".preview-image.preview-show-"+no).children().css({"color": "red", "border": "2px solid red"}));

            });
        });


        var num = 0;

        function readImage() {
            if (window.File && window.FileList && window.FileReader) {
                var files = event.target.files; //FileList object
                var output = $(".preview-images-zone");

                for (let i = 0; i < files.length; i++) {
                    var file = files[i];
                    var checkdiv = $('div.preview-image').length;
                    // lemit line
                    if (num <= 5 || checkdiv <= 5) {

                        var num = checkdiv;
                        if (!file.type.match('image')) continue;

                        var picReader = new FileReader();

                        picReader.addEventListener('load', function(event) {
                            var picFile = event.target;
                            imagevalue = $('#gallary_images').val()
                            addvalue = picFile.result;
                            console.log(picFile.result);
                            newvalue = imagevalue + "_____" + addvalue
                            $('#gallary_images').val(newvalue);
                            var html = '<div class="preview-image preview-show-' + num + '">' +
                                '<div class="image-cancel" data-no="' + num + '">x</div>' +
                                '<div class="image-zone"><img id="pro-img-' + num + '" src="' + picFile.result +
                                '"></div>' +
                                '<div class="tools-edit-image"><a href="javascript:void(0)" data-no="' + num +
                                '" class="btn btn-light btn-edit-image">edit</a></div>' +
                                '</div>';

                            output.append(html);
                            num = num + 1;
                        });
                    }
                    picReader.readAsDataURL(file);
                }
                $("#pro-image").val('');
            } else {
                console.log('Browser not support');
            }
        }
    </script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endpush
