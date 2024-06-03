<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create categories
        $listCategories = [
            'Homme','Femme','Junior (moins de 18 ans)','Senior (plus de 18 ans)'
        ];

        foreach ($listCategories as $item){
            $category = Category::where('nom',$item)->first();
            if( !$category ){
                Category::create([
                    'nom' => $item
                ]);
            }
        }
    }
}
