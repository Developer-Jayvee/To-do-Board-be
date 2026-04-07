<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Categories::where("title","Open");
        if($category->exists()) return;

        Categories::create([
            'code' => 'CAT00'.$category->count() + rand(20 , 1000),
            'title' => 'Open',
            'sort' => 1,
            'created_by' => 1
        ]);
    }
}
