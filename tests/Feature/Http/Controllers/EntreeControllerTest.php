<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\Entree;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EntreeController
 */
final class EntreeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $entrees = Entree::factory()->count(3)->create();

        $response = $this->get(route('entrees.index'));

        $response->assertOk();
        $response->assertViewIs('entree.index');
        $response->assertViewHas('entrees');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('entrees.create'));

        $response->assertOk();
        $response->assertViewIs('entree.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EntreeController::class,
            'store',
            \App\Http\Requests\EntreeStoreRequest::class
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

        $response = $this->post(route('entrees.store'), [
            'date' => $date->toDateString(),
            'montant' => $montant,
            'user_id' => $user->id,
            'category_id' => $category->id,
            'category_user_id' => $category_user->id,
        ]);

        $entrees = Entree::query()
            ->where('date', $date)
            ->where('montant', $montant)
            ->where('user_id', $user->id)
            ->where('category_id', $category->id)
            ->where('category_user_id', $category_user->id)
            ->get();
        $this->assertCount(1, $entrees);
        $entree = $entrees->first();

        $response->assertRedirect(route('entrees.index'));
        $response->assertSessionHas('entree.id', $entree->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $entree = Entree::factory()->create();

        $response = $this->get(route('entrees.show', $entree));

        $response->assertOk();
        $response->assertViewIs('entree.show');
        $response->assertViewHas('entree');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $entree = Entree::factory()->create();

        $response = $this->get(route('entrees.edit', $entree));

        $response->assertOk();
        $response->assertViewIs('entree.edit');
        $response->assertViewHas('entree');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EntreeController::class,
            'update',
            \App\Http\Requests\EntreeUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $entree = Entree::factory()->create();
        $date = Carbon::parse(fake()->date());
        $montant = fake()->randomFloat(/** decimal_attributes **/);
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $category_user = CategoryUser::factory()->create();

        $response = $this->put(route('entrees.update', $entree), [
            'date' => $date->toDateString(),
            'montant' => $montant,
            'user_id' => $user->id,
            'category_id' => $category->id,
            'category_user_id' => $category_user->id,
        ]);

        $entree->refresh();

        $response->assertRedirect(route('entrees.index'));
        $response->assertSessionHas('entree.id', $entree->id);

        $this->assertEquals($date, $entree->date);
        $this->assertEquals($montant, $entree->montant);
        $this->assertEquals($user->id, $entree->user_id);
        $this->assertEquals($category->id, $entree->category_id);
        $this->assertEquals($category_user->id, $entree->category_user_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $entree = Entree::factory()->create();

        $response = $this->delete(route('entrees.destroy', $entree));

        $response->assertRedirect(route('entrees.index'));

        $this->assertModelMissing($entree);
    }
}
