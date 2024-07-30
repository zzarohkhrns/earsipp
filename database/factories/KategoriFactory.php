<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Kategori;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kategori>
 */
// class KategoriFactory extends Factory
// {
//     /**
//      * Define the model's default state.
//      *
//      * @return array<string, mixed>
//      */
//     public function definition()
//     {
//         return [
//             //
//         ];
//     }
// }

$factory->define(Kategori::class, function (Faker $faker) {
    return [
        'nama' => $faker->name,
    ];
});
