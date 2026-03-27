<?php

namespace Database\Seeders;

use App\Models\Labels;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Labels::create([
            'code' => 'L001',
            'title' => 'Bug',
        ]);
    }
}
