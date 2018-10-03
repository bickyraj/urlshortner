<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Link;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LinkTest extends TestCase
{
	use WithFaker;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateLink()
    {
		// factory(Link::class, 3)->create();
	    $data = [
			'url' => $this->faker->url(),
			'code' => str_random(10),
			'status' => 1,
			'counter' => 1,
		];

	    $response = $this->json('POST', '/api/link', $data);
	    $response->assertStatus(201);
    }

    public function testGettingAllLinksWithMiddleware()
    {
    	$response = $this->json('GET', '/api/admin/links');
        $response->assertStatus(401);
        $response->assertJson(['message' => "Unauthenticated."]);
    }

    public function testGettingAllLinksAsAdmin()
    {
    	$user = factory(\App\User::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/admin/links');
        $response->assertStatus(200);
    }

    public function testDeleteLinkByAdmin()
    {
    	$user = factory(\App\User::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/admin/links');
        $response->assertStatus(200);

        $link = $response->getData()->data[0];

        $delete = $this->actingAs($user, 'api')->json('DELETE', '/api/admin/link/'. $link->id);
        $delete->assertStatus(410);
    }
}
