<?php

namespace Database\Seeders;

use App\Models\Fournisseur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
class FournisseurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('fournisseur_produit')->truncate();
        DB::table('fournisseurs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $numberOfRecords= 50;
        $faker = Faker::create();
        for ($i = 0; $i < $numberOfRecords; $i++) {
            Fournisseur::create([
                'code_fournisseur' => $faker->unique()->randomNumber(),
                'nom' => $faker->name,
                'adresse' => $faker->address,
                'tel' => $faker->phoneNumber,
                'mail' => $faker->email,
                'fax' => $faker->phoneNumber,
            ]);
        }
    }
}
