@extends('admins.master')

@section('title', 'Products')
@section('product_active', 'active')
@section('product_active_c1', 'collapse in')
@section('product_child_2_active', 'active')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caprasimo&family=Noto+Kufi+Arabic:wght@100..900&display=swap"
        rel="stylesheet">

    <style>
        /* Ensure the Select2 multi-select container grows with content */
        .select2-container--default .select2-selection--multiple {
            min-height: 38px;
            /* Minimum height for when no items are selected */
            height: auto !important;
            /* Allow the container to grow dynamically */
            overflow: visible;
            /* Ensure content doesn't get clipped */
        }

        /* Ensure the inner selection area adjusts to content */
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            display: inline-flex;
            flex-wrap: wrap;
            /* Allow tags to wrap to the next line */
            padding: 2px 5px;
            /* Add some padding for better spacing */
            height: auto;
            /* Allow the rendered area to grow */
        }

        /* Style for individual selected items (tags) */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #e4e4e4;
            border: 1px solid #aaa;
            border-radius: 4px;
            padding: 2px 5px;
            margin: 2px;
            display: inline-flex;
            align-items: center;
        }

        /* Ensure the remove button in tags is styled correctly */
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            margin-right: 5px;
            color: #999;
        }

        /* Fix z-index for dropdown in modal */
        .modal {
            overflow-y: auto;
        }

        .select2-container--open {
            z-index: 9999;
        }

        .select2-dropdown {
            z-index: 9999;
        }

        .label_banner {
            border: 1px solid rgba(0, 0, 0, 0.2);
            display: flex;
            /* padding: 0px 12px; */
            align-items: center;
            justify-content: center;
            height: 151.1811023622047px;
            width: 377.95275590551176px;
            margin: auto;
        }

        .left_side .logo {
            width: 80px;
        }

        .label_banner h2 {
            margin: 0px;
            color: #000 !important;

        }

        .label_banner .left_side {
            width: 111px;
            /* border-right: 0.5px solid #D9D9D9; */
        }

        .label_banner .left_side,
        .label_banner .right_side {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: center;
            gap: 2px;
            width: 50%;
            justify-content: space-between;
            /* padding: 10px 0px; */
            height: 100%;
        }

        .label_banner .left_side .product_image {
            width: 55px !important;
            aspect-ratio: 1 / 1;
            object-fit: cover;
        }

        .medium_label_banner.label_banner .left_side .product_image {
            width: 38px;

        }

        .label_banner .left_side {
            justify-content: center;
            align-items: center;
            width: 40%;
            gap: 12px;
        }

        .medium_label_banner.label_banner {
            height: 198.4252px;
            width: 283.4646px;
            padding: 8px;
            gap: 10px;
        }

        /* .medium_label_banner.label_banner .left_side .product_name {
                                            font-size: 6px;
                                            line-height: 8px;

                                        } */

        .label_banner .left_side ul {
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .medium_label_banner.label_banner .left_side ul li {

            font-size: 5px;
            line-height: 12px;
            align-items: center;
            font-weight: 700;


        }

        .label_banner .Qr_code img {
            width: 33px;
            height: 33px;
        }

        .medium_label_banner.label_banner .Qr_code img {
            width: 32px;
            height: 32px;
        }

        .medium_label_banner.label_banner .left_side .logo {
            width: 62px;
        }

        .medium_label_banner.label_banner .left_side {
            width: 37%;
            gap: 8px;
        }

        .medium_label_banner.label_banner h2 {
            font-size: 10px;
        }

        .medium_label_banner.label_banner .left_side ul li svg {
            width: 10px;
            height: 10px;
        }

        .medium_label_banner.label_banner .Qr_code svg {
            width: 42px;
            height: 42px;
        }

        .medium_label_banner.label_banner .left_side ul {
            gap: 3px;
        }

        .label_banner .left_side ul {
            display: grid;
            grid-template-columns: auto auto;
            gap: 2px;
            padding: 0px;
            margin-bottom: 0px;
            list-style: none;
        }

        .bar_code img,
        .bar_code svg {
            height: 40px;
            width: 100px;

        }

        .label_banner .left_side ul li {
            font-weight: 400;
            font-size: 6px;
            line-height: 8px;
            letter-spacing: 0%;
            gap: 2px;
            text-align: left;
            display: flex;
        }

        .label_banner .left_side ul li svg {
            width: 12px;
            height: 12px;
        }

        .label_banner .left_side ul li span {
            color: #000 !important;
        }

        .label_banner .right_side {
            display: flex;
            flex-direction: column;
            gap: 6px;
            align-items: center;
            justify-content: space-between;
            flex: 1 1 auto;
        }

        .label_banner .right_side h2 {
            /* font-family: "Inter"; */
            font-weight: 600;
            font-size: 10px;
            line-height: 100%;
            letter-spacing: 0%;
            text-align: left;
            color: #303030;
        }

        .medium_label_banner.label_banner .right_side h2 {
            font-size: 10px;
            text-align: center;
        }

        .medium_label_banner.label_banner .right_side .ingrediants {
            text-align: center;
            margin: 0px;
            margin-top: -2px;
            text-orientation: sideways;
            text-emphasis-position: over right;
            width: auto;
            font-size: 4px;
            line-height: 8px;
        }

        .label_banner .right_side .ingrediants {
            font-weight: 400;
            font-size: 6px;
            line-height: 6px;
            letter-spacing: 0%;
            margin: 0px;

            text-align: left;

        }

        .d-flex {
            display: flex;
            justify-content: space-between;
            gap: 2px;
            align-items: center;
            width: 100%;
        }

        .flex-column {
            flex-direction: column;
            align-items: flex-start;
        }

        .ingredient-title {
            font-size: 8px !important;
        }

        .small_label_banner {
            /* padding-top: 12px; */
        }

        .loader {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3498db;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-left: 5px;
        }

        .d-flex:has(.product_name) {
            align-items: center;
            justify-content: center;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="row">
                            <div class="col-sm-6">
                                <h5>Product List</h5>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="{{ route('admins.products.export') }}" class="btn btn-md btn-primary">Export</a>
                                <a href="{{ route('admins.products.import.export') }}"
                                    class="btn btn-md btn-primary">Import</a>
                                <a href="{{ route('admins.product_form') }}" class="btn btn-md btn-primary">Add</a>
                                <button type="button" class="btn btn-md btn-primary" data-toggle="modal"
                                    data-target="#exportModal">
                                    Custom Export
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-2" style="margin-bottom: 5px;">
                                <select id="categoryFilter" class="form-control">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2" style="margin-bottom: 5px;">
                                <select id="formatFilter" class="form-control">
                                    <option value="">All Formats</option>
                                    @foreach ($formats as $format)
                                        <option value="{{ $format->id }}">{{ $format->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2" style="margin-bottom: 5px;">
                                <select id="statusFilter" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2" style="margin-bottom: 5px;">
                                <input type="text" id="searchInput" class="form-control"
                                    placeholder="Search by Name, SKU">
                            </div>
                            <div class="col-md-2" style="margin-bottom: 5px;">
                                <input type="text" id="articleNumberInput" class="form-control"
                                    placeholder="Article Numbers (comma separated)">
                            </div>
                            <div class="col-md-1 text-right">
                                <button id="filterBtn" class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="button" class="btn btn-md btn-primary" id="generateMultipleLabelsBtn">
                                Generate Multiple Labels
                            </button>
                        </div>

                        <div class="table-responsive mt-3">
                            <table id="productTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Sort Order</th>
                                        <th>Category</th>
                                        <th>Format</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Visits</th>
                                        <th>Status</th>
                                        <th>Trending products</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Custom Excel Export</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <form id="extractExcelForm" action="{{ route('admins.products.custom_export') }}" method="POST">
                        @csrf

                        <!-- Export Type Selection -->
                        <div class="form-group">
                            <label>Export Type</label>
                            <select class="form-control" name="export_type" id="exportType">
                                <option value="products">Specific Products</option>
                                <option value="categories">By Categories</option>
                            </select>
                        </div>

                        <!-- Product Selection -->
                        <div class="form-group" id="productSelection">
                            <label>Select Products</label>
                            <select class="form-control" name="product_ids[]" multiple="multiple" id="productSelect">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple products</small>
                        </div>

                        <!-- Category Selection -->
                        <div class="form-group" id="categorySelection" style="display: none;">
                            <label>Select Categories</label>
                            <select class="form-control" name="category_ids[]" multiple="multiple" id="categorySelect">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple categories</small>
                        </div>

                        <!-- Column Selection -->
                        <div class="form-group">
                            <label>Select Columns</label>
                            <select class="form-control" name="columns[]" multiple="multiple" id="columnSelect">
                                <option value="product_name">Product Name</option>
                                <option value="name_ar">Name (Arabic)</option>
                                <option value="category_id">Category ID</option>
                                <option value="brand_id">Brand ID</option>
                                <option value="name_sw">Name (Swedish)</option>
                                <option value="slug">Slug</option>
                                <option value="sku">SKU</option>
                                <option value="product_code">Product Code</option>
                                <option value="product_quantity">Product Quantity</option>
                                <option value="product_details">Product Details</option>
                                <option value="related_product_id">Related Product ID</option>
                                <option value="product_color">Product Color</option>
                                <option value="product_size">Product Size</option>
                                <option value="product_shape">Product Shape</option>
                                <option value="tags">Tags</option>
                                <option value="selling_price">Discounted Price</option>
                                <option value="discount_price">Price</option>
                                <option value="shipping_price">Shipping Price</option>
                                <option value="new_arrival">New Arrival</option>
                                <option value="featured">Featured</option>
                                <option value="view">Visits</option>
                                <option value="sale">Sale</option>
                                <option value="status">Status</option>
                                <option value="image_one">Image One</option>
                                <option value="thumb">Thumbnail</option>
                                <option value="gallary_images">Gallery Images</option>
                                <option value="theme_id">Theme ID</option>
                                <option value="package_type_id">Package Type ID</option>
                                <option value="flavour_id">Flavour ID</option>
                                <option value="basket_type_id">Basket Type ID</option>
                                <option value="product_type_id">Product Type ID</option>
                                <option value="ingredient">Ingredient</option>
                                <option value="allergen">Allergen</option>
                                <option value="weight">Weight</option>
                                <option value="format_id">Format</option>
                                <option value="country">Country</option>
                                <option value="sub_category_id">Sub Category ID</option>
                                <option value="total_weight">Total Weight</option>
                                <option value="palm_oil">Palm Oil</option>
                                <option value="vegan">Vegan</option>
                                <option value="gelatin_free">Gelatin Free</option>
                                <option value="lactose_free">Lactose Free</option>
                                <option value="sustainability">Sustainability</option>
                                <option value="bundle_product_id">Bundle Product ID</option>
                                <option value="shape">Shape</option>
                                <option value="ingredients_ar">Ingredients (Arabic)</option>
                                <option value="b2c_price">B2C Price</option>
                                <option value="b2b_price">B2B Price</option>
                                <option value="b2d_price">B2D Price</option>
                                <option value="b2p">B2P</option>
                                <option value="HS_Code">HS Code</option>
                                <option value="Country_Code">Country Code</option>
                                <option value="Country">Country</option>
                                <option value="Country_in_English">Country in English</option>
                                <option value="Country_in_Arabic">Country in Arabic</option>
                                <option value="nutritional_facts">Nutritional Facts</option>
                                <option value="sort_order">Sort Order</option>
                                <option value="gluten_free">Gluten Free</option>
                                <option value="sku_no">SKU Number</option>
                                <option value="article_number">Article Number</option>
                                <option value="orignal_name">Original Name</option>
                                <option value="original_price">Original Price</option>
                                <option value="nutritions">Nutritions</option>
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple columns</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="extractBtn">Extract Excel</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Size Selection Modal -->
    <div class="modal fade" id="sizeSelectionModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Size</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <form id="sizeSelectionForm">
                        <div class="form-group">
                            <label>Select Size</label>
                            <select class="form-control" id="sizeSelect" name="size">
                                <option value="">Select a size</option>
                                <option value="MOE (100mm x 400mm)">MOE (100mm x 40mm)</option>
                                <option value="DFC (100mm x 600mm)">DFC (100mm x 70mm)</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="proceedToLabelBtn">Proceed</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Label Generation Modal -->
    <div class="modal fade" id="labelGenerationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span id="heading_label"></span> Label</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="labelProductId">
                    <div class="form-group">
                        <div class="label_banner" id="label_id">
                            <div class="left_side">
                                <div class="logo">
                                    <svg viewBox="0 0 212 92" fill="none" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <path
                                            d="M83.1485 65.7289C83.4418 64.7772 83.7462 63.832 84.0257 62.8739C84.2996 61.9352 84.5403 60.9836 84.817 60.045C84.889 59.7973 85.0246 59.5659 85.1657 59.3605C85.6472 58.6631 85.9183 58.5523 86.4026 58.8C86.9366 59.0737 87.1967 59.6669 87.039 60.4198C86.8757 61.1987 86.6682 61.9646 86.4496 62.724C85.9598 64.4285 85.4618 66.1265 84.9499 67.8212C84.7423 68.5056 84.5127 69.1835 84.2498 69.8386C83.8624 70.8033 82.5896 70.95 82.0721 70.0341C81.7041 69.3791 81.4827 68.6034 81.2337 67.8636C80.8325 66.6675 80.4617 65.4583 80.0024 64.0178C79.8031 64.4578 79.7035 64.6305 79.6454 64.8228C79.2386 66.1558 78.8457 67.4953 78.4362 68.8283C78.3255 69.1868 78.1899 69.542 78.0322 69.8745C77.4982 70.9891 76.6072 71.0934 75.9182 70.1091C75.7134 69.819 75.5335 69.4801 75.4229 69.1249C74.6149 66.5013 73.8263 63.8712 73.0459 61.2378C72.9629 60.9575 72.9463 60.6349 72.9436 60.335C72.9353 59.4029 73.1732 59.002 73.7654 58.8814C74.4267 58.7478 74.8445 59.0509 75.0936 59.8722C75.5584 61.4236 76.0122 62.9814 76.4771 64.536C76.5823 64.888 76.7151 65.2302 76.9198 65.8234C77.1716 65.1781 77.3653 64.7642 77.4982 64.3307C77.8551 63.1802 78.165 62.0102 78.5358 60.8663C78.7074 60.335 78.926 59.8038 79.2054 59.3475C79.7063 58.5295 80.3676 58.5099 80.9487 59.4551C81.1894 59.8461 81.2918 60.3611 81.4329 60.8304C81.9172 62.4469 82.3931 64.0634 82.8718 65.6832C82.9659 65.6963 83.06 65.7126 83.154 65.7256L83.1485 65.7289Z"
                                            fill="#E92827" />
                                        <path
                                            d="M180.707 65.9539C180.76 65.3151 180.804 64.9175 180.821 64.5134C180.884 62.9425 180.909 61.3716 181.009 59.804C181.07 58.8393 181.579 58.3993 182.154 58.7578C182.583 59.025 182.976 59.4064 182.971 60.0843C182.971 60.4297 182.973 60.7785 182.973 61.1239C182.973 63.4737 182.973 65.8203 182.973 68.1701C182.973 68.5156 182.987 68.8708 182.924 69.2033C182.805 69.8323 182.724 70.6047 182.091 70.7514C181.441 70.9045 180.821 70.6666 180.372 69.9789C179.6 68.7959 178.798 67.6389 178.018 66.4656C177.539 65.7421 177.08 65.0023 176.598 64.2787C176.512 64.1484 176.363 64.0767 176.131 63.8811C176.111 64.2918 176.097 64.546 176.086 64.8002C176.025 66.2147 175.995 67.6356 175.893 69.0468C175.862 69.4836 175.699 69.9366 175.505 70.3179C175.32 70.6894 174.996 70.9404 174.586 70.7514C174.249 70.5949 173.942 70.4189 173.925 69.8747C173.906 69.1902 173.773 68.5058 173.767 67.8214C173.748 65.3966 173.776 62.9718 173.751 60.5438C173.743 59.817 173.878 59.2923 174.484 58.9631C175.096 58.6307 175.608 58.8654 176.003 59.3314C176.601 60.0321 177.129 60.8176 177.65 61.5998C178.513 62.8936 179.343 64.2168 180.195 65.5205C180.267 65.6313 180.397 65.6932 180.71 65.9474L180.707 65.9539Z"
                                            fill="#E92827" />
                                        <path
                                            d="M186.293 64.7323C186.293 63.269 186.285 61.8056 186.296 60.3423C186.301 59.5112 186.525 59.1592 187.195 58.9213C188.249 58.5498 189.329 58.6247 190.402 58.729C190.917 58.7779 191.42 58.9572 191.935 59.0386C194.467 59.4297 196.21 62.6172 195.842 65.5015C195.491 68.2717 194.165 70.4521 191.138 70.6053C190.225 70.6509 189.306 70.6183 188.39 70.6085C188.13 70.6085 187.865 70.5987 187.613 70.5336C186.296 70.1881 186.29 70.1718 186.29 68.552C186.29 67.281 186.29 66.0099 186.29 64.7388L186.293 64.7323ZM188.449 67.9458C189.71 68.6172 190.92 68.3728 192.007 67.8057C193.059 67.2581 193.593 66.0588 193.504 64.69C193.404 63.1614 192.71 62.0077 191.443 61.5058C190.9 61.2907 190.297 61.232 189.719 61.2157C188.794 61.1897 188.482 61.5417 188.46 62.653C188.424 64.3836 188.451 66.1142 188.451 67.9458H188.449Z"
                                            fill="#E92827" />
                                        <path
                                            d="M101.121 65.0412C101.201 63.4735 101.273 61.9026 101.37 60.3383C101.431 59.3736 101.661 59.0379 102.449 58.8521C102.986 58.725 103.551 58.637 104.09 58.6859C105.155 58.7804 106.224 58.9206 107.272 59.1585C108.905 59.5267 109.799 60.9151 110.399 62.6066C111.06 64.4741 110.847 66.3155 110.053 68.0396C109.597 69.0369 108.836 69.7767 107.917 70.1319C107.22 70.3992 106.464 70.5393 105.728 70.5914C104.655 70.6664 103.573 70.6175 102.496 70.6077C101.722 70.6012 101.511 70.4155 101.376 69.5257C101.279 68.8902 101.223 68.2384 101.201 67.5898C101.174 66.7457 101.193 65.8983 101.193 65.0509C101.168 65.0509 101.146 65.0477 101.121 65.0444V65.0412ZM103.681 68.3785C104.547 68.2644 105.216 68.1569 105.889 68.095C107.931 67.9059 108.791 66.058 108.338 63.832C108.169 63.0075 107.823 62.1373 107.026 61.7821C106.265 61.4431 105.51 61.1139 104.663 61.1856C103.755 61.2606 103.689 61.2899 103.681 62.4143C103.672 63.9559 103.681 65.4942 103.681 67.0357C103.681 67.4138 103.681 67.7886 103.681 68.3753V68.3785Z"
                                            fill="#E92827" />
                                        <path
                                            d="M168.023 67.5443H163.523C163.366 68.4275 163.247 69.2488 163.061 70.0538C162.965 70.4677 162.71 70.8393 162.287 70.7969C161.847 70.7545 161.465 70.5492 161.365 69.9463C161.335 69.7573 161.243 69.578 161.243 69.3922C161.235 67.1988 161.094 64.9859 161.288 62.8153C161.443 61.0815 162.312 59.7843 163.817 59.0348C165.488 58.2004 167.004 58.4677 168.488 59.4226C169.547 60.1037 170.159 61.2607 170.253 62.6784C170.369 64.396 170.408 66.1266 170.427 67.8507C170.436 68.5709 170.342 69.301 170.247 70.018C170.17 70.6144 169.611 70.9175 169.132 70.6796C168.67 70.4514 168.402 70.0375 168.305 69.477C168.2 68.8805 168.125 68.2743 168.017 67.5443H168.023ZM168.028 64.9892C168.142 64.1776 168.216 63.5095 167.995 62.8447C167.655 61.8278 166.398 60.8794 165.626 61.0489C164.295 61.3389 163.416 62.4699 163.382 63.9234C163.366 64.6991 163.537 64.9598 164.232 64.9794C165.463 65.012 166.697 64.9892 168.028 64.9892Z"
                                            fill="#E92827" />
                                        <path
                                            d="M125.553 67.4299C125.327 66.1198 124.377 66.1947 123.575 66.022C122.654 65.8232 121.71 65.745 120.8 65.4973C119.601 65.1714 119.084 64.0698 119.184 62.8737C119.214 62.4924 119.175 62.1013 119.211 61.7199C119.341 60.4261 120.097 59.6797 121.007 59.1974C122.797 58.2523 124.615 58.2946 126.361 59.3799C126.976 59.7612 127.474 60.3185 127.358 61.3028C127.272 62.0068 126.871 62.3946 126.276 62.1762C125.719 61.9709 125.177 61.7004 124.643 61.4201C123.763 60.9573 122.9 60.8204 122.034 61.4592C121.666 61.7297 121.433 62.0687 121.533 62.5967C121.627 63.0953 121.987 63.2354 122.346 63.2908C123.376 63.4505 124.411 63.5516 125.44 63.7276C127.095 64.0111 127.739 64.9563 127.867 66.7586C127.983 68.4044 127.172 69.871 125.908 70.3599C123.879 71.1453 121.882 71.0638 119.942 69.9101C119.483 69.6363 119.233 69.2355 119.167 68.6749C119.103 68.1371 119.101 67.5635 119.538 67.2213C119.934 66.9117 120.385 67.0193 120.733 67.3452C121.821 68.3653 123.085 68.3588 124.369 68.3001C124.898 68.274 125.304 68.0198 125.553 67.4267V67.4299Z"
                                            fill="#E92827" />
                                        <path
                                            d="M69.2701 62.4442C68.3625 61.9879 67.5462 61.4893 66.6856 61.1731C65.5373 60.7495 64.7293 61.2351 64.1261 62.5713C64.4028 63.0928 64.8206 63.2688 65.3436 63.3242C66.3453 63.4252 67.3414 63.5719 68.3376 63.7381C68.653 63.7902 68.9657 63.9304 69.259 64.0868C71.1904 65.133 70.9829 68.9168 69.3392 69.9206C68.4925 70.4388 67.6126 70.7778 66.6469 70.8299C65.4294 70.8951 64.2451 70.755 63.1189 70.1781C62.4465 69.8326 61.8239 69.4252 61.7879 68.4051C61.7492 67.3264 62.3496 66.7951 63.1631 67.271C64.1344 67.8348 65.1388 68.1998 66.2069 68.4279C66.8129 68.5583 67.3082 68.3465 67.7869 68.0825C68.4372 67.7272 68.451 66.8538 67.8118 66.4823C67.3608 66.2215 66.8295 66.1368 66.3259 66.0227C65.3436 65.8044 64.3364 65.7001 63.3707 65.41C62.3967 65.1167 61.9816 64.3964 61.9761 63.2199C61.9733 62.5778 61.9844 61.9064 62.1283 61.2937C62.5682 59.4491 63.8964 58.9667 65.2744 58.6864C66.4809 58.442 67.6652 58.6343 68.7913 59.2372C68.9684 59.3317 69.1677 59.3839 69.3199 59.5143C70.5567 60.5539 70.5457 61.2742 69.2728 62.4475L69.2701 62.4442Z"
                                            fill="#E92827" />
                                        <path
                                            d="M92.0696 61.1996V63.2528C93.11 63.3408 94.1365 63.4158 95.1576 63.52C95.6418 63.5689 96.1261 63.6308 96.5992 63.758C97.0586 63.8818 97.3325 64.2599 97.3131 64.84C97.2965 65.306 96.8455 65.7623 96.353 65.7949C95.1189 65.8796 93.882 65.9416 92.6479 66.0165C92.4901 66.0263 92.3324 66.0524 92.2107 66.0687C92.1443 66.186 92.0834 66.2447 92.0779 66.3098C91.9367 68.135 92.0696 68.3012 93.6357 68.3044C94.5184 68.3044 95.4039 68.2751 96.2838 68.3142C96.7985 68.337 97.3214 68.4185 97.8223 68.5652C98.4283 68.7444 98.6247 69.6439 98.1405 70.11C97.861 70.3805 97.4432 70.5728 97.0862 70.5825C95.1244 70.6282 93.1625 70.6151 91.2007 70.5988C90.473 70.5923 90.0468 70.1523 89.9112 69.3343C89.8753 69.1094 89.8836 68.8748 89.8836 68.6434C89.8836 66.0622 89.8753 63.4809 89.8836 60.8997C89.8891 59.2473 90.271 58.6965 91.6573 58.6868C93.4808 58.6737 95.307 58.7943 97.1305 58.8758C97.3519 58.8856 97.5843 58.954 97.7863 59.0616C98.1294 59.2408 98.4061 59.5178 98.3646 60.023C98.3287 60.4923 98.1073 60.8247 97.7199 60.9388C97.3131 61.0561 96.8925 61.1735 96.4775 61.1865C95.3651 61.2191 94.2528 61.1996 93.1404 61.1996C92.8194 61.1996 92.5012 61.1996 92.0696 61.1996Z"
                                            fill="#E92827" />
                                        <path
                                            d="M137.707 66.0159H133.249C133.163 66.5374 133.047 67.0035 133.022 67.4793C132.983 68.1702 133.028 68.8644 133.005 69.5586C132.981 70.3212 132.388 70.9437 131.76 70.7873C131.497 70.7221 131.185 70.4092 131.08 70.1159C130.922 69.6727 130.872 69.148 130.869 68.6591C130.85 65.9247 130.869 63.1903 130.853 60.4559C130.847 59.8725 130.961 59.4162 131.348 59.0349C131.91 58.4776 132.56 58.6308 132.828 59.4423C132.934 59.7584 132.981 60.1072 133.005 60.4461C133.036 60.8665 133.011 61.2935 133.014 61.7172C133.028 63.1153 133.349 63.5423 134.53 63.5032C135.565 63.4706 136.594 63.3174 137.726 63.2066C137.793 62.5254 137.848 61.854 137.928 61.1827C137.989 60.6547 138.033 60.1137 138.172 59.6118C138.343 58.9828 138.852 58.6112 139.278 58.6992C139.627 58.7709 140.172 59.4423 140.239 59.9051C140.266 60.0941 140.252 60.2897 140.252 60.482C140.252 63.1773 140.261 65.8758 140.247 68.5711C140.247 68.985 140.172 69.4054 140.089 69.8128C139.945 70.5266 139.644 70.8166 139.101 70.8231C138.661 70.8297 138.26 70.4777 138.125 69.8813C138.022 69.4413 137.975 68.9817 137.931 68.5287C137.851 67.7368 137.79 66.9448 137.712 66.0225L137.707 66.0159Z"
                                            fill="#E92827" />
                                        <path
                                            d="M153.648 70.8232C152.101 70.9308 150.806 70.1062 149.821 68.669C149.259 67.8477 148.908 66.8601 148.858 65.7325C148.778 63.9791 149.151 62.3789 149.884 60.8927C150.316 60.0193 150.897 59.2957 151.808 59.0937C151.998 59.0513 152.189 58.9894 152.367 58.9014C154.29 57.9106 155.944 58.7547 157.477 60.0421C157.984 60.469 158.338 61.1991 158.105 62.0627C157.884 62.8873 157.386 63.148 156.761 62.7211C156.481 62.5288 156.251 62.2452 155.975 62.0464C155.562 61.7466 155.156 61.3783 154.702 61.2316C153.518 60.8471 152.203 61.6488 151.506 62.9818C150.56 64.7939 151.132 67.2317 152.762 68.053C153.822 68.5875 154.934 68.5288 155.889 67.6228C156.384 67.1535 156.877 66.7819 157.558 66.8667C158.291 66.9579 158.615 67.4826 158.346 68.2811C158.125 68.9427 157.718 69.4316 157.184 69.7803C156.108 70.481 154.968 70.8591 153.65 70.8265L153.648 70.8232Z"
                                            fill="#E92827" />
                                        <path
                                            d="M202.426 63.2223C202.935 62.4597 203.356 61.7948 203.812 61.1625C204.377 60.3836 204.772 59.4254 205.611 58.9431C205.973 58.7345 206.278 58.6921 206.604 58.9822C206.92 59.2625 207.108 59.6079 206.934 60.074C206.621 60.9083 206.355 61.785 205.937 62.5411C205.533 63.2712 205.008 63.9295 204.457 64.5162C203.74 65.2755 203.502 66.2174 203.475 67.2799C203.458 67.8926 203.505 68.5118 203.458 69.1213C203.43 69.4863 203.323 69.8741 203.157 70.1805C202.949 70.5618 202.667 70.9301 202.194 70.7769C201.707 70.6205 201.416 70.2392 201.333 69.6525C201.305 69.4635 201.305 69.268 201.322 69.0789C201.527 66.9018 200.835 65.1484 199.557 63.6166C198.898 62.8312 198.336 61.9284 197.761 61.055C197.246 60.2728 197.318 59.6079 197.918 59.0571C198.455 58.565 198.848 58.5487 199.377 59.1973C200.074 60.0512 200.691 60.993 201.352 61.886C201.668 62.3097 202.011 62.7106 202.423 63.2223H202.426Z"
                                            fill="#E92827" />
                                        <path
                                            d="M116.118 64.1451C116.035 65.9832 115.954 67.8214 115.866 69.6563C115.824 70.5264 115.752 70.5884 114.967 70.6047C114.045 70.621 113.918 70.5036 113.896 69.4607C113.832 66.4656 113.782 63.4737 113.721 60.4786C113.71 59.9604 113.744 59.478 114.136 59.1358C114.482 58.836 114.831 58.497 115.288 58.7838C115.725 59.0576 116.087 59.3607 116.057 60.0973C116.001 61.44 116.04 62.7893 116.04 64.1386C116.065 64.1386 116.093 64.1386 116.118 64.1418V64.1451Z"
                                            fill="#E92827" />
                                        <path
                                            d="M105.634 44.5599C105.741 44.0145 105.884 43.4764 106.056 42.948C106.179 42.565 106.325 42.1893 106.446 41.8064C106.519 41.5785 106.591 41.3507 106.671 41.1253C105.838 41.9906 104.851 42.6862 103.707 43.2074C102.66 43.6849 101.586 44.1188 100.406 44.1212C100.275 44.1212 100.144 44.0339 99.9863 43.9806C100.333 43.4861 100.629 43.045 100.944 42.6159C102.267 40.8126 103.385 38.8928 103.915 36.7065C104.184 35.5988 104.398 34.4426 104.393 33.3106C104.386 31.9266 104.058 30.5886 103.389 29.3088C102.551 27.7017 101.237 26.7879 99.5888 26.3274C98.1005 25.9105 96.5686 26.0947 95.0585 26.3516C94.0381 26.5261 93.1194 26.9746 92.2347 27.4787C90.4774 28.4798 89.0546 29.8517 88.1505 31.66C87.6778 32.6028 87.4233 33.6621 87.1252 34.685C86.9603 35.2546 86.8125 35.8097 86.4368 36.2896C85.6078 37.3464 84.8637 38.4614 84.3886 39.7242C84.088 40.5217 83.7947 41.3361 83.6469 42.1675C83.5014 42.9771 83.482 43.823 83.5208 44.6472C83.6178 46.6954 85.0891 49.1556 87.7432 49.6598C88.9091 49.8804 90.0338 49.7689 91.1585 49.5628C93.0855 49.2065 94.7652 48.2733 96.3747 47.1923C96.6777 46.9886 97.0364 46.8069 97.3879 46.7535C98.0981 46.6469 98.8277 46.6784 99.5403 46.5742C100.619 46.419 101.719 46.2978 102.752 45.973C103.743 45.6628 104.664 45.1247 105.612 44.6811C105.619 44.6399 105.627 44.5963 105.634 44.5551V44.5599ZM92.4601 46.3827C91.6215 46.7802 90.7246 47.0444 89.7866 47.1268C87.7578 47.3038 86.1289 45.6604 86.5095 43.6097C86.6985 42.5917 86.987 41.5906 87.2706 40.592C87.3675 40.2527 87.5857 39.9448 87.8305 39.4576C89.217 42.1409 91.0931 44.1188 93.6478 45.4374C93.4248 46.0579 92.8746 46.1839 92.4577 46.3827H92.4601ZM96.891 42.9941C96.0451 43.8206 95.7833 43.8134 94.7265 43.2656C93.7133 42.7396 92.8576 42.0536 92.0359 41.2683C90.9088 40.1896 90.2932 38.8541 89.8157 37.4215C89.5587 36.6507 89.9393 36.0448 90.4313 35.5455C90.9743 34.9977 91.5899 34.5201 92.1959 34.0378C93.6866 32.8501 95.3833 32.1181 97.257 31.7787C97.6497 31.7084 98.0375 31.5872 98.4108 31.4442C99.0289 31.2067 99.1573 30.5183 98.6216 30.1208C98.3211 29.8978 97.8993 29.7887 97.5164 29.7427C96.5395 29.6263 95.5966 29.9002 94.6901 30.1959C93.8296 30.4747 93.02 30.9037 92.1862 31.2673C92.0456 31.3279 91.9002 31.3836 91.7572 31.4418L91.6312 31.3012C91.9923 30.9934 92.3292 30.6589 92.7146 30.3874C93.9823 29.493 95.4124 28.8967 96.9346 28.7731C99.2931 28.5816 101.273 29.9996 101.361 32.7313C101.373 33.0804 101.349 33.4294 101.365 33.7784C101.465 35.7903 100.694 37.5379 99.7366 39.2346C98.9561 40.6162 98.0278 41.8839 96.891 42.9965V42.9941Z"
                                            fill="#E92827" />
                                        <path
                                            d="M102.315 28.5387C102.882 28.9677 103.866 30.0124 104.07 32.1915C104.094 32.4484 103.949 32.7102 103.701 32.7926C103.478 32.8677 103.209 32.7853 103.03 32.1381C102.977 31.9418 102.957 31.7382 102.972 31.537C102.991 31.251 102.906 30.502 102.104 28.7108C102.046 28.5774 102.199 28.449 102.315 28.5362V28.5387Z"
                                            fill="white" />
                                        <path
                                            d="M83.819 44.5599C83.9257 44.0145 84.0687 43.4764 84.2408 42.948C84.3644 42.565 84.5098 42.1893 84.631 41.8064C84.7037 41.5785 84.7764 41.3507 84.8564 41.1253C84.0226 41.9906 83.0361 42.6862 81.892 43.2074C80.8449 43.6849 79.7711 44.1188 78.5907 44.1212C78.4598 44.1212 78.3289 44.0339 78.1714 43.9806C78.518 43.4861 78.8137 43.045 79.1288 42.6159C80.4522 40.8126 81.5696 38.8928 82.1005 36.7065C82.3695 35.5988 82.5828 34.4426 82.578 33.3106C82.5707 31.9266 82.2435 30.5886 81.5745 29.3088C80.7358 27.7017 79.4221 26.7879 77.7738 26.3274C76.2856 25.9105 74.7537 26.0947 73.2436 26.3516C72.2231 26.5261 71.3045 26.9746 70.4198 27.4787C68.6624 28.4798 67.2396 29.8517 66.3355 31.66C65.8629 32.6028 65.6083 33.6621 65.3102 34.685C65.1454 35.2546 64.9975 35.8097 64.6218 36.2896C63.7929 37.3464 63.0487 38.4614 62.5736 39.7242C62.2731 40.5217 61.9798 41.3361 61.8319 42.1675C61.6865 42.9771 61.6671 43.823 61.7059 44.6472C61.8028 46.6954 63.2741 49.1556 65.9283 49.6598C67.0942 49.8804 68.2189 49.7689 69.3436 49.5628C71.2705 49.2065 72.9503 48.2733 74.5598 47.1923C74.8628 46.9886 75.2215 46.8069 75.5729 46.7535C76.2831 46.6469 77.0127 46.6784 77.7254 46.5742C78.804 46.419 79.9044 46.2978 80.937 45.973C81.9284 45.6628 82.8495 45.1247 83.7972 44.6811C83.8045 44.6399 83.8117 44.5963 83.819 44.5551V44.5599ZM70.6452 46.3827C69.8065 46.7802 68.9097 47.0444 67.9716 47.1268C65.9428 47.3038 64.314 45.6604 64.6945 43.6097C64.8836 42.5917 65.172 41.5906 65.4556 40.592C65.5526 40.2527 65.7707 39.9448 66.0156 39.4576C67.402 42.1409 69.2781 44.1188 71.8329 45.4374C71.6099 46.0579 71.0597 46.1839 70.6428 46.3827H70.6452ZM75.0761 42.9941C74.2301 43.8206 73.9683 43.8134 72.9115 43.2656C71.8983 42.7396 71.0427 42.0536 70.221 41.2683C69.0939 40.1896 68.4782 38.8541 68.0007 37.4215C67.7438 36.6507 68.1243 36.0448 68.6164 35.5455C69.1593 34.9977 69.775 34.5201 70.381 34.0378C71.8717 32.8501 73.5684 32.1181 75.4421 31.7787C75.8347 31.7084 76.2226 31.5872 76.5958 31.4442C77.2139 31.2067 77.3424 30.5183 76.8067 30.1208C76.5061 29.8978 76.0844 29.7887 75.7014 29.7427C74.7246 29.6263 73.7817 29.9002 72.8752 30.1959C72.0147 30.4747 71.2051 30.9037 70.3713 31.2673C70.2307 31.3279 70.0853 31.3836 69.9423 31.4418L69.8162 31.3012C70.1774 30.9934 70.5143 30.6589 70.8997 30.3874C72.1674 29.493 73.5975 28.8967 75.1197 28.7731C77.4781 28.5816 79.4584 29.9996 79.5457 32.7313C79.5578 33.0804 79.5336 33.4294 79.5505 33.7784C79.6499 35.7903 78.8791 37.5379 77.9217 39.2346C77.1412 40.6162 76.2129 41.8839 75.0761 42.9965V42.9941Z"
                                            fill="#E92827" />
                                        <path
                                            d="M80.5005 28.5387C81.0677 28.9677 82.0518 30.0124 82.2554 32.1915C82.2796 32.4484 82.1342 32.7102 81.887 32.7926C81.664 32.8677 81.3949 32.7853 81.2156 32.1381C81.1622 31.9418 81.1428 31.7382 81.1574 31.537C81.1768 31.251 81.0919 30.502 80.2896 28.7108C80.2315 28.5774 80.3842 28.449 80.5005 28.5362V28.5387Z"
                                            fill="white" />
                                        <path
                                            d="M207.717 21.0076C208.929 19.546 210.161 18.1037 211.375 16.6446C211.579 16.3997 211.763 16.1258 211.889 15.8374C212.16 15.2169 211.799 14.7467 211.419 14.3225C211.026 13.8862 210.716 13.845 210.122 14.1334C209.863 14.2594 209.613 14.4437 209.424 14.6594C207.991 16.2834 206.542 17.8953 205.16 19.5629C204.055 20.9009 203.042 22.314 201.978 23.686C201.699 24.0447 201.408 24.3986 201.083 24.7137C200.683 25.1015 200.182 25.3536 199.619 25.2227C198.298 24.91 196.96 24.9464 195.622 24.9537C194.502 24.9585 193.45 25.247 192.471 25.7826C192.263 25.8966 192.071 26.0541 191.906 26.2262C191.509 26.6407 191.431 27.1982 191.681 27.6248C191.894 27.9908 192.391 28.1193 192.98 27.9375C193.312 27.8357 193.627 27.6708 193.962 27.5909C195.179 27.3 196.415 27.4333 197.644 27.4818C198.061 27.4987 198.473 27.5981 198.994 27.6757C198.904 27.9011 198.873 28.032 198.805 28.1411C198.279 29.0113 197.755 29.8839 197.215 30.7468C196.003 32.6835 194.97 34.7123 194.066 36.8089C193.707 37.6427 193.356 38.4935 193.126 39.3685C192.934 40.1006 192.563 40.7017 192.091 41.2446C190.833 42.6893 189.279 43.8043 187.752 44.929C186.438 45.8961 184.984 46.6548 183.425 47.1929C181.442 47.8788 179.445 48.4945 177.319 48.286C176.616 48.2182 175.821 48.0921 175.264 47.7092C174.088 46.9069 173.436 45.7022 173.39 44.2357C173.371 43.6249 173.611 43.3025 174.2 43.0989C174.53 42.9874 174.876 42.9268 175.203 42.8105C176.386 42.3936 177.545 41.8942 178.749 41.5501C180.206 41.1356 181.535 40.4399 182.87 39.7806C184.378 39.0389 185.839 38.1857 187.114 37.0513C188.178 36.106 189.027 35.0177 189.412 33.6457C189.718 32.555 189.412 31.5297 188.566 30.788C187.173 29.5712 185.471 29.5009 183.777 29.8523C182.768 30.0632 181.801 30.502 180.841 30.8995C179.273 31.5515 177.874 32.5065 176.575 33.5827C175.797 34.225 175.135 35.008 174.413 35.7182C173.376 36.7411 172.501 37.8754 171.822 39.1722C171.514 39.7612 171.153 40.3405 170.722 40.8423C169.095 42.7353 167.025 44.0006 164.727 44.912C164.342 45.0647 163.927 45.1544 163.467 45.2901C163.38 44.6454 163.288 44.1 163.237 43.5498C163.113 42.2118 162.866 40.9101 162.34 39.6594C161.966 38.7723 161.632 37.8657 161.327 36.9495C160.97 35.8757 160.66 34.7559 161.108 33.653C161.45 32.8143 161.92 32.0242 162.403 31.2534C162.812 30.5965 163.343 30.0196 163.77 29.3724C164.146 28.8004 164.044 28.1944 163.571 27.6757C163.016 27.0673 162.534 26.9485 161.857 27.2927C161.622 27.4115 161.409 27.5812 161.205 27.7533C160.413 28.4223 159.899 29.307 159.361 30.1723C158.103 32.1938 156.942 34.2881 155.56 36.2199C154.336 37.9312 152.925 39.5237 151.478 41.0604C150.458 42.1463 149.244 43.0504 148.112 44.0321C146.592 45.3483 144.89 46.3275 142.941 46.8632C142.197 47.0668 141.453 47.0814 140.726 46.822C139.822 46.4996 139.007 45.358 139.182 44.5896C139.373 43.7582 139.611 42.9268 139.933 42.1366C140.644 40.4011 141.555 38.7747 142.609 37.2137C143.584 35.7715 144.582 34.3535 145.68 33.0034C145.966 32.6519 146.233 32.2787 146.478 31.8957C146.824 31.3503 146.778 30.6644 146.4 30.2474C146.003 29.8111 145.419 29.7554 144.784 30.1287C144.531 30.2765 144.284 30.4535 144.088 30.6668C143.523 31.2752 142.951 31.8787 142.447 32.5356C141.586 33.6603 140.731 34.7947 139.958 35.9824C139.257 37.0586 138.622 38.1833 138.057 39.337C137.781 39.9018 137.48 40.4254 137.054 40.8665C135.582 42.3936 134 43.8043 132.155 44.8635C130.999 45.5277 129.84 46.2548 128.5 46.4924C127.312 46.7032 126.134 46.696 125.249 45.644C124.287 44.4975 124.282 43.1401 124.401 41.7585C124.411 41.647 124.544 41.5379 124.636 41.4434C125.482 40.5466 126.331 39.6521 127.176 38.7553C127.967 37.9166 128.779 37.0974 129.545 36.2369C130.841 34.7777 132.141 33.3185 133.384 31.8157C135.961 28.7058 138.464 25.5354 140.585 22.0886C141.133 21.1991 141.635 20.2828 142.163 19.3836C142.76 18.3655 143.242 17.3014 143.644 16.1889C143.996 15.2169 144.243 14.2522 144.221 13.2196C144.19 11.8113 143.433 10.7763 142.108 10.2964C140.75 9.80433 139.417 9.86008 138.142 10.5194C137.507 10.849 136.93 11.295 136.331 11.695C134.516 12.9093 133.18 14.6036 131.942 16.3416C130.747 18.0141 129.736 19.8223 128.699 21.6014C127.208 24.1538 126.013 26.8516 124.893 29.5809C124.723 29.9929 124.556 30.4074 124.372 30.8558C124.159 30.7419 123.994 30.6595 123.836 30.5674C122.787 29.9614 121.652 29.6948 120.45 29.736C119.122 29.7821 117.864 30.1553 116.662 30.6862C115.927 31.011 115.193 31.3697 114.538 31.8254C113.29 32.6931 112.044 33.5827 110.9 34.5814C110.1 35.2794 109.453 36.1545 108.774 36.981C108.214 37.6621 107.625 38.3384 107.199 39.1019L105.638 42.0882C105.504 42.4929 105.352 42.888 105.228 43.2977C105.102 43.717 104.993 44.1436 104.906 44.5726C104.978 44.546 105.061 44.5145 105.16 44.4757C104.806 46.0948 105.136 47.4983 106.052 48.7369C106.675 49.578 107.378 50.3464 108.517 50.5306C110.255 50.8117 111.899 50.6566 113.508 49.8519C115.898 48.6569 117.968 47.0087 120.087 45.4234C120.513 45.1035 120.848 44.6114 121.478 44.5096C121.519 44.6817 121.553 44.8053 121.577 44.9314C121.883 46.5578 122.733 47.8037 124.219 48.5575C125.642 49.2823 127.159 49.1877 128.67 48.9308C130.044 48.6981 131.232 47.9709 132.427 47.3189C133.479 46.742 134.528 46.1336 135.367 45.2368C135.59 44.9992 135.905 44.8514 136.261 44.6017C136.319 44.895 136.351 45.0453 136.375 45.1956C136.453 45.6682 136.462 46.1651 136.617 46.6111C137.403 48.8702 139.473 49.6555 141.473 49.4471C143.53 49.2314 145.36 48.3491 147.118 47.2826C148.155 46.6523 149.103 45.9228 150.019 45.1447C151.241 44.1048 152.475 43.0771 153.657 41.9936C154.142 41.5476 154.511 40.9732 154.928 40.4545C155.497 39.7491 156.074 39.0437 156.634 38.3311C157.078 37.7664 157.499 37.187 158.028 36.4914C158.226 36.981 158.391 37.3616 158.537 37.7494C158.835 38.5493 159.121 39.3516 159.409 40.1515C159.727 41.0289 160.115 41.8918 160.34 42.7935C160.527 43.5352 160.558 44.323 160.585 45.0914C160.607 45.7264 160.452 45.8985 159.821 45.9785C159.109 46.0706 158.384 46.0827 157.667 46.1361C156.416 46.2282 155.165 46.3154 153.917 46.4245C153.018 46.5021 152.118 46.5433 151.364 47.1904C150.312 48.0921 150.206 49.9173 150.654 50.5766C151.008 51.0978 151.454 51.5947 151.958 51.9679C153.413 53.0441 155.078 53.0805 156.779 52.7751C157.172 52.7048 157.574 52.6321 157.94 52.4818C159.86 51.7013 161.392 50.4627 162.432 48.6375C162.837 47.9273 163.355 47.3116 164.284 47.2729C164.439 47.2656 164.592 47.1856 164.744 47.1298C166.514 46.4802 168.16 45.5858 169.74 44.5702C169.931 44.4466 170.137 44.3448 170.39 44.2042C170.421 44.3981 170.453 44.4975 170.453 44.5993C170.433 47.6922 172.675 49.9367 175.373 50.6615C176.82 51.0517 178.294 50.9281 179.741 50.7511C181.389 50.55 182.967 50.0288 184.48 49.3186C186.773 48.24 188.843 46.8293 190.794 45.2271C191.145 44.9387 191.458 44.5242 192.023 44.5023C192.091 44.9168 192.125 45.3192 192.226 45.6998C192.457 46.5505 192.694 47.3965 193.416 48.0121C194.476 48.9138 195.719 49.3186 197.055 49.1659C198.187 49.0375 199.333 48.7684 200.392 48.3539C202.041 47.7092 203.57 46.7929 204.957 45.6779C206.227 44.6575 207.465 43.5934 208.692 42.522C209.051 42.2093 209.373 41.8288 209.625 41.424C209.797 41.1501 209.93 40.7647 209.887 40.4569C209.785 39.7297 208.949 39.4922 208.309 40.0085C207.519 40.6459 206.755 41.3198 206.001 42.0009C204.867 43.0238 203.742 44.0612 202.419 44.8344C200.783 45.7894 199.069 46.5093 197.11 46.4269C196.012 46.3809 195.246 45.6367 195.29 44.5508C195.314 43.9376 195.334 43.3171 195.457 42.7184C195.823 40.9417 196.189 39.1552 196.938 37.49C197.566 36.0987 198.201 34.7074 198.938 33.3743C199.818 31.7818 200.821 30.2596 201.747 28.6913C201.985 28.2865 202.29 28.1314 202.739 28.1774C204.225 28.335 205.71 28.5047 207.199 28.6331C208.023 28.7034 208.857 28.7471 209.683 28.7131C210.122 28.6961 210.573 28.5313 210.985 28.3544C211.484 28.1387 211.651 27.7533 211.574 27.2491C211.518 26.8879 211.225 26.6286 210.691 26.568C209.606 26.4468 208.51 26.3862 207.427 26.2529C206.326 26.1171 205.233 25.9256 204.016 25.7414C204.169 25.4603 204.242 25.2663 204.365 25.1136C205.473 23.7417 206.583 22.3698 207.708 21.0124L207.717 21.0076ZM175.358 39.068C176.326 37.7106 177.504 36.5568 178.752 35.4491C179.974 34.3656 181.35 33.5706 182.81 32.8895C183.84 32.4071 184.928 32.2084 186.06 32.3853C186.656 32.4774 186.896 32.858 186.656 33.4227C186.462 33.8833 186.184 34.3293 185.859 34.7098C185.124 35.5679 184.259 36.2878 183.26 36.8283C182.507 37.2355 181.775 37.6961 180.987 38.0257C179.14 38.8014 177.269 39.5164 175.402 40.2436C175.245 40.3042 175.051 40.2751 174.74 40.2969C174.978 39.817 175.116 39.4073 175.358 39.0704V39.068ZM126.171 34.7098C127.019 32.3999 127.799 30.0608 128.781 27.809C129.688 25.7269 130.822 23.7466 131.852 21.7178C132.509 20.4258 133.333 19.2405 134.094 18.0116C135.19 16.247 136.695 14.8824 138.145 13.4596C138.816 12.8003 139.689 12.5215 140.658 12.6451C141.271 12.7227 141.545 13.0039 141.596 13.6389C141.635 14.1067 141.451 14.5188 141.337 14.9575C140.891 16.6955 140.004 18.2298 139.146 19.7641C137.657 22.428 135.861 24.8955 134.014 27.317C132.865 28.8246 131.607 30.2474 130.415 31.7236C129.05 33.413 127.593 35.0152 126.035 36.5277C125.923 36.6344 125.807 36.7362 125.691 36.8404C125.645 36.8138 125.598 36.7871 125.552 36.7604C125.756 36.0769 125.928 35.3812 126.173 34.7122L126.171 34.7098ZM123.305 34.0942C122.809 35.9775 122.314 37.8633 121.846 39.7539C121.648 40.5587 121.274 41.2059 120.654 41.7827C118.407 43.8649 116.007 45.741 113.314 47.2026C112.529 47.6292 111.644 47.9685 110.767 48.1188C109.426 48.3442 107.875 47.5565 107.945 45.7603C107.999 44.3884 108.457 43.1425 109.009 41.9306C109.417 41.0386 109.897 40.1539 110.488 39.3734C111.763 37.6912 113.159 36.1181 114.849 34.8092C116.305 33.6821 117.852 32.7707 119.648 32.332C120.033 32.2375 120.44 32.235 120.836 32.1914C121.538 32.1381 122.174 32.332 122.763 32.6835C123.359 33.0373 123.48 33.4276 123.303 34.0966L123.305 34.0942ZM158.859 49.0956C157.8 49.9973 156.6 50.5984 155.18 50.613C154.586 50.6178 154.021 50.4336 153.527 50.0943C153.257 49.9101 153.022 49.6798 153.085 49.3017C153.148 48.9211 153.417 48.7878 153.766 48.7393C154.319 48.6642 154.867 48.5575 155.42 48.5018C156.186 48.4266 156.956 48.3903 157.727 48.3297C158.042 48.3054 158.357 48.2473 158.672 48.2254C158.905 48.2085 159.138 48.223 159.371 48.223C159.407 48.286 159.441 48.3515 159.477 48.4145C159.274 48.6424 159.092 48.8969 158.862 49.0932L158.859 49.0956Z"
                                            fill="#E92827" />
                                        <path
                                            d="M149.647 22.9417C149.637 22.8569 149.647 22.7721 149.661 22.6896C149.707 22.4569 149.821 22.2727 150.027 22.1491C150.151 22.074 150.289 22.04 150.432 22.0303C150.609 22.0182 150.779 22.0449 150.939 22.1224C151.036 22.1685 151.123 22.2291 151.205 22.3018C151.389 22.4666 151.501 22.6678 151.54 22.9126C151.557 23.0241 151.557 23.1381 151.549 23.252C151.545 23.3562 151.53 23.4604 151.503 23.5598C151.474 23.6665 151.44 23.7731 151.394 23.8749C151.295 24.0931 151.157 24.2821 150.98 24.4397C150.737 24.6554 150.454 24.7936 150.134 24.8469C149.559 24.9439 149.043 24.8033 148.575 24.4615C148.389 24.3258 148.231 24.1634 148.1 23.9743C148.032 23.8749 147.972 23.7683 147.918 23.6568C147.814 23.4435 147.756 23.218 147.734 22.9854C147.717 22.7987 147.72 22.6121 147.741 22.4254C147.78 22.1152 147.863 21.8195 148.003 21.5407C148.124 21.3032 148.277 21.085 148.466 20.896C148.852 20.513 149.312 20.273 149.848 20.1736C150.078 20.1324 150.308 20.1179 150.541 20.1324C151.065 20.1664 151.549 20.3263 151.991 20.6075C152.56 20.9711 152.977 21.4607 153.236 22.0861C153.278 22.183 153.307 22.2848 153.338 22.3842C153.421 22.646 153.455 22.9126 153.462 23.1865C153.474 23.6398 153.406 24.0834 153.251 24.51C153.169 24.7403 153.064 24.9584 152.933 25.1644C152.47 25.8892 151.828 26.374 151.006 26.6236C150.892 26.6576 150.776 26.6818 150.66 26.706C150.514 26.7351 150.369 26.7569 150.221 26.7618C150.105 26.7666 149.988 26.7739 149.872 26.7715C149.78 26.7715 149.688 26.7642 149.596 26.7545C149.477 26.7424 149.356 26.7278 149.237 26.7085C149.135 26.6915 149.036 26.6673 148.939 26.6406C148.175 26.4394 147.526 26.0443 146.978 25.4795C146.891 25.3899 146.813 25.2953 146.733 25.2008C146.433 24.8421 146.207 24.4397 146.047 24.001C146.006 23.8919 145.977 23.778 145.943 23.664C145.89 23.4895 145.858 23.3126 145.836 23.1332C145.807 22.9029 145.795 22.6702 145.807 22.4376C145.81 22.3648 145.807 22.2897 145.817 22.217C145.829 22.0861 145.844 21.9528 145.863 21.8219C145.909 21.5383 145.982 21.262 146.086 20.9929C146.134 20.8717 146.188 20.7554 146.241 20.6366C146.389 20.3142 146.585 20.0209 146.813 19.7495C146.927 19.6137 147.051 19.4877 147.182 19.3689C147.732 18.8623 148.372 18.5278 149.099 18.3509C149.341 18.2927 149.586 18.2539 149.836 18.2345C150.097 18.2151 150.359 18.2176 150.623 18.2394C151.108 18.2806 151.576 18.3921 152.027 18.569C152.344 18.6926 152.65 18.8478 152.936 19.032C153.028 19.0902 153.118 19.1556 153.207 19.2186C153.505 19.4295 153.774 19.6767 154.017 19.9506C154.187 20.1446 154.342 20.3482 154.477 20.5663C154.8 21.0777 155.02 21.6328 155.139 22.2243C155.183 22.44 155.212 22.6581 155.226 22.8787C155.241 23.0799 155.243 23.2835 155.231 23.4847C155.205 23.9282 155.129 24.3646 154.984 24.7863C154.943 24.9027 154.902 25.019 154.853 25.1329C154.623 25.6807 154.305 26.1728 153.893 26.6018C153.789 26.7085 153.68 26.8103 153.568 26.9096C153.135 27.2999 152.643 27.598 152.104 27.821C151.753 27.9665 151.392 28.0707 151.016 28.1337C150.907 28.1507 150.798 28.1652 150.689 28.1773C150.56 28.1895 150.434 28.2016 150.306 28.2064C150.112 28.2137 149.921 28.2137 149.727 28.1992C149.441 28.1773 149.157 28.1361 148.878 28.0683C148.316 27.9325 147.787 27.7095 147.3 27.3968C146.583 26.9387 146.011 26.3449 145.579 25.6104C145.504 25.4795 145.436 25.3438 145.371 25.2105C145.165 24.796 145.029 24.3573 144.949 23.9016C144.918 23.7198 144.889 23.538 144.881 23.3538C144.876 23.2544 144.869 23.155 144.867 23.0556C144.886 23.1793 144.901 23.3053 144.925 23.4289C144.956 23.5913 144.99 23.7537 145.036 23.9137C145.155 24.3161 145.315 24.7015 145.528 25.0626C145.601 25.1838 145.671 25.3074 145.754 25.4238C146.147 25.9813 146.619 26.4564 147.186 26.8369C147.698 27.1811 148.253 27.4308 148.852 27.5786C149.096 27.6392 149.344 27.6804 149.596 27.7023C149.814 27.7216 150.032 27.7265 150.253 27.7168C151.225 27.6659 152.095 27.3508 152.851 26.7351C153.263 26.4006 153.595 25.9958 153.859 25.5353C153.934 25.4044 154.002 25.2687 154.061 25.1305C154.172 24.8687 154.262 24.5972 154.32 24.3161C154.347 24.1852 154.366 24.0543 154.388 23.9234C154.429 23.6665 154.427 23.4071 154.419 23.1478C154.412 22.9078 154.38 22.6702 154.33 22.4351C154.267 22.1467 154.17 21.8704 154.046 21.6013C153.942 21.3759 153.818 21.1626 153.673 20.9614C153.588 20.8451 153.505 20.7287 153.411 20.6221C152.948 20.0985 152.398 19.701 151.746 19.444C151.615 19.3931 151.484 19.3471 151.348 19.3083C151.162 19.255 150.97 19.2235 150.776 19.1944C150.636 19.1726 150.495 19.1653 150.352 19.1629C149.954 19.1556 149.564 19.2065 149.184 19.3253C148.473 19.5459 147.889 19.9506 147.441 20.5445C147.116 20.9735 146.915 21.4559 146.816 21.9843C146.789 22.1273 146.765 22.2703 146.762 22.4133C146.762 22.5563 146.757 22.6993 146.762 22.8423C146.779 23.2714 146.888 23.6786 147.082 24.064C147.278 24.4567 147.548 24.7936 147.882 25.0772C147.996 25.1717 148.112 25.2614 148.238 25.339C148.597 25.5644 148.982 25.7122 149.402 25.7825C149.622 25.8189 149.845 25.8286 150.068 25.814C150.505 25.785 150.912 25.6565 151.285 25.4286C151.421 25.3462 151.547 25.2541 151.661 25.1475C152.087 24.7475 152.359 24.2627 152.463 23.6859C152.512 23.4192 152.519 23.1502 152.487 22.8787C152.473 22.7575 152.446 22.6387 152.407 22.5224C152.369 22.4012 152.323 22.28 152.257 22.1685C151.937 21.6159 151.472 21.2498 150.844 21.1117C150.354 21.0026 149.887 21.0729 149.458 21.3444C149.179 21.5189 148.975 21.7613 148.832 22.0546C148.709 22.3115 148.665 22.5806 148.67 22.8617C148.67 23.0338 148.706 23.1962 148.789 23.3489C148.866 23.4968 148.97 23.6228 149.106 23.7198C149.227 23.8046 149.358 23.8701 149.508 23.8992C149.642 23.9258 149.775 23.9258 149.908 23.904C150.02 23.8846 150.124 23.8483 150.221 23.7925C150.405 23.6859 150.536 23.538 150.597 23.332C150.628 23.2277 150.628 23.1235 150.602 23.0193C150.568 22.8811 150.488 22.7793 150.357 22.7236C150.158 22.6387 149.967 22.6533 149.782 22.7721C149.719 22.8133 149.676 22.869 149.637 22.9345L149.647 22.9417Z"
                                            fill="#E92827" />
                                        <rect x="143.133" y="10.1216" width="19.1487" height="18.9064"
                                            fill="url(#pattern0_2639_40882)" />
                                        <rect x="139.498" y="14.7269" width="19.1487" height="18.664"
                                            fill="url(#pattern1_2639_40882)" />
                                        <path
                                            d="M115.719 31.8251C116.311 31.1633 117.566 30.1962 119.929 30.0387C120.245 30.0168 120.56 30.1889 120.652 30.4919C120.734 30.761 120.623 31.0809 119.828 31.27C119.6 31.3233 119.362 31.3282 119.13 31.3088C118.79 31.2797 117.939 31.3621 115.959 32.1668C115.748 32.2517 115.569 31.9947 115.719 31.8251Z"
                                            fill="white" />
                                        <path
                                            d="M142.522 17.2353C143.138 16.5954 144.006 15.2695 143.987 12.9014C143.984 12.5863 143.788 12.2857 143.48 12.2154C143.206 12.1548 142.896 12.2881 142.767 13.0953C142.731 13.3255 142.743 13.5631 142.782 13.7934C142.835 14.1303 142.818 14.9859 142.166 17.0196C142.096 17.2353 142.367 17.3977 142.525 17.2329L142.522 17.2353Z"
                                            fill="white" />
                                        <path
                                            d="M161.345 48.7027C161.96 48.0628 162.828 46.737 162.809 44.3688C162.806 44.0537 162.61 43.7532 162.302 43.6829C162.028 43.6223 161.718 43.7556 161.59 44.5627C161.553 44.793 161.565 45.0305 161.604 45.2608C161.657 45.5977 161.64 46.4534 160.988 48.487C160.918 48.7027 161.19 48.8651 161.347 48.7003L161.345 48.7027Z"
                                            fill="white" />
                                        <path
                                            d="M144.126 32.3438C143.871 32.1572 143.515 32.2105 143.277 32.4165C141.484 33.963 141.062 35.49 140.987 36.3748C140.967 36.6026 141.265 36.6996 141.384 36.5032C142.482 34.6708 143.115 34.0939 143.403 33.9121C143.602 33.786 143.789 33.6406 143.939 33.4612C144.46 32.8335 144.358 32.5087 144.131 32.3438H144.126Z"
                                            fill="white" />
                                        <path
                                            d="M181.589 31.7304C181.414 31.4662 181.065 31.391 180.767 31.5001C178.544 32.3194 177.613 33.6016 177.233 34.4039C177.136 34.6099 177.381 34.8063 177.56 34.6633C179.233 33.3326 180.025 33.0126 180.36 32.9447C180.59 32.8963 180.815 32.826 181.019 32.7096C181.729 32.3048 181.744 31.9655 181.591 31.7304H181.589Z"
                                            fill="white" />
                                        <path
                                            d="M208.062 17.9439C207.807 17.7572 207.451 17.8081 207.213 18.0142C205.415 19.5558 204.986 21.0804 204.908 21.9651C204.889 22.193 205.187 22.2899 205.303 22.096C206.409 20.266 207.041 19.6915 207.33 19.5121C207.528 19.3885 207.715 19.2431 207.865 19.0637C208.389 18.4359 208.287 18.1136 208.059 17.9463L208.062 17.9439Z"
                                            fill="white" />
                                        <path
                                            d="M196.534 48.4922C196.631 48.7928 196.948 48.96 197.261 48.9358C199.622 48.7443 200.865 47.7626 201.447 47.0912C201.597 46.9191 201.413 46.6646 201.202 46.7543C199.234 47.5857 198.383 47.6778 198.044 47.656C197.811 47.639 197.573 47.6487 197.346 47.7044C196.553 47.9032 196.446 48.2256 196.531 48.4922H196.534Z"
                                            fill="white" />
                                        <path
                                            d="M113.3 49.2868C112.878 49.7571 111.983 50.4454 110.299 50.5594C110.076 50.5739 109.85 50.4527 109.785 50.237C109.727 50.0455 109.807 49.8177 110.372 49.6819C110.534 49.6431 110.704 49.6407 110.869 49.6528C111.111 49.6722 111.717 49.614 113.128 49.042C113.278 48.9814 113.406 49.1632 113.297 49.2844L113.3 49.2868Z"
                                            fill="white" />
                                        <path
                                            d="M8.28555 75.7098C8.66852 75.2177 9.07574 74.7572 9.50477 74.3136C9.70837 73.3368 9.85381 72.0376 9.7011 70.5493C8.92546 71.1844 8.18617 71.8679 7.49536 72.6145C6.97423 73.1768 6.47491 73.7634 5.93438 74.3064C5.75744 74.4833 5.59261 74.6724 5.43506 74.8614C6.13071 75.9352 6.56701 76.9775 6.84091 77.8355C7.26267 77.1011 7.75229 76.3957 8.28797 75.7098H8.28555Z"
                                            fill="#E92827" />
                                        <path
                                            d="M55.3406 19.4827C53.8329 20.4111 52.2647 21.2255 50.6479 21.943C51.855 21.9357 52.8997 22.1054 53.6972 22.3041C54.2959 22.452 54.8098 22.6289 55.217 22.7889C56.6616 22.0035 58.0626 21.1431 59.4103 20.1832C59.7957 19.9093 60.1762 19.6306 60.5519 19.3445C60.1084 19.2573 59.5436 19.1749 58.8867 19.1434C57.956 19.0973 56.7174 19.1434 55.3382 19.4803L55.3406 19.4827Z"
                                            fill="#E92827" />
                                        <path
                                            d="M3.83262 16.5815C3.64599 16.1549 3.49086 15.7283 3.36239 15.2992C2.05349 14.5769 1.07182 13.7213 0.4004 13.0184C0.257391 12.8681 0.124077 12.7202 0.000458709 12.5772C-0.00923684 13.4135 0.136196 14.2327 0.301021 15.0496C0.48766 15.9707 0.778527 16.8578 1.16635 17.6965C2.17469 18.1473 3.57327 18.603 5.25545 18.729C4.71007 18.0649 4.18894 17.3959 3.83262 16.5815Z"
                                            fill="white" />
                                        <path
                                            d="M50.533 21.9912C50.3318 22.0809 50.1282 22.1682 49.9246 22.2554C48.303 22.9414 46.6887 23.6661 45.0138 24.1921C44.8854 24.2333 44.7569 24.2697 44.6309 24.3085C45.9373 24.2745 47.0669 24.4539 47.9177 24.6672C48.7466 24.8732 49.4108 25.1302 49.8592 25.3289C50.3973 25.1083 50.9305 24.8781 51.4638 24.6405C52.7218 24.0782 53.9556 23.4746 55.1602 22.8202C54.7603 22.6626 54.261 22.4954 53.6817 22.35C52.8624 22.1463 51.7813 21.9718 50.533 21.9912Z"
                                            fill="white" />
                                        <path
                                            d="M3.34596 15.2339C3.0357 14.1649 2.91451 13.0742 3.04297 11.901C3.07206 11.6417 3.11327 11.3944 3.16174 11.1496C2.24067 9.56681 1.82618 8.03491 1.64681 6.90295C1.5135 7.11141 1.38503 7.32714 1.26626 7.55013C0.471228 9.02871 0.119765 10.597 0.0131135 12.2428C0.00826574 12.3301 0.00584186 12.4197 0.00341797 12.507C0.136732 12.6621 0.279741 12.8221 0.437294 12.9869C1.09901 13.6802 2.0613 14.5213 3.34353 15.2339H3.34596Z"
                                            fill="#E92827" />
                                        <path
                                            d="M38.644 25.915C38.4549 25.9587 38.2683 26.0047 38.0792 26.0459C36.8843 26.3126 35.6675 26.4774 34.4507 26.6422C35.1173 26.9113 35.6893 27.2094 36.1547 27.4881C36.9255 27.9511 37.5072 28.4116 37.8756 28.7365C38.8331 28.574 39.7881 28.4044 40.7334 28.1959C41.7151 27.9778 42.6822 27.6942 43.6493 27.4082C43.3415 27.2361 42.9828 27.0567 42.578 26.8822C41.623 26.4701 40.2729 26.0387 38.644 25.915Z"
                                            fill="white" />
                                        <path
                                            d="M60.0771 16.0653C58.7803 17.2045 57.3647 18.1935 55.908 19.1291C55.7625 19.2212 55.6171 19.3109 55.4717 19.403C56.8 19.0951 57.9901 19.0491 58.8942 19.0976C59.5753 19.1315 60.1546 19.2188 60.6055 19.3085C61.7374 18.4455 62.8161 17.522 63.7783 16.4604C63.9989 16.218 64.2098 15.9683 64.4231 15.7211C64.234 15.7017 64.0328 15.6872 63.8244 15.675C62.8476 15.6266 61.5362 15.6823 60.0771 16.0653Z"
                                            fill="white" />
                                        <path
                                            d="M5.6509 19.2109C5.53213 19.0678 5.41579 18.9248 5.29702 18.7818C3.61484 18.6631 2.21626 18.2146 1.1958 17.7638C1.50848 18.4279 1.87691 19.063 2.31079 19.6593C2.89979 20.4664 3.63908 21.1645 4.38321 21.8577C5.32368 21.7875 6.46775 21.5935 7.69181 21.1475C6.95738 20.5658 6.25687 19.955 5.6509 19.2133V19.2109Z"
                                            fill="#E92827" />
                                        <path
                                            d="M44.4494 24.3641C42.5854 24.9337 40.6972 25.4403 38.7969 25.879C40.3676 26.0172 41.6716 26.4365 42.6024 26.8364C43.0266 27.0182 43.3998 27.2097 43.7174 27.3867C44.1924 27.2461 44.6675 27.1031 45.145 26.9697C46.7303 26.5238 48.2767 25.9735 49.7965 25.353C49.3505 25.1567 48.7057 24.9119 47.9058 24.7131C47.0211 24.4925 45.8286 24.3083 44.4494 24.3641Z"
                                            fill="#E92827" />
                                        <path
                                            d="M34.3573 26.6551C33.7901 26.7302 33.2229 26.8078 32.6557 26.8926C32.6048 26.8999 32.5539 26.8999 32.503 26.9023C31.5165 26.9241 30.5275 26.9459 29.541 26.9653C30.4669 27.5325 31.1965 28.1482 31.7371 28.679C32.0328 28.9699 32.2873 29.2486 32.5054 29.5056C33.4798 29.4474 34.4518 29.3432 35.4189 29.1638C36.2164 29.0159 37.0163 28.8826 37.8162 28.7469C37.4477 28.4245 36.8805 27.9761 36.1316 27.5277C35.6492 27.2392 35.0554 26.9314 34.3573 26.6526V26.6551Z"
                                            fill="#E92827" />
                                        <path
                                            d="M17.0651 44.7978C17.0651 44.9214 17.0772 45.0426 17.0942 45.1662C17.1427 45.1396 17.1887 45.1153 17.2372 45.0887C18.025 44.6524 19.0091 43.9858 19.9689 43.0259C19.9859 41.9934 19.9132 40.9535 20.0247 39.9306C20.0489 39.7004 20.0804 39.4725 20.1144 39.2422C18.98 39.7052 17.9232 39.9379 17.07 40.0518C17.0069 41.6298 17.0627 43.215 17.0651 44.7978Z"
                                            fill="white" />
                                        <path
                                            d="M25.3518 7.36062C25.3372 7.33638 25.3275 7.31214 25.3105 7.29033C25.0294 6.89766 24.7409 6.47833 24.3677 6.18746C24.1471 6.01536 23.9265 5.84084 23.7059 5.67117C23.6163 5.66874 23.5241 5.66632 23.432 5.66632C23.4102 5.66632 23.3884 5.66632 23.3666 5.66632C22.4891 5.66632 21.3572 5.7657 20.1089 6.10747C20.8603 6.50014 21.5608 6.9728 22.2322 7.48666C23.2672 7.38971 24.3071 7.36305 25.3493 7.36305L25.3518 7.36062Z"
                                            fill="white" />
                                        <path
                                            d="M19.1148 50.9686C19.934 51.8461 20.6467 52.8399 21.5483 53.6204C21.8198 53.8555 22.1034 54.0809 22.3967 54.2991C22.4331 54.2021 22.4718 54.1003 22.5082 53.9985C22.7676 53.2641 23.0221 52.3042 23.1384 51.1844C22.9372 50.9783 22.7409 50.7578 22.5518 50.5275C21.7423 49.5385 21.1436 48.4769 20.7073 47.3037C20.0698 48.6005 19.2966 49.5943 18.6445 50.2899C18.773 50.5299 18.9209 50.7602 19.1172 50.9711L19.1148 50.9686Z"
                                            fill="white" />
                                        <path
                                            d="M19.5516 3.28821C18.2185 3.28821 16.2939 3.51363 14.2627 4.48804C16.1873 4.4638 17.9543 5.07462 19.6583 5.87693C19.7892 5.93752 19.9176 6.00539 20.0461 6.07084C21.3211 5.71453 22.4772 5.61272 23.3692 5.61272H23.4371C23.5074 5.61272 23.5753 5.61272 23.6456 5.61757C22.5427 4.75951 21.4204 3.93781 20.1261 3.33669C20.097 3.32457 20.0703 3.31245 20.0412 3.2979C19.9031 3.29306 19.7649 3.28821 19.6171 3.28821H19.5516Z"
                                            fill="#E92827" />
                                        <path
                                            d="M9.0415 4.87355C10.2292 4.46391 11.4896 4.30636 12.7719 4.36211C13.2276 4.3815 13.6857 4.50027 14.1389 4.48815C14.1438 4.48815 14.1462 4.48815 14.1511 4.48815C16.2235 3.47254 18.1917 3.23984 19.5515 3.23984C19.5733 3.23984 19.5975 3.23984 19.6193 3.23984C19.7236 3.23984 19.823 3.24227 19.9223 3.24469C17.7263 2.25089 15.4624 1.6425 13.07 1.5722C12.9391 1.63765 12.8058 1.70794 12.6701 1.78551C11.6326 2.36482 10.2583 3.34165 9.04393 4.87355H9.0415Z"
                                            fill="white" />
                                        <path
                                            d="M5.0179 7.43103C5.2409 5.49191 5.8905 3.9382 6.46496 2.89835C6.47951 2.87169 6.49405 2.84502 6.51102 2.81836C6.37043 2.8838 6.22742 2.94925 6.08684 3.01954C4.27377 3.9285 2.77338 5.15257 1.68506 6.8396C1.85958 7.96186 2.26194 9.49134 3.17575 11.079C3.47389 9.61253 4.10895 8.41271 5.0179 7.43103Z"
                                            fill="white" />
                                        <path
                                            d="M5.07322 7.37489C5.89735 6.50229 6.93719 5.79936 8.14429 5.23217C8.40849 5.10613 8.67997 5.0019 8.95387 4.90494C10.1828 3.33184 11.5886 2.33319 12.6454 1.74419C12.7545 1.68359 12.8612 1.62542 12.9678 1.56967C12.7909 1.56482 12.6164 1.56482 12.437 1.56482C11.9546 1.56967 11.4723 1.67147 10.9899 1.68844C9.43622 1.74419 7.97947 2.14655 6.58331 2.78161C6.55664 2.82767 6.52998 2.87372 6.50332 2.9222C5.93855 3.94751 5.29865 5.47214 5.0708 7.37247L5.07322 7.37489Z"
                                            fill="#E92827" />
                                        <path
                                            d="M63.2933 12.4263C63.063 12.7681 62.8327 13.1099 62.5952 13.4468C62.3019 13.8613 61.9383 14.2273 61.5893 14.603C61.1336 15.0926 60.6561 15.5531 60.1616 15.9919C61.5893 15.6307 62.8715 15.5774 63.829 15.6259C64.052 15.638 64.2628 15.655 64.4616 15.6743C64.5367 15.5895 64.6095 15.5022 64.6846 15.4198C65.8553 14.1352 66.7546 12.6881 67.4309 11.1077C66.9509 11.1683 66.2795 11.2847 65.5063 11.5174C64.8712 11.7089 64.1077 11.9949 63.2957 12.4239L63.2933 12.4263Z"
                                            fill="#E92827" />
                                        <path
                                            d="M17.1006 45.219C17.1054 45.2578 17.1103 45.2941 17.1176 45.3329C17.3042 46.4091 17.452 47.5047 17.9102 48.5058C18.1695 49.073 18.3343 49.6862 18.6204 50.2437C19.2724 49.5432 20.048 48.5446 20.6831 47.2405C20.671 47.209 20.6589 47.1775 20.6467 47.146C20.1813 45.8347 19.9414 44.4894 19.968 43.0981C19.0155 44.0434 18.0411 44.7027 17.2581 45.1366C17.2048 45.1657 17.1539 45.1923 17.1006 45.2214V45.219Z"
                                            fill="#E92827" />
                                        <path
                                            d="M39.0208 11.7336C39.2171 11.5736 39.4134 11.4161 39.6122 11.2585C40.1503 10.8344 40.7587 10.4999 41.3089 10.0854C41.7743 9.73391 42.2518 9.40426 42.7342 9.08431C42.2639 9.13521 41.8131 9.15945 41.3889 9.15945C40.509 9.15945 39.7358 9.06491 39.108 8.94857C38.7517 8.8807 38.4245 8.80313 38.1312 8.72314C37.4622 9.1958 36.7932 9.66846 36.1509 10.1751C35.4698 10.7132 34.8493 11.3264 34.1948 11.896C34.5172 11.9493 34.8808 11.9978 35.2759 12.0269C36.2479 12.0996 37.5592 12.0778 39.0232 11.7312L39.0208 11.7336Z"
                                            fill="white" />
                                        <path
                                            d="M42.8209 9.02577C43.8583 8.34466 44.9297 7.72414 46.0253 7.14241C45.1551 6.99455 44.4013 6.77155 43.8002 6.54856C43.2524 6.34495 42.7846 6.1268 42.4064 5.92804C41.1145 6.69157 39.8492 7.50115 38.6203 8.37132C38.4725 8.47555 38.3246 8.57978 38.1768 8.68401C38.4604 8.76157 38.773 8.83429 39.1124 8.89973C40.0601 9.0791 41.3448 9.19787 42.8185 9.02335L42.8209 9.02577Z"
                                            fill="#E92827" />
                                        <path
                                            d="M31.9307 15.614C32.75 15.5679 33.7971 15.4225 34.9484 15.0613C35.4453 14.6371 35.9519 14.2226 36.4682 13.8178C37.302 13.1634 38.1092 12.475 38.9309 11.8036C37.9226 12.0314 36.9894 12.1114 36.1919 12.1114C35.8574 12.1114 35.5471 12.0969 35.266 12.0775C34.8515 12.046 34.4758 11.9951 34.1413 11.9393C33.2129 12.7465 32.2507 13.5149 31.3587 14.3608C30.9369 14.7607 30.5224 15.168 30.1128 15.58C30.5806 15.6261 31.2035 15.6576 31.9307 15.6164V15.614Z"
                                            fill="#E92827" />
                                        <path
                                            d="M20.3297 31.2118C20.0922 30.9234 19.8862 30.6471 19.7068 30.3901C19.3771 31.207 19.0523 32.0093 18.7663 32.8237C18.4609 33.6963 18.1725 34.5786 17.918 35.4682C17.9907 35.4852 18.0634 35.5021 18.1385 35.5167C18.8754 35.6742 19.8159 35.8003 20.8945 35.7857C20.8969 35.7736 20.9018 35.7639 20.9042 35.7518C21.1854 34.7459 21.5441 33.7763 21.9416 32.8261C21.2702 32.2662 20.7345 31.7015 20.3297 31.2118Z"
                                            fill="white" />
                                        <path
                                            d="M18.1233 35.5646C18.0481 35.5477 17.9754 35.5307 17.9027 35.5137C17.8106 35.8337 17.7233 36.1561 17.6433 36.4784C17.3815 37.5134 17.144 38.5775 17.0858 39.6392C17.0786 39.7604 17.0761 39.8816 17.0713 40.0028C17.9245 39.8889 18.9837 39.6537 20.123 39.1859C20.2951 38.0564 20.5714 36.9438 20.8816 35.8313C20.8235 35.8313 20.7629 35.8337 20.7047 35.8337C19.7012 35.8337 18.8213 35.7101 18.1257 35.5622L18.1233 35.5646Z"
                                            fill="#E92827" />
                                        <path
                                            d="M16.8609 25.4961C15.8695 25.2246 14.8927 24.9143 13.9304 24.5532C13.8214 25.5809 13.5959 26.4705 13.3584 27.1807C14.3861 27.5539 15.4284 27.8812 16.4925 28.1551C16.73 28.2181 16.9724 28.2714 17.2124 28.3247C17.2124 28.2375 17.2124 28.1502 17.2075 28.0605C17.1881 27.3528 17.096 26.4705 16.8609 25.4961Z"
                                            fill="white" />
                                        <path
                                            d="M46.0929 7.106C46.9364 6.65758 47.792 6.23097 48.6525 5.81406C49.2512 5.5232 49.8572 5.25415 50.468 4.99964C49.6972 4.7427 49.0379 4.43972 48.5119 4.1537C48.0174 3.88707 47.6005 3.61802 47.2636 3.37805C46.4613 3.73436 45.6711 4.11249 44.893 4.53182C44.0713 4.9754 43.2593 5.43109 42.457 5.90375C42.8279 6.09766 43.286 6.30854 43.8193 6.5073C44.4325 6.73514 45.2009 6.96299 46.0929 7.10842V7.106Z"
                                            fill="white" />
                                        <path
                                            d="M27.7104 19.747C28.5684 19.6985 29.6737 19.5434 30.8856 19.1435C31.5692 18.3896 32.2745 17.6552 32.975 16.9159C33.5689 16.2857 34.2015 15.7015 34.856 15.1416C33.7434 15.4809 32.7326 15.6191 31.9352 15.6627C31.6976 15.6749 31.4698 15.6821 31.2565 15.6821C30.796 15.6821 30.396 15.6555 30.0712 15.6215C28.8035 16.9038 27.6013 18.2515 26.479 19.6646C26.4572 19.6937 26.4354 19.7228 26.4136 19.7494C26.7917 19.7688 27.228 19.7737 27.7128 19.747H27.7104Z"
                                            fill="white" />
                                        <path
                                            d="M65.0288 4.75463C65.1427 4.95097 65.247 5.16427 65.3366 5.39939C65.5645 6.00051 65.676 6.61618 65.5233 7.20519C65.4384 7.53241 65.3609 7.86206 65.2785 8.19171C66.391 7.45243 67.4697 6.99673 68.3447 6.71798C68.3447 6.5168 68.3447 6.31562 68.3398 6.11444C68.2962 4.39589 67.6369 3.007 66.4347 1.94049C66.4104 1.97685 66.3862 2.01078 66.3619 2.04957C65.9184 2.72583 65.4191 3.63964 65.0288 4.75706V4.75463Z"
                                            fill="#E92827" />
                                        <path
                                            d="M22.4459 26.6959C22.2665 26.4802 22.1065 26.2717 21.9635 26.073C21.7575 26.3711 21.4884 26.5747 21.074 26.4826C20.3056 26.3129 19.5348 26.1481 18.7664 25.9736C18.1459 25.833 17.5302 25.6779 16.917 25.5106C17.1497 26.4778 17.2394 27.3552 17.2588 28.0606C17.2612 28.1527 17.2636 28.2448 17.2636 28.3345C17.9496 28.4799 18.6428 28.5962 19.3288 28.7514C19.6657 28.8265 20.0511 28.8653 20.1795 29.2119C20.0293 29.5925 19.879 29.9633 19.7287 30.3342C19.9105 30.5984 20.1214 30.882 20.3686 31.1801C20.771 31.6649 21.2994 32.2248 21.9635 32.7775C22.3562 31.8394 22.7852 30.9183 23.2142 29.9948C23.3815 29.6337 23.6457 29.5125 24.0044 29.5173C24.6225 29.527 25.2406 29.5391 25.8563 29.5488C24.2808 28.6568 23.1658 27.5588 22.4483 26.6935L22.4459 26.6959Z"
                                            fill="#E92827" />
                                        <path
                                            d="M50.5368 4.97043C51.6978 4.48807 52.8807 4.06874 54.0853 3.72212C53.3824 3.28824 52.8031 2.83255 52.3498 2.42776C52.0493 2.15871 51.7875 1.89693 51.5596 1.65454C51.0555 1.82421 50.5561 2.00601 50.0593 2.20476C49.1358 2.57562 48.2195 2.9489 47.313 3.35127C47.6451 3.58638 48.0547 3.84816 48.5346 4.10994C49.0703 4.40081 49.7441 4.70865 50.5343 4.97043H50.5368Z"
                                            fill="#E92827" />
                                        <path
                                            d="M12.0912 23.7922C11.5968 23.5667 11.1071 23.3316 10.6248 23.082C10.014 23.9328 9.36194 24.6139 8.77051 25.1374C9.05168 25.2901 9.3377 25.4404 9.62614 25.5834C10.8284 26.1821 12.0573 26.7057 13.3129 27.1638C13.5504 26.456 13.7758 25.564 13.8825 24.5363C13.2789 24.3085 12.6802 24.0636 12.0912 23.7946V23.7922Z"
                                            fill="#E92827" />
                                        <path
                                            d="M10.5806 23.06C9.83157 22.6698 9.10441 22.2359 8.42572 21.7148C8.19303 21.5378 7.96276 21.3609 7.73491 21.1815C6.5157 21.6299 5.37404 21.8287 4.43115 21.9038C4.66869 22.1244 4.90381 22.3426 5.1365 22.5656C6.21029 23.5933 7.4295 24.4077 8.72628 25.1155C9.31771 24.5944 9.96974 23.9132 10.583 23.0625L10.5806 23.06Z"
                                            fill="white" />
                                        <path
                                            d="M29.4456 26.9673C28.2119 26.9939 26.9781 27.0182 25.7443 27.04C25.5335 27.0424 25.3177 26.9649 24.9542 26.897C25.3202 26.3104 25.5844 25.8208 25.9092 25.3772C26.6485 24.3689 27.3926 23.3605 28.1561 22.3716C26.9442 22.7691 25.8389 22.9242 24.9808 22.9727C24.7433 22.9848 24.5154 22.9921 24.3021 22.9921C24.1979 22.9921 24.0961 22.9921 23.9967 22.9873C23.6404 23.4841 23.2865 23.981 22.9302 24.4755C22.5884 24.9506 22.3291 25.4863 22.0188 25.9856C22.0091 26.0002 21.9994 26.0147 21.9897 26.0292C22.1376 26.2328 22.3 26.4461 22.4818 26.6667C23.209 27.5417 24.3433 28.6567 25.9528 29.5512C26.4545 29.5584 26.9563 29.5681 27.458 29.5705C29.1184 29.5778 30.7812 29.6093 32.4391 29.5124C32.2258 29.2627 31.981 28.9937 31.695 28.7149C31.1448 28.1744 30.3958 27.5466 29.4432 26.9697L29.4456 26.9673Z"
                                            fill="white" />
                                        <path
                                            d="M52.3826 2.39431C52.8407 2.80395 53.4322 3.26691 54.1496 3.70564C55.1725 3.41477 56.2099 3.17481 57.2667 2.99786C57.5382 2.95181 57.8121 2.90575 58.086 2.8597C57.5625 2.20283 57.1649 1.57019 56.8717 1.02966C56.7529 0.811511 56.6511 0.603056 56.5565 0.404297C56.319 0.447927 56.0815 0.493981 55.8463 0.540035C54.4138 0.821206 52.9983 1.17752 51.6118 1.64048C51.8324 1.87802 52.0893 2.13253 52.3826 2.39431Z"
                                            fill="white" />
                                        <path
                                            d="M61.9872 2.83558C63.2161 3.09009 64.3117 3.57972 64.9952 4.70198C65.3855 3.59669 65.8799 2.69015 66.3211 2.01873C66.3453 1.97995 66.372 1.94359 66.3962 1.90481C66.1757 1.7109 65.9381 1.52668 65.6812 1.35458C64.5638 0.605602 63.2888 0.290496 61.9896 0.125671C61.9629 0.351093 61.9436 0.591059 61.929 0.847991C61.8999 1.41033 61.9023 2.08418 61.9848 2.83558H61.9872Z"
                                            fill="white" />
                                        <path
                                            d="M58.1427 2.84981C59.1632 2.68498 60.1957 2.56137 61.2235 2.70438C61.4658 2.73831 61.7034 2.77709 61.9361 2.82315C61.8561 2.07659 61.8512 1.40275 61.8803 0.842826C61.8949 0.585894 61.9167 0.345928 61.9409 0.118082C61.7349 0.0914196 61.5264 0.0696045 61.3204 0.0502134C59.7352 -0.100068 58.1621 0.108387 56.606 0.391982C56.6981 0.588318 56.7999 0.791924 56.9138 1.00523C57.2095 1.5506 57.6094 2.18809 58.1403 2.84739L58.1427 2.84981Z"
                                            fill="#E92827" />
                                        <path
                                            d="M28.884 79.0182C28.1689 79.9781 27.4224 80.9089 26.6516 81.8203C26.3025 82.2348 25.9195 82.625 25.5244 83.0007C25.1948 84.0939 24.9282 85.5434 25.0227 87.2207C25.7038 86.6753 26.3583 86.0984 27.0054 85.5143C27.7617 84.8307 28.4307 84.0454 29.1142 83.2843C29.1627 83.231 29.2088 83.1801 29.2572 83.1268C28.8452 81.5779 28.7967 80.1575 28.884 79.0182Z"
                                            fill="#E92827" />
                                        <path
                                            d="M29.9578 77.5203C29.6281 78.0051 29.2864 78.4778 28.9373 78.948C28.8428 80.0872 28.884 81.5197 29.2961 83.0856C30.2438 82.0336 31.177 80.9719 31.9357 79.7673C32.2484 79.2704 32.5659 78.7759 32.8834 78.2838C32.1635 77.2028 31.7078 76.1435 31.4194 75.2467C30.9492 76.0151 30.4668 76.7762 29.9578 77.5252V77.5203Z"
                                            fill="white" />
                                        <path
                                            d="M24.9829 22.9243C25.8531 22.8759 26.9802 22.7159 28.214 22.3014C28.3812 22.0832 28.5485 21.8651 28.7206 21.6494C29.3823 20.8107 30.0998 20.0132 30.8172 19.2182C29.6344 19.6012 28.5533 19.749 27.7122 19.7975C27.4747 19.8121 27.2468 19.8169 27.0335 19.8169C26.7984 19.8169 26.5778 19.8096 26.3767 19.7999C25.5695 20.8252 24.8011 21.8796 24.04 22.9413C24.3309 22.9486 24.646 22.9461 24.9878 22.9268L24.9829 22.9243Z"
                                            fill="#E92827" />
                                        <path
                                            d="M28.1899 64.623C28.3499 64.577 28.5075 64.5285 28.6674 64.4776C30.1315 64.0074 31.6609 63.9104 33.1468 63.5735C33.3649 63.525 33.5879 63.4862 33.8109 63.4547C34.4727 62.7688 35.161 61.8937 35.75 60.8127C35.5731 60.8297 35.3986 60.849 35.2216 60.866C34.4605 60.9387 33.697 60.9824 32.9432 61.0987C32.1603 61.2199 31.3725 61.3169 30.5944 61.4623C29.877 62.8197 28.9947 63.8595 28.1948 64.6206L28.1899 64.623Z"
                                            fill="#E92827" />
                                        <path
                                            d="M25.4531 83.0686C24.9805 83.5171 24.4884 83.9485 24.0036 84.3824C23.3783 84.9423 22.6972 85.4416 22.0185 85.9385C21.8536 86.0597 21.6888 86.1761 21.5216 86.2876C21.0635 87.2256 20.5859 88.52 20.3848 90.0858C21.4319 89.5913 22.4475 89.0241 23.4316 88.3794C23.9673 88.0279 24.4787 87.6498 24.9732 87.2571C24.8738 85.5992 25.1307 84.1618 25.4531 83.0662V83.0686Z"
                                            fill="white" />
                                        <path
                                            d="M18.3253 87.9259C17.998 88.0423 17.666 88.1538 17.3363 88.2628C16.677 89.0676 15.9208 90.2092 15.3633 91.6757C16.3231 91.443 17.3194 91.3097 18.2429 90.9776C18.9555 90.7207 19.6511 90.4322 20.3347 90.1123C20.531 88.5683 20.994 87.2836 21.4448 86.3407C20.4728 86.9927 19.4354 87.5308 18.3277 87.9259H18.3253Z"
                                            fill="#E92827" />
                                        <path
                                            d="M47.7996 65.5316C48.4929 66.0309 49.0867 66.6005 49.5715 67.2477C50.3544 67.3641 51.2755 67.4198 52.2887 67.3447C52.1699 66.9835 52.0124 66.632 51.8185 66.3024C51.1349 65.1365 50.2357 64.2033 49.1691 63.4664C48.3159 64.0869 47.4676 64.5378 46.6968 64.8626C47.0749 65.0589 47.4433 65.2795 47.7996 65.534V65.5316Z"
                                            fill="white" />
                                        <path
                                            d="M33.7144 71.2138C33.6078 71.4174 33.4939 71.6162 33.3872 71.8198C34.0029 72.4258 34.7809 73.0633 35.736 73.628C36.2813 72.6536 36.8049 71.6671 37.3139 70.6733C37.4957 70.3194 37.6678 69.9607 37.8375 69.5995C36.7201 69.3789 35.7626 69.0275 34.9991 68.6736C34.5822 69.5268 34.158 70.3752 33.7169 71.2162L33.7144 71.2138Z"
                                            fill="white" />
                                        <path
                                            d="M35.0181 68.6274C35.7792 68.9838 36.7366 69.3328 37.8564 69.5534C38.2103 68.7971 38.5448 68.0312 38.8939 67.2725C39.255 66.4847 39.6234 65.7018 39.9773 64.9116C38.62 65.5273 37.3377 65.8085 36.3173 65.9272C35.8882 66.8289 35.4568 67.7306 35.0181 68.6274Z"
                                            fill="#E92827" />
                                        <path
                                            d="M52.5408 69.2285C52.5408 69.1291 52.5408 69.0298 52.5408 68.9304C52.5481 68.3971 52.4633 67.8833 52.3057 67.3936C51.9858 67.4179 51.6731 67.43 51.3725 67.43C50.7326 67.43 50.1412 67.3791 49.6104 67.304C50.0151 67.8518 50.3375 68.4577 50.5775 69.117C51.2319 69.1388 51.8864 69.1776 52.5408 69.2285Z"
                                            fill="#E92827" />
                                        <path
                                            d="M31.4526 75.1864C31.7387 76.0833 32.1919 77.1474 32.9118 78.2357C33.6075 77.1546 34.3056 76.076 34.9624 74.9707C35.2194 74.5417 35.4666 74.1054 35.7114 73.6691C34.7588 73.1043 33.9783 72.4668 33.3627 71.8633C32.7567 72.988 32.1216 74.0957 31.4526 75.1864Z"
                                            fill="#E92827" />
                                        <path
                                            d="M9.56688 74.2506C10.6916 73.0969 11.952 72.0934 13.2682 71.1602C13.5348 70.2536 13.7626 69.1047 13.7723 67.7837C12.3592 68.5957 11.0018 69.4901 9.7414 70.513C9.89653 71.9819 9.76079 73.2714 9.56445 74.2506H9.56688Z"
                                            fill="white" />
                                        <path
                                            d="M5.49054 81.4396C5.71838 80.155 6.18377 78.9891 6.80671 77.8935C6.53766 77.0354 6.10136 75.9835 5.40085 74.9024C4.71005 75.7483 4.19133 76.7082 3.70413 77.6802C3.43266 78.2231 3.21693 78.7903 3.03271 79.3696C4.07741 80.0386 4.88699 80.7828 5.48811 81.4396H5.49054Z"
                                            fill="white" />
                                        <path
                                            d="M17.4158 68.6267C17.8981 67.7347 18.3732 66.593 18.6496 65.2357C17.074 65.9992 15.5106 66.7918 13.9884 67.6571C13.9327 67.6886 13.8793 67.7226 13.8236 67.7541C13.8139 69.063 13.5957 70.2071 13.3315 71.1136C14.6356 70.1925 15.993 69.3514 17.4134 68.6267H17.4158Z"
                                            fill="#E92827" />
                                        <path
                                            d="M42.7451 63.6051C44.0976 63.8668 45.4235 64.2134 46.6427 64.8315C47.4159 64.5092 48.2692 64.0607 49.1272 63.4378C48.56 63.05 47.9516 62.7131 47.2972 62.4319C46.4367 62.061 45.5617 61.7411 44.6673 61.4866C44.0322 62.3761 43.3535 63.0766 42.7451 63.6075V63.6051Z"
                                            fill="#E92827" />
                                        <path
                                            d="M19.3038 67.7496C20.1837 67.3836 21.0587 66.9982 21.9386 66.6274C22.69 65.8226 23.5771 64.6495 24.2413 63.0958C23.7153 63.2727 23.1917 63.4618 22.6657 63.646C21.6332 64.0096 20.5691 64.3174 19.585 64.7852C19.2917 64.9258 18.9984 65.0688 18.7051 65.2094C18.4361 66.5547 17.9707 67.6915 17.4932 68.5859C18.0846 68.2853 18.6881 68.0041 19.3038 67.7472V67.7496Z"
                                            fill="white" />
                                        <path
                                            d="M15.5617 88.808C15.1739 88.9219 14.7643 88.9656 14.3619 89.0213C13.6493 89.1207 12.9367 89.1813 12.2289 89.1862C11.3854 89.7776 10.4013 90.6284 9.51172 91.7967C9.80016 91.8476 10.0935 91.8864 10.3916 91.9106C12.0204 92.0439 13.6808 92.0706 15.3048 91.6876C15.8502 90.2381 16.5943 89.1013 17.2488 88.2893C16.6888 88.4711 16.1265 88.6408 15.5617 88.8056V88.808Z"
                                            fill="white" />
                                        <path
                                            d="M24.2608 65.713C25.5067 65.2743 26.8156 65.0174 28.0882 64.6514C28.8977 63.8951 29.797 62.848 30.529 61.4736C30.0321 61.5682 29.5352 61.6821 29.0456 61.8372C27.8627 62.2105 26.6217 62.3947 25.4243 62.7244C25.0462 62.8286 24.6729 62.9474 24.3021 63.071C23.6549 64.6005 22.7895 65.7639 22.0454 66.5784C22.7774 66.2705 23.5143 65.9748 24.2608 65.713Z"
                                            fill="#E92827" />
                                        <path
                                            d="M12.147 89.1864C11.1048 89.1864 10.0698 89.0628 9.05901 88.7331C8.62029 88.5901 8.2155 88.4011 7.84222 88.1732C6.98901 88.3865 5.97825 88.7356 4.92871 89.3076C5.03294 89.4118 5.13717 89.5185 5.24139 89.6227C6.43879 90.8007 7.88101 91.4964 9.45896 91.7872C10.3388 90.6286 11.3084 89.7827 12.147 89.1864Z"
                                            fill="#E92827" />
                                        <path
                                            d="M5.37927 82.2522C5.40351 81.9977 5.43986 81.7481 5.48107 81.5033C4.88237 80.844 4.07037 80.095 3.02082 79.4211C2.86569 79.918 2.7348 80.4246 2.61846 80.9337C2.32274 82.2256 2.24276 83.5054 2.49969 84.7998C2.50454 84.8288 2.51181 84.8579 2.51908 84.887C3.71648 84.9258 4.76845 85.1391 5.62893 85.3936C5.28473 84.378 5.27989 83.3527 5.38169 82.2547L5.37927 82.2522Z"
                                            fill="#E92827" />
                                        <path
                                            d="M5.82238 85.895C5.75451 85.7447 5.69392 85.5969 5.64302 85.4466C4.78496 85.1897 3.73057 84.9739 2.52832 84.9327C2.86282 86.5398 3.47364 88.0111 4.7486 89.1358C4.79708 89.1794 4.84313 89.2279 4.89161 89.2739C5.93146 88.7043 6.93252 88.3528 7.78331 88.1371C6.94464 87.6136 6.27323 86.8791 5.82238 85.895Z"
                                            fill="white" />
                                        <path
                                            d="M22.4365 54.3282C23.0789 54.8009 23.7648 55.2226 24.475 55.5499C25.3185 55.9377 26.1935 56.2286 27.0855 56.4491C27.0274 55.6056 26.865 54.5585 26.4893 53.4193C25.2555 52.9175 24.1454 52.2025 23.1807 51.2256C23.0619 52.3358 22.8098 53.2835 22.5529 54.0131C22.5141 54.1198 22.4753 54.224 22.4365 54.3258V54.3282Z"
                                            fill="#E92827" />
                                        <path
                                            d="M48.9269 42.7304C48.9899 42.5946 49.0602 42.4638 49.1329 42.3329C48.7694 42.3644 48.4155 42.3789 48.0737 42.3789C47.4217 42.3789 46.8181 42.3256 46.2727 42.2456C45.7831 43.203 45.3299 44.1823 44.9008 45.1712C44.7166 45.593 44.5372 46.0148 44.353 46.4365C45.422 46.1602 46.6994 45.6778 47.9889 44.8367C48.2943 44.1314 48.5997 43.4236 48.9245 42.728L48.9269 42.7304Z"
                                            fill="white" />
                                        <path
                                            d="M54.0968 39.5935C54.0823 39.6347 54.0726 39.6783 54.058 39.7195C53.4957 41.2708 52.6498 42.667 51.5493 43.8935C51.3942 44.0656 51.2342 44.2328 51.0767 44.4049C52.4122 43.7383 53.6726 43.4135 54.6301 43.2608C54.8579 43.2245 55.0761 43.1954 55.2845 43.1736C55.2966 43.1542 55.3088 43.1372 55.3185 43.1178C56.1765 41.678 57.02 40.2382 57.2091 38.5633C57.2576 38.1464 57.2576 37.7562 57.2164 37.3926C56.7995 37.5962 56.2759 37.8822 55.7014 38.2773C55.2191 38.6094 54.6616 39.0433 54.0944 39.5935H54.0968Z"
                                            fill="white" />
                                        <path
                                            d="M46.377 48.7073C46.3649 48.6977 46.3504 48.688 46.3382 48.6783C46.8182 47.5584 47.2957 46.4386 47.7805 45.3212C47.8386 45.1854 47.8968 45.0521 47.955 44.9164C46.6655 45.7478 45.3929 46.2229 44.3288 46.4943C43.7156 47.9075 43.1023 49.3206 42.494 50.7361C42.38 51.0003 42.2346 51.2355 42.0625 51.4488C43.2866 50.9931 44.8912 50.169 46.3746 48.7049L46.377 48.7073Z"
                                            fill="#E92827" />
                                        <path
                                            d="M49.1609 42.2793C49.3039 42.0297 49.4566 41.7849 49.6021 41.5401C49.9875 40.8977 50.3753 40.253 50.8116 39.647C49.9681 39.2543 49.2433 38.7986 48.6301 38.3405C48.3271 38.7744 48.0338 39.218 47.7478 39.6615C47.217 40.4832 46.7395 41.334 46.2935 42.2018C47.1273 42.323 48.0944 42.3763 49.1585 42.2818L49.1609 42.2793Z"
                                            fill="#E92827" />
                                        <path
                                            d="M51.61 38.6602C51.9566 38.2821 52.3639 37.9597 52.822 37.727C52.4584 36.789 52.2427 35.8897 52.1215 35.0729C51.2464 35.4559 50.4926 36.0933 49.826 36.8229C49.4043 37.2835 49.0213 37.7852 48.6602 38.2991C49.2734 38.7572 49.9981 39.2129 50.8441 39.6056C51.0816 39.2783 51.3337 38.9608 51.61 38.6602Z"
                                            fill="white" />
                                        <path
                                            d="M53.2364 37.5451C53.9369 37.2881 54.3684 37.5693 54.332 38.3013C54.3126 38.6988 54.2448 39.1085 54.1284 39.4939C54.6762 38.9703 55.2095 38.5558 55.6773 38.2359C56.259 37.8359 56.7947 37.5451 57.214 37.3415C57.008 35.7078 55.8882 34.6946 53.92 34.6946C53.2849 34.6946 52.7056 34.8255 52.1699 35.0533C52.2887 35.8702 52.5044 36.7694 52.868 37.7075C52.9868 37.6493 53.1104 37.5936 53.2364 37.5475V37.5451Z"
                                            fill="#E92827" />
                                        <path
                                            d="M38.6836 55.7758C39.1854 55.6279 39.6774 55.4461 40.1767 55.2934C40.3076 55.2546 40.4531 55.2643 40.7051 55.2425C40.5888 55.5406 40.4797 55.8218 40.3731 56.0981C40.6397 56.0181 40.9233 55.926 41.2263 55.8097C42.094 55.48 43.2042 54.9419 44.3264 54.0839C44.3458 54.0354 44.3652 53.9893 44.3822 53.9409C44.6149 53.3519 44.9857 52.8913 45.5263 52.5423C46.3189 52.0308 47.1139 51.5145 47.8532 50.9352C48.8155 50.179 49.7535 49.3888 50.6504 48.5574C51.1133 48.1284 51.5787 47.6921 52.0247 47.2412C50.8443 47.1612 49.3851 47.234 47.8023 47.6921C47.3757 48.0653 46.9418 48.4338 46.5176 48.8095C46.4837 48.7852 46.4498 48.7586 46.4158 48.7343C44.8912 50.2372 43.243 51.071 42.0019 51.5218C41.8201 51.7327 41.6117 51.9169 41.3741 52.0696C40.9742 52.329 40.5112 52.5035 40.0555 52.6586C38.863 53.0707 37.6801 53.5288 36.4585 53.8415C36.7784 54.0572 37.0669 54.2729 37.3141 54.4741C37.9056 54.9541 38.3612 55.4146 38.6788 55.7709L38.6836 55.7758Z"
                                            fill="white" />
                                        <path
                                            d="M40.3506 56.1535C40.1179 56.7546 39.8997 57.3169 39.6816 57.8744C39.4295 58.5168 39.1847 59.164 38.9181 59.8014C38.8453 59.9735 38.7654 60.1359 38.6611 60.2717C39.0732 60.1747 39.5652 60.0317 40.1106 59.8281C40.8135 59.5615 41.6764 59.1615 42.5733 58.5653C42.6702 58.3059 42.7672 58.049 42.8666 57.792C43.3344 56.5825 43.8143 55.3803 44.2894 54.1732C43.1841 55.007 42.0958 55.533 41.2401 55.8578C40.925 55.9765 40.6269 56.0759 40.3482 56.1559L40.3506 56.1535Z"
                                            fill="#E92827" />
                                        <path
                                            d="M50.9796 44.5089C50.2694 45.2821 49.5447 46.0432 48.7957 46.7801C48.5024 47.0686 48.1946 47.3449 47.8867 47.6188C49.4574 47.1776 50.8996 47.1146 52.0704 47.197C52.4533 46.8092 52.8218 46.4117 53.1611 45.9899C53.8834 45.0931 54.6397 44.2253 55.2529 43.2267C55.0566 43.2485 54.853 43.2752 54.6372 43.3091C53.6556 43.4666 52.3564 43.8036 50.982 44.5089H50.9796Z"
                                            fill="#E92827" />
                                        <path
                                            d="M30.6142 57.0044C31.4528 57.0722 32.2915 57.048 33.1229 56.9729C32.9896 56.7014 32.832 56.4081 32.6478 56.0978C32.3618 55.6203 31.9861 55.0701 31.5086 54.5005C30.4154 54.4496 29.3392 54.229 28.2751 53.9818C27.6764 53.8436 27.102 53.6642 26.5493 53.4437C26.9202 54.578 27.0801 55.6227 27.1359 56.4614C28.2727 56.7402 29.4386 56.9074 30.6142 57.0044Z"
                                            fill="white" />
                                        <path
                                            d="M33.1759 56.9682C33.9273 56.8979 34.6739 56.7888 35.418 56.6676C36.5088 56.4883 37.5656 56.1005 38.6321 55.7902C38.3146 55.4363 37.8662 54.9855 37.2868 54.5152C37.0299 54.3068 36.7318 54.0838 36.3997 53.8608C35.9198 53.982 35.435 54.0814 34.9381 54.1444C34.2303 54.2341 33.5322 54.3989 32.8245 54.4716C32.4051 54.5152 31.9907 54.5201 31.5762 54.5055C32.044 55.0655 32.4124 55.6036 32.6936 56.0762C32.8826 56.3913 33.0426 56.6919 33.1784 56.9706L33.1759 56.9682Z"
                                            fill="#E92827" />
                                        <path
                                            d="M38.6084 60.3321C38.4582 60.4969 38.257 60.6084 37.954 60.6229C37.2365 60.6569 36.5215 60.7344 35.8064 60.8096C35.2247 61.8833 34.546 62.7584 33.8867 63.4468C34.5436 63.3595 35.2126 63.3304 35.8695 63.2553C36.0973 63.2286 36.3203 63.1704 36.5481 63.1632C36.7881 63.1535 37.0305 63.1874 37.4426 63.2141C37.1541 63.9655 36.9651 64.5739 36.6912 65.1459C36.5748 65.3883 36.4585 65.6331 36.3421 65.8779C37.365 65.7567 38.6497 65.4683 40.007 64.8453C40.1234 64.5836 40.2397 64.3218 40.3512 64.0576C40.5791 63.5243 40.9354 63.3086 41.4929 63.3959C41.7934 63.4419 42.0964 63.4831 42.3946 63.5389C42.4891 63.5558 42.586 63.5752 42.6806 63.5922C43.289 63.0638 43.9725 62.3609 44.6124 61.4689C43.8634 61.258 43.1023 61.0907 42.3218 60.9841C42.1376 60.9598 41.9728 60.812 41.7716 60.7078C42.0382 59.9976 42.2879 59.314 42.5424 58.6378C41.6601 59.2171 40.8142 59.6097 40.1234 59.8715C39.5489 60.0872 39.0302 60.2351 38.606 60.3321H38.6084Z"
                                            fill="white" />
                                        <path
                                            d="M64.2819 10.8971C63.9813 11.3843 63.6686 11.8643 63.3511 12.3418C64.1388 11.9321 64.8757 11.6558 65.4914 11.4716C66.284 11.2341 66.9675 11.1153 67.4523 11.0571C67.5735 10.7711 67.6874 10.4851 67.7941 10.1918C68.194 9.08164 68.3322 7.93514 68.3443 6.77167C67.4644 7.05526 66.3785 7.51823 65.2611 8.26721C65.0357 9.17859 64.7836 10.0851 64.2819 10.8971Z"
                                            fill="white" />
                                        <defs>
                                            <pattern id="pattern0_2639_40882" patternContentUnits="objectBoundingBox"
                                                width="1" height="1">
                                                <use xlink:href="#image0_2639_40882"
                                                    transform="scale(0.0126582 0.0128205)" />
                                            </pattern>
                                            <pattern id="pattern1_2639_40882" patternContentUnits="objectBoundingBox"
                                                width="1" height="1">
                                                <use xlink:href="#image1_2639_40882"
                                                    transform="scale(0.0126582 0.012987)" />
                                            </pattern>
                                            <image id="image0_2639_40882" width="79" height="78"
                                                preserveAspectRatio="none"
                                                xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAE8AAABOCAYAAABhaEsjAAAACXBIWXMAAAsSAAALEgHS3X78AAAAwklEQVR4nO3VsWnEUBAE0BE4VA9XgPpxIe7oQgcO3YB7uAJUg5WPA8lwHDhwpG/8Hiz8cBnmswkAAAAAAAAAAAAA/HvT2QvcazsnuSSZk2xJ1mmatnO3+tnT2Qs8uCR5SbIkWZO8tb1l0BBHCy/ZW7fczS3Jte3HaAGOFt6a5Hq8l+xN/P7GGTHAobSd2y5tn9u+t/085rXtcvZ+90ZrXo5m3dqu2Y/Glr19wzVuqGv76K9dXwAAAAAAAAAAAACA3/gCNsdF9uLNGZIAAAAASUVORK5CYII=" />
                                            <image id="image1_2639_40882" width="79" height="77"
                                                preserveAspectRatio="none"
                                                xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAE8AAABNCAYAAADn/DmNAAAACXBIWXMAAAsSAAALEgHS3X78AAAAwElEQVR4nO3VsU0DMRgF4GcJieZ2yADXZgpa5qOgzBqZgQyQGUj/KO6QIhrKGPF9kiW7+/X0bCcAAAAAAAAAAAAA8O+NRw9wr+2S5LAfr2OM2yPn+VParm3f2p7avuxhTuvp0QP8sCRZ97UkWdpeooW/25t3avu5r4+ZWzhb865J3vf9mu39O2RrYdqeZ2rgVOGNMW5tz9lCXJO8ZgvvOckxySXJNOFN9dveu/t5v6/rLd4+AAAAAAAAAAAAAJjNFw3ATUX+NmUmAAAAAElFTkSuQmCC" />
                                        </defs>
                                    </svg>
                                </div>

                                <div class="d-flex flex-column ">

                                    <h2 id="product_name_en" class="product_name"
                                        style="font-family: 'DM Sans', sans-serif; Font-weight: 700;font-size:8px;"></h2>
                                    <!-- <h2 id="product_name_ar" class="product_name" style="font-family: 'Noto Kufi Arabic', sans-serif; Font-weight: 700;font-size:8px;"></h2> -->

                                </div>
                                <ul>
                                    <li id="vegan">
                                        <svg width="8" height="9" viewBox="0 0 8 9" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6.82844 2.02119C6.07294 1.26569 5.06844 0.849609 4 0.849609C2.93156 0.849609 1.92708 1.26569 1.17158 2.02119C0.416078 2.77669 0 3.78117 0 4.84961C0 5.91805 0.416078 6.92253 1.17158 7.67803C1.92708 8.43353 2.93156 8.84961 4 8.84961C5.06844 8.84961 6.07294 8.43353 6.82844 7.67803C7.58392 6.92253 8 5.91805 8 4.84961C8 3.78117 7.58392 2.77669 6.82844 2.02119ZM0.46875 4.84961C0.46875 3.90637 0.836062 3.01961 1.50303 2.35264C2.17 1.68567 3.05677 1.31836 4 1.31836C4.86467 1.31836 5.68175 1.62723 6.3257 2.19245L5.68369 2.83447C5.6667 2.77095 5.64728 2.70738 5.62509 2.64345C5.50178 2.28831 5.1993 2.05884 4.85447 2.05884C4.41889 2.05884 4.06452 2.4132 4.06452 2.84878V4.59702C4.04311 4.59658 3.87387 4.59812 3.81273 4.60188L3.57359 3.59441C3.49495 3.25478 3.25377 2.97744 2.9283 2.85245C2.60312 2.72758 2.23869 2.77202 1.95308 2.97127L1.52997 3.25884C1.16606 3.50617 1.06677 4.00644 1.30859 4.37402C1.54809 4.73805 2.01042 4.87302 2.44241 4.5992L2.66586 5.02591C2.40813 5.26586 2.27292 5.596 2.27292 5.99144C2.27292 6.07195 2.27859 6.15117 2.28931 6.2288L1.34284 7.17527C0.777625 6.53136 0.46875 5.71428 0.46875 4.84961ZM4.22875 6.12273L4 6.35148L3.77125 6.12273L3.4398 6.45419L3.76562 6.78003V7.22758C3.18345 7.11741 2.74169 6.60522 2.74169 5.9915C2.74169 5.67933 2.8517 5.45134 3.07802 5.2945C3.29477 5.1443 3.61358 5.06489 4 5.06489C4.38641 5.06489 4.70523 5.14428 4.92198 5.2945C5.1483 5.45133 5.2583 5.67933 5.2583 5.9915C5.2583 6.60522 4.81653 7.11742 4.23436 7.22758V6.78003L4.56019 6.4542L4.22875 6.12273ZM2.62722 3.9417L2.16092 4.22148C2.0035 4.31594 1.80113 4.2698 1.7002 4.11641C1.5983 3.96153 1.64014 3.75075 1.79347 3.64655L2.21781 3.35812L2.22047 3.3563C2.38081 3.24405 2.57756 3.21992 2.76027 3.29008C2.94297 3.36023 3.07302 3.50986 3.11703 3.70056L3.34781 4.67286C3.24614 4.69898 3.15039 4.73163 3.06133 4.77067L2.62722 3.9417ZM5.11716 4.39119L4.97336 4.78661C4.84128 4.72498 4.6938 4.67784 4.53325 4.64594V2.84881C4.53325 2.6717 4.67734 2.52762 4.85445 2.52762C4.96248 2.52762 5.11317 2.59823 5.18225 2.79722C5.35431 3.29277 5.33545 3.75472 5.11716 4.39119ZM6.49697 7.34658C5.83 8.01355 4.94323 8.38086 4 8.38086C3.13533 8.38086 2.31825 8.07198 1.6743 7.50677L2.44286 6.7382C2.72187 7.31767 3.315 7.71855 4 7.71855C4.9523 7.71855 5.72706 6.94378 5.72706 5.99148C5.72706 5.61577 5.60506 5.29895 5.37183 5.06248L5.55842 4.54936L5.55983 4.54539C5.70375 4.12636 5.77198 3.76161 5.76598 3.41509L6.65716 2.52392C7.22238 3.16786 7.53125 3.98494 7.53125 4.84961C7.53125 5.79284 7.16394 6.67961 6.49697 7.34658Z"
                                                fill="#E92827" />
                                        </svg>
                                        <span>Vegan</span>
                                    </li>
                                    <li id="palm">
                                        <svg width="8" height="9" viewBox="0 0 8 9" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4 0.849609C6.20914 0.849609 8 2.64047 8 4.84961C8 7.05875 6.20914 8.84961 4 8.84961C1.79086 8.84961 0 7.05875 0 4.84961C1.61064e-08 2.64047 1.79086 0.849609 4 0.849609ZM5.66309 3.44336C5.72004 3.49615 5.77567 3.55167 5.82715 3.60938L5.85352 3.64844C5.87231 3.69073 5.87003 3.74022 5.84766 3.78125L5.81934 3.81738C5.7864 3.84852 5.74049 3.8641 5.69434 3.85742L5.69336 3.85645C5.59915 3.84174 5.48041 3.84186 5.3623 3.84961C5.54698 4.04755 5.69917 4.35215 5.74609 4.7002L5.75586 4.79004V4.81445C5.75101 4.87044 5.71416 4.92165 5.65918 4.94238C5.59732 4.96544 5.5271 4.94467 5.4873 4.8916L5.38477 4.76562C5.34987 4.72622 5.31426 4.68869 5.27832 4.65332C5.2826 4.87309 5.21579 5.12413 5.05566 5.36816L5.00781 5.43652C4.9689 5.48937 4.90023 5.51021 4.83887 5.48926C4.77815 5.46736 4.73522 5.40768 4.73828 5.34082C4.75149 5.02761 4.68329 4.81684 4.57227 4.6084C4.4937 5.0292 4.46592 5.59171 4.49414 5.98145C4.94299 6.15295 5.27042 6.39062 5.35059 6.4375C5.4103 6.4719 5.43578 6.5408 5.41895 6.60449C5.40096 6.66941 5.34199 6.71582 5.27441 6.71582H2.16016L1.5 7.37598C2.14236 8.01167 3.02487 8.40527 4 8.40527C5.96368 8.40527 7.55566 6.81329 7.55566 4.84961C7.55566 3.93336 7.20885 3.09819 6.63965 2.46777L5.66309 3.44336ZM4 1.29395C2.03632 1.29395 0.444336 2.88593 0.444336 4.84961C0.444336 5.67788 0.728258 6.43953 1.20312 7.04395L1.68848 6.55859C1.69105 6.5092 1.71802 6.46242 1.7627 6.43652C1.82592 6.39912 2.03094 6.25344 2.32617 6.1084C2.22318 5.89438 2.11419 5.62894 2.07031 5.37793L2.05371 5.25781L2.0498 5.13965C2.05352 4.87603 2.15139 4.69243 2.25879 4.57129C2.37499 4.44031 2.4995 4.38536 2.51855 4.37793C2.54427 4.368 2.57116 4.36581 2.59668 4.37012L2.62207 4.37695H2.62402L2.65527 4.39062C2.77235 4.44372 3.16704 4.66266 3.2168 5.23145L3.22168 5.3125C3.22605 5.46749 3.20455 5.64048 3.16211 5.8291C3.28863 5.80747 3.4212 5.79492 3.55762 5.79492C3.61586 5.79494 3.67314 5.79826 3.72949 5.80273C3.76467 5.42186 3.82057 4.97311 3.90918 4.58984C3.78959 4.73281 3.68196 4.911 3.58984 5.12012L3.58887 5.12109C3.56214 5.17944 3.50004 5.21733 3.43262 5.20801C3.36711 5.19889 3.31484 5.14776 3.30469 5.08203L3.28027 4.87598C3.26301 4.66745 3.26956 4.45386 3.32324 4.27051C3.35937 4.14734 3.41854 4.03412 3.50879 3.94531C3.52935 3.9251 3.55176 3.90579 3.5752 3.88867C3.43761 3.87666 3.2919 3.8859 3.13965 3.91699C3.07804 3.92971 3.01586 3.90124 2.9834 3.84863L2.96484 3.80566C2.95414 3.76212 2.96407 3.71563 2.99121 3.67969L3.0459 3.61133C3.17738 3.45529 3.33641 3.31719 3.51074 3.23633C3.64364 3.17478 3.78694 3.14689 3.93262 3.16895C3.84799 3.02994 3.75099 2.9047 3.63965 2.79199L3.6123 2.75488C3.59193 2.71454 3.59087 2.66616 3.61035 2.62402L3.62207 2.60352C3.64469 2.57027 3.68018 2.54704 3.71973 2.54004L3.75977 2.53906C4.01795 2.5631 4.26217 2.62827 4.44531 2.76074C4.59267 2.8674 4.69616 3.01512 4.7373 3.20801C4.7959 3.17167 4.85746 3.14709 4.9209 3.13477C5.03331 3.11304 5.14569 3.12911 5.25195 3.16895C5.26511 3.17388 5.27795 3.17988 5.29102 3.18555L6.32129 2.15723C5.69835 1.61967 4.88737 1.29395 4 1.29395ZM3.55664 6.09473C3.09852 6.09476 2.68197 6.25891 2.37891 6.41699H4.73438C4.43131 6.25892 4.01474 6.09475 3.55664 6.09473ZM2.5752 4.68555C2.53893 4.70934 2.48943 4.74918 2.44629 4.81055C2.38613 4.89633 2.33398 5.02998 2.35156 5.23242L2.36523 5.33301C2.40339 5.54761 2.50164 5.78674 2.59961 5.98828C2.67416 5.95931 2.75267 5.93251 2.83398 5.9082C2.906 5.64893 2.93305 5.43119 2.91797 5.25879L2.89941 5.13477C2.83731 4.86655 2.66538 4.73693 2.5752 4.68555ZM4.13184 2.92676C4.24356 3.09384 4.33748 3.27832 4.41406 3.4834L4.4209 3.50879C4.43181 3.56979 4.40353 3.63305 4.34766 3.66504L4.30371 3.68164C4.25884 3.69069 4.21104 3.67885 4.17578 3.64844L4.15723 3.62891C4.04038 3.4835 3.90509 3.4443 3.76758 3.46875C3.68271 3.48393 3.59318 3.52449 3.50586 3.58594C3.77416 3.59362 4.02557 3.66538 4.25488 3.80176C4.31659 3.83818 4.34428 3.91399 4.31836 3.98242C4.31111 4.00163 4.29954 4.01808 4.28613 4.03223L4.29785 4.04102L4.31445 4.05859C4.3492 4.10148 4.35663 4.15973 4.33594 4.20996C4.2022 4.5248 4.09404 5.08724 4.02441 5.84473C4.08037 5.85575 4.13489 5.86967 4.18848 5.88379C4.17757 5.63579 4.18388 5.34277 4.20898 5.05957C4.23835 4.72868 4.29218 4.40308 4.37402 4.17383L4.39453 4.13672C4.41867 4.10338 4.45582 4.08017 4.49805 4.0752C4.54206 4.07014 4.58482 4.0849 4.61523 4.1123L4.64258 4.14453L4.7832 4.37598C4.86016 4.50884 4.92357 4.64083 4.96875 4.78906C4.99822 4.59316 4.95343 4.43184 4.87402 4.34863L4.84473 4.30371C4.82443 4.25538 4.83054 4.19797 4.86426 4.1543C4.90879 4.09655 4.98916 4.07902 5.05371 4.11426L5.12402 4.1543C5.185 4.19111 5.24481 4.23338 5.30273 4.27832C5.26915 4.21563 5.23267 4.15872 5.19434 4.11035C5.09389 3.98367 4.99324 3.92115 4.92871 3.91016L4.92773 3.90918C4.86021 3.89717 4.8078 3.84103 4.80371 3.77051C4.80082 3.70181 4.84485 3.63754 4.91211 3.61816L5.05273 3.58594C5.13785 3.57013 5.2338 3.55948 5.33105 3.55273C5.19851 3.45484 5.09492 3.42077 5.01465 3.4248C4.9088 3.43015 4.8122 3.50312 4.72168 3.6582C4.68532 3.71975 4.60975 3.74761 4.54199 3.72363C4.47359 3.69913 4.43227 3.62871 4.44434 3.55762L4.45508 3.47852C4.47146 3.30286 4.43342 3.17543 4.35742 3.08301C4.30518 3.01954 4.23002 2.96775 4.13184 2.92676ZM4.05469 4.06445C3.96918 4.0583 3.8997 4.06739 3.84375 4.08594C3.76957 4.11057 3.71354 4.15395 3.67188 4.21582C3.61999 4.29301 3.58854 4.40068 3.57617 4.53418C3.71602 4.33635 3.87725 4.17716 4.05469 4.06445Z"
                                                fill="#E92827" />
                                        </svg>
                                        <span>Palm Oil Free</span>
                                    </li>
                                    <li id="gelatine">
                                        <svg width="8" height="9" viewBox="0 0 8 9" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4 0.849609C6.20914 0.849609 8 2.64047 8 4.84961C8 7.05875 6.20914 8.84961 4 8.84961C1.79086 8.84961 0 7.05875 0 4.84961C1.61064e-08 2.64047 1.79086 0.849609 4 0.849609ZM5.20703 3.89941C5.33012 4.01893 5.4136 4.18836 5.43262 4.37988L5.43359 4.38086L5.55469 5.60254H5.90039C5.95776 5.6026 6.0095 5.63455 6.04004 5.68359L6.05859 5.72266C6.06774 5.7495 6.0711 5.77829 6.06836 5.80664L6.05957 5.84863L5.81055 6.61426C5.78754 6.68502 5.72556 6.73728 5.65137 6.7373H2.15137C2.14782 6.7373 2.14412 6.73559 2.14062 6.73535L1.5 7.37598C2.14236 8.01167 3.02487 8.40527 4 8.40527C5.96368 8.40527 7.55566 6.81329 7.55566 4.84961C7.55566 3.93336 7.20885 3.09819 6.63965 2.46777L5.20703 3.89941ZM4 1.29395C2.03632 1.29395 0.444336 2.88593 0.444336 4.84961C0.444336 5.67788 0.728258 6.43953 1.20312 7.04395L1.90332 6.34277L1.74316 5.84863C1.72543 5.79373 1.73251 5.73235 1.7627 5.68359L1.78906 5.65039C1.81918 5.6207 1.85918 5.60255 1.90234 5.60254H2.24805L2.36914 4.38086L2.37891 4.31055C2.44163 3.97128 2.70956 3.7168 3.03223 3.7168H3.52246C3.498 3.65772 3.48341 3.59235 3.4834 3.52344C3.48344 3.31975 3.60315 3.14304 3.77344 3.08203C3.87478 2.80916 4.06849 2.58321 4.35254 2.58301C4.45055 2.58305 4.52148 2.67081 4.52148 2.76758C4.52135 2.86424 4.45046 2.9521 4.35254 2.95215C4.25753 2.95233 4.18346 3.02235 4.12598 3.13281C4.24277 3.2161 4.3193 3.3608 4.31934 3.52344C4.31932 3.59232 4.30473 3.65774 4.28027 3.7168H4.7627L6.32129 2.15723C5.69835 1.61967 4.88737 1.29395 4 1.29395ZM2.27051 6.36816H5.53223L5.66113 5.97168H2.1416L2.27051 6.36816ZM2.58789 5.60254H3.05078V4.93066C2.95047 4.89757 2.87669 4.83784 2.81836 4.7793L2.75879 4.7168C2.73018 4.68546 2.70665 4.65967 2.68359 4.63965L2.58789 5.60254ZM3.67969 4.7168C3.61258 4.79029 3.52517 4.88537 3.3877 4.93066V5.60254H3.73242V4.66113L3.67969 4.7168ZM4.07031 5.60254H4.41406V4.93066C4.31372 4.89756 4.23998 4.83785 4.18164 4.7793L4.12207 4.7168C4.10307 4.69599 4.08622 4.67788 4.07031 4.66211V5.60254ZM5.11133 4.64648L5.04395 4.7168C4.97686 4.79028 4.8894 4.88529 4.75195 4.93066V5.60254H5.21484L5.11816 4.64062C5.11599 4.64251 5.11351 4.6445 5.11133 4.64648ZM3.03223 4.08594C2.91826 4.08594 2.81442 4.15303 2.75488 4.25977C2.86501 4.30944 2.93923 4.39164 2.99805 4.45605L3.05176 4.5127C3.06834 4.529 3.08487 4.54345 3.10156 4.55469C3.13281 4.57559 3.16814 4.5878 3.21875 4.58789C3.26967 4.58789 3.30555 4.57567 3.33691 4.55469C3.37038 4.53219 3.40063 4.49964 3.44043 4.45605L3.51758 4.37598C3.58914 4.30763 3.6823 4.24076 3.81641 4.2207L3.90137 4.21484L3.98633 4.2207C4.17385 4.24879 4.28057 4.36762 4.36133 4.45605L4.41602 4.5127C4.4326 4.529 4.44816 4.54345 4.46484 4.55469C4.49624 4.57576 4.53203 4.58786 4.58301 4.58789C4.63406 4.58788 4.66974 4.57578 4.70117 4.55469C4.73466 4.53218 4.76486 4.49968 4.80469 4.45605L4.85938 4.39844C4.90879 4.34821 4.96828 4.29534 5.04688 4.25977C4.98733 4.15324 4.88433 4.08596 4.77051 4.08594H3.03223ZM3.87109 3.43555C3.84379 3.44928 3.82133 3.48107 3.82129 3.52344C3.82134 3.58102 3.86218 3.61902 3.90137 3.61914C3.94053 3.61897 3.98139 3.58098 3.98145 3.52344C3.98141 3.48099 3.959 3.44925 3.93164 3.43555L3.90234 3.42773H3.89941L3.87109 3.43555Z"
                                                fill="#E92827" />
                                        </svg>
                                        <span>Gelatine-Free</span>
                                    </li>
                                    <li id="lectose">
                                        <svg width="8" height="9" viewBox="0 0 8 9" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4 0.849609C6.20914 0.849609 8 2.64047 8 4.84961C8 7.05875 6.20914 8.84961 4 8.84961C1.79086 8.84961 0 7.05875 0 4.84961C1.61064e-08 2.64047 1.79086 0.849609 4 0.849609ZM5.25488 3.85156C5.26245 3.86125 5.26946 3.87139 5.27734 3.88086L5.36426 3.99414C5.55295 4.26569 5.6543 4.58991 5.6543 4.92285V7.66797H2.3457V6.53027L1.5 7.37598C2.14236 8.01167 3.02487 8.40527 4 8.40527C5.96368 8.40527 7.55566 6.81329 7.55566 4.84961C7.55566 3.93336 7.20885 3.09819 6.63965 2.46777L5.25488 3.85156ZM2.79004 7.22363H5.20996V5.5791C4.60608 5.55879 4.26558 5.45743 3.93555 5.35742C3.62782 5.26417 3.32999 5.17291 2.79004 5.15332V7.22363ZM4 1.29395C2.03632 1.29395 0.444336 2.88593 0.444336 4.84961C0.444336 5.67788 0.728258 6.43953 1.20312 7.04395L2.3457 5.90137V4.92285L2.35156 4.78027C2.38048 4.45091 2.50956 4.13658 2.72266 3.88086L2.78516 3.79883C2.92218 3.60162 2.99694 3.36675 2.99707 3.125V1.75488H5.00391V3.125C5.00396 3.22999 5.01785 3.33369 5.04492 3.43359L6.32129 2.15723C5.69835 1.61967 4.88737 1.29395 4 1.29395ZM3.43652 3.24023C3.41569 3.53196 3.31708 3.81282 3.15039 4.05273L3.06445 4.16602C2.93345 4.32325 2.84799 4.51099 2.81152 4.70996C3.4014 4.73199 3.73762 4.8329 4.06348 4.93164C4.37131 5.02492 4.66964 5.11522 5.20996 5.13477V4.92285C5.20996 4.68091 5.13613 4.44539 4.99902 4.24805L4.93652 4.16602C4.71775 3.90347 4.58869 3.57919 4.56445 3.24023H3.43652ZM3.44141 2.19922V2.7959H4.55957V2.19922H3.44141Z"
                                                fill="#E92827" />
                                        </svg>
                                        <span>Lectose-Free</span>
                                    </li>
                                    <li id="gluten">
                                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <mask id="mask0_3537_34024" style="mask-type:luminance"
                                                maskUnits="userSpaceOnUse" x="0" y="0" width="8" height="8">
                                                <path d="M8 0H0V8H8V0Z" fill="white" />
                                            </mask>
                                            <g mask="url(#mask0_3537_34024)">
                                                <path
                                                    d="M3.99986 8C3.07448 7.99929 2.17797 7.67773 1.46308 7.09018C0.748177 6.50258 0.259129 5.68529 0.0792401 4.77756C-0.100647 3.86984 0.0397614 2.92782 0.476542 2.112C0.913324 1.29619 1.61945 0.657049 2.47463 0.30348C3.3298 -0.050088 4.2811 -0.0962111 5.16648 0.172969C6.05186 0.442149 6.81648 1.00998 7.33017 1.77972C7.84381 2.54945 8.0747 3.47347 7.98346 4.39435C7.89221 5.3152 7.48452 6.17596 6.82981 6.82996C6.45844 7.20178 6.01724 7.49653 5.53159 7.69729C5.0459 7.89809 4.52537 8.00098 3.99986 8ZM3.99986 0.453427C3.17916 0.453867 2.384 0.738862 1.74987 1.25985C1.11574 1.78084 0.681871 2.50558 0.522191 3.3106C0.362511 4.11562 0.486897 4.95111 0.87416 5.67467C1.26143 6.39827 1.8876 6.9652 2.646 7.27884C3.4044 7.59253 4.24808 7.63351 5.03332 7.39484C5.81857 7.15618 6.49675 6.65267 6.95235 5.97C7.40795 5.28738 7.61275 4.46791 7.53186 3.6512C7.45097 2.83449 7.08941 2.07109 6.50879 1.49108C6.17959 1.16133 5.78848 0.899898 5.3579 0.721818C4.92732 0.543742 4.46581 0.452529 3.99986 0.453427Z"
                                                    fill="#E92827" />
                                                <path
                                                    d="M4.13859 6.2382H3.67802C3.40037 6.23802 3.13413 6.12762 2.9378 5.93127C2.74146 5.73491 2.63107 5.46869 2.63086 5.19105V4.92154C2.63086 4.87087 2.65099 4.82225 2.68682 4.78642C2.72264 4.7506 2.77124 4.73047 2.8219 4.73047H3.08825C3.36591 4.73069 3.63214 4.84109 3.82848 5.0374C4.02481 5.23376 4.13521 5.49998 4.13541 5.77767L4.13859 6.2382ZM2.94953 5.04914V5.19185C2.94974 5.38518 3.02664 5.57056 3.16336 5.70731C3.30009 5.84402 3.48546 5.92091 3.67882 5.92114H3.8215V5.77842C3.8213 5.58509 3.74439 5.39971 3.60767 5.263C3.47095 5.12625 3.28557 5.04936 3.09222 5.04914H2.94953Z"
                                                    fill="#E92827" />
                                                <path
                                                    d="M4.13859 5.12901H3.67802C3.4003 5.12901 3.13395 5.0187 2.93757 4.8223C2.74118 4.6259 2.63086 4.35956 2.63086 4.08184V3.81311C2.63086 3.76244 2.65099 3.71385 2.68682 3.67803C2.72264 3.6422 2.77124 3.62207 2.8219 3.62207H3.08825C3.36597 3.62207 3.63233 3.73239 3.82871 3.92878C4.02509 4.12516 4.13541 4.39151 4.13541 4.66923L4.13859 5.12901ZM2.94953 3.93995V4.08184C2.94973 4.27527 3.02661 4.46074 3.16332 4.59759C3.30001 4.73443 3.48539 4.8115 3.67882 4.81194H3.8215V4.66923C3.8213 4.4759 3.74439 4.2905 3.60767 4.15378C3.47095 4.01706 3.28557 3.94015 3.09222 3.93995H2.94953Z"
                                                    fill="#E92827" />
                                                <path
                                                    d="M4.13859 4.0214H3.67802C3.40037 4.02119 3.13413 3.9108 2.9378 3.71446C2.74146 3.51813 2.63107 3.25189 2.63086 2.97424V2.70472C2.63086 2.65405 2.65099 2.60545 2.68682 2.56963C2.72264 2.5338 2.77124 2.51367 2.8219 2.51367H3.08825C3.36591 2.51388 3.63214 2.62428 3.82848 2.82061C4.02481 3.01695 4.13521 3.28318 4.13541 3.56084L4.13859 4.0214ZM2.94953 2.83234V2.97503C2.94974 3.16838 3.02664 3.35376 3.16336 3.49049C3.30009 3.62721 3.48546 3.70411 3.67882 3.70432H3.8215V3.56163C3.8213 3.36828 3.74439 3.1829 3.60767 3.04618C3.47095 2.90945 3.28557 2.83255 3.09222 2.83234H2.94953Z"
                                                    fill="#E92827" />
                                                <path
                                                    d="M4.27794 6.2382H3.81738V5.77767C3.81738 5.49994 3.92771 5.23358 4.12409 5.03718C4.32048 4.84083 4.58683 4.73047 4.86457 4.73047H5.13328C5.15839 4.73038 5.18328 4.73527 5.20652 4.74483C5.22972 4.75438 5.25083 4.76843 5.26861 4.7862C5.28634 4.80398 5.30043 4.82509 5.30999 4.84829C5.31954 4.87154 5.32443 4.89643 5.32434 4.92154V5.19105C5.32434 5.46865 5.21412 5.73487 5.0179 5.93123C4.82168 6.12758 4.55554 6.23803 4.27794 6.2382ZM4.13526 5.92114H4.27794C4.47132 5.92091 4.6567 5.84403 4.79341 5.70731C4.93012 5.57056 5.00701 5.38518 5.00723 5.19185V5.04914H4.86457C4.67119 5.04936 4.48581 5.12625 4.3491 5.263C4.21237 5.39971 4.13547 5.58509 4.13526 5.77843V5.92114Z"
                                                    fill="#E92827" />
                                                <path
                                                    d="M4.27794 5.12901H3.81738V4.66923C3.81728 4.53168 3.84429 4.39548 3.89689 4.26838C3.94947 4.14129 4.0266 4.02581 4.12386 3.92855C4.22112 3.83129 4.33661 3.75416 4.46368 3.70157C4.59079 3.64898 4.72701 3.62197 4.86457 3.62207H5.13328C5.15839 3.62197 5.18328 3.62684 5.20652 3.6364C5.22972 3.64597 5.25083 3.66003 5.26861 3.6778C5.28634 3.69556 5.30043 3.71665 5.30999 3.73988C5.31954 3.76311 5.32443 3.788 5.32434 3.81312V4.08185C5.32443 4.21932 5.29745 4.35547 5.24492 4.48252C5.19234 4.60954 5.11532 4.72501 5.01812 4.82225C4.92097 4.9195 4.80554 4.99665 4.67857 5.04928C4.55154 5.1019 4.41541 5.12901 4.27794 5.12901ZM4.13526 4.81194H4.27794C4.47137 4.8115 4.65674 4.73443 4.79345 4.59759C4.93017 4.46074 5.00701 4.27527 5.00723 4.08185V3.93995H4.86457C4.67119 3.94016 4.48581 4.01706 4.3491 4.15378C4.21237 4.29051 4.13547 4.4759 4.13526 4.66923V4.81194Z"
                                                    fill="#E92827" />
                                                <path
                                                    d="M4.27794 4.0214H3.81738V3.56084C3.81738 3.28311 3.92771 3.01677 4.12409 2.82038C4.32048 2.624 4.58683 2.51367 4.86457 2.51367H5.16261C5.18377 2.51367 5.2047 2.51789 5.22421 2.52611C5.24372 2.53432 5.26136 2.54636 5.27612 2.5615C5.29092 2.57665 5.30252 2.5946 5.31025 2.61429C5.31799 2.63398 5.32168 2.65503 5.32114 2.67618V2.97424C5.32114 3.25128 5.21136 3.51703 5.01585 3.7133C4.8203 3.90957 4.55496 4.02035 4.27794 4.0214ZM4.13526 3.70432H4.27794C4.47132 3.70411 4.6567 3.62721 4.79341 3.49049C4.93012 3.35376 5.00701 3.16838 5.00723 2.97503V2.83234H4.86457C4.67119 2.83255 4.48581 2.90945 4.3491 3.04618C4.21237 3.1829 4.13547 3.36828 4.13526 3.56163V3.70432Z"
                                                    fill="#E92827" />
                                                <path
                                                    d="M3.97816 3.34853L3.64284 3.01242C3.54091 2.9106 3.46004 2.78969 3.40486 2.65659C3.34969 2.5235 3.32129 2.38084 3.32129 2.23676C3.32129 2.09268 3.34969 1.95002 3.40486 1.81692C3.46004 1.68383 3.54091 1.56291 3.64284 1.4611L3.87115 1.23279C3.88544 1.21844 3.90242 1.20705 3.92112 1.19927C3.93983 1.1915 3.95988 1.1875 3.98014 1.1875C4.0004 1.1875 4.02045 1.1915 4.03916 1.19927C4.05786 1.20705 4.07485 1.21844 4.08914 1.23279L4.31742 1.4611C4.52293 1.66694 4.63835 1.9459 4.63835 2.23676C4.63835 2.52761 4.52293 2.80658 4.31742 3.01242L3.97816 3.34853ZM3.97816 1.57207L3.8656 1.68464C3.71984 1.83111 3.63802 2.02933 3.63802 2.23597C3.63802 2.4426 3.71984 2.64082 3.8656 2.7873L3.97816 2.89986L4.09152 2.7873C4.23728 2.64082 4.31911 2.4426 4.31911 2.23597C4.31911 2.02933 4.23728 1.83111 4.09152 1.68464L3.97816 1.57207Z"
                                                    fill="#E92827" />
                                                <path
                                                    d="M3.98374 6.90699C3.94169 6.90699 3.90136 6.89027 3.87163 6.86054C3.8419 6.83081 3.8252 6.7905 3.8252 6.74845V3.12338C3.8252 3.08134 3.8419 3.04101 3.87163 3.01128C3.90136 2.98155 3.94169 2.96484 3.98374 2.96484C4.02579 2.96484 4.06611 2.98155 4.09584 3.01128C4.12558 3.04101 4.14228 3.08134 4.14228 3.12338V6.74765C4.14238 6.76854 4.13836 6.78921 4.13044 6.80854C4.12252 6.82787 4.11086 6.84547 4.09612 6.86027C4.08139 6.87507 4.06388 6.88681 4.04459 6.89485C4.02531 6.90285 4.00463 6.90699 3.98374 6.90699Z"
                                                    fill="#E92827" />
                                                <path
                                                    d="M2.71358 5.40559C2.68033 5.31106 2.66058 5.2123 2.65493 5.1123L1.21378 6.55422C1.19095 6.57715 1.17542 6.60635 1.16914 6.63808C1.16286 6.66986 1.1661 6.70275 1.17847 6.73266C1.19084 6.76257 1.21178 6.78817 1.23866 6.80622C1.26554 6.82426 1.29715 6.83395 1.32952 6.83404C1.37318 6.83377 1.41501 6.81639 1.44605 6.78568L2.74371 5.48804C2.7334 5.4603 2.7231 5.43333 2.71358 5.40559Z"
                                                    fill="#E92827" />
                                                <path
                                                    d="M6.78493 1.21516C6.76969 1.19989 6.7516 1.18777 6.73169 1.17951C6.71173 1.17125 6.6904 1.16699 6.6688 1.16699C6.64724 1.16699 6.62587 1.17125 6.60595 1.17951C6.586 1.18777 6.56791 1.19989 6.55267 1.21516L5.17969 2.58892C5.26929 2.66343 5.28831 2.80849 5.29622 2.91551C5.29582 2.92211 5.29582 2.92873 5.29622 2.93533L6.78413 1.44742C6.79947 1.43223 6.81164 1.41417 6.81995 1.39427C6.82831 1.37437 6.83262 1.35302 6.83271 1.33145C6.8328 1.30988 6.82862 1.2885 6.8204 1.26855C6.81222 1.24859 6.80018 1.23045 6.78493 1.21516Z"
                                                    fill="#E92827" />
                                            </g>
                                        </svg>

                                        <span>Gluten Free</span>

                                    </li>
                                </ul>


                                {{-- <img id="product_image" src="" alt="Product Image" class="product_image"> --}}


                                <div class="qr_code Qr_code">
                                    <div id="qrcode"></div>
                                </div>
                                <div style="font-size: 8px; font-family: 'DM Sans', sans-serif; "><span
                                        id="article_number" class="product_name"></span></div>


                            </div>
                            <div class="right_side">
                                <div class="contnet">
                                    <h2 class="ingredient-title"
                                        style="font-family: 'DM Sans', sans-serif; font-size: 8px; margin-bottom: 8px;">
                                        <b>Ingredients</b>
                                    </h2>
                                    <p style=" font-family: 'Noto Kufi Arabic', sans-serif; color: #000; "
                                        id="ingredients_ar" class="ingrediants"></p>
                                </div>

                                <div class="bar_code" style="">
                                    <svg id="barcode"></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="downloadLabelBtn">Download Label</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Size Selection Modal -->
    <div class="modal fade" id="sizeSelectionModalmultiple" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Size</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <form id="sizeSelectionForm">
                        <div class="form-group">
                            <label>Select Size</label>
                            <select class="form-control" id="sizeSelectmultiple" name="size">
                                <option value="">Select a size</option>
                                <option value="MOE (100mm x 400mm)">MOE (100mm x 400mm)</option>
                                <option value="DFC (100mm x 600mm)">DFC (100mm x 700mm)</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="proceedToMultipleLabelBtn">Proceed</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Multiple Label Generation Modal -->
    <div class="modal fade" id="multiplelabelGenerationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span id="heading_label_multi"></span> Labels</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body" id="labelsContainer">
                    <!-- Labels will be dynamically added here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="downloadMultipleLabelBtn">Download Labels</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            function loadTable(category = '', format = '', status = '') {
                $('#productTable').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: {
                        url: "{{ route('admins.products.data') }}",
                        data: function(d) {
                            d.category = $('#categoryFilter').val();
                            d.format = $('#formatFilter').val();
                            d.status = $('#statusFilter').val();
                            d.search = $('#searchInput').val();
                            d.article_numbers = $('#articleNumberInput').val();
                        }
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return '<input type="checkbox" class="product-checkbox" value="' +
                                    data + '">';
                            }
                        },
                        {
                            data: 'image',
                            name: 'image',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'product_name',
                            name: 'product_name',
                            orderable: true
                        },
                        {
                            data: 'sort_order',
                            name: 'sort_order',
                            orderable: true
                        },
                        {
                            data: 'category',
                            name: 'category',
                            orderable: false
                        }, // Computed, cannot sort
                        {
                            data: 'format',
                            name: 'format',
                            orderable: false
                        }, // Computed, cannot sort
                        {
                            data: 'price',
                            name: 'discount_price',
                            orderable: true
                        },
                        {
                            data: 'quantity',
                            name: 'product_quantity',
                            orderable: true
                        },
                        {
                            data: 'visits',
                            name: 'view',
                            orderable: true
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'trending_products',
                            name: 'is_trending',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    order: [
                        [1, 'asc']
                    ], // Default sorting on product_name
                });

            }

            // Initial Load
            loadTable();

            // Filter Button Click
            $('#filterBtn').click(function() {
                let category = $('#categoryFilter').val();
                let format = $('#formatFilter').val();
                let status = $('#statusFilter').val();
                let search = $('#searchInput').val();
                loadTable(category, format, status);
            });

            $('#selectAll').on('change', function() {
                $('.product-checkbox').prop('checked', $(this).prop('checked'));
            });
        });
    </script>
    <script>
        function updateStatus(status, product_id) {
            if (product_id > 0) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    url: "{{ route('admins.update_product_status') }}",
                    type: "POST",
                    data: {
                        product_id: product_id,
                        Status: status,
                    },
                    success: function(response) {
                        showToastr(response.msg, response.msg_type);
                    }
                });
            }
        }

        function updateTrendingStatus(status, product_id) {
            if (product_id > 0) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    url: "{{ route('admins.update_trending_product') }}",
                    type: "POST",
                    data: {
                        product_id: product_id,
                        is_trending: status,
                    },
                    success: function(response) {
                        showToastr(response.msg, response.msg_type);
                    }
                });
            }
        }

        $(document).ready(function() {
            $(document).on("change", ".sort-order-input", function() {
                var productId = $(this).data("id");
                var sortOrder = $(this).val();

                $.ajax({
                    url: "{{ route('admins.update_sort_order') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: productId,
                        sort_order: sortOrder
                    },
                    success: function(response) {
                        if (response.success) {
                            alert("Sort order updated successfully!");
                        } else {
                            alert("Failed to update sort order.");
                        }
                    },
                    error: function() {
                        alert("An error occurred.");
                    }
                });
            });
        });
    </script>

    <!-- Export modal script -->
    <script>
        $(document).ready(function() {
            // Initialize Select2 for product, category, and column selects
            try {
                $('#productSelect').select2({
                    placeholder: "Select products to export",
                    allowClear: true,
                    width: '100%'
                });

                $('#categorySelect').select2({
                    placeholder: "Select categories to export",
                    allowClear: true,
                    width: '100%'
                });

                $('#columnSelect').select2({
                    placeholder: "Select columns to export",
                    allowClear: true,
                    width: '100%'
                });
            } catch (e) {
                console.error('Select2 initialization error:', e);
            }

            // Toggle product/category selection based on export type
            $('#exportType').on('change', function() {
                const exportType = $(this).val();
                if (exportType === 'products') {
                    $('#productSelection').show();
                    $('#categorySelection').hide();
                    $('#categorySelect').val(null).trigger('change'); // Clear category selection
                } else {
                    $('#categorySelection').show();
                    $('#productSelection').hide();
                    $('#productSelect').val(null).trigger('change'); // Clear product selection
                }
            });

            // Ensure Select2 reinitializes when modal is shown
            $('#exportModal').on('shown.bs.modal', function() {
                $('#productSelect').select2({
                    placeholder: "Select products to export",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#exportModal')
                });

                $('#categorySelect').select2({
                    placeholder: "Select categories to export",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#exportModal')
                });

                $('#columnSelect').select2({
                    placeholder: "Select columns to export",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#exportModal')
                });
            });

            // Extract button click handler
            $('#extractBtn').click(function() {
                const exportType = $('#exportType').val();
                let productIds = $('#productSelect').val();
                let categoryIds = $('#categorySelect').val();
                let columns = $('#columnSelect').val();

                // Validation
                if (exportType === 'products' && (!productIds || productIds.length === 0)) {
                    showToastr('Please select at least one product', 'error');
                    return;
                }
                if (exportType === 'categories' && (!categoryIds || categoryIds.length === 0)) {
                    showToastr('Please select at least one category', 'error');
                    return;
                }
                if (!columns || columns.length === 0) {
                    showToastr('Please select at least one column', 'error');
                    return;
                }

                $.ajax({
                    url: $('#extractExcelForm').attr('action'),
                    type: 'POST',
                    data: $('#extractExcelForm').serialize(),
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.download_url;
                            $('#exportModal').modal('hide');
                            showToastr('Excel file generated successfully', 'success');
                        } else {
                            showToastr('Error generating Excel file: ' + response.message,
                                'error');
                        }
                    },
                    error: function(xhr) {
                        console.error('Export error:', xhr);
                        showToastr('An error occurred while generating the file', 'error');
                    }
                });
            });
        });
    </script>

    <!-- Include QR code and Barcode libraries -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.0/build/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
    <script>
        $(document).ready(function() {
            console.log('QRCode available:', typeof window.QRCode);
            console.log('QRCode details:', window.QRCode);
            // Handle click on the plus button
            $(document).on('click', '#genrate_label', function() {
                var productId = $(this).data('id');

                // Store product ID for later use
                $('#labelProductId').val(productId);

                // Clear previous size selection
                $('#sizeSelect').val('');

                // Show the size selection modal
                $('#sizeSelectionModal').modal('show');
            });

            // Handle proceed button in size selection modal
            $('#proceedToLabelBtn').click(function() {
                var selectedSize = $('#sizeSelect').val();
                var productId = $('#labelProductId').val();
                if (!selectedSize) {
                    showToastr('Please select a size', 'error');
                    return;
                }
                $('#heading_label').html(selectedSize);

                // Apply size-based styling
                if (selectedSize === 'MOE (100mm x 400mm)') {
                    $('#label_id').removeClass('medium_label_banner').addClass('small_label_banner');
                } else {
                    $('#label_id').removeClass('small_label_banner').addClass('medium_label_banner');
                }

                // Fetch product details via AJAX
                $.ajax({
                    url: "{{ route('admins.get_product_details', '') }}/" + productId,
                    type: 'GET',
                    data: {
                        product_id: productId
                    },
                    success: function(response) {
                        if (response.success) {
                            // Populate label content
                            // $('#product_image').attr('src', response.product.image_one);
                            $('#product_name_en').text(response.product.product_name);
                            // $('#product_name_ar').text(response.product.name_ar || response
                            // .product.product_name);
                            $('#article_number').text(response
                                .product.article_number ||
                                response
                                .product.article_number);
                            $('#ingredients_en').text(response.product.ingredient);
                            $('#ingredients_ar').text(response.product.ingredients_ar ||
                                response.product.ingredient || '');

                            $('#vegan').css('display', response.product.vegan === '1' ? 'flex' :
                                'none');
                            $('#gelatin').css('display', response.product.gelatin_free === '1' ?
                                'flex' : 'none');
                            $('#lectose').css('display', response.product.lactose_free === '1' ?
                                'flex' : 'none');
                            $('#gluten').css('display', response.product.gluten_free === '1' ?
                                'flex' : 'none');
                            $('#palm').css('display', response.product.palm_oil === '1' ?
                                'flex' : 'none');

                            // Display server-side QR code
                            $(`#qrcode`).empty();

                            if (response.product.qr_code) {
                                $(`#qrcode`).html(response.product.qr_code); // inject raw SVG
                            } else {
                                $(`#qrcode`).html('');
                            }

                            // Generate barcode for item_no
                            // if (response.product.sku_no) {
                            //     JsBarcode("#barcode", response.product.sku_no, {
                            //         format: "CODE128",
                            //         width: 2,
                            //         height: 40,
                            //         displayValue: true
                            //     });
                            // } else {
                            //     $('#barcode').replaceWith('');
                            // }

                            // Show label generation modal
                            $('#sizeSelectionModal').modal('hide');
                            $('#labelGenerationModal').modal('show');
                        } else {
                            showToastr('Error fetching product details: ' + response.message,
                                'error');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching product details:', xhr);
                        showToastr('An error occurred while fetching product details', 'error');
                    }
                });
            });

            $('#downloadLabelBtn').click(async function() {
                const $button = $(this);
                $button.prop('disabled', true).text('Generating PDF...');

                try {
                    const {
                        jsPDF
                    } = window.jspdf;
                    const pdf = new jsPDF({
                        orientation: 'portrait',
                        unit: 'mm',
                        format: 'a4',
                        compress: false // Disable compression for high quality
                    });

                    const label = document.querySelector('#label_id');
                    if (!label) {
                        throw new Error('Label element #label_id not found');
                    }

                    // Get label dimensions based on sizeSelectmultiple
                    const selectedSize = $('#sizeSelect').val();
                    let width, height;

                    if (selectedSize === 'MOE (100mm x 400mm)') {
                        width = 377.95275590551176; // in pixels
                        height = 151.1811023622047; // in pixels
                    } else {
                        width = 283.4646; // in pixels
                        height = 198.4252; // in pixels
                    }

                    // Apply dimensions to the label element
                    $(label).css({
                        width: `${width}px`,
                        height: `${height}px`,
                        'box-sizing': 'border-box',
                        overflow: 'hidden' // Prevent content from spilling out
                    });

                    // Log the dimensions of the label
                    console.log(`Label #label_id dimensions: Width = ${width}px, Height = ${height}px`);

                    // Wait for fonts and images to load
                    await document.fonts.ready;
                    const images = label.querySelectorAll('img');
                    await Promise.all(Array.from(images).map(img => img.complete ? Promise.resolve() :
                        new Promise(resolve => img.onload = resolve)));

                    // Render with high scale
                    const canvas = await html2canvas(label, {
                        scale: 5, // High resolution
                        useCORS: true, // Handle cross-origin images
                        backgroundColor: '#ffffff', // Avoid transparency
                        logging: true, // Enable for debugging
                        width: width, // Use exact width
                        height: height, // Use exact height
                        windowWidth: width, // Match viewport to label
                        windowHeight: height
                    });

                    // Log canvas dimensions for verification
                    console.log(
                        `Label #label_id canvas dimensions: Width = ${canvas.width}px, Height = ${canvas.height}px`
                    );

                    const imgData = canvas.toDataURL('image/png', 1.0); // Maximum PNG quality

                    // Convert pixel dimensions to mm (96 DPI)
                    const pixelsToMm = 25.4 / 96; // 1 inch = 25.4 mm, 96 pixels = 1 inch
                    const pdfWidth = width * pixelsToMm;
                    const pdfHeight = height * pixelsToMm;

                    const a4Width = 210; // A4 width in mm
                    const a4Height = 297; // A4 height in mm
                    const margin = 10; // 10mm margins

                    // Center the label horizontally
                    const xOffset = (a4Width - pdfWidth) / 2;

                    // Check if image fits within A4 height
                    if (pdfHeight > a4Height - 2 * margin) {
                        console.warn('Label height exceeds A4, scaling down');
                        const scaleFactor = (a4Height - 2 * margin) / pdfHeight;
                        const scaledWidth = pdfWidth * scaleFactor;
                        const scaledHeight = pdfHeight * scaleFactor;
                        const scaledXOffset = (a4Width - scaledWidth) /
                            2; // Recalculate for scaled image
                        pdf.addImage(imgData, 'PNG', scaledXOffset, margin, scaledWidth, scaledHeight,
                            undefined, 'NONE');
                    } else {
                        pdf.addImage(imgData, 'PNG', xOffset, margin, pdfWidth, pdfHeight, undefined,
                            'NONE');
                    }

                    const productId = $('#labelProductId').val();
                    pdf.save(`label_product_${productId}.pdf`);
                } catch (error) {
                    console.error('PDF generation error:', error);
                    showToastr('Failed to generate PDF. Check console for details.', 'error');
                } finally {
                    $button.prop('disabled', false).text('Download Label');
                }
            });
        });


        $(document).ready(function() {
            // Handle click on the Generate Multiple Labels button
            $('#generateMultipleLabelsBtn').click(function() {
                var selectedProducts = [];
                $('.product-checkbox:checked').each(function() {
                    selectedProducts.push($(this).val());
                });

                if (selectedProducts.length === 0) {
                    alert('Please select at least one product to generate labels');
                    return;
                }

                // Store selected product IDs
                $('#sizeSelectionModalmultiple').data('productIds', selectedProducts);

                // Clear previous size selection
                $('#sizeSelectmultiple').val('');

                // Show the size selection modal
                $('#sizeSelectionModalmultiple').modal('show');
            });

            // Handle proceed button in size selection modal
            $('#proceedToMultipleLabelBtn').click(function() {
                var sizeSelectmultiple = $('#sizeSelectmultiple').val();
                var productIds = $('#sizeSelectionModalmultiple').data('productIds');
                // Clear previous labels
                $('#labelsContainer').empty();
                $('#heading_label_multi').html(sizeSelectmultiple);

                // Apply size-based styling
                if (sizeSelectmultiple === 'MOE (100mm x 400mm)') {
                    $('#label_id').removeClass('medium_label_banner').addClass('small_label_banner');
                } else {
                    $('#label_id').removeClass('small_label_banner').addClass('medium_label_banner');
                }

                // Fetch product details for all selected products via AJAX
                $.ajax({
                    url: "{{ route('admins.get_multiple_product_details') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_ids: productIds
                    },
                    success: function(response) {
                        if (response.success) {
                            response.products.forEach(function(product, index) {
                                // Create a new label container for each product
                                var labelHtml = `
                                                            <div class="form-group">
                                                                <div class="label_banner ${sizeSelectmultiple === 'MOE (100mm x 400mm)' ? 'small_label_banner' : 'medium_label_banner'}" id="label_${index}">
                                                                    <div class="left_side">
                                                                        <div class="logo" id="logo_image_${index}">
                                                                            <svg viewBox="0 0 212 92" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                <path d="M83.1485 65.7289C83.4418 64.7772 83.7462 63.832 84.0257 62.8739C84.2996 61.9352 84.5403 60.9836 84.817 60.045C84.889 59.7973 85.0246 59.5659 85.1657 59.3605C85.6472 58.6631 85.9183 58.5523 86.4026 58.8C86.9366 59.0737 87.1967 59.6669 87.039 60.4198C86.8757 61.1987 86.6682 61.9646 86.4496 62.724C85.9598 64.4285 85.4618 66.1265 84.9499 67.8212C84.7423 68.5056 84.5127 69.1835 84.2498 69.8386C83.8624 70.8033 82.5896 70.95 82.0721 70.0341C81.7041 69.3791 81.4827 68.6034 81.2337 67.8636C80.8325 66.6675 80.4617 65.4583 80.0024 64.0178C79.8031 64.4578 79.7035 64.6305 79.6454 64.8228C79.2386 66.1558 78.8457 67.4953 78.4362 68.8283C78.3255 69.1868 78.1899 69.542 78.0322 69.8745C77.4982 70.9891 76.6072 71.0934 75.9182 70.1091C75.7134 69.819 75.5335 69.4801 75.4229 69.1249C74.6149 66.5013 73.8263 63.8712 73.0459 61.2378C72.9629 60.9575 72.9463 60.6349 72.9436 60.335C72.9353 59.4029 73.1732 59.002 73.7654 58.8814C74.4267 58.7478 74.8445 59.0509 75.0936 59.8722C75.5584 61.4236 76.0122 62.9814 76.4771 64.536C76.5823 64.888 76.7151 65.2302 76.9198 65.8234C77.1716 65.1781 77.3653 64.7642 77.4982 64.3307C77.8551 63.1802 78.165 62.0102 78.5358 60.8663C78.7074 60.335 78.926 59.8038 79.2054 59.3475C79.7063 58.5295 80.3676 58.5099 80.9487 59.4551C81.1894 59.8461 81.2918 60.3611 81.4329 60.8304C81.9172 62.4469 82.3931 64.0634 82.8718 65.6832C82.9659 65.6963 83.06 65.7126 83.154 65.7256L83.1485 65.7289Z" fill="#E92827"/>
                                                                                <path d="M180.707 65.9539C180.76 65.3151 180.804 64.9175 180.821 64.5134C180.884 62.9425 180.909 61.3716 181.009 59.804C181.07 58.8393 181.579 58.3993 182.154 58.7578C182.583 59.025 182.976 59.4064 182.971 60.0843C182.971 60.4297 182.973 60.7785 182.973 61.1239C182.973 63.4737 182.973 65.8203 182.973 68.1701C182.973 68.5156 182.987 68.8708 182.924 69.2033C182.805 69.8323 182.724 70.6047 182.091 70.7514C181.441 70.9045 180.821 70.6666 180.372 69.9789C179.6 68.7959 178.798 67.6389 178.018 66.4656C177.539 65.7421 177.08 65.0023 176.598 64.2787C176.512 64.1484 176.363 64.0767 176.131 63.8811C176.111 64.2918 176.097 64.546 176.086 64.8002C176.025 66.2147 175.995 67.6356 175.893 69.0468C175.862 69.4836 175.699 69.9366 175.505 70.3179C175.32 70.6894 174.996 70.9404 174.586 70.7514C174.249 70.5949 173.942 70.4189 173.925 69.8747C173.906 69.1902 173.773 68.5058 173.767 67.8214C173.748 65.3966 173.776 62.9718 173.751 60.5438C173.743 59.817 173.878 59.2923 174.484 58.9631C175.096 58.6307 175.608 58.8654 176.003 59.3314C176.601 60.0321 177.129 60.8176 177.65 61.5998C178.513 62.8936 179.343 64.2168 180.195 65.5205C180.267 65.6313 180.397 65.6932 180.71 65.9474L180.707 65.9539Z" fill="#E92827"/>
                                                                                <path d="M186.293 64.7323C186.293 63.269 186.285 61.8056 186.296 60.3423C186.301 59.5112 186.525 59.1592 187.195 58.9213C188.249 58.5498 189.329 58.6247 190.402 58.729C190.917 58.7779 191.42 58.9572 191.935 59.0386C194.467 59.4297 196.21 62.6172 195.842 65.5015C195.491 68.2717 194.165 70.4521 191.138 70.6053C190.225 70.6509 189.306 70.6183 188.39 70.6085C188.13 70.6085 187.865 70.5987 187.613 70.5336C186.296 70.1881 186.29 70.1718 186.29 68.552C186.29 67.281 186.29 66.0099 186.29 64.7388L186.293 64.7323ZM188.449 67.9458C189.71 68.6172 190.92 68.3728 192.007 67.8057C193.059 67.2581 193.593 66.0588 193.504 64.69C193.404 63.1614 192.71 62.0077 191.443 61.5058C190.9 61.2907 190.297 61.232 189.719 61.2157C188.794 61.1897 188.482 61.5417 188.46 62.653C188.424 64.3836 188.451 66.1142 188.451 67.9458H188.449Z" fill="#E92827"/>
                                                                                <path d="M101.121 65.0412C101.201 63.4735 101.273 61.9026 101.37 60.3383C101.431 59.3736 101.661 59.0379 102.449 58.8521C102.986 58.725 103.551 58.637 104.09 58.6859C105.155 58.7804 106.224 58.9206 107.272 59.1585C108.905 59.5267 109.799 60.9151 110.399 62.6066C111.06 64.4741 110.847 66.3155 110.053 68.0396C109.597 69.0369 108.836 69.7767 107.917 70.1319C107.22 70.3992 106.464 70.5393 105.728 70.5914C104.655 70.6664 103.573 70.6175 102.496 70.6077C101.722 70.6012 101.511 70.4155 101.376 69.5257C101.279 68.8902 101.223 68.2384 101.201 67.5898C101.174 66.7457 101.193 65.8983 101.193 65.0509C101.168 65.0509 101.146 65.0477 101.121 65.0444V65.0412ZM103.681 68.3785C104.547 68.2644 105.216 68.1569 105.889 68.095C107.931 67.9059 108.791 66.058 108.338 63.832C108.169 63.0075 107.823 62.1373 107.026 61.7821C106.265 61.4431 105.51 61.1139 104.663 61.1856C103.755 61.2606 103.689 61.2899 103.681 62.4143C103.672 63.9559 103.681 65.4942 103.681 67.0357C103.681 67.4138 103.681 67.7886 103.681 68.3753V68.3785Z" fill="#E92827"/>
                                                                                <path d="M168.023 67.5443H163.523C163.366 68.4275 163.247 69.2488 163.061 70.0538C162.965 70.4677 162.71 70.8393 162.287 70.7969C161.847 70.7545 161.465 70.5492 161.365 69.9463C161.335 69.7573 161.243 69.578 161.243 69.3922C161.235 67.1988 161.094 64.9859 161.288 62.8153C161.443 61.0815 162.312 59.7843 163.817 59.0348C165.488 58.2004 167.004 58.4677 168.488 59.4226C169.547 60.1037 170.159 61.2607 170.253 62.6784C170.369 64.396 170.408 66.1266 170.427 67.8507C170.436 68.5709 170.342 69.301 170.247 70.018C170.17 70.6144 169.611 70.9175 169.132 70.6796C168.67 70.4514 168.402 70.0375 168.305 69.477C168.2 68.8805 168.125 68.2743 168.017 67.5443H168.023ZM168.028 64.9892C168.142 64.1776 168.216 63.5095 167.995 62.8447C167.655 61.8278 166.398 60.8794 165.626 61.0489C164.295 61.3389 163.416 62.4699 163.382 63.9234C163.366 64.6991 163.537 64.9598 164.232 64.9794C165.463 65.012 166.697 64.9892 168.028 64.9892Z" fill="#E92827"/>
                                                                                <path d="M125.553 67.4299C125.327 66.1198 124.377 66.1947 123.575 66.022C122.654 65.8232 121.71 65.745 120.8 65.4973C119.601 65.1714 119.084 64.0698 119.184 62.8737C119.214 62.4924 119.175 62.1013 119.211 61.7199C119.341 60.4261 120.097 59.6797 121.007 59.1974C122.797 58.2523 124.615 58.2946 126.361 59.3799C126.976 59.7612 127.474 60.3185 127.358 61.3028C127.272 62.0068 126.871 62.3946 126.276 62.1762C125.719 61.9709 125.177 61.7004 124.643 61.4201C123.763 60.9573 122.9 60.8204 122.034 61.4592C121.666 61.7297 121.433 62.0687 121.533 62.5967C121.627 63.0953 121.987 63.2354 122.346 63.2908C123.376 63.4505 124.411 63.5516 125.44 63.7276C127.095 64.0111 127.739 64.9563 127.867 66.7586C127.983 68.4044 127.172 69.871 125.908 70.3599C123.879 71.1453 121.882 71.0638 119.942 69.9101C119.483 69.6363 119.233 69.2355 119.167 68.6749C119.103 68.1371 119.101 67.5635 119.538 67.2213C119.934 66.9117 120.385 67.0193 120.733 67.3452C121.821 68.3653 123.085 68.3588 124.369 68.3001C124.898 68.274 125.304 68.0198 125.553 67.4267V67.4299Z" fill="#E92827"/>
                                                                                <path d="M69.2701 62.4442C68.3625 61.9879 67.5462 61.4893 66.6856 61.1731C65.5373 60.7495 64.7293 61.2351 64.1261 62.5713C64.4028 63.0928 64.8206 63.2688 65.3436 63.3242C66.3453 63.4252 67.3414 63.5719 68.3376 63.7381C68.653 63.7902 68.9657 63.9304 69.259 64.0868C71.1904 65.133 70.9829 68.9168 69.3392 69.9206C68.4925 70.4388 67.6126 70.7778 66.6469 70.8299C65.4294 70.8951 64.2451 70.755 63.1189 70.1781C62.4465 69.8326 61.8239 69.4252 61.7879 68.4051C61.7492 67.3264 62.3496 66.7951 63.1631 67.271C64.1344 67.8348 65.1388 68.1998 66.2069 68.4279C66.8129 68.5583 67.3082 68.3465 67.7869 68.0825C68.4372 67.7272 68.451 66.8538 67.8118 66.4823C67.3608 66.2215 66.8295 66.1368 66.3259 66.0227C65.3436 65.8044 64.3364 65.7001 63.3707 65.41C62.3967 65.1167 61.9816 64.3964 61.9761 63.2199C61.9733 62.5778 61.9844 61.9064 62.1283 61.2937C62.5682 59.4491 63.8964 58.9667 65.2744 58.6864C66.4809 58.442 67.6652 58.6343 68.7913 59.2372C68.9684 59.3317 69.1677 59.3839 69.3199 59.5143C70.5567 60.5539 70.5457 61.2742 69.2728 62.4475L69.2701 62.4442Z" fill="#E92827"/>
                                                                                <path d="M92.0696 61.1996V63.2528C93.11 63.3408 94.1365 63.4158 95.1576 63.52C95.6418 63.5689 96.1261 63.6308 96.5992 63.758C97.0586 63.8818 97.3325 64.2599 97.3131 64.84C97.2965 65.306 96.8455 65.7623 96.353 65.7949C95.1189 65.8796 93.882 65.9416 92.6479 66.0165C92.4901 66.0263 92.3324 66.0524 92.2107 66.0687C92.1443 66.186 92.0834 66.2447 92.0779 66.3098C91.9367 68.135 92.0696 68.3012 93.6357 68.3044C94.5184 68.3044 95.4039 68.2751 96.2838 68.3142C96.7985 68.337 97.3214 68.4185 97.8223 68.5652C98.4283 68.7444 98.6247 69.6439 98.1405 70.11C97.861 70.3805 97.4432 70.5728 97.0862 70.5825C95.1244 70.6282 93.1625 70.6151 91.2007 70.5988C90.473 70.5923 90.0468 70.1523 89.9112 69.3343C89.8753 69.1094 89.8836 68.8748 89.8836 68.6434C89.8836 66.0622 89.8753 63.4809 89.8836 60.8997C89.8891 59.2473 90.271 58.6965 91.6573 58.6868C93.4808 58.6737 95.307 58.7943 97.1305 58.8758C97.3519 58.8856 97.5843 58.954 97.7863 59.0616C98.1294 59.2408 98.4061 59.5178 98.3646 60.023C98.3287 60.4923 98.1073 60.8247 97.7199 60.9388C97.3131 61.0561 96.8925 61.1735 96.4775 61.1865C95.3651 61.2191 94.2528 61.1996 93.1404 61.1996C92.8194 61.1996 92.5012 61.1996 92.0696 61.1996Z" fill="#E92827"/>
                                                                                <path d="M137.707 66.0159H133.249C133.163 66.5374 133.047 67.0035 133.022 67.4793C132.983 68.1702 133.028 68.8644 133.005 69.5586C132.981 70.3212 132.388 70.9437 131.76 70.7873C131.497 70.7221 131.185 70.4092 131.08 70.1159C130.922 69.6727 130.872 69.148 130.869 68.6591C130.85 65.9247 130.869 63.1903 130.853 60.4559C130.847 59.8725 130.961 59.4162 131.348 59.0349C131.91 58.4776 132.56 58.6308 132.828 59.4423C132.934 59.7584 132.981 60.1072 133.005 60.4461C133.036 60.8665 133.011 61.2935 133.014 61.7172C133.028 63.1153 133.349 63.5423 134.53 63.5032C135.565 63.4706 136.594 63.3174 137.726 63.2066C137.793 62.5254 137.848 61.854 137.928 61.1827C137.989 60.6547 138.033 60.1137 138.172 59.6118C138.343 58.9828 138.852 58.6112 139.278 58.6992C139.627 58.7709 140.172 59.4423 140.239 59.9051C140.266 60.0941 140.252 60.2897 140.252 60.482C140.252 63.1773 140.261 65.8758 140.247 68.5711C140.247 68.985 140.172 69.4054 140.089 69.8128C139.945 70.5266 139.644 70.8166 139.101 70.8231C138.661 70.8297 138.26 70.4777 138.125 69.8813C138.022 69.4413 137.975 68.9817 137.931 68.5287C137.851 67.7368 137.79 66.9448 137.712 66.0225L137.707 66.0159Z" fill="#E92827"/>
                                                                                <path d="M153.648 70.8232C152.101 70.9308 150.806 70.1062 149.821 68.669C149.259 67.8477 148.908 66.8601 148.858 65.7325C148.778 63.9791 149.151 62.3789 149.884 60.8927C150.316 60.0193 150.897 59.2957 151.808 59.0937C151.998 59.0513 152.189 58.9894 152.367 58.9014C154.29 57.9106 155.944 58.7547 157.477 60.0421C157.984 60.469 158.338 61.1991 158.105 62.0627C157.884 62.8873 157.386 63.148 156.761 62.7211C156.481 62.5288 156.251 62.2452 155.975 62.0464C155.562 61.7466 155.156 61.3783 154.702 61.2316C153.518 60.8471 152.203 61.6488 151.506 62.9818C150.56 64.7939 151.132 67.2317 152.762 68.053C153.822 68.5875 154.934 68.5288 155.889 67.6228C156.384 67.1535 156.877 66.7819 157.558 66.8667C158.291 66.9579 158.615 67.4826 158.346 68.2811C158.125 68.9427 157.718 69.4316 157.184 69.7803C156.108 70.481 154.968 70.8591 153.65 70.8265L153.648 70.8232Z" fill="#E92827"/>
                                                                                <path d="M202.426 63.2223C202.935 62.4597 203.356 61.7948 203.812 61.1625C204.377 60.3836 204.772 59.4254 205.611 58.9431C205.973 58.7345 206.278 58.6921 206.604 58.9822C206.92 59.2625 207.108 59.6079 206.934 60.074C206.621 60.9083 206.355 61.785 205.937 62.5411C205.533 63.2712 205.008 63.9295 204.457 64.5162C203.74 65.2755 203.502 66.2174 203.475 67.2799C203.458 67.8926 203.505 68.5118 203.458 69.1213C203.43 69.4863 203.323 69.8741 203.157 70.1805C202.949 70.5618 202.667 70.9301 202.194 70.7769C201.707 70.6205 201.416 70.2392 201.333 69.6525C201.305 69.4635 201.305 69.268 201.322 69.0789C201.527 66.9018 200.835 65.1484 199.557 63.6166C198.898 62.8312 198.336 61.9284 197.761 61.055C197.246 60.2728 197.318 59.6079 197.918 59.0571C198.455 58.565 198.848 58.5487 199.377 59.1973C200.074 60.0512 200.691 60.993 201.352 61.886C201.668 62.3097 202.011 62.7106 202.423 63.2223H202.426Z" fill="#E92827"/>
                                                                                <path d="M116.118 64.1451C116.035 65.9832 115.954 67.8214 115.866 69.6563C115.824 70.5264 115.752 70.5884 114.967 70.6047C114.045 70.621 113.918 70.5036 113.896 69.4607C113.832 66.4656 113.782 63.4737 113.721 60.4786C113.71 59.9604 113.744 59.478 114.136 59.1358C114.482 58.836 114.831 58.497 115.288 58.7838C115.725 59.0576 116.087 59.3607 116.057 60.0973C116.001 61.44 116.04 62.7893 116.04 64.1386C116.065 64.1386 116.093 64.1386 116.118 64.1418V64.1451Z" fill="#E92827"/>
                                                                                <path d="M105.634 44.5599C105.741 44.0145 105.884 43.4764 106.056 42.948C106.179 42.565 106.325 42.1893 106.446 41.8064C106.519 41.5785 106.591 41.3507 106.671 41.1253C105.838 41.9906 104.851 42.6862 103.707 43.2074C102.66 43.6849 101.586 44.1188 100.406 44.1212C100.275 44.1212 100.144 44.0339 99.9863 43.9806C100.333 43.4861 100.629 43.045 100.944 42.6159C102.267 40.8126 103.385 38.8928 103.915 36.7065C104.184 35.5988 104.398 34.4426 104.393 33.3106C104.386 31.9266 104.058 30.5886 103.389 29.3088C102.551 27.7017 101.237 26.7879 99.5888 26.3274C98.1005 25.9105 96.5686 26.0947 95.0585 26.3516C94.0381 26.5261 93.1194 26.9746 92.2347 27.4787C90.4774 28.4798 89.0546 29.8517 88.1505 31.66C87.6778 32.6028 87.4233 33.6621 87.1252 34.685C86.9603 35.2546 86.8125 35.8097 86.4368 36.2896C85.6078 37.3464 84.8637 38.4614 84.3886 39.7242C84.088 40.5217 83.7947 41.3361 83.6469 42.1675C83.5014 42.9771 83.482 43.823 83.5208 44.6472C83.6178 46.6954 85.0891 49.1556 87.7432 49.6598C88.9091 49.8804 90.0338 49.7689 91.1585 49.5628C93.0855 49.2065 94.7652 48.2733 96.3747 47.1923C96.6777 46.9886 97.0364 46.8069 97.3879 46.7535C98.0981 46.6469 98.8277 46.6784 99.5403 46.5742C100.619 46.419 101.719 46.2978 102.752 45.973C103.743 45.6628 104.664 45.1247 105.612 44.6811C105.619 44.6399 105.627 44.5963 105.634 44.5551V44.5599ZM92.4601 46.3827C91.6215 46.7802 90.7246 47.0444 89.7866 47.1268C87.7578 47.3038 86.1289 45.6604 86.5095 43.6097C86.6985 42.5917 86.987 41.5906 87.2706 40.592C87.3675 40.2527 87.5857 39.9448 87.8305 39.4576C89.217 42.1409 91.0931 44.1188 93.6478 45.4374C93.4248 46.0579 92.8746 46.1839 92.4577 46.3827H92.4601ZM96.891 42.9941C96.0451 43.8206 95.7833 43.8134 94.7265 43.2656C93.7133 42.7396 92.8576 42.0536 92.0359 41.2683C90.9088 40.1896 90.2932 38.8541 89.8157 37.4215C89.5587 36.6507 89.9393 36.0448 90.4313 35.5455C90.9743 34.9977 91.5899 34.5201 92.1959 34.0378C93.6866 32.8501 95.3833 32.1181 97.257 31.7787C97.6497 31.7084 98.0375 31.5872 98.4108 31.4442C99.0289 31.2067 99.1573 30.5183 98.6216 30.1208C98.3211 29.8978 97.8993 29.7887 97.5164 29.7427C96.5395 29.6263 95.5966 29.9002 94.6901 30.1959C93.8296 30.4747 93.02 30.9037 92.1862 31.2673C92.0456 31.3279 91.9002 31.3836 91.7572 31.4418L91.6312 31.3012C91.9923 30.9934 92.3292 30.6589 92.7146 30.3874C93.9823 29.493 95.4124 28.8967 96.9346 28.7731C99.2931 28.5816 101.273 29.9996 101.361 32.7313C101.373 33.0804 101.349 33.4294 101.365 33.7784C101.465 35.7903 100.694 37.5379 99.7366 39.2346C98.9561 40.6162 98.0278 41.8839 96.891 42.9965V42.9941Z" fill="#E92827"/>
                                                                                <path d="M102.315 28.5387C102.882 28.9677 103.866 30.0124 104.07 32.1915C104.094 32.4484 103.949 32.7102 103.701 32.7926C103.478 32.8677 103.209 32.7853 103.03 32.1381C102.977 31.9418 102.957 31.7382 102.972 31.537C102.991 31.251 102.906 30.502 102.104 28.7108C102.046 28.5774 102.199 28.449 102.315 28.5362V28.5387Z" fill="white"/>
                                                                                <path d="M83.819 44.5599C83.9257 44.0145 84.0687 43.4764 84.2408 42.948C84.3644 42.565 84.5098 42.1893 84.631 41.8064C84.7037 41.5785 84.7764 41.3507 84.8564 41.1253C84.0226 41.9906 83.0361 42.6862 81.892 43.2074C80.8449 43.6849 79.7711 44.1188 78.5907 44.1212C78.4598 44.1212 78.3289 44.0339 78.1714 43.9806C78.518 43.4861 78.8137 43.045 79.1288 42.6159C80.4522 40.8126 81.5696 38.8928 82.1005 36.7065C82.3695 35.5988 82.5828 34.4426 82.578 33.3106C82.5707 31.9266 82.2435 30.5886 81.5745 29.3088C80.7358 27.7017 79.4221 26.7879 77.7738 26.3274C76.2856 25.9105 74.7537 26.0947 73.2436 26.3516C72.2231 26.5261 71.3045 26.9746 70.4198 27.4787C68.6624 28.4798 67.2396 29.8517 66.3355 31.66C65.8629 32.6028 65.6083 33.6621 65.3102 34.685C65.1454 35.2546 64.9975 35.8097 64.6218 36.2896C63.7929 37.3464 63.0487 38.4614 62.5736 39.7242C62.2731 40.5217 61.9798 41.3361 61.8319 42.1675C61.6865 42.9771 61.6671 43.823 61.7059 44.6472C61.8028 46.6954 63.2741 49.1556 65.9283 49.6598C67.0942 49.8804 68.2189 49.7689 69.3436 49.5628C71.2705 49.2065 72.9503 48.2733 74.5598 47.1923C74.8628 46.9886 75.2215 46.8069 75.5729 46.7535C76.2831 46.6469 77.0127 46.6784 77.7254 46.5742C78.804 46.419 79.9044 46.2978 80.937 45.973C81.9284 45.6628 82.8495 45.1247 83.7972 44.6811C83.8045 44.6399 83.8117 44.5963 83.819 44.5551V44.5599ZM70.6452 46.3827C69.8065 46.7802 68.9097 47.0444 67.9716 47.1268C65.9428 47.3038 64.314 45.6604 64.6945 43.6097C64.8836 42.5917 65.172 41.5906 65.4556 40.592C65.5526 40.2527 65.7707 39.9448 66.0156 39.4576C67.402 42.1409 69.2781 44.1188 71.8329 45.4374C71.6099 46.0579 71.0597 46.1839 70.6428 46.3827H70.6452ZM75.0761 42.9941C74.2301 43.8206 73.9683 43.8134 72.9115 43.2656C71.8983 42.7396 71.0427 42.0536 70.221 41.2683C69.0939 40.1896 68.4782 38.8541 68.0007 37.4215C67.7438 36.6507 68.1243 36.0448 68.6164 35.5455C69.1593 34.9977 69.775 34.5201 70.381 34.0378C71.8717 32.8501 73.5684 32.1181 75.4421 31.7787C75.8347 31.7084 76.2226 31.5872 76.5958 31.4442C77.2139 31.2067 77.3424 30.5183 76.8067 30.1208C76.5061 29.8978 76.0844 29.7887 75.7014 29.7427C74.7246 29.6263 73.7817 29.9002 72.8752 30.1959C72.0147 30.4747 71.2051 30.9037 70.3713 31.2673C70.2307 31.3279 70.0853 31.3836 69.9423 31.4418L69.8162 31.3012C70.1774 30.9934 70.5143 30.6589 70.8997 30.3874C72.1674 29.493 73.5975 28.8967 75.1197 28.7731C77.4781 28.5816 79.4584 29.9996 79.5457 32.7313C79.5578 33.0804 79.5336 33.4294 79.5505 33.7784C79.6499 35.7903 78.8791 37.5379 77.9217 39.2346C77.1412 40.6162 76.2129 41.8839 75.0761 42.9965V42.9941Z" fill="#E92827"/>
                                                                                <path d="M80.5005 28.5387C81.0677 28.9677 82.0518 30.0124 82.2554 32.1915C82.2796 32.4484 82.1342 32.7102 81.887 32.7926C81.664 32.8677 81.3949 32.7853 81.2156 32.1381C81.1622 31.9418 81.1428 31.7382 81.1574 31.537C81.1768 31.251 81.0919 30.502 80.2896 28.7108C80.2315 28.5774 80.3842 28.449 80.5005 28.5362V28.5387Z" fill="white"/>
                                                                                <path d="M207.717 21.0076C208.929 19.546 210.161 18.1037 211.375 16.6446C211.579 16.3997 211.763 16.1258 211.889 15.8374C212.16 15.2169 211.799 14.7467 211.419 14.3225C211.026 13.8862 210.716 13.845 210.122 14.1334C209.863 14.2594 209.613 14.4437 209.424 14.6594C207.991 16.2834 206.542 17.8953 205.16 19.5629C204.055 20.9009 203.042 22.314 201.978 23.686C201.699 24.0447 201.408 24.3986 201.083 24.7137C200.683 25.1015 200.182 25.3536 199.619 25.2227C198.298 24.91 196.96 24.9464 195.622 24.9537C194.502 24.9585 193.45 25.247 192.471 25.7826C192.263 25.8966 192.071 26.0541 191.906 26.2262C191.509 26.6407 191.431 27.1982 191.681 27.6248C191.894 27.9908 192.391 28.1193 192.98 27.9375C193.312 27.8357 193.627 27.6708 193.962 27.5909C195.179 27.3 196.415 27.4333 197.644 27.4818C198.061 27.4987 198.473 27.5981 198.994 27.6757C198.904 27.9011 198.873 28.032 198.805 28.1411C198.279 29.0113 197.755 29.8839 197.215 30.7468C196.003 32.6835 194.97 34.7123 194.066 36.8089C193.707 37.6427 193.356 38.4935 193.126 39.3685C192.934 40.1006 192.563 40.7017 192.091 41.2446C190.833 42.6893 189.279 43.8043 187.752 44.929C186.438 45.8961 184.984 46.6548 183.425 47.1929C181.442 47.8788 179.445 48.4945 177.319 48.286C176.616 48.2182 175.821 48.0921 175.264 47.7092C174.088 46.9069 173.436 45.7022 173.39 44.2357C173.371 43.6249 173.611 43.3025 174.2 43.0989C174.53 42.9874 174.876 42.9268 175.203 42.8105C176.386 42.3936 177.545 41.8942 178.749 41.5501C180.206 41.1356 181.535 40.4399 182.87 39.7806C184.378 39.0389 185.839 38.1857 187.114 37.0513C188.178 36.106 189.027 35.0177 189.412 33.6457C189.718 32.555 189.412 31.5297 188.566 30.788C187.173 29.5712 185.471 29.5009 183.777 29.8523C182.768 30.0632 181.801 30.502 180.841 30.8995C179.273 31.5515 177.874 32.5065 176.575 33.5827C175.797 34.225 175.135 35.008 174.413 35.7182C173.376 36.7411 172.501 37.8754 171.822 39.1722C171.514 39.7612 171.153 40.3405 170.722 40.8423C169.095 42.7353 167.025 44.0006 164.727 44.912C164.342 45.0647 163.927 45.1544 163.467 45.2901C163.38 44.6454 163.288 44.1 163.237 43.5498C163.113 42.2118 162.866 40.9101 162.34 39.6594C161.966 38.7723 161.632 37.8657 161.327 36.9495C160.97 35.8757 160.66 34.7559 161.108 33.653C161.45 32.8143 161.92 32.0242 162.403 31.2534C162.812 30.5965 163.343 30.0196 163.77 29.3724C164.146 28.8004 164.044 28.1944 163.571 27.6757C163.016 27.0673 162.534 26.9485 161.857 27.2927C161.622 27.4115 161.409 27.5812 161.205 27.7533C160.413 28.4223 159.899 29.307 159.361 30.1723C158.103 32.1938 156.942 34.2881 155.56 36.2199C154.336 37.9312 152.925 39.5237 151.478 41.0604C150.458 42.1463 149.244 43.0504 148.112 44.0321C146.592 45.3483 144.89 46.3275 142.941 46.8632C142.197 47.0668 141.453 47.0814 140.726 46.822C139.822 46.4996 139.007 45.358 139.182 44.5896C139.373 43.7582 139.611 42.9268 139.933 42.1366C140.644 40.4011 141.555 38.7747 142.609 37.2137C143.584 35.7715 144.582 34.3535 145.68 33.0034C145.966 32.6519 146.233 32.2787 146.478 31.8957C146.824 31.3503 146.778 30.6644 146.4 30.2474C146.003 29.8111 145.419 29.7554 144.784 30.1287C144.531 30.2765 144.284 30.4535 144.088 30.6668C143.523 31.2752 142.951 31.8787 142.447 32.5356C141.586 33.6603 140.731 34.7947 139.958 35.9824C139.257 37.0586 138.622 38.1833 138.057 39.337C137.781 39.9018 137.48 40.4254 137.054 40.8665C135.582 42.3936 134 43.8043 132.155 44.8635C130.999 45.5277 129.84 46.2548 128.5 46.4924C127.312 46.7032 126.134 46.696 125.249 45.644C124.287 44.4975 124.282 43.1401 124.401 41.7585C124.411 41.647 124.544 41.5379 124.636 41.4434C125.482 40.5466 126.331 39.6521 127.176 38.7553C127.967 37.9166 128.779 37.0974 129.545 36.2369C130.841 34.7777 132.141 33.3185 133.384 31.8157C135.961 28.7058 138.464 25.5354 140.585 22.0886C141.133 21.1991 141.635 20.2828 142.163 19.3836C142.76 18.3655 143.242 17.3014 143.644 16.1889C143.996 15.2169 144.243 14.2522 144.221 13.2196C144.19 11.8113 143.433 10.7763 142.108 10.2964C140.75 9.80433 139.417 9.86008 138.142 10.5194C137.507 10.849 136.93 11.295 136.331 11.695C134.516 12.9093 133.18 14.6036 131.942 16.3416C130.747 18.0141 129.736 19.8223 128.699 21.6014C127.208 24.1538 126.013 26.8516 124.893 29.5809C124.723 29.9929 124.556 30.4074 124.372 30.8558C124.159 30.7419 123.994 30.6595 123.836 30.5674C122.787 29.9614 121.652 29.6948 120.45 29.736C119.122 29.7821 117.864 30.1553 116.662 30.6862C115.927 31.011 115.193 31.3697 114.538 31.8254C113.29 32.6931 112.044 33.5827 110.9 34.5814C110.1 35.2794 109.453 36.1545 108.774 36.981C108.214 37.6621 107.625 38.3384 107.199 39.1019L105.638 42.0882C105.504 42.4929 105.352 42.888 105.228 43.2977C105.102 43.717 104.993 44.1436 104.906 44.5726C104.978 44.546 105.061 44.5145 105.16 44.4757C104.806 46.0948 105.136 47.4983 106.052 48.7369C106.675 49.578 107.378 50.3464 108.517 50.5306C110.255 50.8117 111.899 50.6566 113.508 49.8519C115.898 48.6569 117.968 47.0087 120.087 45.4234C120.513 45.1035 120.848 44.6114 121.478 44.5096C121.519 44.6817 121.553 44.8053 121.577 44.9314C121.883 46.5578 122.733 47.8037 124.219 48.5575C125.642 49.2823 127.159 49.1877 128.67 48.9308C130.044 48.6981 131.232 47.9709 132.427 47.3189C133.479 46.742 134.528 46.1336 135.367 45.2368C135.59 44.9992 135.905 44.8514 136.261 44.6017C136.319 44.895 136.351 45.0453 136.375 45.1956C136.453 45.6682 136.462 46.1651 136.617 46.6111C137.403 48.8702 139.473 49.6555 141.473 49.4471C143.53 49.2314 145.36 48.3491 147.118 47.2826C148.155 46.6523 149.103 45.9228 150.019 45.1447C151.241 44.1048 152.475 43.0771 153.657 41.9936C154.142 41.5476 154.511 40.9732 154.928 40.4545C155.497 39.7491 156.074 39.0437 156.634 38.3311C157.078 37.7664 157.499 37.187 158.028 36.4914C158.226 36.981 158.391 37.3616 158.537 37.7494C158.835 38.5493 159.121 39.3516 159.409 40.1515C159.727 41.0289 160.115 41.8918 160.34 42.7935C160.527 43.5352 160.558 44.323 160.585 45.0914C160.607 45.7264 160.452 45.8985 159.821 45.9785C159.109 46.0706 158.384 46.0827 157.667 46.1361C156.416 46.2282 155.165 46.3154 153.917 46.4245C153.018 46.5021 152.118 46.5433 151.364 47.1904C150.312 48.0921 150.206 49.9173 150.654 50.5766C151.008 51.0978 151.454 51.5947 151.958 51.9679C153.413 53.0441 155.078 53.0805 156.779 52.7751C157.172 52.7048 157.574 52.6321 157.94 52.4818C159.86 51.7013 161.392 50.4627 162.432 48.6375C162.837 47.9273 163.355 47.3116 164.284 47.2729C164.439 47.2656 164.592 47.1856 164.744 47.1298C166.514 46.4802 168.16 45.5858 169.74 44.5702C169.931 44.4466 170.137 44.3448 170.39 44.2042C170.421 44.3981 170.453 44.4975 170.453 44.5993C170.433 47.6922 172.675 49.9367 175.373 50.6615C176.82 51.0517 178.294 50.9281 179.741 50.7511C181.389 50.55 182.967 50.0288 184.48 49.3186C186.773 48.24 188.843 46.8293 190.794 45.2271C191.145 44.9387 191.458 44.5242 192.023 44.5023C192.091 44.9168 192.125 45.3192 192.226 45.6998C192.457 46.5505 192.694 47.3965 193.416 48.0121C194.476 48.9138 195.719 49.3186 197.055 49.1659C198.187 49.0375 199.333 48.7684 200.392 48.3539C202.041 47.7092 203.57 46.7929 204.957 45.6779C206.227 44.6575 207.465 43.5934 208.692 42.522C209.051 42.2093 209.373 41.8288 209.625 41.424C209.797 41.1501 209.93 40.7647 209.887 40.4569C209.785 39.7297 208.949 39.4922 208.309 40.0085C207.519 40.6459 206.755 41.3198 206.001 42.0009C204.867 43.0238 203.742 44.0612 202.419 44.8344C200.783 45.7894 199.069 46.5093 197.11 46.4269C196.012 46.3809 195.246 45.6367 195.29 44.5508C195.314 43.9376 195.334 43.3171 195.457 42.7184C195.823 40.9417 196.189 39.1552 196.938 37.49C197.566 36.0987 198.201 34.7074 198.938 33.3743C199.818 31.7818 200.821 30.2596 201.747 28.6913C201.985 28.2865 202.29 28.1314 202.739 28.1774C204.225 28.335 205.71 28.5047 207.199 28.6331C208.023 28.7034 208.857 28.7471 209.683 28.7131C210.122 28.6961 210.573 28.5313 210.985 28.3544C211.484 28.1387 211.651 27.7533 211.574 27.2491C211.518 26.8879 211.225 26.6286 210.691 26.568C209.606 26.4468 208.51 26.3862 207.427 26.2529C206.326 26.1171 205.233 25.9256 204.016 25.7414C204.169 25.4603 204.242 25.2663 204.365 25.1136C205.473 23.7417 206.583 22.3698 207.708 21.0124L207.717 21.0076ZM175.358 39.068C176.326 37.7106 177.504 36.5568 178.752 35.4491C179.974 34.3656 181.35 33.5706 182.81 32.8895C183.84 32.4071 184.928 32.2084 186.06 32.3853C186.656 32.4774 186.896 32.858 186.656 33.4227C186.462 33.8833 186.184 34.3293 185.859 34.7098C185.124 35.5679 184.259 36.2878 183.26 36.8283C182.507 37.2355 181.775 37.6961 180.987 38.0257C179.14 38.8014 177.269 39.5164 175.402 40.2436C175.245 40.3042 175.051 40.2751 174.74 40.2969C174.978 39.817 175.116 39.4073 175.358 39.0704V39.068ZM126.171 34.7098C127.019 32.3999 127.799 30.0608 128.781 27.809C129.688 25.7269 130.822 23.7466 131.852 21.7178C132.509 20.4258 133.333 19.2405 134.094 18.0116C135.19 16.247 136.695 14.8824 138.145 13.4596C138.816 12.8003 139.689 12.5215 140.658 12.6451C141.271 12.7227 141.545 13.0039 141.596 13.6389C141.635 14.1067 141.451 14.5188 141.337 14.9575C140.891 16.6955 140.004 18.2298 139.146 19.7641C137.657 22.428 135.861 24.8955 134.014 27.317C132.865 28.8246 131.607 30.2474 130.415 31.7236C129.05 33.413 127.593 35.0152 126.035 36.5277C125.923 36.6344 125.807 36.7362 125.691 36.8404C125.645 36.8138 125.598 36.7871 125.552 36.7604C125.756 36.0769 125.928 35.3812 126.173 34.7122L126.171 34.7098ZM123.305 34.0942C122.809 35.9775 122.314 37.8633 121.846 39.7539C121.648 40.5587 121.274 41.2059 120.654 41.7827C118.407 43.8649 116.007 45.741 113.314 47.2026C112.529 47.6292 111.644 47.9685 110.767 48.1188C109.426 48.3442 107.875 47.5565 107.945 45.7603C107.999 44.3884 108.457 43.1425 109.009 41.9306C109.417 41.0386 109.897 40.1539 110.488 39.3734C111.763 37.6912 113.159 36.1181 114.849 34.8092C116.305 33.6821 117.852 32.7707 119.648 32.332C120.033 32.2375 120.44 32.235 120.836 32.1914C121.538 32.1381 122.174 32.332 122.763 32.6835C123.359 33.0373 123.48 33.4276 123.303 34.0966L123.305 34.0942ZM158.859 49.0956C157.8 49.9973 156.6 50.5984 155.18 50.613C154.586 50.6178 154.021 50.4336 153.527 50.0943C153.257 49.9101 153.022 49.6798 153.085 49.3017C153.148 48.9211 153.417 48.7878 153.766 48.7393C154.319 48.6642 154.867 48.5575 155.42 48.5018C156.186 48.4266 156.956 48.3903 157.727 48.3297C158.042 48.3054 158.357 48.2473 158.672 48.2254C158.905 48.2085 159.138 48.223 159.371 48.223C159.407 48.286 159.441 48.3515 159.477 48.4145C159.274 48.6424 159.092 48.8969 158.862 49.0932L158.859 49.0956Z" fill="#E92827"/>
                                                                                <path d="M149.647 22.9417C149.637 22.8569 149.647 22.7721 149.661 22.6896C149.707 22.4569 149.821 22.2727 150.027 22.1491C150.151 22.074 150.289 22.04 150.432 22.0303C150.609 22.0182 150.779 22.0449 150.939 22.1224C151.036 22.1685 151.123 22.2291 151.205 22.3018C151.389 22.4666 151.501 22.6678 151.54 22.9126C151.557 23.0241 151.557 23.1381 151.549 23.252C151.545 23.3562 151.53 23.4604 151.503 23.5598C151.474 23.6665 151.44 23.7731 151.394 23.8749C151.295 24.0931 151.157 24.2821 150.98 24.4397C150.737 24.6554 150.454 24.7936 150.134 24.8469C149.559 24.9439 149.043 24.8033 148.575 24.4615C148.389 24.3258 148.231 24.1634 148.1 23.9743C148.032 23.8749 147.972 23.7683 147.918 23.6568C147.814 23.4435 147.756 23.218 147.734 22.9854C147.717 22.7987 147.72 22.6121 147.741 22.4254C147.78 22.1152 147.863 21.8195 148.003 21.5407C148.124 21.3032 148.277 21.085 148.466 20.896C148.852 20.513 149.312 20.273 149.848 20.1736C150.078 20.1324 150.308 20.1179 150.541 20.1324C151.065 20.1664 151.549 20.3263 151.991 20.6075C152.56 20.9711 152.977 21.4607 153.236 22.0861C153.278 22.183 153.307 22.2848 153.338 22.3842C153.421 22.646 153.455 22.9126 153.462 23.1865C153.474 23.6398 153.406 24.0834 153.251 24.51C153.169 24.7403 153.064 24.9584 152.933 25.1644C152.47 25.8892 151.828 26.374 151.006 26.6236C150.892 26.6576 150.776 26.6818 150.66 26.706C150.514 26.7351 150.369 26.7569 150.221 26.7618C150.105 26.7666 149.988 26.7739 149.872 26.7715C149.78 26.7715 149.688 26.7642 149.596 26.7545C149.477 26.7424 149.356 26.7278 149.237 26.7085C149.135 26.6915 149.036 26.6673 148.939 26.6406C148.175 26.4394 147.526 26.0443 146.978 25.4795C146.891 25.3899 146.813 25.2953 146.733 25.2008C146.433 24.8421 146.207 24.4397 146.047 24.001C146.006 23.8919 145.977 23.778 145.943 23.664C145.89 23.4895 145.858 23.3126 145.836 23.1332C145.807 22.9029 145.795 22.6702 145.807 22.4376C145.81 22.3648 145.807 22.2897 145.817 22.217C145.829 22.0861 145.844 21.9528 145.863 21.8219C145.909 21.5383 145.982 21.262 146.086 20.9929C146.134 20.8717 146.188 20.7554 146.241 20.6366C146.389 20.3142 146.585 20.0209 146.813 19.7495C146.927 19.6137 147.051 19.4877 147.182 19.3689C147.732 18.8623 148.372 18.5278 149.099 18.3509C149.341 18.2927 149.586 18.2539 149.836 18.2345C150.097 18.2151 150.359 18.2176 150.623 18.2394C151.108 18.2806 151.576 18.3921 152.027 18.569C152.344 18.6926 152.65 18.8478 152.936 19.032C153.028 19.0902 153.118 19.1556 153.207 19.2186C153.505 19.4295 153.774 19.6767 154.017 19.9506C154.187 20.1446 154.342 20.3482 154.477 20.5663C154.8 21.0777 155.02 21.6328 155.139 22.2243C155.183 22.44 155.212 22.6581 155.226 22.8787C155.241 23.0799 155.243 23.2835 155.231 23.4847C155.205 23.9282 155.129 24.3646 154.984 24.7863C154.943 24.9027 154.902 25.019 154.853 25.1329C154.623 25.6807 154.305 26.1728 153.893 26.6018C153.789 26.7085 153.68 26.8103 153.568 26.9096C153.135 27.2999 152.643 27.598 152.104 27.821C151.753 27.9665 151.392 28.0707 151.016 28.1337C150.907 28.1507 150.798 28.1652 150.689 28.1773C150.56 28.1895 150.434 28.2016 150.306 28.2064C150.112 28.2137 149.921 28.2137 149.727 28.1992C149.441 28.1773 149.157 28.1361 148.878 28.0683C148.316 27.9325 147.787 27.7095 147.3 27.3968C146.583 26.9387 146.011 26.3449 145.579 25.6104C145.504 25.4795 145.436 25.3438 145.371 25.2105C145.165 24.796 145.029 24.3573 144.949 23.9016C144.918 23.7198 144.889 23.538 144.881 23.3538C144.876 23.2544 144.869 23.155 144.867 23.0556C144.886 23.1793 144.901 23.3053 144.925 23.4289C144.956 23.5913 144.99 23.7537 145.036 23.9137C145.155 24.3161 145.315 24.7015 145.528 25.0626C145.601 25.1838 145.671 25.3074 145.754 25.4238C146.147 25.9813 146.619 26.4564 147.186 26.8369C147.698 27.1811 148.253 27.4308 148.852 27.5786C149.096 27.6392 149.344 27.6804 149.596 27.7023C149.814 27.7216 150.032 27.7265 150.253 27.7168C151.225 27.6659 152.095 27.3508 152.851 26.7351C153.263 26.4006 153.595 25.9958 153.859 25.5353C153.934 25.4044 154.002 25.2687 154.061 25.1305C154.172 24.8687 154.262 24.5972 154.32 24.3161C154.347 24.1852 154.366 24.0543 154.388 23.9234C154.429 23.6665 154.427 23.4071 154.419 23.1478C154.412 22.9078 154.38 22.6702 154.33 22.4351C154.267 22.1467 154.17 21.8704 154.046 21.6013C153.942 21.3759 153.818 21.1626 153.673 20.9614C153.588 20.8451 153.505 20.7287 153.411 20.6221C152.948 20.0985 152.398 19.701 151.746 19.444C151.615 19.3931 151.484 19.3471 151.348 19.3083C151.162 19.255 150.97 19.2235 150.776 19.1944C150.636 19.1726 150.495 19.1653 150.352 19.1629C149.954 19.1556 149.564 19.2065 149.184 19.3253C148.473 19.5459 147.889 19.9506 147.441 20.5445C147.116 20.9735 146.915 21.4559 146.816 21.9843C146.789 22.1273 146.765 22.2703 146.762 22.4133C146.762 22.5563 146.757 22.6993 146.762 22.8423C146.779 23.2714 146.888 23.6786 147.082 24.064C147.278 24.4567 147.548 24.7936 147.882 25.0772C147.996 25.1717 148.112 25.2614 148.238 25.339C148.597 25.5644 148.982 25.7122 149.402 25.7825C149.622 25.8189 149.845 25.8286 150.068 25.814C150.505 25.785 150.912 25.6565 151.285 25.4286C151.421 25.3462 151.547 25.2541 151.661 25.1475C152.087 24.7475 152.359 24.2627 152.463 23.6859C152.512 23.4192 152.519 23.1502 152.487 22.8787C152.473 22.7575 152.446 22.6387 152.407 22.5224C152.369 22.4012 152.323 22.28 152.257 22.1685C151.937 21.6159 151.472 21.2498 150.844 21.1117C150.354 21.0026 149.887 21.0729 149.458 21.3444C149.179 21.5189 148.975 21.7613 148.832 22.0546C148.709 22.3115 148.665 22.5806 148.67 22.8617C148.67 23.0338 148.706 23.1962 148.789 23.3489C148.866 23.4968 148.97 23.6228 149.106 23.7198C149.227 23.8046 149.358 23.8701 149.508 23.8992C149.642 23.9258 149.775 23.9258 149.908 23.904C150.02 23.8846 150.124 23.8483 150.221 23.7925C150.405 23.6859 150.536 23.538 150.597 23.332C150.628 23.2277 150.628 23.1235 150.602 23.0193C150.568 22.8811 150.488 22.7793 150.357 22.7236C150.158 22.6387 149.967 22.6533 149.782 22.7721C149.719 22.8133 149.676 22.869 149.637 22.9345L149.647 22.9417Z" fill="#E92827"/>
                                                                                <rect x="143.133" y="10.1216" width="19.1487" height="18.9064" fill="url(#pattern0_2639_40882)"/>
                                                                                <rect x="139.498" y="14.7269" width="19.1487" height="18.664" fill="url(#pattern1_2639_40882)"/>
                                                                                <path d="M115.719 31.8251C116.311 31.1633 117.566 30.1962 119.929 30.0387C120.245 30.0168 120.56 30.1889 120.652 30.4919C120.734 30.761 120.623 31.0809 119.828 31.27C119.6 31.3233 119.362 31.3282 119.13 31.3088C118.79 31.2797 117.939 31.3621 115.959 32.1668C115.748 32.2517 115.569 31.9947 115.719 31.8251Z" fill="white"/>
                                                                                <path d="M142.522 17.2353C143.138 16.5954 144.006 15.2695 143.987 12.9014C143.984 12.5863 143.788 12.2857 143.48 12.2154C143.206 12.1548 142.896 12.2881 142.767 13.0953C142.731 13.3255 142.743 13.5631 142.782 13.7934C142.835 14.1303 142.818 14.9859 142.166 17.0196C142.096 17.2353 142.367 17.3977 142.525 17.2329L142.522 17.2353Z" fill="white"/>
                                                                                <path d="M161.345 48.7027C161.96 48.0628 162.828 46.737 162.809 44.3688C162.806 44.0537 162.61 43.7532 162.302 43.6829C162.028 43.6223 161.718 43.7556 161.59 44.5627C161.553 44.793 161.565 45.0305 161.604 45.2608C161.657 45.5977 161.64 46.4534 160.988 48.487C160.918 48.7027 161.19 48.8651 161.347 48.7003L161.345 48.7027Z" fill="white"/>
                                                                                <path d="M144.126 32.3438C143.871 32.1572 143.515 32.2105 143.277 32.4165C141.484 33.963 141.062 35.49 140.987 36.3748C140.967 36.6026 141.265 36.6996 141.384 36.5032C142.482 34.6708 143.115 34.0939 143.403 33.9121C143.602 33.786 143.789 33.6406 143.939 33.4612C144.46 32.8335 144.358 32.5087 144.131 32.3438H144.126Z" fill="white"/>
                                                                                <path d="M181.589 31.7304C181.414 31.4662 181.065 31.391 180.767 31.5001C178.544 32.3194 177.613 33.6016 177.233 34.4039C177.136 34.6099 177.381 34.8063 177.56 34.6633C179.233 33.3326 180.025 33.0126 180.36 32.9447C180.59 32.8963 180.815 32.826 181.019 32.7096C181.729 32.3048 181.744 31.9655 181.591 31.7304H181.589Z" fill="white"/>
                                                                                <path d="M208.062 17.9439C207.807 17.7572 207.451 17.8081 207.213 18.0142C205.415 19.5558 204.986 21.0804 204.908 21.9651C204.889 22.193 205.187 22.2899 205.303 22.096C206.409 20.266 207.041 19.6915 207.33 19.5121C207.528 19.3885 207.715 19.2431 207.865 19.0637C208.389 18.4359 208.287 18.1136 208.059 17.9463L208.062 17.9439Z" fill="white"/>
                                                                                <path d="M196.534 48.4922C196.631 48.7928 196.948 48.96 197.261 48.9358C199.622 48.7443 200.865 47.7626 201.447 47.0912C201.597 46.9191 201.413 46.6646 201.202 46.7543C199.234 47.5857 198.383 47.6778 198.044 47.656C197.811 47.639 197.573 47.6487 197.346 47.7044C196.553 47.9032 196.446 48.2256 196.531 48.4922H196.534Z" fill="white"/>
                                                                                <path d="M113.3 49.2868C112.878 49.7571 111.983 50.4454 110.299 50.5594C110.076 50.5739 109.85 50.4527 109.785 50.237C109.727 50.0455 109.807 49.8177 110.372 49.6819C110.534 49.6431 110.704 49.6407 110.869 49.6528C111.111 49.6722 111.717 49.614 113.128 49.042C113.278 48.9814 113.406 49.1632 113.297 49.2844L113.3 49.2868Z" fill="white"/>
                                                                                <path d="M8.28555 75.7098C8.66852 75.2177 9.07574 74.7572 9.50477 74.3136C9.70837 73.3368 9.85381 72.0376 9.7011 70.5493C8.92546 71.1844 8.18617 71.8679 7.49536 72.6145C6.97423 73.1768 6.47491 73.7634 5.93438 74.3064C5.75744 74.4833 5.59261 74.6724 5.43506 74.8614C6.13071 75.9352 6.56701 76.9775 6.84091 77.8355C7.26267 77.1011 7.75229 76.3957 8.28797 75.7098H8.28555Z" fill="#E92827"/>
                                                                                <path d="M55.3406 19.4827C53.8329 20.4111 52.2647 21.2255 50.6479 21.943C51.855 21.9357 52.8997 22.1054 53.6972 22.3041C54.2959 22.452 54.8098 22.6289 55.217 22.7889C56.6616 22.0035 58.0626 21.1431 59.4103 20.1832C59.7957 19.9093 60.1762 19.6306 60.5519 19.3445C60.1084 19.2573 59.5436 19.1749 58.8867 19.1434C57.956 19.0973 56.7174 19.1434 55.3382 19.4803L55.3406 19.4827Z" fill="#E92827"/>
                                                                                <path d="M3.83262 16.5815C3.64599 16.1549 3.49086 15.7283 3.36239 15.2992C2.05349 14.5769 1.07182 13.7213 0.4004 13.0184C0.257391 12.8681 0.124077 12.7202 0.000458709 12.5772C-0.00923684 13.4135 0.136196 14.2327 0.301021 15.0496C0.48766 15.9707 0.778527 16.8578 1.16635 17.6965C2.17469 18.1473 3.57327 18.603 5.25545 18.729C4.71007 18.0649 4.18894 17.3959 3.83262 16.5815Z" fill="white"/>
                                                                                <path d="M50.533 21.9912C50.3318 22.0809 50.1282 22.1682 49.9246 22.2554C48.303 22.9414 46.6887 23.6661 45.0138 24.1921C44.8854 24.2333 44.7569 24.2697 44.6309 24.3085C45.9373 24.2745 47.0669 24.4539 47.9177 24.6672C48.7466 24.8732 49.4108 25.1302 49.8592 25.3289C50.3973 25.1083 50.9305 24.8781 51.4638 24.6405C52.7218 24.0782 53.9556 23.4746 55.1602 22.8202C54.7603 22.6626 54.261 22.4954 53.6817 22.35C52.8624 22.1463 51.7813 21.9718 50.533 21.9912Z" fill="white"/>
                                                                                <path d="M3.34596 15.2339C3.0357 14.1649 2.91451 13.0742 3.04297 11.901C3.07206 11.6417 3.11327 11.3944 3.16174 11.1496C2.24067 9.56681 1.82618 8.03491 1.64681 6.90295C1.5135 7.11141 1.38503 7.32714 1.26626 7.55013C0.471228 9.02871 0.119765 10.597 0.0131135 12.2428C0.00826574 12.3301 0.00584186 12.4197 0.00341797 12.507C0.136732 12.6621 0.279741 12.8221 0.437294 12.9869C1.09901 13.6802 2.0613 14.5213 3.34353 15.2339H3.34596Z" fill="#E92827"/>
                                                                                <path d="M38.644 25.915C38.4549 25.9587 38.2683 26.0047 38.0792 26.0459C36.8843 26.3126 35.6675 26.4774 34.4507 26.6422C35.1173 26.9113 35.6893 27.2094 36.1547 27.4881C36.9255 27.9511 37.5072 28.4116 37.8756 28.7365C38.8331 28.574 39.7881 28.4044 40.7334 28.1959C41.7151 27.9778 42.6822 27.6942 43.6493 27.4082C43.3415 27.2361 42.9828 27.0567 42.578 26.8822C41.623 26.4701 40.2729 26.0387 38.644 25.915Z" fill="white"/>
                                                                                <path d="M60.0771 16.0653C58.7803 17.2045 57.3647 18.1935 55.908 19.1291C55.7625 19.2212 55.6171 19.3109 55.4717 19.403C56.8 19.0951 57.9901 19.0491 58.8942 19.0976C59.5753 19.1315 60.1546 19.2188 60.6055 19.3085C61.7374 18.4455 62.8161 17.522 63.7783 16.4604C63.9989 16.218 64.2098 15.9683 64.4231 15.7211C64.234 15.7017 64.0328 15.6872 63.8244 15.675C62.8476 15.6266 61.5362 15.6823 60.0771 16.0653Z" fill="white"/>
                                                                                <path d="M5.6509 19.2109C5.53213 19.0678 5.41579 18.9248 5.29702 18.7818C3.61484 18.6631 2.21626 18.2146 1.1958 17.7638C1.50848 18.4279 1.87691 19.063 2.31079 19.6593C2.89979 20.4664 3.63908 21.1645 4.38321 21.8577C5.32368 21.7875 6.46775 21.5935 7.69181 21.1475C6.95738 20.5658 6.25687 19.955 5.6509 19.2133V19.2109Z" fill="#E92827"/>
                                                                                <path d="M44.4494 24.3641C42.5854 24.9337 40.6972 25.4403 38.7969 25.879C40.3676 26.0172 41.6716 26.4365 42.6024 26.8364C43.0266 27.0182 43.3998 27.2097 43.7174 27.3867C44.1924 27.2461 44.6675 27.1031 45.145 26.9697C46.7303 26.5238 48.2767 25.9735 49.7965 25.353C49.3505 25.1567 48.7057 24.9119 47.9058 24.7131C47.0211 24.4925 45.8286 24.3083 44.4494 24.3641Z" fill="#E92827"/>
                                                                                <path d="M34.3573 26.6551C33.7901 26.7302 33.2229 26.8078 32.6557 26.8926C32.6048 26.8999 32.5539 26.8999 32.503 26.9023C31.5165 26.9241 30.5275 26.9459 29.541 26.9653C30.4669 27.5325 31.1965 28.1482 31.7371 28.679C32.0328 28.9699 32.2873 29.2486 32.5054 29.5056C33.4798 29.4474 34.4518 29.3432 35.4189 29.1638C36.2164 29.0159 37.0163 28.8826 37.8162 28.7469C37.4477 28.4245 36.8805 27.9761 36.1316 27.5277C35.6492 27.2392 35.0554 26.9314 34.3573 26.6526V26.6551Z" fill="#E92827"/>
                                                                                <path d="M17.0651 44.7978C17.0651 44.9214 17.0772 45.0426 17.0942 45.1662C17.1427 45.1396 17.1887 45.1153 17.2372 45.0887C18.025 44.6524 19.0091 43.9858 19.9689 43.0259C19.9859 41.9934 19.9132 40.9535 20.0247 39.9306C20.0489 39.7004 20.0804 39.4725 20.1144 39.2422C18.98 39.7052 17.9232 39.9379 17.07 40.0518C17.0069 41.6298 17.0627 43.215 17.0651 44.7978Z" fill="white"/>
                                                                                <path d="M25.3518 7.36062C25.3372 7.33638 25.3275 7.31214 25.3105 7.29033C25.0294 6.89766 24.7409 6.47833 24.3677 6.18746C24.1471 6.01536 23.9265 5.84084 23.7059 5.67117C23.6163 5.66874 23.5241 5.66632 23.432 5.66632C23.4102 5.66632 23.3884 5.66632 23.3666 5.66632C22.4891 5.66632 21.3572 5.7657 20.1089 6.10747C20.8603 6.50014 21.5608 6.9728 22.2322 7.48666C23.2672 7.38971 24.3071 7.36305 25.3493 7.36305L25.3518 7.36062Z" fill="white"/>
                                                                                <path d="M19.1148 50.9686C19.934 51.8461 20.6467 52.8399 21.5483 53.6204C21.8198 53.8555 22.1034 54.0809 22.3967 54.2991C22.4331 54.2021 22.4718 54.1003 22.5082 53.9985C22.7676 53.2641 23.0221 52.3042 23.1384 51.1844C22.9372 50.9783 22.7409 50.7578 22.5518 50.5275C21.7423 49.5385 21.1436 48.4769 20.7073 47.3037C20.0698 48.6005 19.2966 49.5943 18.6445 50.2899C18.773 50.5299 18.9209 50.7602 19.1172 50.9711L19.1148 50.9686Z" fill="white"/>
                                                                                <path d="M19.5516 3.28821C18.2185 3.28821 16.2939 3.51363 14.2627 4.48804C16.1873 4.4638 17.9543 5.07462 19.6583 5.87693C19.7892 5.93752 19.9176 6.00539 20.0461 6.07084C21.3211 5.71453 22.4772 5.61272 23.3692 5.61272H23.4371C23.5074 5.61272 23.5753 5.61272 23.6456 5.61757C22.5427 4.75951 21.4204 3.93781 20.1261 3.33669C20.097 3.32457 20.0703 3.31245 20.0412 3.2979C19.9031 3.29306 19.7649 3.28821 19.6171 3.28821H19.5516Z" fill="#E92827"/>
                                                                                <path d="M9.0415 4.87355C10.2292 4.46391 11.4896 4.30636 12.7719 4.36211C13.2276 4.3815 13.6857 4.50027 14.1389 4.48815C14.1438 4.48815 14.1462 4.48815 14.1511 4.48815C16.2235 3.47254 18.1917 3.23984 19.5515 3.23984C19.5733 3.23984 19.5975 3.23984 19.6193 3.23984C19.7236 3.23984 19.823 3.24227 19.9223 3.24469C17.7263 2.25089 15.4624 1.6425 13.07 1.5722C12.9391 1.63765 12.8058 1.70794 12.6701 1.78551C11.6326 2.36482 10.2583 3.34165 9.04393 4.87355H9.0415Z" fill="white"/>
                                                                                <path d="M5.0179 7.43103C5.2409 5.49191 5.8905 3.9382 6.46496 2.89835C6.47951 2.87169 6.49405 2.84502 6.51102 2.81836C6.37043 2.8838 6.22742 2.94925 6.08684 3.01954C4.27377 3.9285 2.77338 5.15257 1.68506 6.8396C1.85958 7.96186 2.26194 9.49134 3.17575 11.079C3.47389 9.61253 4.10895 8.41271 5.0179 7.43103Z" fill="white"/>
                                                                                <path d="M5.07322 7.37489C5.89735 6.50229 6.93719 5.79936 8.14429 5.23217C8.40849 5.10613 8.67997 5.0019 8.95387 4.90494C10.1828 3.33184 11.5886 2.33319 12.6454 1.74419C12.7545 1.68359 12.8612 1.62542 12.9678 1.56967C12.7909 1.56482 12.6164 1.56482 12.437 1.56482C11.9546 1.56967 11.4723 1.67147 10.9899 1.68844C9.43622 1.74419 7.97947 2.14655 6.58331 2.78161C6.55664 2.82767 6.52998 2.87372 6.50332 2.9222C5.93855 3.94751 5.29865 5.47214 5.0708 7.37247L5.07322 7.37489Z" fill="#E92827"/>
                                                                                <path d="M63.2933 12.4263C63.063 12.7681 62.8327 13.1099 62.5952 13.4468C62.3019 13.8613 61.9383 14.2273 61.5893 14.603C61.1336 15.0926 60.6561 15.5531 60.1616 15.9919C61.5893 15.6307 62.8715 15.5774 63.829 15.6259C64.052 15.638 64.2628 15.655 64.4616 15.6743C64.5367 15.5895 64.6095 15.5022 64.6846 15.4198C65.8553 14.1352 66.7546 12.6881 67.4309 11.1077C66.9509 11.1683 66.2795 11.2847 65.5063 11.5174C64.8712 11.7089 64.1077 11.9949 63.2957 12.4239L63.2933 12.4263Z" fill="#E92827"/>
                                                                                <path d="M17.1006 45.219C17.1054 45.2578 17.1103 45.2941 17.1176 45.3329C17.3042 46.4091 17.452 47.5047 17.9102 48.5058C18.1695 49.073 18.3343 49.6862 18.6204 50.2437C19.2724 49.5432 20.048 48.5446 20.6831 47.2405C20.671 47.209 20.6589 47.1775 20.6467 47.146C20.1813 45.8347 19.9414 44.4894 19.968 43.0981C19.0155 44.0434 18.0411 44.7027 17.2581 45.1366C17.2048 45.1657 17.1539 45.1923 17.1006 45.2214V45.219Z" fill="#E92827"/>
                                                                                <path d="M39.0208 11.7336C39.2171 11.5736 39.4134 11.4161 39.6122 11.2585C40.1503 10.8344 40.7587 10.4999 41.3089 10.0854C41.7743 9.73391 42.2518 9.40426 42.7342 9.08431C42.2639 9.13521 41.8131 9.15945 41.3889 9.15945C40.509 9.15945 39.7358 9.06491 39.108 8.94857C38.7517 8.8807 38.4245 8.80313 38.1312 8.72314C37.4622 9.1958 36.7932 9.66846 36.1509 10.1751C35.4698 10.7132 34.8493 11.3264 34.1948 11.896C34.5172 11.9493 34.8808 11.9978 35.2759 12.0269C36.2479 12.0996 37.5592 12.0778 39.0232 11.7312L39.0208 11.7336Z" fill="white"/>
                                                                                <path d="M42.8209 9.02577C43.8583 8.34466 44.9297 7.72414 46.0253 7.14241C45.1551 6.99455 44.4013 6.77155 43.8002 6.54856C43.2524 6.34495 42.7846 6.1268 42.4064 5.92804C41.1145 6.69157 39.8492 7.50115 38.6203 8.37132C38.4725 8.47555 38.3246 8.57978 38.1768 8.68401C38.4604 8.76157 38.773 8.83429 39.1124 8.89973C40.0601 9.0791 41.3448 9.19787 42.8185 9.02335L42.8209 9.02577Z" fill="#E92827"/>
                                                                                <path d="M31.9307 15.614C32.75 15.5679 33.7971 15.4225 34.9484 15.0613C35.4453 14.6371 35.9519 14.2226 36.4682 13.8178C37.302 13.1634 38.1092 12.475 38.9309 11.8036C37.9226 12.0314 36.9894 12.1114 36.1919 12.1114C35.8574 12.1114 35.5471 12.0969 35.266 12.0775C34.8515 12.046 34.4758 11.9951 34.1413 11.9393C33.2129 12.7465 32.2507 13.5149 31.3587 14.3608C30.9369 14.7607 30.5224 15.168 30.1128 15.58C30.5806 15.6261 31.2035 15.6576 31.9307 15.6164V15.614Z" fill="#E92827"/>
                                                                                <path d="M20.3297 31.2118C20.0922 30.9234 19.8862 30.6471 19.7068 30.3901C19.3771 31.207 19.0523 32.0093 18.7663 32.8237C18.4609 33.6963 18.1725 34.5786 17.918 35.4682C17.9907 35.4852 18.0634 35.5021 18.1385 35.5167C18.8754 35.6742 19.8159 35.8003 20.8945 35.7857C20.8969 35.7736 20.9018 35.7639 20.9042 35.7518C21.1854 34.7459 21.5441 33.7763 21.9416 32.8261C21.2702 32.2662 20.7345 31.7015 20.3297 31.2118Z" fill="white"/>
                                                                                <path d="M18.1233 35.5646C18.0481 35.5477 17.9754 35.5307 17.9027 35.5137C17.8106 35.8337 17.7233 36.1561 17.6433 36.4784C17.3815 37.5134 17.144 38.5775 17.0858 39.6392C17.0786 39.7604 17.0761 39.8816 17.0713 40.0028C17.9245 39.8889 18.9837 39.6537 20.123 39.1859C20.2951 38.0564 20.5714 36.9438 20.8816 35.8313C20.8235 35.8313 20.7629 35.8337 20.7047 35.8337C19.7012 35.8337 18.8213 35.7101 18.1257 35.5622L18.1233 35.5646Z" fill="#E92827"/>
                                                                                <path d="M16.8609 25.4961C15.8695 25.2246 14.8927 24.9143 13.9304 24.5532C13.8214 25.5809 13.5959 26.4705 13.3584 27.1807C14.3861 27.5539 15.4284 27.8812 16.4925 28.1551C16.73 28.2181 16.9724 28.2714 17.2124 28.3247C17.2124 28.2375 17.2124 28.1502 17.2075 28.0605C17.1881 27.3528 17.096 26.4705 16.8609 25.4961Z" fill="white"/>
                                                                                <path d="M46.0929 7.106C46.9364 6.65758 47.792 6.23097 48.6525 5.81406C49.2512 5.5232 49.8572 5.25415 50.468 4.99964C49.6972 4.7427 49.0379 4.43972 48.5119 4.1537C48.0174 3.88707 47.6005 3.61802 47.2636 3.37805C46.4613 3.73436 45.6711 4.11249 44.893 4.53182C44.0713 4.9754 43.2593 5.43109 42.457 5.90375C42.8279 6.09766 43.286 6.30854 43.8193 6.5073C44.4325 6.73514 45.2009 6.96299 46.0929 7.10842V7.106Z" fill="white"/>
                                                                                <path d="M27.7104 19.747C28.5684 19.6985 29.6737 19.5434 30.8856 19.1435C31.5692 18.3896 32.2745 17.6552 32.975 16.9159C33.5689 16.2857 34.2015 15.7015 34.856 15.1416C33.7434 15.4809 32.7326 15.6191 31.9352 15.6627C31.6976 15.6749 31.4698 15.6821 31.2565 15.6821C30.796 15.6821 30.396 15.6555 30.0712 15.6215C28.8035 16.9038 27.6013 18.2515 26.479 19.6646C26.4572 19.6937 26.4354 19.7228 26.4136 19.7494C26.7917 19.7688 27.228 19.7737 27.7128 19.747H27.7104Z" fill="white"/>
                                                                                <path d="M65.0288 4.75463C65.1427 4.95097 65.247 5.16427 65.3366 5.39939C65.5645 6.00051 65.676 6.61618 65.5233 7.20519C65.4384 7.53241 65.3609 7.86206 65.2785 8.19171C66.391 7.45243 67.4697 6.99673 68.3447 6.71798C68.3447 6.5168 68.3447 6.31562 68.3398 6.11444C68.2962 4.39589 67.6369 3.007 66.4347 1.94049C66.4104 1.97685 66.3862 2.01078 66.3619 2.04957C65.9184 2.72583 65.4191 3.63964 65.0288 4.75706V4.75463Z" fill="#E92827"/>
                                                                                <path d="M22.4459 26.6959C22.2665 26.4802 22.1065 26.2717 21.9635 26.073C21.7575 26.3711 21.4884 26.5747 21.074 26.4826C20.3056 26.3129 19.5348 26.1481 18.7664 25.9736C18.1459 25.833 17.5302 25.6779 16.917 25.5106C17.1497 26.4778 17.2394 27.3552 17.2588 28.0606C17.2612 28.1527 17.2636 28.2448 17.2636 28.3345C17.9496 28.4799 18.6428 28.5962 19.3288 28.7514C19.6657 28.8265 20.0511 28.8653 20.1795 29.2119C20.0293 29.5925 19.879 29.9633 19.7287 30.3342C19.9105 30.5984 20.1214 30.882 20.3686 31.1801C20.771 31.6649 21.2994 32.2248 21.9635 32.7775C22.3562 31.8394 22.7852 30.9183 23.2142 29.9948C23.3815 29.6337 23.6457 29.5125 24.0044 29.5173C24.6225 29.527 25.2406 29.5391 25.8563 29.5488C24.2808 28.6568 23.1658 27.5588 22.4483 26.6935L22.4459 26.6959Z" fill="#E92827"/>
                                                                                <path d="M50.5368 4.97043C51.6978 4.48807 52.8807 4.06874 54.0853 3.72212C53.3824 3.28824 52.8031 2.83255 52.3498 2.42776C52.0493 2.15871 51.7875 1.89693 51.5596 1.65454C51.0555 1.82421 50.5561 2.00601 50.0593 2.20476C49.1358 2.57562 48.2195 2.9489 47.313 3.35127C47.6451 3.58638 48.0547 3.84816 48.5346 4.10994C49.0703 4.40081 49.7441 4.70865 50.5343 4.97043H50.5368Z" fill="#E92827"/>
                                                                                <path d="M12.0912 23.7922C11.5968 23.5667 11.1071 23.3316 10.6248 23.082C10.014 23.9328 9.36194 24.6139 8.77051 25.1374C9.05168 25.2901 9.3377 25.4404 9.62614 25.5834C10.8284 26.1821 12.0573 26.7057 13.3129 27.1638C13.5504 26.456 13.7758 25.564 13.8825 24.5363C13.2789 24.3085 12.6802 24.0636 12.0912 23.7946V23.7922Z" fill="#E92827"/>
                                                                                <path d="M10.5806 23.06C9.83157 22.6698 9.10441 22.2359 8.42572 21.7148C8.19303 21.5378 7.96276 21.3609 7.73491 21.1815C6.5157 21.6299 5.37404 21.8287 4.43115 21.9038C4.66869 22.1244 4.90381 22.3426 5.1365 22.5656C6.21029 23.5933 7.4295 24.4077 8.72628 25.1155C9.31771 24.5944 9.96974 23.9132 10.583 23.0625L10.5806 23.06Z" fill="white"/>
                                                                                <path d="M29.4456 26.9673C28.2119 26.9939 26.9781 27.0182 25.7443 27.04C25.5335 27.0424 25.3177 26.9649 24.9542 26.897C25.3202 26.3104 25.5844 25.8208 25.9092 25.3772C26.6485 24.3689 27.3926 23.3605 28.1561 22.3716C26.9442 22.7691 25.8389 22.9242 24.9808 22.9727C24.7433 22.9848 24.5154 22.9921 24.3021 22.9921C24.1979 22.9921 24.0961 22.9921 23.9967 22.9873C23.6404 23.4841 23.2865 23.981 22.9302 24.4755C22.5884 24.9506 22.3291 25.4863 22.0188 25.9856C22.0091 26.0002 21.9994 26.0147 21.9897 26.0292C22.1376 26.2328 22.3 26.4461 22.4818 26.6667C23.209 27.5417 24.3433 28.6567 25.9528 29.5512C26.4545 29.5584 26.9563 29.5681 27.458 29.5705C29.1184 29.5778 30.7812 29.6093 32.4391 29.5124C32.2258 29.2627 31.981 28.9937 31.695 28.7149C31.1448 28.1744 30.3958 27.5466 29.4432 26.9697L29.4456 26.9673Z" fill="white"/>
                                                                                <path d="M52.3826 2.39431C52.8407 2.80395 53.4322 3.26691 54.1496 3.70564C55.1725 3.41477 56.2099 3.17481 57.2667 2.99786C57.5382 2.95181 57.8121 2.90575 58.086 2.8597C57.5625 2.20283 57.1649 1.57019 56.8717 1.02966C56.7529 0.811511 56.6511 0.603056 56.5565 0.404297C56.319 0.447927 56.0815 0.493981 55.8463 0.540035C54.4138 0.821206 52.9983 1.17752 51.6118 1.64048C51.8324 1.87802 52.0893 2.13253 52.3826 2.39431Z" fill="white"/>
                                                                                <path d="M61.9872 2.83558C63.2161 3.09009 64.3117 3.57972 64.9952 4.70198C65.3855 3.59669 65.8799 2.69015 66.3211 2.01873C66.3453 1.97995 66.372 1.94359 66.3962 1.90481C66.1757 1.7109 65.9381 1.52668 65.6812 1.35458C64.5638 0.605602 63.2888 0.290496 61.9896 0.125671C61.9629 0.351093 61.9436 0.591059 61.929 0.847991C61.8999 1.41033 61.9023 2.08418 61.9848 2.83558H61.9872Z" fill="white"/>
                                                                                <path d="M58.1427 2.84981C59.1632 2.68498 60.1957 2.56137 61.2235 2.70438C61.4658 2.73831 61.7034 2.77709 61.9361 2.82315C61.8561 2.07659 61.8512 1.40275 61.8803 0.842826C61.8949 0.585894 61.9167 0.345928 61.9409 0.118082C61.7349 0.0914196 61.5264 0.0696045 61.3204 0.0502134C59.7352 -0.100068 58.1621 0.108387 56.606 0.391982C56.6981 0.588318 56.7999 0.791924 56.9138 1.00523C57.2095 1.5506 57.6094 2.18809 58.1403 2.84739L58.1427 2.84981Z" fill="#E92827"/>
                                                                                <path d="M28.884 79.0182C28.1689 79.9781 27.4224 80.9089 26.6516 81.8203C26.3025 82.2348 25.9195 82.625 25.5244 83.0007C25.1948 84.0939 24.9282 85.5434 25.0227 87.2207C25.7038 86.6753 26.3583 86.0984 27.0054 85.5143C27.7617 84.8307 28.4307 84.0454 29.1142 83.2843C29.1627 83.231 29.2088 83.1801 29.2572 83.1268C28.8452 81.5779 28.7967 80.1575 28.884 79.0182Z" fill="#E92827"/>
                                                                                <path d="M29.9578 77.5203C29.6281 78.0051 29.2864 78.4778 28.9373 78.948C28.8428 80.0872 28.884 81.5197 29.2961 83.0856C30.2438 82.0336 31.177 80.9719 31.9357 79.7673C32.2484 79.2704 32.5659 78.7759 32.8834 78.2838C32.1635 77.2028 31.7078 76.1435 31.4194 75.2467C30.9492 76.0151 30.4668 76.7762 29.9578 77.5252V77.5203Z" fill="white"/>
                                                                                <path d="M24.9829 22.9243C25.8531 22.8759 26.9802 22.7159 28.214 22.3014C28.3812 22.0832 28.5485 21.8651 28.7206 21.6494C29.3823 20.8107 30.0998 20.0132 30.8172 19.2182C29.6344 19.6012 28.5533 19.749 27.7122 19.7975C27.4747 19.8121 27.2468 19.8169 27.0335 19.8169C26.7984 19.8169 26.5778 19.8096 26.3767 19.7999C25.5695 20.8252 24.8011 21.8796 24.04 22.9413C24.3309 22.9486 24.646 22.9461 24.9878 22.9268L24.9829 22.9243Z" fill="#E92827"/>
                                                                                <path d="M28.1899 64.623C28.3499 64.577 28.5075 64.5285 28.6674 64.4776C30.1315 64.0074 31.6609 63.9104 33.1468 63.5735C33.3649 63.525 33.5879 63.4862 33.8109 63.4547C34.4727 62.7688 35.161 61.8937 35.75 60.8127C35.5731 60.8297 35.3986 60.849 35.2216 60.866C34.4605 60.9387 33.697 60.9824 32.9432 61.0987C32.1603 61.2199 31.3725 61.3169 30.5944 61.4623C29.877 62.8197 28.9947 63.8595 28.1948 64.6206L28.1899 64.623Z" fill="#E92827"/>
                                                                                <path d="M25.4531 83.0686C24.9805 83.5171 24.4884 83.9485 24.0036 84.3824C23.3783 84.9423 22.6972 85.4416 22.0185 85.9385C21.8536 86.0597 21.6888 86.1761 21.5216 86.2876C21.0635 87.2256 20.5859 88.52 20.3848 90.0858C21.4319 89.5913 22.4475 89.0241 23.4316 88.3794C23.9673 88.0279 24.4787 87.6498 24.9732 87.2571C24.8738 85.5992 25.1307 84.1618 25.4531 83.0662V83.0686Z" fill="white"/>
                                                                                <path d="M18.3253 87.9259C17.998 88.0423 17.666 88.1538 17.3363 88.2628C16.677 89.0676 15.9208 90.2092 15.3633 91.6757C16.3231 91.443 17.3194 91.3097 18.2429 90.9776C18.9555 90.7207 19.6511 90.4322 20.3347 90.1123C20.531 88.5683 20.994 87.2836 21.4448 86.3407C20.4728 86.9927 19.4354 87.5308 18.3277 87.9259H18.3253Z" fill="#E92827"/>
                                                                                <path d="M47.7996 65.5316C48.4929 66.0309 49.0867 66.6005 49.5715 67.2477C50.3544 67.3641 51.2755 67.4198 52.2887 67.3447C52.1699 66.9835 52.0124 66.632 51.8185 66.3024C51.1349 65.1365 50.2357 64.2033 49.1691 63.4664C48.3159 64.0869 47.4676 64.5378 46.6968 64.8626C47.0749 65.0589 47.4433 65.2795 47.7996 65.534V65.5316Z" fill="white"/>
                                                                                <path d="M33.7144 71.2138C33.6078 71.4174 33.4939 71.6162 33.3872 71.8198C34.0029 72.4258 34.7809 73.0633 35.736 73.628C36.2813 72.6536 36.8049 71.6671 37.3139 70.6733C37.4957 70.3194 37.6678 69.9607 37.8375 69.5995C36.7201 69.3789 35.7626 69.0275 34.9991 68.6736C34.5822 69.5268 34.158 70.3752 33.7169 71.2162L33.7144 71.2138Z" fill="white"/>
                                                                                <path d="M35.0181 68.6274C35.7792 68.9838 36.7366 69.3328 37.8564 69.5534C38.2103 68.7971 38.5448 68.0312 38.8939 67.2725C39.255 66.4847 39.6234 65.7018 39.9773 64.9116C38.62 65.5273 37.3377 65.8085 36.3173 65.9272C35.8882 66.8289 35.4568 67.7306 35.0181 68.6274Z" fill="#E92827"/>
                                                                                <path d="M52.5408 69.2285C52.5408 69.1291 52.5408 69.0298 52.5408 68.9304C52.5481 68.3971 52.4633 67.8833 52.3057 67.3936C51.9858 67.4179 51.6731 67.43 51.3725 67.43C50.7326 67.43 50.1412 67.3791 49.6104 67.304C50.0151 67.8518 50.3375 68.4577 50.5775 69.117C51.2319 69.1388 51.8864 69.1776 52.5408 69.2285Z" fill="#E92827"/>
                                                                                <path d="M31.4526 75.1864C31.7387 76.0833 32.1919 77.1474 32.9118 78.2357C33.6075 77.1546 34.3056 76.076 34.9624 74.9707C35.2194 74.5417 35.4666 74.1054 35.7114 73.6691C34.7588 73.1043 33.9783 72.4668 33.3627 71.8633C32.7567 72.988 32.1216 74.0957 31.4526 75.1864Z" fill="#E92827"/>
                                                                                <path d="M9.56688 74.2506C10.6916 73.0969 11.952 72.0934 13.2682 71.1602C13.5348 70.2536 13.7626 69.1047 13.7723 67.7837C12.3592 68.5957 11.0018 69.4901 9.7414 70.513C9.89653 71.9819 9.76079 73.2714 9.56445 74.2506H9.56688Z" fill="white"/>
                                                                                <path d="M5.49054 81.4396C5.71838 80.155 6.18377 78.9891 6.80671 77.8935C6.53766 77.0354 6.10136 75.9835 5.40085 74.9024C4.71005 75.7483 4.19133 76.7082 3.70413 77.6802C3.43266 78.2231 3.21693 78.7903 3.03271 79.3696C4.07741 80.0386 4.88699 80.7828 5.48811 81.4396H5.49054Z" fill="white"/>
                                                                                <path d="M17.4158 68.6267C17.8981 67.7347 18.3732 66.593 18.6496 65.2357C17.074 65.9992 15.5106 66.7918 13.9884 67.6571C13.9327 67.6886 13.8793 67.7226 13.8236 67.7541C13.8139 69.063 13.5957 70.2071 13.3315 71.1136C14.6356 70.1925 15.993 69.3514 17.4134 68.6267H17.4158Z" fill="#E92827"/>
                                                                                <path d="M42.7451 63.6051C44.0976 63.8668 45.4235 64.2134 46.6427 64.8315C47.4159 64.5092 48.2692 64.0607 49.1272 63.4378C48.56 63.05 47.9516 62.7131 47.2972 62.4319C46.4367 62.061 45.5617 61.7411 44.6673 61.4866C44.0322 62.3761 43.3535 63.0766 42.7451 63.6075V63.6051Z" fill="#E92827"/>
                                                                                <path d="M19.3038 67.7496C20.1837 67.3836 21.0587 66.9982 21.9386 66.6274C22.69 65.8226 23.5771 64.6495 24.2413 63.0958C23.7153 63.2727 23.1917 63.4618 22.6657 63.646C21.6332 64.0096 20.5691 64.3174 19.585 64.7852C19.2917 64.9258 18.9984 65.0688 18.7051 65.2094C18.4361 66.5547 17.9707 67.6915 17.4932 68.5859C18.0846 68.2853 18.6881 68.0041 19.3038 67.7472V67.7496Z" fill="white"/>
                                                                                <path d="M15.5617 88.808C15.1739 88.9219 14.7643 88.9656 14.3619 89.0213C13.6493 89.1207 12.9367 89.1813 12.2289 89.1862C11.3854 89.7776 10.4013 90.6284 9.51172 91.7967C9.80016 91.8476 10.0935 91.8864 10.3916 91.9106C12.0204 92.0439 13.6808 92.0706 15.3048 91.6876C15.8502 90.2381 16.5943 89.1013 17.2488 88.2893C16.6888 88.4711 16.1265 88.6408 15.5617 88.8056V88.808Z" fill="white"/>
                                                                                <path d="M24.2608 65.713C25.5067 65.2743 26.8156 65.0174 28.0882 64.6514C28.8977 63.8951 29.797 62.848 30.529 61.4736C30.0321 61.5682 29.5352 61.6821 29.0456 61.8372C27.8627 62.2105 26.6217 62.3947 25.4243 62.7244C25.0462 62.8286 24.6729 62.9474 24.3021 63.071C23.6549 64.6005 22.7895 65.7639 22.0454 66.5784C22.7774 66.2705 23.5143 65.9748 24.2608 65.713Z" fill="#E92827"/>
                                                                                <path d="M12.147 89.1864C11.1048 89.1864 10.0698 89.0628 9.05901 88.7331C8.62029 88.5901 8.2155 88.4011 7.84222 88.1732C6.98901 88.3865 5.97825 88.7356 4.92871 89.3076C5.03294 89.4118 5.13717 89.5185 5.24139 89.6227C6.43879 90.8007 7.88101 91.4964 9.45896 91.7872C10.3388 90.6286 11.3084 89.7827 12.147 89.1864Z" fill="#E92827"/>
                                                                                <path d="M5.37927 82.2522C5.40351 81.9977 5.43986 81.7481 5.48107 81.5033C4.88237 80.844 4.07037 80.095 3.02082 79.4211C2.86569 79.918 2.7348 80.4246 2.61846 80.9337C2.32274 82.2256 2.24276 83.5054 2.49969 84.7998C2.50454 84.8288 2.51181 84.8579 2.51908 84.887C3.71648 84.9258 4.76845 85.1391 5.62893 85.3936C5.28473 84.378 5.27989 83.3527 5.38169 82.2547L5.37927 82.2522Z" fill="#E92827"/>
                                                                                <path d="M5.82238 85.895C5.75451 85.7447 5.69392 85.5969 5.64302 85.4466C4.78496 85.1897 3.73057 84.9739 2.52832 84.9327C2.86282 86.5398 3.47364 88.0111 4.7486 89.1358C4.79708 89.1794 4.84313 89.2279 4.89161 89.2739C5.93146 88.7043 6.93252 88.3528 7.78331 88.1371C6.94464 87.6136 6.27323 86.8791 5.82238 85.895Z" fill="white"/>
                                                                                <path d="M22.4365 54.3282C23.0789 54.8009 23.7648 55.2226 24.475 55.5499C25.3185 55.9377 26.1935 56.2286 27.0855 56.4491C27.0274 55.6056 26.865 54.5585 26.4893 53.4193C25.2555 52.9175 24.1454 52.2025 23.1807 51.2256C23.0619 52.3358 22.8098 53.2835 22.5529 54.0131C22.5141 54.1198 22.4753 54.224 22.4365 54.3258V54.3282Z" fill="#E92827"/>
                                                                                <path d="M48.9269 42.7304C48.9899 42.5946 49.0602 42.4638 49.1329 42.3329C48.7694 42.3644 48.4155 42.3789 48.0737 42.3789C47.4217 42.3789 46.8181 42.3256 46.2727 42.2456C45.7831 43.203 45.3299 44.1823 44.9008 45.1712C44.7166 45.593 44.5372 46.0148 44.353 46.4365C45.422 46.1602 46.6994 45.6778 47.9889 44.8367C48.2943 44.1314 48.5997 43.4236 48.9245 42.728L48.9269 42.7304Z" fill="white"/>
                                                                                <path d="M54.0968 39.5935C54.0823 39.6347 54.0726 39.6783 54.058 39.7195C53.4957 41.2708 52.6498 42.667 51.5493 43.8935C51.3942 44.0656 51.2342 44.2328 51.0767 44.4049C52.4122 43.7383 53.6726 43.4135 54.6301 43.2608C54.8579 43.2245 55.0761 43.1954 55.2845 43.1736C55.2966 43.1542 55.3088 43.1372 55.3185 43.1178C56.1765 41.678 57.02 40.2382 57.2091 38.5633C57.2576 38.1464 57.2576 37.7562 57.2164 37.3926C56.7995 37.5962 56.2759 37.8822 55.7014 38.2773C55.2191 38.6094 54.6616 39.0433 54.0944 39.5935H54.0968Z" fill="white"/>
                                                                                <path d="M46.377 48.7073C46.3649 48.6977 46.3504 48.688 46.3382 48.6783C46.8182 47.5584 47.2957 46.4386 47.7805 45.3212C47.8386 45.1854 47.8968 45.0521 47.955 44.9164C46.6655 45.7478 45.3929 46.2229 44.3288 46.4943C43.7156 47.9075 43.1023 49.3206 42.494 50.7361C42.38 51.0003 42.2346 51.2355 42.0625 51.4488C43.2866 50.9931 44.8912 50.169 46.3746 48.7049L46.377 48.7073Z" fill="#E92827"/>
                                                                                <path d="M49.1609 42.2793C49.3039 42.0297 49.4566 41.7849 49.6021 41.5401C49.9875 40.8977 50.3753 40.253 50.8116 39.647C49.9681 39.2543 49.2433 38.7986 48.6301 38.3405C48.3271 38.7744 48.0338 39.218 47.7478 39.6615C47.217 40.4832 46.7395 41.334 46.2935 42.2018C47.1273 42.323 48.0944 42.3763 49.1585 42.2818L49.1609 42.2793Z" fill="#E92827"/>
                                                                                <path d="M51.61 38.6602C51.9566 38.2821 52.3639 37.9597 52.822 37.727C52.4584 36.789 52.2427 35.8897 52.1215 35.0729C51.2464 35.4559 50.4926 36.0933 49.826 36.8229C49.4043 37.2835 49.0213 37.7852 48.6602 38.2991C49.2734 38.7572 49.9981 39.2129 50.8441 39.6056C51.0816 39.2783 51.3337 38.9608 51.61 38.6602Z" fill="white"/>
                                                                                <path d="M53.2364 37.5451C53.9369 37.2881 54.3684 37.5693 54.332 38.3013C54.3126 38.6988 54.2448 39.1085 54.1284 39.4939C54.6762 38.9703 55.2095 38.5558 55.6773 38.2359C56.259 37.8359 56.7947 37.5451 57.214 37.3415C57.008 35.7078 55.8882 34.6946 53.92 34.6946C53.2849 34.6946 52.7056 34.8255 52.1699 35.0533C52.2887 35.8702 52.5044 36.7694 52.868 37.7075C52.9868 37.6493 53.1104 37.5936 53.2364 37.5475V37.5451Z" fill="#E92827"/>
                                                                                <path d="M38.6836 55.7758C39.1854 55.6279 39.6774 55.4461 40.1767 55.2934C40.3076 55.2546 40.4531 55.2643 40.7051 55.2425C40.5888 55.5406 40.4797 55.8218 40.3731 56.0981C40.6397 56.0181 40.9233 55.926 41.2263 55.8097C42.094 55.48 43.2042 54.9419 44.3264 54.0839C44.3458 54.0354 44.3652 53.9893 44.3822 53.9409C44.6149 53.3519 44.9857 52.8913 45.5263 52.5423C46.3189 52.0308 47.1139 51.5145 47.8532 50.9352C48.8155 50.179 49.7535 49.3888 50.6504 48.5574C51.1133 48.1284 51.5787 47.6921 52.0247 47.2412C50.8443 47.1612 49.3851 47.234 47.8023 47.6921C47.3757 48.0653 46.9418 48.4338 46.5176 48.8095C46.4837 48.7852 46.4498 48.7586 46.4158 48.7343C44.8912 50.2372 43.243 51.071 42.0019 51.5218C41.8201 51.7327 41.6117 51.9169 41.3741 52.0696C40.9742 52.329 40.5112 52.5035 40.0555 52.6586C38.863 53.0707 37.6801 53.5288 36.4585 53.8415C36.7784 54.0572 37.0669 54.2729 37.3141 54.4741C37.9056 54.9541 38.3612 55.4146 38.6788 55.7709L38.6836 55.7758Z" fill="white"/>
                                                                                <path d="M40.3506 56.1535C40.1179 56.7546 39.8997 57.3169 39.6816 57.8744C39.4295 58.5168 39.1847 59.164 38.9181 59.8014C38.8453 59.9735 38.7654 60.1359 38.6611 60.2717C39.0732 60.1747 39.5652 60.0317 40.1106 59.8281C40.8135 59.5615 41.6764 59.1615 42.5733 58.5653C42.6702 58.3059 42.7672 58.049 42.8666 57.792C43.3344 56.5825 43.8143 55.3803 44.2894 54.1732C43.1841 55.007 42.0958 55.533 41.2401 55.8578C40.925 55.9765 40.6269 56.0759 40.3482 56.1559L40.3506 56.1535Z" fill="#E92827"/>
                                                                                <path d="M50.9796 44.5089C50.2694 45.2821 49.5447 46.0432 48.7957 46.7801C48.5024 47.0686 48.1946 47.3449 47.8867 47.6188C49.4574 47.1776 50.8996 47.1146 52.0704 47.197C52.4533 46.8092 52.8218 46.4117 53.1611 45.9899C53.8834 45.0931 54.6397 44.2253 55.2529 43.2267C55.0566 43.2485 54.853 43.2752 54.6372 43.3091C53.6556 43.4666 52.3564 43.8036 50.982 44.5089H50.9796Z" fill="#E92827"/>
                                                                                <path d="M30.6142 57.0044C31.4528 57.0722 32.2915 57.048 33.1229 56.9729C32.9896 56.7014 32.832 56.4081 32.6478 56.0978C32.3618 55.6203 31.9861 55.0701 31.5086 54.5005C30.4154 54.4496 29.3392 54.229 28.2751 53.9818C27.6764 53.8436 27.102 53.6642 26.5493 53.4437C26.9202 54.578 27.0801 55.6227 27.1359 56.4614C28.2727 56.7402 29.4386 56.9074 30.6142 57.0044Z" fill="white"/>
                                                                                <path d="M33.1759 56.9682C33.9273 56.8979 34.6739 56.7888 35.418 56.6676C36.5088 56.4883 37.5656 56.1005 38.6321 55.7902C38.3146 55.4363 37.8662 54.9855 37.2868 54.5152C37.0299 54.3068 36.7318 54.0838 36.3997 53.8608C35.9198 53.982 35.435 54.0814 34.9381 54.1444C34.2303 54.2341 33.5322 54.3989 32.8245 54.4716C32.4051 54.5152 31.9907 54.5201 31.5762 54.5055C32.044 55.0655 32.4124 55.6036 32.6936 56.0762C32.8826 56.3913 33.0426 56.6919 33.1784 56.9706L33.1759 56.9682Z" fill="#E92827"/>
                                                                                <path d="M38.6084 60.3321C38.4582 60.4969 38.257 60.6084 37.954 60.6229C37.2365 60.6569 36.5215 60.7344 35.8064 60.8096C35.2247 61.8833 34.546 62.7584 33.8867 63.4468C34.5436 63.3595 35.2126 63.3304 35.8695 63.2553C36.0973 63.2286 36.3203 63.1704 36.5481 63.1632C36.7881 63.1535 37.0305 63.1874 37.4426 63.2141C37.1541 63.9655 36.9651 64.5739 36.6912 65.1459C36.5748 65.3883 36.4585 65.6331 36.3421 65.8779C37.365 65.7567 38.6497 65.4683 40.007 64.8453C40.1234 64.5836 40.2397 64.3218 40.3512 64.0576C40.5791 63.5243 40.9354 63.3086 41.4929 63.3959C41.7934 63.4419 42.0964 63.4831 42.3946 63.5389C42.4891 63.5558 42.586 63.5752 42.6806 63.5922C43.289 63.0638 43.9725 62.3609 44.6124 61.4689C43.8634 61.258 43.1023 61.0907 42.3218 60.9841C42.1376 60.9598 41.9728 60.812 41.7716 60.7078C42.0382 59.9976 42.2879 59.314 42.5424 58.6378C41.6601 59.2171 40.8142 59.6097 40.1234 59.8715C39.5489 60.0872 39.0302 60.2351 38.606 60.3321H38.6084Z" fill="white"/>
                                                                                <path d="M64.2819 10.8971C63.9813 11.3843 63.6686 11.8643 63.3511 12.3418C64.1388 11.9321 64.8757 11.6558 65.4914 11.4716C66.284 11.2341 66.9675 11.1153 67.4523 11.0571C67.5735 10.7711 67.6874 10.4851 67.7941 10.1918C68.194 9.08164 68.3322 7.93514 68.3443 6.77167C67.4644 7.05526 66.3785 7.51823 65.2611 8.26721C65.0357 9.17859 64.7836 10.0851 64.2819 10.8971Z" fill="white"/>
                                                                                <defs>
                                                                                <pattern id="pattern0_2639_40882" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                                                <use xlink:href="#image0_2639_40882" transform="scale(0.0126582 0.0128205)"/>
                                                                                </pattern>
                                                                                <pattern id="pattern1_2639_40882" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                                                <use xlink:href="#image1_2639_40882" transform="scale(0.0126582 0.012987)"/>
                                                                                </pattern>
                                                                                <image id="image0_2639_40882" width="79" height="78" preserveAspectRatio="none" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAE8AAABOCAYAAABhaEsjAAAACXBIWXMAAAsSAAALEgHS3X78AAAAwklEQVR4nO3VsWnEUBAE0BE4VA9XgPpxIe7oQgcO3YB7uAJUg5WPA8lwHDhwpG/8Hiz8cBnmswkAAAAAAAAAAAAA/HvT2QvcazsnuSSZk2xJ1mmatnO3+tnT2Qs8uCR5SbIkWZO8tb1l0BBHCy/ZW7fczS3Jte3HaAGOFt6a5Hq8l+xN/P7GGTHAobSd2y5tn9u+t/085rXtcvZ+90ZrXo5m3dqu2Y/Glr19wzVuqGv76K9dXwAAAAAAAAAAAACA3/gCNsdF9uLNGZIAAAAASUVORK5CYII="/>
                                                                                <image id="image1_2639_40882" width="79" height="77" preserveAspectRatio="none" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAE8AAABNCAYAAADn/DmNAAAACXBIWXMAAAsSAAALEgHS3X78AAAAwElEQVR4nO3VsU0DMRgF4GcJieZ2yADXZgpa5qOgzBqZgQyQGUj/KO6QIhrKGPF9kiW7+/X0bCcAAAAAAAAAAAAA8O+NRw9wr+2S5LAfr2OM2yPn+VParm3f2p7avuxhTuvp0QP8sCRZ97UkWdpeooW/25t3avu5r4+ZWzhb865J3vf9mu39O2RrYdqeZ2rgVOGNMW5tz9lCXJO8ZgvvOckxySXJNOFN9dveu/t5v6/rLd4+AAAAAAAAAAAAAJjNFw3ATUX+NmUmAAAAAElFTkSuQmCC"/>
                                                                                </defs>
                                                                            </svg>
                                                                        </div>
                                                                         <div class="d-flex flex-column">
                                                                                <h2 id="product_name_en_${index}" class="product_name" style="font-family: 'DM Sans', sans-serif; Font-weight: 700;font-size:8px;">${product.product_name}</h2>

                                                                         </div>
                                                                        <ul>
                                                                            <li id="vegan_${index}" style="display: ${product.vegan == 1 ? 'flex' : 'none'};">
                                                                                <svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                    <path d="M6.82844 2.02119C6.07294 1.26569 5.06844 0.849609 4 0.849609C2.93156 0.849609 1.92708 1.26569 1.17158 2.02119C0.416078 2.77669 0 3.78117 0 4.84961C0 5.91805 0.416078 6.92253 1.17158 7.67803C1.92708 8.43353 2.93156 8.84961 4 8.84961C5.06844 8.84961 6.07294 8.43353 6.82844 7.67803C7.58392 6.92253 8 5.91805 8 4.84961C8 3.78117 7.58392 2.77669 6.82844 2.02119ZM0.46875 4.84961C0.46875 3.90637 0.836062 3.01961 1.50303 2.35264C2.17 1.68567 3.05677 1.31836 4 1.31836C4.86467 1.31836 5.68175 1.62723 6.3257 2.19245L5.68369 2.83447C5.6667 2.77095 5.64728 2.70738 5.62509 2.64345C5.50178 2.28831 5.1993 2.05884 4.85447 2.05884C4.41889 2.05884 4.06452 2.4132 4.06452 2.84878V4.59702C4.04311 4.59658 3.87387 4.59812 3.81273 4.60188L3.57359 3.59441C3.49495 3.25478 3.25377 2.97744 2.9283 2.85245C2.60312 2.72758 2.23869 2.77202 1.95308 2.97127L1.52997 3.25884C1.16606 3.50617 1.06677 4.00644 1.30859 4.37402C1.54809 4.73805 2.01042 4.87302 2.44241 4.5992L2.66586 5.02591C2.40813 5.26586 2.27292 5.596 2.27292 5.99144C2.27292 6.07195 2.27859 6.15117 2.28931 6.2288L1.34284 7.17527C0.777625 6.53136 0.46875 5.71428 0.46875 4.84961ZM4.22875 6.12273L4 6.35148L3.77125 6.12273L3.4398 6.45419L3.76562 6.78003V7.22758C3.18345 7.11741 2.74169 6.60522 2.74169 5.9915C2.74169 5.67933 2.8517 5.45134 3.07802 5.2945C3.29477 5.1443 3.61358 5.06489 4 5.06489C4.38641 5.06489 4.70523 5.14428 4.92198 5.2945C5.1483 5.45133 5.2583 5.67933 5.2583 5.9915C5.2583 6.60522 4.81653 7.11742 4.23436 7.22758V6.78003L4.56019 6.4542L4.22875 6.12273ZM2.62722 3.9417L2.16092 4.22148C2.0035 4.31594 1.80113 4.2698 1.7002 4.11641C1.5983 3.96153 1.64014 3.75075 1.79347 3.64655L2.21781 3.35812L2.22047 3.3563C2.38081 3.24405 2.57756 3.21992 2.76027 3.29008C2.94297 3.36023 3.07302 3.50986 3.11703 3.70056L3.34781 4.67286C3.24614 4.69898 3.15039 4.73163 3.06133 4.77067L2.62722 3.9417ZM5.11716 4.39119L4.97336 4.78661C4.84128 4.72498 4.6938 4.67784 4.53325 4.64594V2.84881C4.53325 2.6717 4.67734 2.52762 4.85445 2.52762C4.96248 2.52762 5.11317 2.59823 5.18225 2.79722C5.35431 3.29277 5.33545 3.75472 5.11716 4.39119ZM6.49697 7.34658C5.83 8.01355 4.94323 8.38086 4 8.38086C3.13533 8.38086 2.31825 8.07198 1.6743 7.50677L2.44286 6.7382C2.72187 7.31767 3.315 7.71855 4 7.71855C4.9523 7.71855 5.72706 6.94378 5.72706 5.99148C5.72706 5.61577 5.60506 5.29895 5.37183 5.06248L5.55842 4.54936L5.55983 4.54539C5.70375 4.12636 5.77198 3.76161 5.76598 3.41509L6.65716 2.52392C7.22238 3.16786 7.53125 3.98494 7.53125 4.84961C7.53125 5.79284 7.16394 6.67961 6.49697 7.34658Z" fill="#E92827"/>
                                                                                </svg>
                                                                                <span>Vegan</span>
                                                                            </li>
                                                                            <li id="palm_${index}" style="display: ${product.palm_oil == 1 ? 'flex' : 'none'};">
                                                                                <svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4 0.849609C6.20914 0.849609 8 2.64047 8 4.84961C8 7.05875 6.20914 8.84961 4 8.84961C1.79086 8.84961 0 7.05875 0 4.84961C1.61064e-08 2.64047 1.79086 0.849609 4 0.849609ZM5.66309 3.44336C5.72004 3.49615 5.77567 3.55167 5.82715 3.60938L5.85352 3.64844C5.87231 3.69073 5.87003 3.74022 5.84766 3.78125L5.81934 3.81738C5.7864 3.84852 5.74049 3.8641 5.69434 3.85742L5.69336 3.85645C5.59915 3.84174 5.48041 3.84186 5.3623 3.84961C5.54698 4.04755 5.69917 4.35215 5.74609 4.7002L5.75586 4.79004V4.81445C5.75101 4.87044 5.71416 4.92165 5.65918 4.94238C5.59732 4.96544 5.5271 4.94467 5.4873 4.8916L5.38477 4.76562C5.34987 4.72622 5.31426 4.68869 5.27832 4.65332C5.2826 4.87309 5.21579 5.12413 5.05566 5.36816L5.00781 5.43652C4.9689 5.48937 4.90023 5.51021 4.83887 5.48926C4.77815 5.46736 4.73522 5.40768 4.73828 5.34082C4.75149 5.02761 4.68329 4.81684 4.57227 4.6084C4.4937 5.0292 4.46592 5.59171 4.49414 5.98145C4.94299 6.15295 5.27042 6.39062 5.35059 6.4375C5.4103 6.4719 5.43578 6.5408 5.41895 6.60449C5.40096 6.66941 5.34199 6.71582 5.27441 6.71582H2.16016L1.5 7.37598C2.14236 8.01167 3.02487 8.40527 4 8.40527C5.96368 8.40527 7.55566 6.81329 7.55566 4.84961C7.55566 3.93336 7.20885 3.09819 6.63965 2.46777L5.66309 3.44336ZM4 1.29395C2.03632 1.29395 0.444336 2.88593 0.444336 4.84961C0.444336 5.67788 0.728258 6.43953 1.20312 7.04395L1.68848 6.55859C1.69105 6.5092 1.71802 6.46242 1.7627 6.43652C1.82592 6.39912 2.03094 6.25344 2.32617 6.1084C2.22318 5.89438 2.11419 5.62894 2.07031 5.37793L2.05371 5.25781L2.0498 5.13965C2.05352 4.87603 2.15139 4.69243 2.25879 4.57129C2.37499 4.44031 2.4995 4.38536 2.51855 4.37793C2.54427 4.368 2.57116 4.36581 2.59668 4.37012L2.62207 4.37695H2.62402L2.65527 4.39062C2.77235 4.44372 3.16704 4.66266 3.2168 5.23145L3.22168 5.3125C3.22605 5.46749 3.20455 5.64048 3.16211 5.8291C3.28863 5.80747 3.4212 5.79492 3.55762 5.79492C3.61586 5.79494 3.67314 5.79826 3.72949 5.80273C3.76467 5.42186 3.82057 4.97311 3.90918 4.58984C3.78959 4.73281 3.68196 4.911 3.58984 5.12012L3.58887 5.12109C3.56214 5.17944 3.50004 5.21733 3.43262 5.20801C3.36711 5.19889 3.31484 5.14776 3.30469 5.08203L3.28027 4.87598C3.26301 4.66745 3.26956 4.45386 3.32324 4.27051C3.35937 4.14734 3.41854 4.03412 3.50879 3.94531C3.52935 3.9251 3.55176 3.90579 3.5752 3.88867C3.43761 3.87666 3.2919 3.8859 3.13965 3.91699C3.07804 3.92971 3.01586 3.90124 2.9834 3.84863L2.96484 3.80566C2.95414 3.76212 2.96407 3.71563 2.99121 3.67969L3.0459 3.61133C3.17738 3.45529 3.33641 3.31719 3.51074 3.23633C3.64364 3.17478 3.78694 3.14689 3.93262 3.16895C3.84799 3.02994 3.75099 2.9047 3.63965 2.79199L3.6123 2.75488C3.59193 2.71454 3.59087 2.66616 3.61035 2.62402L3.62207 2.60352C3.64469 2.57027 3.68018 2.54704 3.71973 2.54004L3.75977 2.53906C4.01795 2.5631 4.26217 2.62827 4.44531 2.76074C4.59267 2.8674 4.69616 3.01512 4.7373 3.20801C4.7959 3.17167 4.85746 3.14709 4.9209 3.13477C5.03331 3.11304 5.14569 3.12911 5.25195 3.16895C5.26511 3.17388 5.27795 3.17988 5.29102 3.18555L6.32129 2.15723C5.69835 1.61967 4.88737 1.29395 4 1.29395ZM3.55664 6.09473C3.09852 6.09476 2.68197 6.25891 2.37891 6.41699H4.73438C4.43131 6.25892 4.01474 6.09475 3.55664 6.09473ZM2.5752 4.68555C2.53893 4.70934 2.48943 4.74918 2.44629 4.81055C2.38613 4.89633 2.33398 5.02998 2.35156 5.23242L2.36523 5.33301C2.40339 5.54761 2.50164 5.78674 2.59961 5.98828C2.67416 5.95931 2.75267 5.93251 2.83398 5.9082C2.906 5.64893 2.93305 5.43119 2.91797 5.25879L2.89941 5.13477C2.83731 4.86655 2.66538 4.73693 2.5752 4.68555ZM4.13184 2.92676C4.24356 3.09384 4.33748 3.27832 4.41406 3.4834L4.4209 3.50879C4.43181 3.56979 4.40353 3.63305 4.34766 3.66504L4.30371 3.68164C4.25884 3.69069 4.21104 3.67885 4.17578 3.64844L4.15723 3.62891C4.04038 3.4835 3.90509 3.4443 3.76758 3.46875C3.68271 3.48393 3.59318 3.52449 3.50586 3.58594C3.77416 3.59362 4.02557 3.66538 4.25488 3.80176C4.31659 3.83818 4.34428 3.91399 4.31836 3.98242C4.31111 4.00163 4.29954 4.01808 4.28613 4.03223L4.29785 4.04102L4.31445 4.05859C4.3492 4.10148 4.35663 4.15973 4.33594 4.20996C4.2022 4.5248 4.09404 5.08724 4.02441 5.84473C4.08037 5.85575 4.13489 5.86967 4.18848 5.88379C4.17757 5.63579 4.18388 5.34277 4.20898 5.05957C4.23835 4.72868 4.29218 4.40308 4.37402 4.17383L4.39453 4.13672C4.41867 4.10338 4.45582 4.08017 4.49805 4.0752C4.54206 4.07014 4.58482 4.0849 4.61523 4.1123L4.64258 4.14453L4.7832 4.37598C4.86016 4.50884 4.92357 4.64083 4.96875 4.78906C4.99822 4.59316 4.95343 4.43184 4.87402 4.34863L4.84473 4.30371C4.82443 4.25538 4.83054 4.19797 4.86426 4.1543C4.90879 4.09655 4.98916 4.07902 5.05371 4.11426L5.12402 4.1543C5.185 4.19111 5.24481 4.23338 5.30273 4.27832C5.26915 4.21563 5.23267 4.15872 5.19434 4.11035C5.09389 3.98367 4.99324 3.92115 4.92871 3.91016L4.92773 3.90918C4.86021 3.89717 4.8078 3.84103 4.80371 3.77051C4.80082 3.70181 4.84485 3.63754 4.91211 3.61816L5.05273 3.58594C5.13785 3.57013 5.2338 3.55948 5.33105 3.55273C5.19851 3.45484 5.09492 3.42077 5.01465 3.4248C4.9088 3.43015 4.8122 3.50312 4.72168 3.6582C4.68532 3.71975 4.60975 3.74761 4.54199 3.72363C4.47359 3.69913 4.43227 3.62871 4.44434 3.55762L4.45508 3.47852C4.47146 3.30286 4.43342 3.17543 4.35742 3.08301C4.30518 3.01954 4.23002 2.96775 4.13184 2.92676ZM4.05469 4.06445C3.96918 4.0583 3.8997 4.06739 3.84375 4.08594C3.76957 4.11057 3.71354 4.15395 3.67188 4.21582C3.61999 4.29301 3.58854 4.40068 3.57617 4.53418C3.71602 4.33635 3.87725 4.17716 4.05469 4.06445Z" fill="#E92827"/>
                                                                                </svg>
                                                                                <span>Palm Oil Free</span>
                                                                            </li>
                                                                            <li id="gelatine_${index}" style="display: ${product.gelatin_free == 1 ? 'flex' : 'none'};">
                                                                                <svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4 0.849609C6.20914 0.849609 8 2.64047 8 4.84961C8 7.05875 6.20914 8.84961 4 8.84961C1.79086 8.84961 0 7.05875 0 4.84961C1.61064e-08 2.64047 1.79086 0.849609 4 0.849609ZM5.20703 3.89941C5.33012 4.01893 5.4136 4.18836 5.43262 4.37988L5.43359 4.38086L5.55469 5.60254H5.90039C5.95776 5.6026 6.0095 5.63455 6.04004 5.68359L6.05859 5.72266C6.06774 5.7495 6.0711 5.77829 6.06836 5.80664L6.05957 5.84863L5.81055 6.61426C5.78754 6.68502 5.72556 6.73728 5.65137 6.7373H2.15137C2.14782 6.7373 2.14412 6.73559 2.14062 6.73535L1.5 7.37598C2.14236 8.01167 3.02487 8.40527 4 8.40527C5.96368 8.40527 7.55566 6.81329 7.55566 4.84961C7.55566 3.93336 7.20885 3.09819 6.63965 2.46777L5.20703 3.89941ZM4 1.29395C2.03632 1.29395 0.444336 2.88593 0.444336 4.84961C0.444336 5.67788 0.728258 6.43953 1.20312 7.04395L1.90332 6.34277L1.74316 5.84863C1.72543 5.79373 1.73251 5.73235 1.7627 5.68359L1.78906 5.65039C1.81918 5.6207 1.85918 5.60255 1.90234 5.60254H2.24805L2.36914 4.38086L2.37891 4.31055C2.44163 3.97128 2.70956 3.7168 3.03223 3.7168H3.52246C3.498 3.65772 3.48341 3.59235 3.4834 3.52344C3.48344 3.31975 3.60315 3.14304 3.77344 3.08203C3.87478 2.80916 4.06849 2.58321 4.35254 2.58301C4.45055 2.58305 4.52148 2.67081 4.52148 2.76758C4.52135 2.86424 4.45046 2.9521 4.35254 2.95215C4.25753 2.95233 4.18346 3.02235 4.12598 3.13281C4.24277 3.2161 4.3193 3.3608 4.31934 3.52344C4.31932 3.59232 4.30473 3.65774 4.28027 3.7168H4.7627L6.32129 2.15723C5.69835 1.61967 4.88737 1.29395 4 1.29395ZM2.27051 6.36816H5.53223L5.66113 5.97168H2.1416L2.27051 6.36816ZM2.58789 5.60254H3.05078V4.93066C2.95047 4.89757 2.87669 4.83784 2.81836 4.7793L2.75879 4.7168C2.73018 4.68546 2.70665 4.65967 2.68359 4.63965L2.58789 5.60254ZM3.67969 4.7168C3.61258 4.79029 3.52517 4.88537 3.3877 4.93066V5.60254H3.73242V4.66113L3.67969 4.7168ZM4.07031 5.60254H4.41406V4.93066C4.31372 4.89756 4.23998 4.83785 4.18164 4.7793L4.12207 4.7168C4.10307 4.69599 4.08622 4.67788 4.07031 4.66211V5.60254ZM5.11133 4.64648L5.04395 4.7168C4.97686 4.79028 4.8894 4.88529 4.75195 4.93066V5.60254H5.21484L5.11816 4.64062C5.11599 4.64251 5.11351 4.6445 5.11133 4.64648ZM3.03223 4.08594C2.91826 4.08594 2.81442 4.15303 2.75488 4.25977C2.86501 4.30944 2.93923 4.39164 2.99805 4.45605L3.05176 4.5127C3.06834 4.529 3.08487 4.54345 3.10156 4.55469C3.13281 4.57559 3.16814 4.5878 3.21875 4.58789C3.26967 4.58789 3.30555 4.57567 3.33691 4.55469C3.37038 4.53219 3.40063 4.49964 3.44043 4.45605L3.51758 4.37598C3.58914 4.30763 3.6823 4.24076 3.81641 4.2207L3.90137 4.21484L3.98633 4.2207C4.17385 4.24879 4.28057 4.36762 4.36133 4.45605L4.41602 4.5127C4.4326 4.529 4.44816 4.54345 4.46484 4.55469C4.49624 4.57576 4.53203 4.58786 4.58301 4.58789C4.63406 4.58788 4.66974 4.57578 4.70117 4.55469C4.73466 4.53218 4.76486 4.49968 4.80469 4.45605L4.85938 4.39844C4.90879 4.34821 4.96828 4.29534 5.04688 4.25977C4.98733 4.15324 4.88433 4.08596 4.77051 4.08594H3.03223ZM3.87109 3.43555C3.84379 3.44928 3.82133 3.48107 3.82129 3.52344C3.82134 3.58102 3.86218 3.61902 3.90137 3.61914C3.94053 3.61897 3.98139 3.58098 3.98145 3.52344C3.98141 3.48099 3.959 3.44925 3.93164 3.43555L3.90234 3.42773H3.89941L3.87109 3.43555Z" fill="#E92827"/>
                                                                                </svg>
                                                                                <span>Gelatine-Free</span>
                                                                            </li>
                                                                            <li id="lectose_${index}" style="display: ${product.lactose_free == 1 ? 'flex' : 'none'};">
                                                                                <svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4 0.849609C6.20914 0.849609 8 2.64047 8 4.84961C8 7.05875 6.20914 8.84961 4 8.84961C1.79086 8.84961 0 7.05875 0 4.84961C1.61064e-08 2.64047 1.79086 0.849609 4 0.849609ZM5.25488 3.85156C5.26245 3.86125 5.26946 3.87139 5.27734 3.88086L5.36426 3.99414C5.55295 4.26569 5.6543 4.58991 5.6543 4.92285V7.66797H2.3457V6.53027L1.5 7.37598C2.14236 8.01167 3.02487 8.40527 4 8.40527C5.96368 8.40527 7.55566 6.81329 7.55566 4.84961C7.55566 3.93336 7.20885 3.09819 6.63965 2.46777L5.25488 3.85156ZM2.79004 7.22363H5.20996V5.5791C4.60608 5.55879 4.26558 5.45743 3.93555 5.35742C3.62782 5.26417 3.32999 5.17291 2.79004 5.15332V7.22363ZM4 1.29395C2.03632 1.29395 0.444336 2.88593 0.444336 4.84961C0.444336 5.67788 0.728258 6.43953 1.20312 7.04395L2.3457 5.90137V4.92285L2.35156 4.78027C2.38048 4.45091 2.50956 4.13658 2.72266 3.88086L2.78516 3.79883C2.92218 3.60162 2.99694 3.36675 2.99707 3.125V1.75488H5.00391V3.125C5.00396 3.22999 5.01785 3.33369 5.04492 3.43359L6.32129 2.15723C5.69835 1.61967 4.88737 1.29395 4 1.29395ZM3.43652 3.24023C3.41569 3.53196 3.31708 3.81282 3.15039 4.05273L3.06445 4.16602C2.93345 4.32325 2.84799 4.51099 2.81152 4.70996C3.4014 4.73199 3.73762 4.8329 4.06348 4.93164C4.37131 5.02492 4.66964 5.11522 5.20996 5.13477V4.92285C5.20996 4.68091 5.13613 4.44539 4.99902 4.24805L4.93652 4.16602C4.71775 3.90347 4.58869 3.57919 4.56445 3.24023H3.43652ZM3.44141 2.19922V2.7959H4.55957V2.19922H3.44141Z" fill="#E92827"/>
                                                                                </svg>
                                                                                <span>Lectose-Free</span>
                                                                            </li>
                                                                            <li id="gluten_${index}" style="display: ${product.gluten_free == 1 ? 'flex' : 'none'};">
                                                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <mask id="mask0_3537_34024" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="8" height="8">
                                                                                <path d="M8 0H0V8H8V0Z" fill="white"/>
                                                                                </mask>
                                                                                <g mask="url(#mask0_3537_34024)">
                                                                                <path d="M3.99986 8C3.07448 7.99929 2.17797 7.67773 1.46308 7.09018C0.748177 6.50258 0.259129 5.68529 0.0792401 4.77756C-0.100647 3.86984 0.0397614 2.92782 0.476542 2.112C0.913324 1.29619 1.61945 0.657049 2.47463 0.30348C3.3298 -0.050088 4.2811 -0.0962111 5.16648 0.172969C6.05186 0.442149 6.81648 1.00998 7.33017 1.77972C7.84381 2.54945 8.0747 3.47347 7.98346 4.39435C7.89221 5.3152 7.48452 6.17596 6.82981 6.82996C6.45844 7.20178 6.01724 7.49653 5.53159 7.69729C5.0459 7.89809 4.52537 8.00098 3.99986 8ZM3.99986 0.453427C3.17916 0.453867 2.384 0.738862 1.74987 1.25985C1.11574 1.78084 0.681871 2.50558 0.522191 3.3106C0.362511 4.11562 0.486897 4.95111 0.87416 5.67467C1.26143 6.39827 1.8876 6.9652 2.646 7.27884C3.4044 7.59253 4.24808 7.63351 5.03332 7.39484C5.81857 7.15618 6.49675 6.65267 6.95235 5.97C7.40795 5.28738 7.61275 4.46791 7.53186 3.6512C7.45097 2.83449 7.08941 2.07109 6.50879 1.49108C6.17959 1.16133 5.78848 0.899898 5.3579 0.721818C4.92732 0.543742 4.46581 0.452529 3.99986 0.453427Z" fill="#E92827"/>
                                                                                <path d="M4.13859 6.2382H3.67802C3.40037 6.23802 3.13413 6.12762 2.9378 5.93127C2.74146 5.73491 2.63107 5.46869 2.63086 5.19105V4.92154C2.63086 4.87087 2.65099 4.82225 2.68682 4.78642C2.72264 4.7506 2.77124 4.73047 2.8219 4.73047H3.08825C3.36591 4.73069 3.63214 4.84109 3.82848 5.0374C4.02481 5.23376 4.13521 5.49998 4.13541 5.77767L4.13859 6.2382ZM2.94953 5.04914V5.19185C2.94974 5.38518 3.02664 5.57056 3.16336 5.70731C3.30009 5.84402 3.48546 5.92091 3.67882 5.92114H3.8215V5.77842C3.8213 5.58509 3.74439 5.39971 3.60767 5.263C3.47095 5.12625 3.28557 5.04936 3.09222 5.04914H2.94953Z" fill="#E92827"/>
                                                                                <path d="M4.13859 5.12901H3.67802C3.4003 5.12901 3.13395 5.0187 2.93757 4.8223C2.74118 4.6259 2.63086 4.35956 2.63086 4.08184V3.81311C2.63086 3.76244 2.65099 3.71385 2.68682 3.67803C2.72264 3.6422 2.77124 3.62207 2.8219 3.62207H3.08825C3.36597 3.62207 3.63233 3.73239 3.82871 3.92878C4.02509 4.12516 4.13541 4.39151 4.13541 4.66923L4.13859 5.12901ZM2.94953 3.93995V4.08184C2.94973 4.27527 3.02661 4.46074 3.16332 4.59759C3.30001 4.73443 3.48539 4.8115 3.67882 4.81194H3.8215V4.66923C3.8213 4.4759 3.74439 4.2905 3.60767 4.15378C3.47095 4.01706 3.28557 3.94015 3.09222 3.93995H2.94953Z" fill="#E92827"/>
                                                                                <path d="M4.13859 4.0214H3.67802C3.40037 4.02119 3.13413 3.9108 2.9378 3.71446C2.74146 3.51813 2.63107 3.25189 2.63086 2.97424V2.70472C2.63086 2.65405 2.65099 2.60545 2.68682 2.56963C2.72264 2.5338 2.77124 2.51367 2.8219 2.51367H3.08825C3.36591 2.51388 3.63214 2.62428 3.82848 2.82061C4.02481 3.01695 4.13521 3.28318 4.13541 3.56084L4.13859 4.0214ZM2.94953 2.83234V2.97503C2.94974 3.16838 3.02664 3.35376 3.16336 3.49049C3.30009 3.62721 3.48546 3.70411 3.67882 3.70432H3.8215V3.56163C3.8213 3.36828 3.74439 3.1829 3.60767 3.04618C3.47095 2.90945 3.28557 2.83255 3.09222 2.83234H2.94953Z" fill="#E92827"/>
                                                                                <path d="M4.27794 6.2382H3.81738V5.77767C3.81738 5.49994 3.92771 5.23358 4.12409 5.03718C4.32048 4.84083 4.58683 4.73047 4.86457 4.73047H5.13328C5.15839 4.73038 5.18328 4.73527 5.20652 4.74483C5.22972 4.75438 5.25083 4.76843 5.26861 4.7862C5.28634 4.80398 5.30043 4.82509 5.30999 4.84829C5.31954 4.87154 5.32443 4.89643 5.32434 4.92154V5.19105C5.32434 5.46865 5.21412 5.73487 5.0179 5.93123C4.82168 6.12758 4.55554 6.23803 4.27794 6.2382ZM4.13526 5.92114H4.27794C4.47132 5.92091 4.6567 5.84403 4.79341 5.70731C4.93012 5.57056 5.00701 5.38518 5.00723 5.19185V5.04914H4.86457C4.67119 5.04936 4.48581 5.12625 4.3491 5.263C4.21237 5.39971 4.13547 5.58509 4.13526 5.77843V5.92114Z" fill="#E92827"/>
                                                                                <path d="M4.27794 5.12901H3.81738V4.66923C3.81728 4.53168 3.84429 4.39548 3.89689 4.26838C3.94947 4.14129 4.0266 4.02581 4.12386 3.92855C4.22112 3.83129 4.33661 3.75416 4.46368 3.70157C4.59079 3.64898 4.72701 3.62197 4.86457 3.62207H5.13328C5.15839 3.62197 5.18328 3.62684 5.20652 3.6364C5.22972 3.64597 5.25083 3.66003 5.26861 3.6778C5.28634 3.69556 5.30043 3.71665 5.30999 3.73988C5.31954 3.76311 5.32443 3.788 5.32434 3.81312V4.08185C5.32443 4.21932 5.29745 4.35547 5.24492 4.48252C5.19234 4.60954 5.11532 4.72501 5.01812 4.82225C4.92097 4.9195 4.80554 4.99665 4.67857 5.04928C4.55154 5.1019 4.41541 5.12901 4.27794 5.12901ZM4.13526 4.81194H4.27794C4.47137 4.8115 4.65674 4.73443 4.79345 4.59759C4.93017 4.46074 5.00701 4.27527 5.00723 4.08185V3.93995H4.86457C4.67119 3.94016 4.48581 4.01706 4.3491 4.15378C4.21237 4.29051 4.13547 4.4759 4.13526 4.66923V4.81194Z" fill="#E92827"/>
                                                                                <path d="M4.27794 4.0214H3.81738V3.56084C3.81738 3.28311 3.92771 3.01677 4.12409 2.82038C4.32048 2.624 4.58683 2.51367 4.86457 2.51367H5.16261C5.18377 2.51367 5.2047 2.51789 5.22421 2.52611C5.24372 2.53432 5.26136 2.54636 5.27612 2.5615C5.29092 2.57665 5.30252 2.5946 5.31025 2.61429C5.31799 2.63398 5.32168 2.65503 5.32114 2.67618V2.97424C5.32114 3.25128 5.21136 3.51703 5.01585 3.7133C4.8203 3.90957 4.55496 4.02035 4.27794 4.0214ZM4.13526 3.70432H4.27794C4.47132 3.70411 4.6567 3.62721 4.79341 3.49049C4.93012 3.35376 5.00701 3.16838 5.00723 2.97503V2.83234H4.86457C4.67119 2.83255 4.48581 2.90945 4.3491 3.04618C4.21237 3.1829 4.13547 3.36828 4.13526 3.56163V3.70432Z" fill="#E92827"/>
                                                                                <path d="M3.97816 3.34853L3.64284 3.01242C3.54091 2.9106 3.46004 2.78969 3.40486 2.65659C3.34969 2.5235 3.32129 2.38084 3.32129 2.23676C3.32129 2.09268 3.34969 1.95002 3.40486 1.81692C3.46004 1.68383 3.54091 1.56291 3.64284 1.4611L3.87115 1.23279C3.88544 1.21844 3.90242 1.20705 3.92112 1.19927C3.93983 1.1915 3.95988 1.1875 3.98014 1.1875C4.0004 1.1875 4.02045 1.1915 4.03916 1.19927C4.05786 1.20705 4.07485 1.21844 4.08914 1.23279L4.31742 1.4611C4.52293 1.66694 4.63835 1.9459 4.63835 2.23676C4.63835 2.52761 4.52293 2.80658 4.31742 3.01242L3.97816 3.34853ZM3.97816 1.57207L3.8656 1.68464C3.71984 1.83111 3.63802 2.02933 3.63802 2.23597C3.63802 2.4426 3.71984 2.64082 3.8656 2.7873L3.97816 2.89986L4.09152 2.7873C4.23728 2.64082 4.31911 2.4426 4.31911 2.23597C4.31911 2.02933 4.23728 1.83111 4.09152 1.68464L3.97816 1.57207Z" fill="#E92827"/>
                                                                                <path d="M3.98374 6.90699C3.94169 6.90699 3.90136 6.89027 3.87163 6.86054C3.8419 6.83081 3.8252 6.7905 3.8252 6.74845V3.12338C3.8252 3.08134 3.8419 3.04101 3.87163 3.01128C3.90136 2.98155 3.94169 2.96484 3.98374 2.96484C4.02579 2.96484 4.06611 2.98155 4.09584 3.01128C4.12558 3.04101 4.14228 3.08134 4.14228 3.12338V6.74765C4.14238 6.76854 4.13836 6.78921 4.13044 6.80854C4.12252 6.82787 4.11086 6.84547 4.09612 6.86027C4.08139 6.87507 4.06388 6.88681 4.04459 6.89485C4.02531 6.90285 4.00463 6.90699 3.98374 6.90699Z" fill="#E92827"/>
                                                                                <path d="M2.71358 5.40559C2.68033 5.31106 2.66058 5.2123 2.65493 5.1123L1.21378 6.55422C1.19095 6.57715 1.17542 6.60635 1.16914 6.63808C1.16286 6.66986 1.1661 6.70275 1.17847 6.73266C1.19084 6.76257 1.21178 6.78817 1.23866 6.80622C1.26554 6.82426 1.29715 6.83395 1.32952 6.83404C1.37318 6.83377 1.41501 6.81639 1.44605 6.78568L2.74371 5.48804C2.7334 5.4603 2.7231 5.43333 2.71358 5.40559Z" fill="#E92827"/>
                                                                                <path d="M6.78493 1.21516C6.76969 1.19989 6.7516 1.18777 6.73169 1.17951C6.71173 1.17125 6.6904 1.16699 6.6688 1.16699C6.64724 1.16699 6.62587 1.17125 6.60595 1.17951C6.586 1.18777 6.56791 1.19989 6.55267 1.21516L5.17969 2.58892C5.26929 2.66343 5.28831 2.80849 5.29622 2.91551C5.29582 2.92211 5.29582 2.92873 5.29622 2.93533L6.78413 1.44742C6.79947 1.43223 6.81164 1.41417 6.81995 1.39427C6.82831 1.37437 6.83262 1.35302 6.83271 1.33145C6.8328 1.30988 6.82862 1.2885 6.8204 1.26855C6.81222 1.24859 6.80018 1.23045 6.78493 1.21516Z" fill="#E92827"/>
                                                                                </g>
                                                                            </svg>

                                                                            <span>Gluten Free</span>

                                                                        </li>
                                                                        </ul>
                                                                        <div class="Qr_code">
                                                                            <dev id="qrcode_${index}"></dev>
                                                                        </div>
                                                                        <div style="font-size: 8px; font-family: 'DM Sans', sans-serif; "><span id="article_number_${index}" class="product_name">${product.article_number || ''}</span></div>

                                                                    </div>
                                                                    <div class="right_side">
                                                                        <div class="contnet">
                                                                        <h2 id="ingredients_title_${index}" style="font-family: 'DM Sans', sans-serif; font-size: 8px; margin-bottom: 8px;"><b>Ingredients</b>:</h2>
                                                                        <p id="ingredients_${index}" style=" font-family: 'Noto Kufi Arabic', sans-serif; color: #000; "  class="ingrediants">${product.ingredients_ar}</p>
                                                                        <p id="ingredients_${index}" style=" font-family: 'Noto Kufi Arabic', sans-serif; color: #000; "  class="ingrediants">${product.ingredient}</p>
                                                                        </div>
                                                                        <div class="bar_code">
                                                                            <svg id="barcode_${index}"></svg>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        `;
                                $('#labelsContainer').append(labelHtml);

                                $(`#qrcode_${index}`).empty();

                                if (product.qr_code) {
                                    $(`#qrcode_${index}`).html(product
                                        .qr_code); // inject raw SVG
                                } else {
                                    $(`#qrcode_${index}`).html('');
                                }

                                // Generate barcode for item_no
                                // if (product.sku_no) {
                                //     JsBarcode(`#barcode_${index}`, product.sku_no, {
                                //         format: "CODE128",
                                //         width: 2,
                                //         height: 40,
                                //         displayValue: true
                                //     });
                                // } else {
                                //     $('#barcode').replaceWith('');
                                // }


                            });

                            // Show the label generation modal
                            $('#sizeSelectionModalmultiple').modal('hide');
                            $('#multiplelabelGenerationModal').modal('show');
                        } else {
                            showToastr('Error fetching product details', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching product details:', xhr);
                        showToastr('An error occurred while fetching product details', 'error');
                    }
                });
            });

            $('#downloadMultipleLabelBtn').click(async function() {
                const $button = $(this);
                $button.prop('disabled', true).html('Generating PDF... <span class="loader"></span>');

                try {
                    const {
                        jsPDF
                    } = window.jspdf;
                    const doc = new jsPDF({
                        orientation: 'portrait',
                        unit: 'mm',
                        format: 'a4',
                        compress: false // Disable compression for better quality
                    });

                    const labels = $('#labelsContainer .label_banner');
                    let yOffset = 10;
                    const pageHeight = doc.internal.pageSize.getHeight();
                    const pageWidth = doc.internal.pageSize.getWidth();
                    const margin = 10;

                    // Get label dimensions based on sizeSelectmultiple
                    const sizeSelectmultiple = $('#sizeSelectmultiple').val();
                    let width, height;
                    if (sizeSelectmultiple === 'MOE (100mm x 400mm)') {
                        width = 377.95275590551176; // in pixels
                        height = 151.1811023622047; // in pixels
                    } else {
                        width = 283.4646; // in pixels
                        height = 198.4252; // in pixels
                    }

                    // Convert pixel dimensions to mm (assuming 96 DPI for html2canvas)
                    const pixelsToMm = 25.4 / 96; // 1 inch = 25.4 mm, 96 pixels = 1 inch
                    const pdfWidth = width * pixelsToMm;
                    const pdfHeight = height * pixelsToMm;

                    // Calculate x-coordinate to center the label
                    const xOffset = (pageWidth - pdfWidth) / 2; // Center horizontally

                    // Wait for fonts to load
                    await document.fonts.ready;

                    // Ensure label elements have the correct dimensions
                    $('.label_banner').css({
                        width: `${width}px`,
                        height: `${height}px`,
                        'box-sizing': 'border-box',
                        overflow: 'hidden' // Prevent content from spilling out
                    });

                    for (let i = 0; i < labels.length; i++) {
                        const label = labels[i];

                        console.log(
                            `Label ${i + 1} dimensions: Width = ${width}px, Height = ${height}px`);

                        // Render label to canvas with specified dimensions
                        const canvas = await html2canvas(label, {
                            scale: 5, // High scale for quality
                            useCORS: true,
                            backgroundColor: '#ffffff',
                            logging: true, // Enable logging for debugging
                            width: width, // Exact width
                            height: height, // Exact height
                            windowWidth: width, // Ensure viewport matches
                            windowHeight: height
                        });

                        console.log(
                            `Label ${i + 1} canvas dimensions: Width = ${canvas.width}px, Height = ${canvas.height}px`
                        );

                        const imgData = canvas.toDataURL('image/png', 1.0);

                        // Check if the image fits on the current page
                        if (yOffset + pdfHeight + margin > pageHeight) {
                            doc.addPage();
                            yOffset = margin;
                        }

                        // Add image to PDF, centered horizontally
                        doc.addImage(imgData, 'PNG', xOffset, yOffset, pdfWidth, pdfHeight, undefined,
                            'NONE');
                        yOffset += pdfHeight + margin;
                    }

                    doc.save('labels.pdf');
                } catch (error) {
                    console.error('Error generating PDF:', error);
                    alert('Failed to generate PDF. Check console for details.');
                } finally {
                    $button.prop('disabled', false).text('Download Labels');
                }
            });
        });
    </script>
@endpush
