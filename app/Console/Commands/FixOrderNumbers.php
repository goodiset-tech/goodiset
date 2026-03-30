<?php

namespace App\Console\Commands;

use App\Models\Admins\Order as AdminsOrder;
use Illuminate\Console\Command;

class FixOrderNumbers extends Command
{
    protected $signature = 'fix:order_numbers';
    protected $description = 'Fix all previous orders to have a 6-digit order number with leading zeros';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $orders = AdminsOrder::all();
        foreach ($orders as $order) {
            $order->order_no = str_pad($order->id, 6, '0', STR_PAD_LEFT);
            $order->save();
        }

        $this->info('All order numbers have been updated successfully.');
    }
}
