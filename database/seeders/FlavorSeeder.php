<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FlavorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('flavours')->truncate();
        $flavors = [
            'Sour fruit mix',
            'Mixed fruit',
            'Sweet green apple',
            'Sweet strawberry',
            'Licorice and vanilla winegum',
            'Sour cola',
            'Sour watermelon',
            'Sweet cola',
            'Strawberry',
            'Orange',
            'Lemon',
            'Lime',
            'Blackcurrant',
            'Mixed tropical fruit flavors',
            'Caramel',
            'Salty licorice',
            'Milk chocolate',
            'Rhubarb',
            'Salty raspberry',
            'Raspberry',
            'Fruity',
            'Berry mix',
            'Coconut',
            'Milk chocolate with hazelnut filling',
            'Mango',
            'Pineapple',
            'Passion fruit',
            'Sweet licorice',
            'Sour licorice',
            'Sour tropical fruit mix',
            'Soda flavors',
            'Cola',
            'Lemon-lime',
            'Cake flavor with vanilla and fruity undertones',
            'Wild strawberry',
            'Mixed fruit toffee',
            'Creamy caramel',
            'Dark chocolate and caramel',
            'Toffee',
            'Blue raspberry',
            'Blue raspberry and lemon',
            'Forest berry',
            'Blueberry',
            'Sour pineapple',
            'Birthday cake',
            'Salted caramel',
            'Vanilla',
            'Sour cherry',
            'Sour blueberry',
            'Peach',
            'Mixed sweet fruit flavors',
            'Fizzy fruit mix',
            'Milk and cream',
            'Jelly fruit mix',
            'Fruit marmalade',
            'Grape soda',
            'Sour mixed candy',
            'Sour pastel candy',
            'Premium fruit mix',
            'Watermelon',
            'Kiwi',
            'Filled strawberry',
            'Sour melon',
            'Bubblegum',
            'Fruit-flavored chewing gum',
            'Chocolate with toffee',
            'Salted almonds',
            'Fizzy fruit',
            'Raspberry and licorice',
            'Chocolate',
            'Sour and salty licorice',
            'Hazelnut cream',
            'Hazelnut cream balls',
            'Cookie dough',
            'Creamy peanut',
            'Praline',
            'Punch roll',
            'Chocolate fudge',
            'Licorice fudge',
            'Vanilla fudge',
            'Banana',
            'Pear',
            'Super sour fruit',
            'Fizzy melon',
            'Rainbow sour fruit',
            'Fruit toffee',
            'Mixed fruit lollipops',
            'Pistachio',
            'Yogurt-flavored lollipops',
            'Liquorice',
            'Peppermint',
        ];        

        foreach ($flavors as $flavor) {
            DB::table('flavours')->insert([
                'name' => $flavor,
                'slug' => Str::slug($flavor, '-'), // Generate slug
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
