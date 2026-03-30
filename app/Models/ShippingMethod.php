<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'enabled', 'is_default'];

    public static function setDefault($id)
    {
        // Unset all other shipping methods as default
        // self::where('is_default', true)->update(['is_default' => false]);

        // If an ID is provided, set that shipping method as default
        if ($id) {
            $method = self::where('id', $id)->first();
            if($method->is_default == true){
                self::where('id', $id)->update(['is_default' => false]);
            }else{
                self::where('id', $id)->update(['is_default' => true]);
            }
        }
    }
}
