<?php

if (!function_exists('get_shipping_time')) {
    /**
     * Get shipping time based on city name, falling back to country name if unavailable.
     *
     * @param string|null $city_name
     * @param string|null $country_name
     * @return string
     */
    function get_shipping_time($city_name = null, $country_name = null)
    {
        // Default shipping time
        $shippingTime = 'N/A';

        // Check city first
        if ($city_name) {
            $city = \App\Models\City::where('name', $city_name)->first();
            if ($city && $city->shipping_time) {
                return $city->shipping_time; // Return city's shipping time if available
            }
        }

        // Fallback to country
        if ($country_name) {
            $country = \App\Models\Countries::where('name', $country_name)->first();
            if ($country && $country->shipping_time) {
                $shippingTime = $country->shipping_time; // Use country's shipping time
            }
        }

        return $shippingTime;
    }
}