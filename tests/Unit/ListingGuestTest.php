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
    
    /**
    * @test
    */   
    public function guest_user_can_view_markers() { 
        $other_user = factory(User::class)->create();
        
        $listing_attributes = [
            'user_id' => $other_user->id,
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'unique_url' => 'ASdfgH',
            'public_listed' => 1
        ];     
        $listing = create($this->base_model, $listing_attributes);
        
        $marker_attributes = [
            'user_id' => $other_user->id,
            'listing_id' => $listing->id,
            'lgt' => -8.10471335,
            'lat' => 39.02606758,
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'is_approved' => 1
        ];             
        create('App\Marker', $marker_attributes);
        
        $response = $this->get(
                        route($this->base_route . '.markers', $listing_attributes['unique_url'])
                )->assertSuccessful();

        $this->assertEquals($response->json()[0]['listing_id'], $marker_attributes['listing_id']);
    }

}
