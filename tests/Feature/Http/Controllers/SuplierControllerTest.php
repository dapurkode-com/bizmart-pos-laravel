<?php

namespace Tests\Feature\Http\Controllers;

use App\Suplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SuplierController
 */
class SuplierControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $response = $this->get(route('suplier.index'));

        $response->assertOk();
        $response->assertViewIs('suplier.index');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('suplier.create'));

        $response->assertOk();
        $response->assertViewIs('suplier.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SuplierController::class,
            'store',
            \App\Http\Requests\SuplierStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $name = $this->faker->name;
        $address = $this->faker->word;
        $phone = $this->faker->phoneNumber;
        $description = $this->faker->text;

        $response = $this->post(route('suplier.store'), [
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'description' => $description,
        ]);

        $supliers = Suplier::query()
            ->where('name', $name)
            ->where('address', $address)
            ->where('phone', $phone)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $supliers);
        $suplier = $supliers->first();

        $response->assertRedirect(route('suplier.index'));
        $response->assertSessionHas('suplier.name', $suplier->name);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $suplier = factory(Suplier::class)->create();

        $response = $this->get(route('suplier.show', $suplier));

        $response->assertOk();
        $response->assertViewIs('suplier.show');
        $response->assertViewHas('suplier');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $suplier = factory(Suplier::class)->create();

        $response = $this->get(route('suplier.edit', $suplier));

        $response->assertOk();
        $response->assertViewIs('suplier.edit');
        $response->assertViewHas('suplier');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SuplierController::class,
            'update',
            \App\Http\Requests\SuplierUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $suplier = factory(Suplier::class)->create();
        $name = $this->faker->name;
        $address = $this->faker->word;
        $phone = $this->faker->phoneNumber;
        $description = $this->faker->text;

        $response = $this->put(route('suplier.update', $suplier), [
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'description' => $description,
        ]);

        $response->assertRedirect(route('suplier.index'));
        $response->assertSessionHas('suplier.name', $suplier->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $suplier = factory(Suplier::class)->create();

        $response = $this->delete(route('suplier.destroy', $suplier));

        $response->assertRedirect(route('suplier.index'));
        $response->assertSessionHas('suplier.name', $suplier->name);

        $this->assertDeleted($suplier);
    }
}
