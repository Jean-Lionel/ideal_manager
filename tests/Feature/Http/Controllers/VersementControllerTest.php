<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\User;
use App\Models\Versement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\VersementController
 */
final class VersementControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $versements = Versement::factory()->count(3)->create();

        $response = $this->get(route('versements.index'));

        $response->assertOk();
        $response->assertViewIs('versement.index');
        $response->assertViewHas('versements');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('versements.create'));

        $response->assertOk();
        $response->assertViewIs('versement.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VersementController::class,
            'store',
            \App\Http\Requests\VersementStoreRequest::class
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

        $response = $this->post(route('versements.store'), [
            'date' => $date->toDateString(),
            'montant' => $montant,
            'user_id' => $user->id,
            'category_id' => $category->id,
            'category_user_id' => $category_user->id,
        ]);

        $versements = Versement::query()
            ->where('date', $date)
            ->where('montant', $montant)
            ->where('user_id', $user->id)
            ->where('category_id', $category->id)
            ->where('category_user_id', $category_user->id)
            ->get();
        $this->assertCount(1, $versements);
        $versement = $versements->first();

        $response->assertRedirect(route('versements.index'));
        $response->assertSessionHas('versement.id', $versement->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $versement = Versement::factory()->create();

        $response = $this->get(route('versements.show', $versement));

        $response->assertOk();
        $response->assertViewIs('versement.show');
        $response->assertViewHas('versement');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $versement = Versement::factory()->create();

        $response = $this->get(route('versements.edit', $versement));

        $response->assertOk();
        $response->assertViewIs('versement.edit');
        $response->assertViewHas('versement');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VersementController::class,
            'update',
            \App\Http\Requests\VersementUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $versement = Versement::factory()->create();
        $date = Carbon::parse(fake()->date());
        $montant = fake()->randomFloat(/** decimal_attributes **/);
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $category_user = CategoryUser::factory()->create();

        $response = $this->put(route('versements.update', $versement), [
            'date' => $date->toDateString(),
            'montant' => $montant,
            'user_id' => $user->id,
            'category_id' => $category->id,
            'category_user_id' => $category_user->id,
        ]);

        $versement->refresh();

        $response->assertRedirect(route('versements.index'));
        $response->assertSessionHas('versement.id', $versement->id);

        $this->assertEquals($date, $versement->date);
        $this->assertEquals($montant, $versement->montant);
        $this->assertEquals($user->id, $versement->user_id);
        $this->assertEquals($category->id, $versement->category_id);
        $this->assertEquals($category_user->id, $versement->category_user_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $versement = Versement::factory()->create();

        $response = $this->delete(route('versements.destroy', $versement));

        $response->assertRedirect(route('versements.index'));

        $this->assertModelMissing($versement);
    }
}
