<?php

namespace App\Exports;

use App\Models\InventoryRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InventoryRequestProductsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $inventoryRequest;

    public function __construct(InventoryRequest $inventoryRequest)
    {
        $this->inventoryRequest = $inventoryRequest;
    }

    /**
     * Return the collection of items.
     */
    public function collection()
    {
        return $this->inventoryRequest->items;
    }

    /**
     * Define the headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'Product Name',
            'Item Number',
            'Barcode',
            'Original Name',
            'Article Number',
            'SKU',
            'Quantity',
            'Unit',
        ];
    }

    /**
     * Map each item to the Excel row.
     */
    public function map($item): array
    {
        return [
            $item->product->product_name,
            $item->product->sku,
            $item->product->product_code,
            $item->product->orignal_name,
            $item->product->article_number,
            $item->product->sku_no,
            $item->quantity,
            $item->unit,
        ];
    }
}