<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CouponEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $couponCode;

    public function __construct($couponCode)
    {
        $this->couponCode = $couponCode;
    }

    public function build()
    {
        return $this->subject('Your 10% Off Coupon Code')
                    ->view('emails.coupon'); // Create this view
    }
}