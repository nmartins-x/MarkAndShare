<?php

namespace Tests\Unit;

use Tests\TestCase;

class ListingTest extends TestCase {

    use \Illuminate\Foundation\Testing\WithFaker;

    private $attributes = [];

    protected function setUp(): void {
        parent::setUp();

        $this->act_as_auth_user();

        $this->setBaseModel('App\Listing');
        $this->setBaseRoute('listing');
        
        $this->attributes = [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'public_listed' => 1
        ];
    }

    /**
     * @test
     */
    public function can_create_listing() {
        $this->generic_create();
    }

}
