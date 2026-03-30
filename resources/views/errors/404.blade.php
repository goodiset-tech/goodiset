@extends('layout.app')
@section('content')
    @php
        use Illuminate\Support\Facades\Session;
        use App\Models\Admins\Rating;
    @endphp

    <section class="section bg_light_red">

        <div class="row">
            <div class="col-md-12 text_404">
                <h1 class="section_heading center red">404</h1>
                <h2>Oops! Page Not Found</h2>
                <p>It seems like you've wandered into a candy-free zone! The page you're looking for might have melted away.
                    Let's get you back to the sweetness!</p>
                <button class="continue_shopping"><a href="{{ route('home') }}">Back to Homepage</a></button>
            </div>

        </div>

    </section>
    <div class="trending_section">
        <?php
            $cate = DB::table('categories')->where('show_on_cart', 1)->get();

            foreach ($cate as $v) {
                $searchObj = DB::table('category_conditions')->where('category_id', $v->id)->select('type', 'condition', 'condition_value')->get();
                $pro = DB::table('products');

                if (isset($v->is_manual) && $v->is_manual == 2) {
                    // $pro = $pro->where('category_id',$v->id);
                    if ($searchObj->count() > 0) {
                        foreach ($searchObj as $key => $val) {
                            $method = $v->is_condition == 2 ? 'orWhere' : 'where';
                            // $v->is_condition == 2 ? 'orWhere'
                            if (trim($val->type) == 'Price') {

                                $pro->$method('discount_price', $val->condition, intval($val->condition_value));
                            }

                            if (trim($val->type) == 'Format') {
                                $pro->$method('format', $val->condition, intval($val->condition_value));
                            }

                            if (trim($val->type) == 'Tag') {
                                $conditionValues = explode(',', $val->condition_value);
                                $tagValues = array_map(fn($value) => str_replace(' ', '', trim($value)), $conditionValues);

                                foreach ($tagValues as $tag) {
                                    $pro->$method('tags', 'LIKE', '%' . $tag . '%');
                                }
                            }

                            if (trim($val->type) == 'Title') {
                                $pro->$method('product_name', $val->condition, $val->condition_value);
                            }

                            if (trim($val->type) == 'Made in') {
                                $pro->$method('country', $val->condition, intval($val->condition_value));
                            }

                            if (trim($val->type) == 'Brand') {
                                $pro->$method('brand_id', $val->condition, intval($val->condition_value));
                            }

                            if (trim($val->type) == 'Products') {
                                if ($val->condition_value) {
                                    $conditionValues = explode(',', $val->condition_value);
                                    $pro->whereIn('id', $conditionValues);
                                }

                            }

                            if (trim($val->type) == 'Theme') {
                                $pro->$method('theme_id', $val->condition, intval($val->condition_value));
                            }

                            if (trim($val->type) == 'Flavour') {
                                $pro->$method('flavour_id', $val->condition, intval($val->condition_value));
                            }

                            if (trim($val->type) == 'Color') {
                                $pro->$method('product_color', $val->condition, intval($val->condition_value));
                            }

                            if (trim($val->type) == 'Allergens') {
                                $pro->$method('allergen', $val->condition, intval($val->condition_value));
                            }

                            if (trim($val->type) == 'Weight') {
                                $pro->$method('weight', $val->condition, $val->condition_value);
                            }

                        }
                    }
                } else {
                    $pro = $pro->whereRaw("? = ANY(string_to_array(category_id, ','))", [$v->id]);
                }

                $pro = $pro->where('status', 1)->limit(10)->get();
               ?>

        <section class="section bg_light_red">
            <div class="container">
                <h2 class="section_heading center red n_m_b">You May Like This</h2>
                <div class="c-slider js-slider">
                    <button class="c-slider__arrow c-slider__arrow--prev" type="button" aria-label="Previous">
                        <svg width="16" height="28" viewBox="0 0 16 28" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 2L2 14L14 26" stroke-opacity="0.4" stroke-width="4" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>

                    </button>

                    <div class="c-slider__track js-slider-track">
                        @foreach ($pro as $k => $v)
                            <div class="c-slider__item">
                                <x-product-card :product="$v" />
                            </div>
                        @endforeach
                    </div>

                    <button class="c-slider__arrow c-slider__arrow--next" type="button" aria-label="Next">
                        <svg width="16" height="28" viewBox="0 0 16 28" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 26L14 14L2 2" stroke-opacity="0.4" stroke-width="4" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>
        <?php }?>
    </div>
@endsection
