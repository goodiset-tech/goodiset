<?php

namespace App\Mail;

use App\Exports\InventoryRequestProductsExport;
use App\Models\InventoryRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class InventoryRequestCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $inventoryRequest;

    /**
     * Create a new message instance.
     */
    public function __construct(InventoryRequest $inventoryRequest)
    {
        $this->inventoryRequest = $inventoryRequest;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Generate the Excel file and store it temporarily
        $fileName = 'inventory_request_' . $this->inventoryRequest->id . '_products.xlsx';
        $filePath = 'product_export/' . $fileName;
        Excel::store(new InventoryRequestProductsExport($this->inventoryRequest), $filePath, 'public');

        // Build the email with the attachment
        return $this->subject('New Inventory Request Created')
                    ->view('emails.inventory_request_created')
                    ->attach(Storage::disk('public')->path($filePath), [
                        'as' => $fileName,
                        'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ]);
    }
}