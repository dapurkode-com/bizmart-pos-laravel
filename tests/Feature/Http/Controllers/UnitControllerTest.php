<?php

namespace Tests\Feature\Http\Controllers;

use App\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UnitController
 */
class UnitControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $response = $this->get(route('unit.index'));

        $response->assertOk();
        $response->assertViewIs('unit.index');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UnitController::class,
            'store',
            \App\Http\Requests\UnitStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $name = $this->faker->name;
        $description = $this->faker->text;

        $response = $this->post(route('unit.store'), [
            'name' => $name,
            'description' => $description,
        ]);

        $units = Unit::query()
            ->where('name', $name)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $units);
        $unit = $units->first();

        $response->assertRedirect(route('unit.index'));
        $response->assertSessionHas('unit.name', $unit->name);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UnitController::class,
            'update',
            \App\Http\Requests\UnitUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $unit = factory(Unit::class)->create();
        $name = $this->faker->name;
        $description = $this->faker->text;

        $response = $this->put(route('unit.update', $unit), [
            'name' => $name,
            'description' => $description,
        ]);

        $response->assertRedirect(route('unit.index'));
        $response->assertSessionHas('unit.name', $unit->name);
    }
}
