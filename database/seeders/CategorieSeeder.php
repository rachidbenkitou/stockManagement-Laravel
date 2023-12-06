<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categorie;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $numberOfRecords= 5;
        $faker = Faker::create();
        for ($i = 0; $i < $numberOfRecords; $i++) {
            Categorie::create([
                'nom' => $faker->word,
                'description' => $faker->sentence,
            ]);
        }
    }
    
}
