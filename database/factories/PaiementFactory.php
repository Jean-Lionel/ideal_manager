<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\Paiement;
use App\Models\User;

class PaiementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Paiement::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'date' => fake()->date(),
            'montant' => fake()->randomFloat(2, 0, 99999999.99),
            'reference' => fake()->word(),
            'description' => fake()->text(),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'category_user_id' => CategoryUser::factory(),
        ];
    }
}
