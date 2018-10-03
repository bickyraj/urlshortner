<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Link;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LinkTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
    	factory(Link::class, 3)->create();
        $this->assertTrue(true);
    }
}
