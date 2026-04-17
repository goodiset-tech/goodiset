@extends('admins.master')
<?php

use App\Models\Admins\Size;
use App\Models\Admins\Colors;
use App\Models\Admins\Shap;
use App\Models\Admins\Gallerie;

?>
<style>
    .preview-images-zone {
        width: 100%;
        border: 1px solid #ddd;
        min-height: 180px;
        /* display: flex; */
        padding: 5px 5px 0px 5px;
        position: relative;
        overflow: auto;
    }

    .preview-images-zone>.preview-image:first-child {
        height: 185px;
        width: 185px;
        position: relative;
        margin-right: 5px;
    }

    .preview-images-zone>.preview-image {
        height: 90px;
        width: 90px;
        position: relative;
        margin-right: 5px;
        float: left;
        margin-bottom: 5px;
    }

    .preview-images-zone>.preview-image>.image-zone {
        width: 100%;
        height: 100%;
    }

    .preview-images-zone>.preview-image>.image-zone>img {
        width: 100%;
        height: 100%;
    }

    .preview-images-zone>.preview-image>.tools-edit-image {
        position: absolute;
        z-index: 100;
        color: #fff;
        bottom: 0;
        width: 100%;
        text-align: center;
        margin-bottom: 10px;
        display: none;
    }

    .preview-images-zone>.preview-image>.image-cancel {
        font-size: 18px;
        position: absolute;
        top: 0;
        right: 0;
        font-weight: bold;
        margin-right: 10px;
        cursor: pointer;
        display: none;
        z-index: 100;
    }

    .preview-image:hover>.image-zone {
        cursor: move;
        opacity: .5;
    }

    .preview-image:hover>.tools-edit-image,
    .preview-image:hover>.image-cancel {
        display: block;
    }

    .ui-sortable-helper {
        width: 90px !important;
        height: 90px !important;
    }

    .container {
        padding-top: 50px;
    }

    label {
        text-align: left !important;
    }

    .bootstrap-tagsinput {
        width: 100% !important;
    }



    /* span.select2-dropdown.select2-dropdown--below {
        width: 301px !important;
    } */
    .select2-container {
        width: 100% !important;
    }

    .modal_image {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal-content {
        background: white;
        padding: 20px;
        border-radius: 5px;
    }

    .image-container {
        max-width: 560px;
        max-height: 560px;
    }
</style>
@section('title', 'Product Form')

@section('product_active', 'active')

@section('product_active_c1', 'collapse in')

@section('product_child_1_active', 'active')


@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <form class="form-horizontal" id="product_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <!-- <div class="ibox-title">
                                                                                                            <h5>Product Form</h5>
                                                                                                        </div> -->

                        <div class="section_box">
                            <!-- Title -->
                            <div class="row">
                                {{-- <input type="hidden" name="slug" value="<?php echo isset($edit->slug) ? $edit->slug : null; ?>"> --}}
                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Swedish Name :</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->name_sw) ? htmlspecialchars($edit->name_sw) : null; ?>" required
                                                class="form-control" name="name_sw"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">English Name :</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->product_name) ? htmlspecialchars($edit->product_name) : null; ?>" required
                                                class="form-control" name="product_name"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Arabic Name :</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->name_ar) ? htmlspecialchars($edit->name_ar) : null; ?>" required
                                                class="form-control" name="name_ar"></div>
                                    </div>
                                </div>
                                @if (isset($edit))
                                    <div class="col-sm-6">
                                        <div class="form-group"><label class="col-sm-12 control-label">Slug :</label>
                                            <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->slug) ? htmlspecialchars($edit->slug) : null; ?>"
                                                    required class="form-control" name="slug"></div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Sorting Order :</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->sort_order) ? htmlspecialchars($edit->sort_order) : null; ?>" required
                                                class="form-control" name="sort_order"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group"><label class="col-sm-12 control-label">Product
                                            Details:</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control input-sm summernote" required name="product_details" id="product_details" rows="15">
                                            <?php echo isset($edit->product_details) ? htmlspecialchars($edit->product_details) : null; ?>
        
                                        </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group"><label class="col-sm-12 control-label">Product
                                            Details Ar:</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control input-sm summernote" required name="product_detail_ar" id="product_details"
                                                rows="15">
                                            <?php echo isset($edit->product_detail_ar) ? htmlspecialchars($edit->product_detail_ar) : null; ?>
        
                                        </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">Product Thumbnail (250 x 250 px) Size under
                                            100kb:</label>
                                        <div class="col-sm-12">
                                            <input type="file" id="thumb-input"
                                                onchange="triggerImageEditor('thumb-input');" <?php echo isset($edit->id) ? null : 'required'; ?>
                                                accept="image/png, image/gif, image/jpeg, image/webp" class="form-control"
                                                name="thumb">
                                            <img id="thumb-preview" src="<?php echo isset($edit->thumb) ? asset($edit->thumb) : null; ?>" alt=""
                                                <?php echo isset($edit->thumb) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">Product Detail Image (500 x 500 px) Size
                                            under 100kb:</label>
                                        <div class="col-sm-12">
                                            <input type="file" id="image-one-input"
                                                onchange="triggerImageEditor('image-one-input');" <?php echo isset($edit->id) ? null : 'required'; ?>
                                                accept="image/png, image/gif, image/jpeg, image/webp" class="form-control"
                                                name="image_one">
                                            <img id="image-one-preview" src="<?php echo isset($edit->image_one) ? asset($edit->image_one) : null; ?>" alt=""
                                                <?php echo isset($edit->image_one) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <?php
                                    if (isset($edit)) {
                                        $gimage = '';
                                        $files = Gallerie::where('product_id', $edit->id)->get();
                                        foreach ($files as $key => $file) {
                                            $gimage = $gimage . '_____' . $file->photo;
                                        }
                                    }
                                    
                                    ?>
                                    <input type="hidden" name="gallary_images" id="gallary_images"
                                        value="<?= isset($edit) ? '' : '' ?>">
                                    <input type="hidden" name="delete_gallary_images" id="delete_gallary_images"
                                        value="">
                                </div>
                            </div>

                            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

                            <!-- Latest compiled and minified JavaScript -->

                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="javascript:void(0)">Gallery Images (500 x 500 px) Size under 100kb</a>
                                    <input type="file" name="gallary_images[]" style="display: ;"
                                        class="form-control" multiple>
                                </div>
                                <div class="col-sm-12">
                                    <div class="preview-images-zone">
                                        <?php 
                                
                                    if(isset($edit)){
                                        foreach ($files as  $key => $file){
                                            // dd($file);
                                            if($file !== ''){
                                                ?>
                                        <div class="preview-image preview-show-<?= $key ?>">
                                            <div class="image-cancel"><a
                                                    href="{{ route('admins.gallery_delete', ['id' => $file->id]) }}">x</a>
                                            </div>
                                            <div class="image-zone"><img id="pro-img-<?= $key ?>"
                                                    src="<?= $file->photo ?>">
                                            </div>

                                        </div>
                                        <?php
                                            }
                                                
                                        }
                                    }
                                ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Categories and Tags -->
                        <div class="section_box">

                            <input type="hidden" name="sub_cat_id" value="<?php echo isset($edit->subcategory_id) ? $edit->subcategory_id : 0; ?>">
                            <!-- Shor Description -->
                            {{-- <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group"><label class="col-sm-12 control-label">Product Short
                                            Discription:</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" rows="3" cols="3" name="short_discriiption" id="short_discriiption">
                                            <?php echo isset($edit->short_description) ? htmlspecialchars($edit->short_description) : null; ?>
        
                                        </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <h2>Categories and Tags</h2>

                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                    $cats = [];
                                    if (isset($edit->category_id)) {
                                        $cats = explode(',', $edit->category_id);
                                    }
                                    ?>
                                    <div class="box-item"><label class="control-label">Category:</label>
                                        <div class="">
                                            <select required class="form-control js-example-basic-multiple"
                                                name="category_id[]" multiple>
                                                @foreach ($categories as $category)
                                                    <option <?php echo isset($edit->category_id) && in_array($category->id, $cats) ? 'selected' : null; ?> value="{{ $category->id }}">
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="box-item"><label class=" control-label">Sub Category:</label>
                                        <div class="">
                                            <select class="form-control" name="subcategory_id">
                                                <option value="">Select</option>
                                                @foreach ($subcategories as $v)
                                                    <option value="{{ $v->id }}" <?php echo isset($edit->subcategory_id) && $edit->subcategory_id == $v->id ? 'selected' : null; ?>>
                                                        {{ $v->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Format:</label>
                                        <div class="col-sm-12">
                                            <select class="form-control" name="format" id="format"
                                                onchange="get_type();">
                                                <option value="">Select Format</option>
                                                @foreach ($format as $v)
                                                    <option value="{{ $v->id }}" <?php echo isset($edit->format) && $edit->format == $v->id ? 'selected' : null; ?>>
                                                        {{ $v->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box-item">
                                        <label class="control-label">Made in:</label>
                                        <select class="form-control" name="country">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $v)
                                                <option value="{{ $v->id }}" <?php echo isset($edit->country) && $edit->country == $v->id ? 'selected' : null; ?>>
                                                    {{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12" id="bundle_products"
                                    style="{{ isset($edit->format) && $edit->format == 3 ? '' : 'display: none;' }}">
                                    <?php
                                    $bpro = [];
                                    if (isset($edit->bundle_product_id)) {
                                        $bpro = explode(',', $edit->bundle_product_id);
                                    }
                                    ?>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Bundle Products:</label>
                                        <div class="col-sm-12">
                                            <select class="form-control" id="products" multiple
                                                name="bundle_product_id[]">
                                                @foreach ($products as $products)
                                                    <option <?php echo isset($edit->bundle_product_id) && in_array($products->id, $bpro) ? 'selected' : null; ?> value="{{ $products->id }}">
                                                        {{ $products->product_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="box-item">
                                        <label class=" control-label">Brand:</label>

                                        <select class="form-control" name="brand_id" required>
                                            <option value="">Select Brand</option>
                                            @foreach ($brands as $brand)
                                                <option <?php echo isset($edit->brand_id) && $edit->brand_id == $brand->id ? 'selected' : null; ?> value="{{ $brand->id }}">
                                                    {{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="box-item">
                                        <label class=" control-label">Product Tags:</label>
                                        <input type="text" data-role="tagsinput" class="form-control"
                                            value="<?php echo isset($edit->tags) ? htmlspecialchars($edit->tags) : null; ?>" name="tags">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing and Inventory -->

                        <div class="section_box">
                            <h2>Pricing</h2>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Selling Price:</label>
                                        <div class="col-sm-12"><input type="number" class="form-control" min="1"
                                                step="0.01" value="<?php echo isset($edit->discount_price) ? htmlspecialchars($edit->discount_price) : null; ?>" name="discount_price"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Comparing
                                            Price:</label>
                                        <div class="col-sm-12"><input type="number" class="form-control" step="0.01"
                                                value="<?php echo isset($edit->selling_price) ? htmlspecialchars($edit->selling_price) : null; ?>" name="selling_price"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">B2C
                                            Price:</label>
                                        <div class="col-sm-12"><input type="number" class="form-control" step="0.01"
                                                value="<?php echo isset($edit->b2c_price) ? htmlspecialchars($edit->b2c_price) : null; ?>" name="b2c_price"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">B2B
                                            Price:</label>
                                        <div class="col-sm-12"><input type="number" class="form-control" step="0.01"
                                                value="<?php echo isset($edit->b2b_price) ? htmlspecialchars($edit->b2b_price) : null; ?>" name="b2b_price"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">B2D
                                            Price:</label>
                                        <div class="col-sm-12"><input type="number" class="form-control" step="0.01"
                                                value="<?php echo isset($edit->b2d_price) ? htmlspecialchars($edit->b2d_price) : null; ?>" name="b2d_price"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">B2P
                                            Price:</label>
                                        <div class="col-sm-12"><input type="number" class="form-control" step="0.01"
                                                value="<?php echo isset($edit->b2p) ? htmlspecialchars($edit->b2p) : null; ?>" name="b2p_price"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Shipping Price:</label>
                                        <div class="col-sm-12"><input type="number" class="form-control" step="0.01"
                                                value="<?php echo isset($edit->shipping_price) ? htmlspecialchars($edit->shipping_price) : null; ?>" name="shipping_price"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Product
                                            Quantity:</label>
                                        <div class="col-sm-12">
                                            <input type="number" min="0" class="form-control" required
                                                value="<?php echo isset($edit->product_quantity) ? htmlspecialchars($edit->product_quantity) : null; ?>" name="product_quantity">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Selling Unit Weight (In
                                            grams):</label>
                                        <div class="col-sm-12"><input type="text" class="form-control"
                                                value="<?php echo isset($edit->weight) ? htmlspecialchars($edit->weight) : null; ?>" name="weight"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="section_box">
                            <h2>Inventory</h2>

                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Item number:</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="sku" class="form-control"
                                                value="<?php echo isset($edit->sku) ? htmlspecialchars($edit->sku) : null; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Barcode:</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="product_code" class="form-control"
                                                value="<?php echo isset($edit->product_code) ? htmlspecialchars($edit->product_code) : null; ?>">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Total Weight (In
                                            grams):</label>
                                        <div class="col-sm-12"><input type="text" class="form-control"
                                                value="<?php echo isset($edit->total_weight) ? htmlspecialchars($edit->total_weight) : null; ?>" name="total_weight"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Weight Per Piece (In
                                            grams):</label>
                                        <div class="col-sm-12"><input type="text" class="form-control"
                                                value="<?php echo isset($edit->weight_per_unit) ? $edit->weight_per_unit : null; ?>" name="weight_per_unit"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Qunatity Per
                                            Piece:</label>
                                        <div class="col-sm-12"><input type="text" class="form-control"
                                                value="<?php echo isset($edit->no_of_unit) ? $edit->no_of_unit : null; ?>" name="no_of_unit"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="section_box">
                            <h2>Supply details</h2>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Original name:</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" required
                                                value="<?php echo isset($edit->orignal_name) ? htmlspecialchars($edit->orignal_name) : null; ?>" name="orignal_name">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Sku:</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="sku_no" class="form-control"
                                                value="<?php echo isset($edit->sku_no) ? htmlspecialchars($edit->sku_no) : null; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Article :</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="article_number" class="form-control"
                                                value="<?php echo isset($edit->article_number) ? htmlspecialchars($edit->article_number) : null; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ----------------- -->



                        {{-- <div class="ibox-content">
                            <div class="row">
                                <div id="attributes-section">
                                    <label>Add Attributes</label>
                                    <div id="attributes-container">
                                        <!-- Attribute group -->
                                        <div class="attribute-group form-group">
                                                <div class="col-sm-12">
                                                    <input type="text" class="attribute-name form-control" placeholder="Attribute Name (e.g., Size)">
                                                </div>
                                                <div class="col-sm-12" id="attribute-values-container"></div>
                                                <div class="col-sm-12">
                                                    <button type="button" class="add-attribute btn btn-primary">Add Attribute</button>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Variations Section -->
                                <div id="variations-section">
                                    <h4>Generated Variations</h4>
                                    <div id="variations-container">
                                        <!-- Dynamically generated variations will appear here -->
                                    </div>
                                </div>
                                
                            </div>
                        </div> --}}

                        <div class="ibox-content" style="display:none;">
                            <div class="row">
                                <h1>Filters</h1>
                                {{-- <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Package Type:</label>
                                        <div class="col-sm-12">
                                            <select class="form-control" name="package_type_id">
                                                <option value="">Select Package Type</option>
                                                @foreach ($package_type as $package_type)
                                                    <option <?php echo isset($edit->package_type_id) && $edit->package_type_id == $package_type->id ? 'selected' : null; ?> value="{{ $package_type->id }}">
                                                        {{ $package_type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Basket Type:</label>
                                        <div class="col-sm-12">
                                            <select class="form-control" name="basket_type_id">
                                                <option value="">Select Basket Type</option>
                                                @foreach ($basket_type as $basket_type)
                                                    <option <?php echo isset($edit->basket_type_id) && $edit->basket_type_id == $basket_type->id ? 'selected' : null; ?> value="{{ $basket_type->id }}">
                                                        {{ $basket_type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}

                            </div>
                            <div class="row">



                            </div>
                            <div class="row">
                                {{-- <div class="col-sm-4">
                                    <div class="form-group"><label class="col-sm-12 control-label">Product Type:</label>
                                        <div class="col-sm-12">
                                            <select class="form-control" name="product_type_id">
                                                <option value="">Select Product Type</option>
                                                @foreach ($product_type as $product_type)
                                                    <option <?php echo isset($edit->product_type_id) && $edit->product_type_id == $product_type->id ? 'selected' : null; ?> value="{{ $product_type->id }}">
                                                        {{ $product_type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}


                            </div>


                            <div class="row">

                                {{-- <div class="col-sm-6">
                                    <div class="form-group"><label class="col-sm-12 control-label">Size:</label>
                                        <div class="col-sm-12">
                                            <?php
                                            $sizes = [];
                                            if (isset($edit->product_size)) {
                                                $sizes = explode(',', $edit->product_size);
                                            }
                                            ?>
                                            <select class="form-control js-example-basic-multiple" name="product_size[]"
                                                multiple>
                                                <option value="">Select Size</option>
                                                @foreach ($size as $size)
                                                    <option <?php echo isset($edit->product_size) && in_array($size->id, $sizes) ? 'selected' : null; ?> value="{{ $size->id }}">
                                                        {{ $size->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">


                            </div>

                            <div class="row">

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">

                                            <div class="row">


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (isset($edit->id))
                                <input type="hidden" name="hidden_id" value="{{ $edit->id }}">
                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="section_box">
                        <h2>Product Attributes</h2>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group"><label class="col-sm-12 control-label">Theme:</label>
                                    <div class="col-sm-12">
                                        <select class="form-control js-example-basic-multiple" name="theme_id[]" multiple>
                                            <option value="">Select Theme</option>
                                            @foreach ($theme as $theme)
                                                <option <?php echo isset($edit->theme_id) && $edit->theme_id == $theme->id ? 'selected' : null; ?> value="{{ $theme->id }}">
                                                    {{ $theme->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group"><label class="col-sm-12 control-label">Flavour:</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="flavour_id">
                                            <option value="">Select Flavour</option>
                                            @foreach ($flavour as $flavour)
                                                <option <?php echo isset($edit->flavour_id) && $edit->flavour_id == $flavour->id ? 'selected' : null; ?> value="{{ $flavour->id }}">
                                                    {{ $flavour->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group"><label class="col-sm-12 control-label">Color:</label>
                                    <div class="col-sm-12">
                                        <?php
                                        $colors = [];
                                        if (isset($edit->product_color)) {
                                            $colors = explode(',', $edit->product_color);
                                        }
                                        ?>
                                        <select class="form-control js-example-basic-multiple" name="product_color[]"
                                            multiple>
                                            <option value="">Select Color</option>
                                            @foreach ($color as $color)
                                                <option <?php echo isset($edit->product_color) && in_array($color->id, $colors) ? 'selected' : null; ?> value="{{ $color->id }}">
                                                    {{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <?php
                                $rpro = [];
                                if (isset($edit->related_product_id)) {
                                    $rpro = explode(',', $edit->related_product_id);
                                }
                                ?>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Related Products:</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" id="products_r" multiple
                                            name="related_product_id[]">
                                            @foreach ($rproducts as $products)
                                                <option <?php echo isset($edit->related_product_id) && in_array($products->id, $rpro) ? 'selected' : null; ?> value="{{ $products->id }}">
                                                    {{ $products->product_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section_box">
                        <h2>Product Attributes</h2>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group"><label class="col-sm-12 control-label">Shapes:</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="shape">
                                            <option value="">Select Shape</option>
                                            @foreach ($shapes as $shape)
                                                <option <?php echo isset($edit->shape) && $edit->shape == $shape->id ? 'selected' : null; ?> value="{{ $shape->id }}">
                                                    {{ ucfirst($shape->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group"><label class="col-sm-12 control-label">Types:</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="type">
                                            <option value="">Select Type</option>
                                            @foreach ($types as $type)
                                                <option <?php echo isset($edit->type) && $edit->type == $type->id ? 'selected' : null; ?> value="{{ $type->id }}">
                                                    {{ ucfirst($type->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section_box">
                        <h2>Nutritional Information</h2>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group"><label class="col-sm-12 control-label">Ingredient:</label>
                                    <div class="col-sm-12">
                                        <?php
                                        $ingredients = [];
                                        if (isset($edit->ingredient)) {
                                            $ingredients = explode(',', $edit->ingredient);
                                        }
                                        ?>
                                        <select class="form-control js-example-basic-multiple" name="ingredient[]"
                                            multiple>
                                            <option value="">Select Ingredient</option>
                                            @foreach ($ingredient as $ingredient)
                                                <option <?php echo isset($edit->ingredient) && in_array($ingredient->id, $ingredients) ? 'selected' : null; ?> value="{{ $ingredient->id }}">
                                                    {{ $ingredient->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group"><label class="col-sm-12 control-label">Product Ingredient:</label>
                                    <div class="col-sm-12">
                                        <textarea name="ingredients_ar" class="form-control" id="" required cols="30" rows="10"><?php echo isset($edit->ingredients_ar) ? htmlspecialchars($edit->ingredients_ar) : null; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group"><label class="col-sm-12 control-label">Product Ingredients
                                        Ar:</label>
                                    <div class="col-sm-12">
                                        <textarea name="ingredients" class="form-control" id="" required cols="30" rows="10"><?php echo isset($edit->ingredients) ? htmlspecialchars($edit->ingredients) : null; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group"><label class="col-sm-12 control-label">Nutritions:</label>
                                    <div class="col-sm-12">
                                        <textarea name="nutritions" class="form-control" id="" required cols="30" rows="10"><?php echo isset($edit->nutritions) ? htmlspecialchars($edit->nutritions) : null; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group"><label class="col-sm-12 control-label">Nutritions Ar:</label>
                                    <div class="col-sm-12">
                                        <textarea name="nutritions_ar" class="form-control" id="" required cols="30" rows="10"><?php echo isset($edit->nutritions_ar) ? htmlspecialchars($edit->nutritions_ar) : null; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group"><label class="col-sm-12 control-label">Allergen:</label>
                                    <div class="col-sm-12">
                                        <?php
                                        $allergens = [];
                                        if (isset($edit->allergen)) {
                                            $allergens = explode(',', $edit->allergen);
                                        }
                                        ?>
                                        <select class="form-control js-example-basic-multiple" name="allergen[]" multiple>
                                            <option value="">Select Allergen</option>
                                            @foreach ($allergen as $allergen)
                                                <option <?php echo isset($edit->allergen) && in_array($allergen->id, $allergens) ? 'selected' : null; ?> value="{{ $allergen->id }}">
                                                    {{ $allergen->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section_box">
                        <h2>Product Benefits</h2>

                        <div class="row">

                            <div class="col-sm-12">
                                <input type="checkbox" <?php if (isset($edit->palm_oil) && $edit->palm_oil == 1) {
                                    echo 'checked';
                                } ?> value="1" name="palm_oil">
                                <label for="trendproduct">
                                    Palm Oil Free
                                </label>
                            </div>

                            <div class="col-sm-12">
                                <input type="checkbox" <?php if (isset($edit->vegan) && $edit->vegan == 1) {
                                    echo 'checked';
                                } ?> value="1" name="vegan">
                                <label for="trendproduct">
                                    Vegan
                                </label>
                            </div>

                            <div class="col-sm-12">
                                <input type="checkbox" <?php if (isset($edit->gelatin_free) && $edit->gelatin_free == 1) {
                                    echo 'checked';
                                } ?> value="1" name="gelatin_free">
                                <label for="trendproduct">
                                    Gelatin Free
                                </label>
                            </div>

                            {{-- <div class="col-sm-12">
                                <input type="checkbox" <?php if (isset($edit->gluten_free) && $edit->gluten_free == 1) {
                                    echo 'checked';
                                } ?> value="1" name="gluten_free">
                                <label for="trendproduct">
                                    Gluten Free
                                </label>
                            </div> --}}

                            {{-- <div class="col-sm-12">
                                <input type="checkbox" <?php if (isset($edit->lactose_free) && $edit->lactose_free == 1) {
                                    echo 'checked';
                                } ?> value="1" name="lactose_free">
                                <label for="trendproduct">
                                    Lactose Free
                                </label>
                            </div> --}}
                        </div><br>
                        <h2>Sustainability & Impact</h2>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="checkbox" <?php if (isset($edit->sustainability) && $edit->sustainability == 1) {
                                    echo 'checked';
                                } ?> value="1" name="sustainability">
                                <label for="trendproduct">
                                    Sustainability & Impact
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="section_box">
                        <h2>Show on</h2>

                        <div class="row">
                            <div class="col-sm-12">
                                <input type="checkbox" <?php if (isset($edit->new_arrival) && $edit->new_arrival == 1) {
                                    echo 'checked';
                                } ?> value="1" name="New_Arrival">
                                <label for="trendproduct">
                                    Just Unwrapped
                                </label>
                            </div>

                            <div class="col-sm-12">
                                <input type="checkbox" <?php if (isset($edit->featured) && $edit->featured == 1) {
                                    echo 'checked';
                                } ?> value="1" name="Featured">
                                <label for="trendproduct">
                                    Featured
                                </label>
                            </div>



                            {{-- <div class="col-sm-12">
                                <input type="checkbox" 
                                <?php if (isset($edit->sale) && $edit->sale == 1) {
                                    echo 'checked';
                                } ?>
                                    value="1" name="Sale">
                                <label for="trendproduct">
                                    Sale
                                </label>
                            </div> --}}
                        </div>
                    </div>
                    <div class="section_box">
                        <div class="row">


                            <div class="col-sm-12">
                                <div class="form-group"><label class="col-sm-12 control-label">Seo Title:</label>
                                    <div class="col-sm-12"><input type="text" class="form-control" required
                                            value="<?php echo isset($seo[0]->title) ? htmlspecialchars($seo[0]->title) : null; ?>" name="stitle"></div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group"><label class="col-sm-12 control-label">Seo
                                        Description:</label>
                                    <div class="col-sm-12"><input type="text" class="form-control" required
                                            value="<?php echo isset($seo[0]->description) ? htmlspecialchars($seo[0]->description) : null; ?>" name="sdescription"></div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group"><label class="col-sm-12 control-label">Seo keywords:</label>
                                    <div class="col-sm-12"><input type="text" class="form-control" required
                                            value="<?php echo isset($seo[0]->keywords) ? htmlspecialchars($seo[0]->keywords) : null; ?>" name="skeywords"></div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="col-sm-10"><button class="btn btn-md btn-primary"
                                            type="submit"><strong>Save</strong></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Editor Modal -->
    <div id="image-editor-modal" class="modal_image" style="display:none;">
        <div class="modal-content">
            <h4>Crop Image</h4>
            <div class="image-container">
                <img id="image-to-edit" src="" alt="Image to edit" />
            </div>
            <div style="margin-top: 10px;display: flex;justify-content: end;gap: 10px;">
                <button id="close-modal" class="btn btn-danger">Cancel</button>
                <button id="save-cropped-image" class="btn btn-success">Save Image</button>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8/hammer.min.js"></script>

    <script>
        var cropper;
        var currentImageInput;

        function triggerImageEditor(inputId) {
            currentImageInput = $('#' + inputId);
            var file = currentImageInput[0].files[0];

            if (file && file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-to-edit').attr('src', e.target.result);
                    $('#image-editor-modal').show();

                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper($('#image-to-edit')[0], {
                        aspectRatio: 1, // square cropper
                        viewMode: 0, // allow crop box to extend beyond the image
                        dragMode: 'move',
                        movable: true,
                        zoomable: true,
                        zoomOnWheel: true,
                        wheelZoomRatio: 0.2,
                        scalable: true,
                        cropBoxResizable: true,
                        minCropBoxWidth: 600,
                        minCropBoxHeight: 600,
                        background: false,
                        autoCropArea: 1,
                        responsive: true,
                        toggleDragModeOnDblclick: false,
                        ready() {
                            // Make the crop box a square that contains the whole image
                            const img = cropper.getImageData(); // {left, top, width, height} in the container
                            const cx = img.left + img.width / 2;
                            const cy = img.top + img.height / 2;
                            const size = Math.max(img.width, img.height); // square that covers image

                            cropper.setCropBoxData({
                                left: Math.round(cx - size / 2),
                                top: Math.round(cy - size / 2),
                                width: Math.round(size),
                                height: Math.round(size)
                            });
                        }
                    });

                };
                reader.readAsDataURL(file);
            }
        }

        // Save cropped image
        $('#save-cropped-image').on('click', function() {
            if (!cropper) return;

            // Desired CSS size for your UI (what you already use)
            const cssSize = 1080;

            // Device pixel ratio for crispness on HiDPI displays
            const dpr = Math.max(1, Math.floor(window.devicePixelRatio || 1));

            // Natural (intrinsic) crop box size in source image pixels
            const cropData = cropper.getData(true); // true => natural image size
            // The crop is square in your setup; use the smaller side to be safe
            const naturalCropSize = Math.floor(Math.min(cropData.width, cropData.height));

            // Target pixel size for the exported bitmap:
            // - Don’t upscale beyond the natural crop (keeps it sharp)
            // - Do scale up to cssSize * dpr for retina crispness if available
            const targetPx = Math.min(naturalCropSize, cssSize * dpr);

            // If you MUST always output exactly 600x600 pixels (not recommended when source is smaller),
            // set `const targetPx = cssSize * dpr;` but expect blur when upscaling.

            const canvas = cropper.getCroppedCanvas({
                width: targetPx,
                height: targetPx,
                fillColor: '#ffffff',
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            // Data URL (PNG is lossless; JPEG is smaller but lossy)
            const base64Image = canvas.toDataURL('image/png');

            // Attach hidden input for your form
            const inputName = currentImageInput.attr('name') === 'thumb' ?
                'thumb_base64' :
                'image_one_base64';

            // Remove any old hidden input with same name to avoid duplicates
            $('#product_form input[name="' + inputName + '"]').remove();

            $('<input>', {
                type: 'hidden',
                name: inputName,
                value: base64Image
            }).appendTo('#product_form');

            // Preview: show at cssSize but use high-DPI pixels for sharpness
            const previewId = currentImageInput.attr('name') === 'thumb' ?
                '#thumb-preview' :
                '#image-one-preview';

            $(previewId)
                .attr('src', base64Image)
                .show();

            $('#image-editor-modal').hide();
        });



        // Close modal
        $('#close-modal').on('click', function() {
            $('#image-editor-modal').hide();
        });
    </script>
    <script>
        function get_type() {
            let format = $('#format').val();
            if (format == 3) {
                $('#bundle_products').show();
            } else {
                $('#bundle_products').hide();
            }
        }
        $(document).ready(function() {
            let attributes = {};

            // Add new input for attribute values dynamically
            $(document).on('keyup', '.attribute-name', function() {
                const attributeName = $(this).val().trim();
                const container = $('#attribute-values-container');
                container.empty();

                if (attributeName) {
                    container.append(`
                        <div class="row attribute-value-row">
                            <div class="col-sm-10">
                                <input type="text" class="form-control attribute-value" placeholder="Add value ">
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="remove-attribute-value btn btn-danger">Remove</button>
                            </div>
                        </div>
                    `);
                }
            });

            // Add additional value input
            $(document).on('keydown', '.attribute-value:last', function(e) {
                // if (e.key === "Enter" || e.keyCode === 13) {
                $('#attribute-values-container').append(`
                        <div class="row attribute-value-row">
                            <div class="col-sm-10">
                                <input type="text" class="form-control attribute-value" placeholder="Add value">
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="remove-attribute-value btn btn-danger">Remove</button>
                            </div>
                        </div>
                    `);
                // }
            });

            // Remove a value input
            $(document).on('click', '.remove-attribute-value', function() {
                $(this).closest('.attribute-value-row').remove();
            });

            // Add attribute with values
            $('.add-attribute').on('click', function() {
                const attributeName = $('.attribute-name').val().trim();
                const attributeValues = $('.attribute-value')
                    .map(function() {
                        return $(this).val().trim();
                    })
                    .get()
                    .filter(Boolean);

                if (attributeName && attributeValues.length) {
                    attributes[attributeName] = attributeValues;

                    // Clear inputs
                    $('.attribute-name').val('');
                    $('#attribute-values-container').empty();

                    // Generate and display variations
                    generateVariations();
                } else {
                    alert('Please provide both attribute name and at least one value.');
                }
            });

            // Generate and display variations in collapsible sections
            function generateVariations() {
                const combinations = generateCombinations(Object.values(attributes));
                const keys = Object.keys(attributes);

                // Group combinations by the first attribute value
                const groupedCombinations = {};
                combinations.forEach(combination => {
                    const groupKey = combination[0]; // First attribute value
                    if (!groupedCombinations[groupKey]) {
                        groupedCombinations[groupKey] = [];
                    }
                    groupedCombinations[groupKey].push(combination);
                });

                $('#variations-container').empty();

                // Render each group as a collapsible section
                Object.entries(groupedCombinations).forEach(([groupKey, groupCombinations], groupIndex) => {
                    const groupID = `group-${groupIndex}`;

                    // Collapsible group header
                    $('#variations-container').append(`
                        <div class="variation-group">
                            <div class="card">
                                <div class="card-header">
                                    <h5>
                                        <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#${groupID}" aria-expanded="true">
                                            ${keys[0]}: ${groupKey}
                                        </button>
                                    </h5>
                                </div>
                                <div id="${groupID}" class="collapse">
                                    <div class="card-body" id="${groupID}-body">
                                        <!-- Variations within this group will go here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);

                    // Render each variation within the group
                    groupCombinations.forEach((combination, index) => {
                        const variationKey = combination.join(' - ');
                        const variationID = `${groupID}-variation-${index}`;
                        $(`#${groupID}-body`).append(`
                            <div class="variation">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h6>Variation: ${variationKey}</h6>
                                    </div>
                                    <input type="hidden" name="variations[${index}][attributes]" value="${combination.join(',')}">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="variations[${index}][price]" placeholder="Price">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="variations[${index}][stock]" placeholder="Stock">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="file" class="form-control" name="variations[${index}][image]">
                                    </div>
                                </div>
                                <hr>
                            </div>
                        `);
                    });
                });
            }


            // Function to generate combinations
            function generateCombinations(arrays, i = 0) {
                if (!arrays[i]) return [
                    []
                ];
                const combinations = [];
                const rest = generateCombinations(arrays, i + 1);
                arrays[i].forEach(value => {
                    rest.forEach(combination => {
                        combinations.push([value, ...combination]);
                    });
                });
                return combinations;
            }
        });



        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
            $('#products_r').select2({
                ajax: {
                    url: "{{ route('admins.get_products') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    type: 'POST',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            $('#products').select2({
                ajax: {
                    url: "{{ route('admins.get_products') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    type: 'POST',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
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

        function readURL1(input) {
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
                let content = $('#product_details').summernote('code').trim();
                if (!content || content === '<p><br></p>') {
                    e.preventDefault();
                    $('.error-message').remove();
                    $('#product_details').after(
                        '<span class="error-message" style="color: red;">Product details cannot be empty.</span>'
                    );
                    $('#product_details').summernote('focus');
                    return false;
                }
                // Validate Comparing Price > Selling Price
                let sellingPrice = parseFloat($('input[name="discount_price"]').val()) || 0;
                let comparingPrice = parseFloat($('input[name="selling_price"]').val()) || 0;
                if (sellingPrice >= comparingPrice && comparingPrice !== 0) {
                    e.preventDefault();
                    $('.error-message-price').remove();
                    $('input[name="selling_price"]').after(
                        '<span class="error-message-price" style="color: red;">Comparing Price must be higher than Selling Price.</span>'
                    );
                    $('input[name="selling_price"]').focus();
                    return false;
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

    <script>
        $(document).ready(function() {
            const PICK_MIX_FORMAT_ID = '1'; // Replace with your actual Pick%Mix format ID

            function updateWeightsAndUnits() {
                const weightPerUnit = parseFloat($('input[name="weight_per_unit"]').val()) || 0;
                const totalWeight = parseFloat($('input[name="total_weight"]').val()) || 0;

                if (weightPerUnit > 0) {
                    const quantityPerUnit = totalWeight / weightPerUnit;
                    $('input[name="no_of_unit"]').val(Math.floor(quantityPerUnit));
                } else {
                    $('input[name="no_of_unit"]').val('');
                }
            }

            function handlePickMixCalculations() {
                const selectedFormat = $('#format').val();
                const isPickMix = selectedFormat === PICK_MIX_FORMAT_ID;

                if (isPickMix) {
                    $('input[name="weight"]').val(100);

                    const quantity = parseInt($('input[name="product_quantity"]').val()) || 0;
                    const totalWeight = quantity * 100;
                    $('input[name="total_weight"]').val(totalWeight);

                    updateWeightsAndUnits();
                } else {
                    // Clear the values when not Pick%Mix
                    $('input[name="weight"]').val('');
                    $('input[name="total_weight"]').val('');
                    $('input[name="no_of_unit"]').val('');
                }
            }

            // Bind events
            $('#format').change(function() {
                handlePickMixCalculations();
            });

            $('input[name="product_quantity"]').on('keyup', function() {
                handlePickMixCalculations();
            });

            $('input[name="weight_per_unit"]').on('keyup', function() {
                updateWeightsAndUnits();
            });

            // Trigger once on page load
            handlePickMixCalculations();

        });
    </script>


    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endpush
