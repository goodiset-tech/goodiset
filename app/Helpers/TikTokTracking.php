<?php

namespace App\Helpers;

class TikTokTracking
{
    // TikTok Pixel ID - Change this to your pixel ID
    const PIXEL_ID = 'D6M0V7BC77UE81ODJ4NG';

    /**
     * Hash email using SHA-256
     * @param string $email
     * @return string
     */
    public static function hashEmail($email)
    {
        if (empty($email)) {
            return '';
        }
        return hash('sha256', strtolower(trim($email)));
    }

    /**
     * Hash phone number using SHA-256
     * @param string $phone
     * @return string
     */
    public static function hashPhoneNumber($phone)
    {
        if (empty($phone)) {
            return '';
        }
        $phone = preg_replace('/[^0-9]/', '', $phone);
        return hash('sha256', $phone);
    }

    /**
     * Hash external ID using SHA-256
     * @param string $externalId
     * @return string
     */
    public static function hashExternalId($externalId)
    {
        if (empty($externalId)) {
            return '';
        }
        return hash('sha256', $externalId);
    }

    /**
     * Generate a unique event ID
     * @return string
     */
    public static function generateEventId()
    {
        $timestamp = (int)(microtime(true) * 1000);
        $random = random_int(0, 999);
        return $timestamp . '_' . $random;
    }

    /**
     * Get pixel ID
     * @return string
     */
    public static function getPixelId()
    {
        return self::PIXEL_ID;
    }

    /**
     * Get hashed user identification data from session
     * Priority: Logged-in user (session('user')) > Checkout session (session('cart'))
     * @return array
     */
    public static function getHashedUserData()
    {
        $email = '';
        $phone = '';
        $userId = '';

        // Check if user is logged in
        if (session()->has('user')) {
            $user = session('user');
            $email = $user['email'] ?? '';
            $phone = $user['phone'] ?? '';
            $userId = $user['id'] ?? '';
        }
        // Otherwise check checkout session
        elseif (session()->has('cart')) {
            $cart = session('cart');
            $email = $cart['email'] ?? '';
            $phone = $cart['phone'] ?? '';
            $userId = $cart['customer_id'] ?? '';
        }

        return [
            'email' => self::hashEmail($email),
            'phone_number' => self::hashPhoneNumber($phone),
            'external_id' => self::hashExternalId($userId),
        ];
    }
}
