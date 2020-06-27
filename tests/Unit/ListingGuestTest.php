<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;

class ListingGuestTest extends TestCase {

    use \Illuminate\Foundation\Testing\WithFaker;

    private $attributes = [];

    protected function setUp(): void {
        parent::setUp();

        $this->setBaseModel('App\Listing');
        $this->setBaseRoute('listing');
    }
    
    /**
    * @test
    */
    public function guest_user_can_view_other_users_listings() {      
        $other_user = factory(User::class)->create();
        
        $attributes = [
            'user_id' => $other_user->id,
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'unique_url' => 'ASdfgH',
            'public_listed' => 1
        ];
        
        create($this->base_model, $attributes);
        
        $response = $this->get(
                        route($this->base_route . '.show', $attributes['unique_url'])
                )->assertSuccessful();
                
        $model = new $this->base_model;
        
        $this->assertNotEmpty($response->json());
                
        if (! empty($response->json())) {
            $this->assertEquals($response->json()['user_id'], $other_user->id);
        }
    }

}
