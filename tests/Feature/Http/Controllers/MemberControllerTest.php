<?php

namespace Tests\Feature\Http\Controllers;

use App\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MemberController
 */
class MemberControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $response = $this->get(route('member.index'));

        $response->assertOk();
        $response->assertViewIs('member.index');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('member.create'));

        $response->assertOk();
        $response->assertViewIs('member.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MemberController::class,
            'store',
            \App\Http\Requests\MemberStoreRequest::class
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

        $response = $this->post(route('member.store'), [
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
        ]);

        $members = Member::query()
            ->where('name', $name)
            ->where('address', $address)
            ->where('phone', $phone)
            ->get();
        $this->assertCount(1, $members);
        $member = $members->first();

        $response->assertRedirect(route('member.index'));
        $response->assertSessionHas('member.name', $member->name);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $member = factory(Member::class)->create();

        $response = $this->get(route('member.show', $member));

        $response->assertOk();
        $response->assertViewIs('member.show');
        $response->assertViewHas('member');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $member = factory(Member::class)->create();

        $response = $this->get(route('member.edit', $member));

        $response->assertOk();
        $response->assertViewIs('member.edit');
        $response->assertViewHas('member');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MemberController::class,
            'update',
            \App\Http\Requests\MemberUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $member = factory(Member::class)->create();
        $name = $this->faker->name;
        $address = $this->faker->word;
        $phone = $this->faker->phoneNumber;

        $response = $this->put(route('member.update', $member), [
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
        ]);

        $response->assertRedirect(route('member.index'));
        $response->assertSessionHas('member.name', $member->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $member = factory(Member::class)->create();

        $response = $this->delete(route('member.destroy', $member));

        $response->assertRedirect(route('member.index'));
        $response->assertSessionHas('member.name', $member->name);

        $this->assertDeleted($member);
    }
}
