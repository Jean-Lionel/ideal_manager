<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\Sortie;
use App\Models\User;

class SortieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sortie::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'date' => fake()->date(),
            'montant' => fake()->randomFloat(2, 0, 99999999.99),
            'description' => fake()->text(),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'category_user_id' => CategoryUser::factory(),
        ];
    }
}
