<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\Sortie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SortieController
 */
final class SortieControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $sorties = Sortie::factory()->count(3)->create();

        $response = $this->get(route('sorties.index'));

        $response->assertOk();
        $response->assertViewIs('sortie.index');
        $response->assertViewHas('sorties');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('sorties.create'));

        $response->assertOk();
        $response->assertViewIs('sortie.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SortieController::class,
            'store',
            \App\Http\Requests\SortieStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $date = Carbon::parse(fake()->date());
        $montant = fake()->randomFloat(/** decimal_attributes **/);
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $category_user = CategoryUser::factory()->create();

        $response = $this->post(route('sorties.store'), [
            'date' => $date->toDateString(),
            'montant' => $montant,
            'user_id' => $user->id,
            'category_id' => $category->id,
            'category_user_id' => $category_user->id,
        ]);

        $sorties = Sortie::query()
            ->where('date', $date)
            ->where('montant', $montant)
            ->where('user_id', $user->id)
            ->where('category_id', $category->id)
            ->where('category_user_id', $category_user->id)
            ->get();
        $this->assertCount(1, $sorties);
        $sortie = $sorties->first();

        $response->assertRedirect(route('sorties.index'));
        $response->assertSessionHas('sortie.id', $sortie->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $sortie = Sortie::factory()->create();

        $response = $this->get(route('sorties.show', $sortie));

        $response->assertOk();
        $response->assertViewIs('sortie.show');
        $response->assertViewHas('sortie');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $sortie = Sortie::factory()->create();

        $response = $this->get(route('sorties.edit', $sortie));

        $response->assertOk();
        $response->assertViewIs('sortie.edit');
        $response->assertViewHas('sortie');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SortieController::class,
            'update',
            \App\Http\Requests\SortieUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $sortie = Sortie::factory()->create();
        $date = Carbon::parse(fake()->date());
        $montant = fake()->randomFloat(/** decimal_attributes **/);
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $category_user = CategoryUser::factory()->create();

        $response = $this->put(route('sorties.update', $sortie), [
            'date' => $date->toDateString(),
            'montant' => $montant,
            'user_id' => $user->id,
            'category_id' => $category->id,
            'category_user_id' => $category_user->id,
        ]);

        $sortie->refresh();

        $response->assertRedirect(route('sorties.index'));
        $response->assertSessionHas('sortie.id', $sortie->id);

        $this->assertEquals($date, $sortie->date);
        $this->assertEquals($montant, $sortie->montant);
        $this->assertEquals($user->id, $sortie->user_id);
        $this->assertEquals($category->id, $sortie->category_id);
        $this->assertEquals($category_user->id, $sortie->category_user_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $sortie = Sortie::factory()->create();

        $response = $this->delete(route('sorties.destroy', $sortie));

        $response->assertRedirect(route('sorties.index'));

        $this->assertModelMissing($sortie);
    }
}
