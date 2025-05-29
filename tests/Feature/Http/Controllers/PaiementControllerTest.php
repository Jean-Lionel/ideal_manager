<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PaiementController
 */
final class PaiementControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $paiements = Paiement::factory()->count(3)->create();

        $response = $this->get(route('paiements.index'));

        $response->assertOk();
        $response->assertViewIs('paiement.index');
        $response->assertViewHas('paiements');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('paiements.create'));

        $response->assertOk();
        $response->assertViewIs('paiement.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PaiementController::class,
            'store',
            \App\Http\Requests\PaiementStoreRequest::class
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

        $response = $this->post(route('paiements.store'), [
            'date' => $date->toDateString(),
            'montant' => $montant,
            'user_id' => $user->id,
            'category_id' => $category->id,
            'category_user_id' => $category_user->id,
        ]);

        $paiements = Paiement::query()
            ->where('date', $date)
            ->where('montant', $montant)
            ->where('user_id', $user->id)
            ->where('category_id', $category->id)
            ->where('category_user_id', $category_user->id)
            ->get();
        $this->assertCount(1, $paiements);
        $paiement = $paiements->first();

        $response->assertRedirect(route('paiements.index'));
        $response->assertSessionHas('paiement.id', $paiement->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $paiement = Paiement::factory()->create();

        $response = $this->get(route('paiements.show', $paiement));

        $response->assertOk();
        $response->assertViewIs('paiement.show');
        $response->assertViewHas('paiement');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $paiement = Paiement::factory()->create();

        $response = $this->get(route('paiements.edit', $paiement));

        $response->assertOk();
        $response->assertViewIs('paiement.edit');
        $response->assertViewHas('paiement');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PaiementController::class,
            'update',
            \App\Http\Requests\PaiementUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $paiement = Paiement::factory()->create();
        $date = Carbon::parse(fake()->date());
        $montant = fake()->randomFloat(/** decimal_attributes **/);
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $category_user = CategoryUser::factory()->create();

        $response = $this->put(route('paiements.update', $paiement), [
            'date' => $date->toDateString(),
            'montant' => $montant,
            'user_id' => $user->id,
            'category_id' => $category->id,
            'category_user_id' => $category_user->id,
        ]);

        $paiement->refresh();

        $response->assertRedirect(route('paiements.index'));
        $response->assertSessionHas('paiement.id', $paiement->id);

        $this->assertEquals($date, $paiement->date);
        $this->assertEquals($montant, $paiement->montant);
        $this->assertEquals($user->id, $paiement->user_id);
        $this->assertEquals($category->id, $paiement->category_id);
        $this->assertEquals($category_user->id, $paiement->category_user_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $paiement = Paiement::factory()->create();

        $response = $this->delete(route('paiements.destroy', $paiement));

        $response->assertRedirect(route('paiements.index'));

        $this->assertModelMissing($paiement);
    }
}
