<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'PHP',
            'OOP PHP',
            'Laravel',
            'HR interview questions'
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
