<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BasicTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
    	$member = factory(Role::class, 3)->create();
        $this->assertTrue(true);
		// $member = new ClientMember(['name'=>'Tesla']);
		// $this->assertEquals('Tesla', $member->name);
    }
}
