@extends('admins.master')

@section('title', 'Category')

@section('category_active', 'active')

@section('category_child_1_active', 'active')

@section('category_active_c1', 'collapse in')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Category Form</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form role="form" class="form-inline" autocomplete="off" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group" style="display: flex;flex-direction: column;">
                                <label for="exampleInputEmail2">Category</label>
                                <input type="text" required name="name"
                                    value="{{ isset($edit->name) ? $edit->name : '' }}" id="exampleInputEmail2"
                                    class="form-control">
                            </div>

                            <div class="form-group" style="display: flex;flex-direction: column;">
                                <label for="exampleInputEmail2">Category Ar</label>
                                <input type="text" required name="name_ar"
                                    value="{{ isset($edit->name_ar) ? $edit->name_ar : '' }}" dir="rtl"
                                    id="exampleInputEmail2" class="form-control">
                            </div>

                            <div class="form-group" style="display: flex;flex-direction: column;">
                                <label for="exampleInputEmail2">Category Subtitle</label>
                                <input type="text" required name="sub_title"
                                    value="{{ isset($edit->sub_title) ? $edit->sub_title : '' }}" id="exampleInputEmail2"
                                    class="form-control">
                            </div>

                            <div class="form-group" style="display: flex;flex-direction: column;">
                                <label for="exampleInputEmail2">Category Ar Subtitle</label>
                                <input type="text" required name="sub_title_ar"
                                    value="{{ isset($edit->sub_title_ar) ? $edit->sub_title_ar : '' }}" dir="rtl"
                                    id="exampleInputEmail2" class="form-control">
                            </div>

                            <div class="form-group" style="display: flex;flex-direction: column;">
                                <label for="exampleInputEmail2">Category Description</label>
                                <textarea name="description" id="description" class="form-control summernote" rows="3">{{ isset($edit->description) ? $edit->description : '' }}</textarea>
                            </div>

                            <div class="form-group" style="display: flex;flex-direction: column;">
                                <label for="exampleInputEmail2">Category Ar Description</label>
                                <textarea name="description_ar" id="description_ar" class="form-control summernote" rows="3" dir="rtl">{{ isset($edit->description_ar) ? $edit->description_ar : '' }}</textarea>
                            </div>

                            <div class="form-group" style="display: flex;flex-direction: column;">
                                <label for="exampleInputEmail2">Color</label>
                                <input type="color" required name="color"
                                    value="{{ isset($edit->color) ? $edit->color : '' }}" id="exampleInputEmail2"
                                    class="form-control">
                            </div>

                            <div class="form-group" style="margin:10px 0px 10px 0px;">
                                <div class="d-flex align-items-center">
                                    <label class="form-check-label" for="categorytypelabel">Category Type</label>
                                    <div class="form-check form-check-inline" style="margin:10px 0px 10px 0px;">
                                        <input type="radio" name="categoryType" id="manualRadio"
                                            {{ isset($edit->is_manual) && $edit->is_manual == 1 ? 'checked' : '' }}
                                            value="1">
                                        <label for="manualRadio">Manual</label>
                                        <input type="radio" name="categoryType" id="smartRadio" value="2"
                                            {{ isset($edit->is_manual) && $edit->is_manual == 2 ? 'checked' : '' }}>
                                        <label for="smartRadio">Smart</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group condition"
                                style="display: {{ isset($edit->is_manual) && $edit->is_manual == 2 ? 'flex' : 'none' }};flex-direction: column;margin:10px 0px 10px 0px;">
                                <div class="d-flex align-items-center">
                                    <label class="form-check-label" for="">Conditions</label>
                                    <div class="form-check form-check-inline" style="margin:10px 0px 10px 0px;">
                                        <label class="form-check-label text-secondary" for="">Product must match:
                                        </label>
                                        <input type="radio" name="is_condition" id="radio1"
                                            {{ isset($edit->is_condition) && $edit->is_condition == 1 ? 'checked' : '' }}
                                            value="1">
                                        <label for="radio1">All Conditions</label>
                                        <input type="radio" name="is_condition" id="radio2" value="2"
                                            {{ isset($edit->is_condition) && $edit->is_condition == 2 ? 'checked' : '' }}>
                                        <label for="radio2">Any Condition</label>
                                    </div>
                                </div>
                                @if (isset($category_conditions) && $category_conditions->count() > 0)

                                    @foreach ($category_conditions as $ccKey => $ccValue)
                                        <div class="conditions-wrapper">
                                            <div class="condition-row d-flex align-items-center mb-2"
                                                style="width: 100%; margin-bottom:8px;">
                                                <div class="d-flex flex-grow-1 gap-2" style="width: 100%">
                                                    <select name="type[]"
                                                        onchange="loadCategoryConditions(this.value, this)"
                                                        data-type="{{ $ccValue->type }}"
                                                        data-pre-selected="{{ $ccValue->condition }}"
                                                        class="form-control type-select" style="width: 30%">
                                                        <option value="">Select type</option>
                                                        @if ($category_types)
                                                            @foreach ($category_types as $key => $value)
                                                                <option value="{{ $value->name }}"
                                                                    {{ $ccValue->type == $value->name ? 'selected' : '' }}>
                                                                    {{ $value->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <select name="condition[]" class="form-control condition-select"
                                                        style="width: 30%">
                                                        <option value="">Select condition</option>
                                                    </select>
                                                    <input type="text"
                                                        name="condition_value[{{ $ccKey }}][normal]"
                                                        class="form-control normal-text" placeholder="Enter value"
                                                        style="width: 30%;display:none"
                                                        value="{{ $ccValue->condition_value }}">
                                                    <select name="condition_value[{{ $ccKey }}][brand]"
                                                        class="form-control brands" style="width: 30%;display:none;">
                                                        <option value="">Select Brand</option>
                                                        @if ($brands)
                                                            @foreach ($brands as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                    {{ $ccValue->type == 'Brand' && $ccValue->condition_value == $value->id ? 'selected' : '' }}>
                                                                    {{ $value->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    <select class="form-control js-example-basic-multiple products"
                                                        name="condition_value[{{ $ccKey }}][product][]"
                                                        style="width: 30%;display:none;" multiple>

                                                        @if ($products)
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}"
                                                                    {{ isset($ccValue->condition_value) && in_array($product->id, explode(',', $ccValue->condition_value)) ? 'selected' : null }}>
                                                                    {{ $product->product_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <select name="condition_value[{{ $ccKey }}][theme]"
                                                        class="form-control themes" style="width: 30%;display:none;">
                                                        <option value="">Select Theme</option>
                                                        @if ($themes)
                                                            @foreach ($themes as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                    {{ $ccValue->type == 'Theme' && $ccValue->condition_value == $value->id ? 'selected' : '' }}>
                                                                    {{ $value->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <select name="condition_value[{{ $ccKey }}][color]"
                                                        class="form-control colors" style="width: 30%;display:none;">
                                                        <option value="">Select Color</option>
                                                        @if ($colors)
                                                            @foreach ($colors as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                    {{ $ccValue->type == 'Color' && $ccValue->condition_value == $value->id ? 'selected' : '' }}>
                                                                    {{ $value->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <select name="condition_value[{{ $ccKey }}][allergens]"
                                                        class="form-control allergens" style="width: 30%;display:none;">
                                                        <option value="">Select Allergen</option>
                                                        @if ($allergens)
                                                            @foreach ($allergens as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                    {{ $ccValue->type == 'Allergens' && $ccValue->condition_value == $value->id ? 'selected' : '' }}>
                                                                    {{ $value->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <select name="condition_value[{{ $ccKey }}][flavours]"
                                                        class="form-control flavours" style="width: 30%;display:none;">
                                                        <option value="">Select Flavour</option>
                                                        @if ($flavours)
                                                            @foreach ($flavours as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                    {{ $ccValue->type == 'Flavour' && $ccValue->condition_value == $value->id ? 'selected' : '' }}>
                                                                    {{ $value->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <select name="condition_value[{{ $ccKey }}][formats]"
                                                        class="form-control formats" style="width: 30%;display:none;">
                                                        <option value="">Select Format</option>
                                                        @if ($formats)
                                                            @foreach ($formats as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                    {{ $ccValue->type == 'Format' && $ccValue->condition_value == $value->id ? 'selected' : '' }}>
                                                                    {{ $value->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <select name="condition_value[{{ $ccKey }}][countries]"
                                                        class="form-control countries" style="width: 30%;display:none;">
                                                        <option value="">Select Country</option>
                                                        @if ($countries)
                                                            @foreach ($countries as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                    {{ $ccValue->type == 'Made in' && $ccValue->condition_value == $value->id ? 'selected' : '' }}>
                                                                    {{ $value->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <button type="button" class="btn btn-secondary condition-btn"
                                                        onclick="removeConditionRow(this)">
                                                        <i width="16" height="16" fill="currentColor"
                                                            class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="conditions-wrapper">
                                        <div class="condition-row d-flex align-items-center mb-2"
                                            style="width: 100%; margin-bottom:8px;">
                                            <div class="d-flex flex-grow-1 gap-2" style="width: 100%">
                                                <select name="type[]" onchange="loadCategoryConditions(this.value, this)"
                                                    class="form-control" style="width: 30%">
                                                    <option value="">Select type</option>
                                                    @if ($category_types)
                                                        @foreach ($category_types as $key => $value)
                                                            <option value="{{ $value->name }}">
                                                                {{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                                <select name="condition[]" class="form-control condition-select"
                                                    style="width: 30%">
                                                    <option value="">Select condition</option>
                                                </select>
                                                <input type="text" name="condition_value[]"
                                                    class="form-control normal-text" placeholder="Enter value"
                                                    style="width: 30%">
                                                <select name="condition_value[]" class="form-control brands"
                                                    style="width: 30%;display:none;">
                                                    <option value="">Select Brands</option>
                                                    @if ($brands)
                                                        @foreach ($brands as $key => $value)
                                                            <option value="{{ $value->id }}">
                                                                {{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <select class="form-control js-example-basic-multiple products"
                                                    name="condition_value[2][]" style="width: 30%;display:none;" multiple>

                                                    @if ($products)
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}">
                                                                {{ $product->product_name }}</option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                                <select name="condition_value[]" class="form-control themes"
                                                    style="width: 30%;display:none;">
                                                    <option value="">Select Theme</option>
                                                    @if ($themes)
                                                        @foreach ($themes as $key => $value)
                                                            <option value="{{ $value->id }}">
                                                                {{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <select name="condition_value[]" class="form-control colors"
                                                    style="width: 30%;display:none;">
                                                    <option value="">Select Color</option>
                                                    @if ($colors)
                                                        @foreach ($colors as $key => $value)
                                                            <option value="{{ $value->id }}">
                                                                {{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <select name="condition_value[]" class="form-control allergens"
                                                    style="width: 30%;display:none;">
                                                    <option value="">Select Allergen</option>
                                                    @if ($allergens)
                                                        @foreach ($allergens as $key => $value)
                                                            <option value="{{ $value->id }}">
                                                                {{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <select name="condition_value[]" class="form-control flavours"
                                                    style="width: 30%;display:none;">
                                                    <option value="">Select Flavour</option>
                                                    @if ($flavours)
                                                        @foreach ($flavours as $key => $value)
                                                            <option value="{{ $value->id }}">
                                                                {{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <select name="condition_value[]" class="form-control formats"
                                                    style="width: 30%;display:none;">
                                                    <option value="">Select Format</option>
                                                    @if ($formats)
                                                        @foreach ($formats as $key => $value)
                                                            <option value="{{ $value->id }}">
                                                                {{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <select name="condition_value[]" class="form-control countries"
                                                    style="width: 30%;display:none;">
                                                    <option value="">Select Country</option>
                                                    @if ($countries)
                                                        @foreach ($countries as $key => $value)
                                                            <option value="{{ $value->id }}">
                                                                {{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <button type="button" class="btn btn-secondary condition-btn"
                                                    onclick="removeConditionRow(this)">
                                                    <i width="16" height="16" fill="currentColor"
                                                        class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                <!-- Add Another Button -->
                                <div style="margin-top:8px">
                                    <button type="button" class="btn btn-primary" onclick="addConditionRow()">Add
                                        Another</button>
                                </div>
                            </div>


                            {{-- <div class="form-group" style="display: flex;flex-direction: column;">
                                <label for="exampleInputEmail2">Featured image (Main Thumbnail) (180 x 180 px Round) Size
                                    under 50kb:</label>
                                <input type="file" onchange="readURL(this);" <?php echo isset($edit->id) ? null : 'required'; ?>
                                    accept="image/png, image/gif, image/jpeg" class="form-control" name="image_one">
                                <img src="<?php echo isset($edit->image) ? asset($edit->image) : null; ?>" alt="" <?php echo isset($edit->image) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>>

                            </div> --}}

                            {{-- <div class="form-group" style="display: flex;flex-direction: column;">
                                <label for="exampleInputEmail2">Icon (50 x 50 px Svg) Size under 50kb:</label>
                                <input type="file" onchange="readURL(this);" <?php echo isset($edit->id) ? null : 'required'; ?>
                                    accept="image/png, image/gif, image/jpeg ,image/svg" class="form-control"
                                    name="icon">
                                <img src="<?php echo isset($edit->icon) ? asset($edit->icon) : null; ?>" alt="" <?php echo isset($edit->icon) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>>

                            </div> --}}

                            <div class="form-group" style="display: flex;flex-direction: column;">
                                <label for="exampleInputEmail2">Main Image (Optional - fallback to banner):</label>
                                <input type="file" onchange="readURL(this);" accept="image/png, image/gif, image/jpeg"
                                    class="form-control" name="homepage_image">
                                <img src="<?php echo isset($edit->homepage_image) ? asset($edit->homepage_image) : null; ?>" alt="" <?php echo isset($edit->homepage_image) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>>

                            </div>

                            <div class="form-group" style="display: flex;flex-direction: column;">
                                <label for="exampleInputEmail2">Category Banner:</label>
                                <input type="file" onchange="readURL(this);" <?php echo isset($edit->id) ? null : ''; ?>
                                    accept="image/png, image/gif, image/jpeg" class="form-control" name="banner">
                                <img src="<?php echo isset($edit->banner) ? asset($edit->banner) : null; ?>" alt="" <?php echo isset($edit->banner) ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>>

                            </div>

                            <div class="form-group" style="display: flex;flex-direction: column;margin-bottom: 8px;">
                                <label>Sort No:</label>
                                <input type="text" class="form-control" value="<?php echo isset($edit->sort_no) ? htmlspecialchars($edit->sort_no) : 0; ?>" name="sort_no">
                            </div>
                            <div class="form-group" style="display: flex;flex-direction: column;margin-bottom: 8px;">
                                <label>Show Product On Home (Carousel Slider):</label>
                                <select name="status" class="form-control" required>
                                    <option value="1"
                                        <?= isset($edit->status) && $edit->status == 1 ? 'selected' : '' ?>>Active</option>
                                    <option value="0"
                                        <?= isset($edit->status) && $edit->status == 0 ? 'selected' : '' ?>>Inactive
                                    </option>
                                </select>
                            </div>
                            <div class="form-group" style="display: flex;flex-direction: column;margin-bottom: 8px;">
                                <label>Show On Home Page (Main Categories With New Page):</label>
                                <select name="home_cat" class="form-control" required>
                                    <option value="1"
                                        <?= isset($edit->home_cat) && $edit->home_cat == 1 ? 'selected' : '' ?>>Active
                                    </option>
                                    <option value="0"
                                        <?= isset($edit->home_cat) && $edit->home_cat == 0 ? 'selected' : '' ?>>Inactive
                                    </option>
                                </select>
                            </div>
                            {{-- <div class="form-group" style="display: flex;flex-direction: column;margin-bottom: 8px;">
                                <label>Show In Header Menu (With New Page):</label>
                                <select name="menu" class="form-control" required>
                                    <option value="1" <?= isset($edit->menu) && $edit->menu == 1 ? 'selected' : '' ?>>
                                        Active</option>
                                    <option value="0" <?= isset($edit->menu) && $edit->menu == 0 ? 'selected' : '' ?>>
                                        Inactive</option>
                                </select>
                            </div> --}}
                            {{-- <div class="form-group" style="display: flex;flex-direction: column;margin-bottom: 8px;">
                                <label>Show In Header Menu On Mobile (With New Page):</label>
                                <select name="show_no_mob" class="form-control" required>
                                    <option value="1"
                                        <?= isset($edit->show_no_mob) && $edit->show_no_mob == 1 ? 'selected' : '' ?>>
                                        Yes</option>
                                    <option value="0"
                                        <?= isset($edit->show_no_mob) && $edit->show_no_mob == 0 ? 'selected' : '' ?>>
                                        No</option>
                                </select>
                            </div> --}}
                            <div class="form-group" style="display: flex;flex-direction: column;margin-bottom: 8px;">
                                <label>Show In Mega Menu (With New Page):</label>
                                <select name="mega_menu" class="form-control" required>
                                    <option value="1"
                                        <?= isset($edit->mega_menu) && $edit->mega_menu == 1 ? 'selected' : '' ?>>
                                        Active</option>
                                    <option value="0"
                                        <?= isset($edit->mega_menu) && $edit->mega_menu == 0 ? 'selected' : '' ?>>
                                        Inactive</option>
                                </select>
                            </div>

                            <div class="form-group" style="display: flex;flex-direction: column;margin-bottom: 8px;">
                                <label>Show On Cart:</label>
                                <select name="show_on_cart" class="form-control" required>
                                    <option value="1"
                                        <?= isset($edit->show_on_cart) && $edit->show_on_cart == 1 ? 'selected' : '' ?>>
                                        Active</option>
                                    <option value="0"
                                        <?= isset($edit->show_on_cart) && $edit->show_on_cart == 0 ? 'selected' : '' ?>>
                                        Inactive</option>
                                </select>
                            </div>
                            <div class="form-group" style="display: flex;flex-direction: column;">
                                <label>Seo Title:</label>
                                <input type="text" class="form-control" required value="<?php echo isset($seo->title) ? htmlspecialchars($seo->title) : null; ?>"
                                    name="stitle">
                            </div>

                            <div class="form-group" style="display: flex;flex-direction: column;">
                                <label>Seo Description:</label>
                                <input type="text" class="form-control" required value="<?php echo isset($seo->description) ? htmlspecialchars($seo->description) : null; ?>"
                                    name="sdescription">
                            </div>

                            <div class="form-group" style="display: flex;flex-direction: column;margin-bottom: 8px;">
                                <label>Seo keywords:</label>
                                <input type="text" class="form-control" required value="<?php echo isset($seo->keywords) ? htmlspecialchars($seo->keywords) : null; ?>"
                                    name="skeywords">
                            </div>

                            @error('name')
                                <span class="help-block m-b-none text-danger">{{ $message }}</span>
                            @enderror
                            @if (isset($edit->id))
                                <input type="hidden" name="hidden_id" value="{{ $edit->id }}">
                            @endif

                            <button class="btn btn-sm btn-primary" type="submit"><strong>Save</strong></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Category List</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <!--<th>Image</th>-->
                                        <th>Category</th>
                                        <th>Visits</th>
                                        <th>Creation Ago</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr=1; @endphp
                                    @foreach ($categories as $item)
                                        <tr>
                                            <td>{{ $sr++ }}</td>
                                            <!--<td><img src="{{ asset($item->image) }}" style="width:50px;" ></td>-->
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->view }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('admins.category') }}/{{ $item->id }}"
                                                    class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0)"
                                                    data-href="{{ route('admins.category') }}/{{ $item->id }}/{{ 'delete' }}"
                                                    class="btn btn-danger delete_record">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <style>
        .select2-container--default .select2-selection--multiple {
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 4px;
            cursor: text;
            padding-bottom: 5px;
            padding-right: 5px;
            position: relative;
            display: flex;
            flex-wrap: wrap;
            /* Ensure items wrap to the next row */
            height: auto;
            /* Allow height to adjust dynamically */
            min-height: 38px;
            /* Ensure a default height */
            overflow: hidden;
            /* Hide overflow for clean rows */
            align-items: center;
            /* Center items vertically */
        }

        .select2-container--default .select2-selection__choice {
            margin: 2px 5px 2px 0;
            /* Add spacing between items */
            display: inline-block;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $('.js-example-basic-multiple').hide();
            if ($('.conditions-wrapper').length === 1) {
                $('.condition-btn').hide(); // Hide all delete buttons
            }
            const radioManual = document.getElementById('manualRadio');
            const radioSmart = document.getElementById('smartRadio');
            const conditionDiv = document.querySelector('.condition');

            // Event Listener for Manual
            radioManual.addEventListener('change', function() {
                if (radioManual.checked) {
                    conditionDiv.style.display = 'none';
                }
            });

            // Event Listener for Smart
            radioSmart.addEventListener('change', function() {
                if (radioSmart.checked) {
                    conditionDiv.style.display = 'flex';
                }
            });
        });

        // Load conditions dynamically based on selected type
        function loadCategoryConditions(type, element, preselectedValue = null) {
            // console.log(element);
            let $container = $(element).closest('.condition-row');

            // Hide all by default
            $container.find('.normal-text').hide();
            $container.find('.brands').hide();
            $container.find('.themes').hide();
            $container.find('.colors').hide();
            $container.find('.allergens').hide();
            $container.find('.flavours').hide();
            $container.find('.formats').hide();
            $container.find('.countries').hide();
            $container.find('.products').hide();
            $container.find('.select2-container ').hide();

            // Show the relevant section based on the selected type
            if (type === 'Brand') {
                $container.find('.brands').show();
            } else if (type === 'Theme') {
                $container.find('.themes').show();
            } else if (type === 'Allergens') {
                $container.find('.allergens').show();
            } else if (type === 'Color') {
                $container.find('.colors').show();
            } else if (type === 'Flavour') {
                $container.find('.flavours').show();
            } else if (type === 'Products') {
                // Reinitialize select2 for the newly added row

                $container.find('.js-example-basic-multiple').select2();
                $container.find('.products').show();
            } else if (type === 'Format') {
                $container.find('.formats').show();
            } else if (type === 'Made in') {
                $container.find('.countries').show();
            } else {
                $container.find('.normal-text').show();
            }

            let conditionSelect = $(element).closest('.condition-row').find('.condition-select');
            conditionSelect.html('<option value="">Loading...</option>');

            $.ajax({
                url: '{{ URL::to('admin/category/condition') }}',
                type: 'GET',
                data: {
                    type: type
                },
                success: function(response) {
                    if (response.status === 'success') {
                        let options = '<option value="">Select condition</option>';
                        response.conditions.forEach(function(condition) {
                            let isSelected = (preselectedValue && preselectedValue == condition.value) ?
                                'selected' : '';
                            options +=
                                `<option value="${condition.value}" ${isSelected}>${condition.name}</option>`;
                        });
                        conditionSelect.html(options);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching conditions:', error);
                    conditionSelect.html('<option value="">Failed to load</option>');
                }
            });
        }

        // Add a new row dynamically
        function addConditionRow() {
            // Clone only the last .condition-row inside the last .conditions-wrapper
            let newRow = $('.conditions-wrapper').last().clone();
            // Clear the selected values in the cloned row
            newRow.find('select').val('');
            newRow.find('input').val('');

            // Increment the index for each element's name attribute
            newRow.find('select, input').each(function() {
                let name = $(this).attr('name');
                if (name) {
                    // Match the index inside square brackets [index]
                    name = name.replace(/\[(\d+)\]/, function(match, index) {
                        return `[${parseInt(index) + 1}]`;
                    });
                    $(this).attr('name', name);
                }
            });
            // Append the cloned row to the last .conditions-wrapper
            $('.conditions-wrapper').last().after(newRow);
            if ($('.conditions-wrapper').length > 1) {
                $('.condition-btn').show(); // Hide all delete buttons
            }

            let $container = $('.conditions-wrapper').last().children('.condition-row');
            // Hide all by default
            $container.find('.normal-text').show();
            $container.find('.brands').hide();
            $container.find('.themes').hide();
            $container.find('.colors').hide();
            $container.find('.allergens').hide();
            $container.find('.flavours').hide();
            $container.find('.formats').hide();
            $container.find('.countries').hide();
            $container.find('.products').hide();
            $container.find('.select2-container').hide();
        }

        function removeConditionRow(element) {
            // Remove the closest .conditions-wrapper parent of the clicked button

            $(element).parent().parent().parent().remove();
            if ($('.conditions-wrapper').length === 1) {
                $('.condition-btn').hide(); // Hide all delete buttons
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Select all type-select and condition-select elements
            const typeSelectElements = document.querySelectorAll('.type-select');
            const conditionSelectElements = document.querySelectorAll('.condition-select');

            // Check if the number of type-select and condition-select match
            if (typeSelectElements.length !== conditionSelectElements.length) {
                console.error('Mismatch: type-select and condition-select counts do not match.');
                return;
            }

            // Iterate over both sets of elements
            typeSelectElements.forEach((typeSelect, index) => {
                const conditionSelect = conditionSelectElements[index];
                const selectedType = typeSelect.value;
                const preSelectedValue = typeSelect.getAttribute('data-pre-selected') || null;

                if (selectedType) {
                    console.log(`Populating condition-select #${index + 1} with type:`, selectedType);
                    loadCategoryConditions(selectedType, conditionSelect, preSelectedValue);
                } else {
                    console.warn(`No type selected for type-select #${index + 1}`);
                }
            });
        });

        document.querySelector('form').addEventListener('submit', function() {
            document.querySelectorAll('select[name^="condition_value"]').forEach(select => {
                if (!select.value) {
                    select.disabled = true;
                }
            });
        });
    </script>
@endsection
