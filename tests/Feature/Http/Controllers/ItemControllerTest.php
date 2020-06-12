<?php

namespace Tests\Feature\Http\Controllers;

use App\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ItemController
 */
class ItemControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $response = $this->get(route('item.index'));

        $response->assertOk();
        $response->assertViewIs('item.index');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('item.create'));

        $response->assertOk();
        $response->assertViewIs('item.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ItemController::class,
            'store',
            \App\Http\Requests\ItemStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $name = $this->faker->name;
        $barcode = $this->faker->word;
        $description = $this->faker->text;
        $is_stock_active = $this->faker->boolean;
        $unit_id = $this->faker->randomDigitNotNull;
        $stock = $this->faker->randomNumber();
        $min_stock = $this->faker->randomNumber();
        $sell_price = 0;
        $buy_price = 0;
        $profit = 0;
        $sell_price_determinant = $this->faker->randomElement(
            /** enum_attributes **/
        );
        $margin = $this->faker->randomFloat(
            /** float_attributes **/
        );
        $markup = $this->faker->randomFloat(
            /** float_attributes **/
        );

        $response = $this->post(route('item.store'), [
            'name' => $name,
            'barcode' => $barcode,
            'description' => $description,
            'is_stock_active' => $is_stock_active,
            'unit_id' => $unit_id,
            'stock' => $stock,
            'min_stock' => $min_stock,
            'sell_price' => $sell_price,
            'buy_price' => $buy_price,
            'profit' => $profit,
            'sell_price_determinant' => $sell_price_determinant,
            'margin' => $margin,
            'markup' => $markup,
        ]);

        $items = Item::query()
            ->where('name', $name)
            ->where('barcode', $barcode)
            ->where('description', $description)
            ->where('is_stock_active', $is_stock_active)
            ->where('unit_id', $unit_id)
            ->where('stock', $stock)
            ->where('min_stock', $min_stock)
            ->where('sell_price', $sell_price)
            ->where('buy_price', $buy_price)
            ->where('profit', $profit)
            ->where('sell_price_determinant', $sell_price_determinant)
            ->where('margin', $margin)
            ->where('markup', $markup)
            ->get();
        $this->assertCount(1, $items);
        $item = $items->first();

        $response->assertRedirect(route('item.index'));
        $response->assertSessionHas('item.name', $item->name);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $item = factory(Item::class)->create();

        $response = $this->get(route('item.show', $item));

        $response->assertOk();
        $response->assertViewIs('item.show');
        $response->assertViewHas('item');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $item = factory(Item::class)->create();

        $response = $this->get(route('item.edit', $item));

        $response->assertOk();
        $response->assertViewIs('item.edit');
        $response->assertViewHas('item');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ItemController::class,
            'update',
            \App\Http\Requests\ItemUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $item = factory(Item::class)->create();
        $name = $this->faker->name;
        $barcode = $this->faker->word;
        $description = $this->faker->text;
        $is_stock_active = $this->faker->boolean;
        $unit_id = $this->faker->randomDigitNotNull;
        $min_stock = $this->faker->randomNumber();
        $profit = 0;
        $sell_price_determinant = $this->faker->randomElement(
            /** enum_attributes **/
        );
        $margin = $this->faker->randomFloat(
            /** float_attributes **/
        );
        $markup = $this->faker->randomFloat(
            /** float_attributes **/
        );

        $response = $this->put(route('item.update', $item), [
            'name' => $name,
            'barcode' => $barcode,
            'description' => $description,
            'is_stock_active' => $is_stock_active,
            'unit_id' => $unit_id,
            'min_stock' => $min_stock,
            'profit' => $profit,
            'sell_price_determinant' => $sell_price_determinant,
            'margin' => $margin,
            'markup' => $markup,
        ]);

        $response->assertRedirect(route('item.index'));
        $response->assertSessionHas('item.name', $item->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $item = factory(Item::class)->create();

        $response = $this->delete(route('item.destroy', $item));

        $response->assertRedirect(route('item.index'));
        $response->assertSessionHas('item.name', $item->name);

        $this->assertDeleted($item);
    }
}
