<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;

class MarkerAuthTest extends TestCase {

    use \Illuminate\Foundation\Testing\WithFaker;

    private $attributes = [];
    private $listing_attributes = [];

    protected function setUp(): void {
        parent::setUp();

        $user = $this->act_as_auth_user();

        $this->setBaseModel('App\Marker');
        $this->setBaseRoute('marker');

        $this->attributes = [
            'user_id' => $user->id,
            'listing_id' => null,
            'lgt' => -8.10471335,
            'lat' => 39.02606758,
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'is_approved' => 1
        ];
        
        $this->listing_attributes = [
            'user_id' => $this->attributes['user_id'],
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'unique_url' => 'ASdfgH',
            'public_listed' => 1
        ];
    }
    
    /**
    * @test
    */
    public function auth_user_can_view_marker() {
        $listing = create('App\Listing', $this->listing_attributes);
        
        $this->attributes['listing_id'] = $listing->id;  
        create($this->base_model, $this->attributes);
        
        $response = $this->get(
                        route($this->base_route . '.show', $this->listing_attributes['unique_url'])
                )->assertSuccessful();

        $model = new $this->base_model;

        $this->assertEquals($response->json()['user_id'], $this->attributes['user_id']);
    }
    
    /**
    * @test
    */   
    public function auth_user_can_view_other_users_marker() { 
        $other_user = factory(User::class)->create();
        
        $listing_attributes = $this->listing_attributes;
        $listing_attributes['user_id'] = $other_user->id;
        $listing_attributes['unique_url'] = 'CSdfgB';      
        $listing = create('App\Listing', $listing_attributes);
        
        $this->attributes['listing_id'] = $listing->id;               
        create($this->base_model, $this->attributes);
        
        $response = $this->get(
                        route($this->base_route . '.show', $this->listing_attributes['unique_url'])
                )->assertSuccessful();

        $model = new $this->base_model;

        $this->assertEquals($response->json()['user_id'], $this->attributes['user_id']);
    }

    /**
     * @test
     */
    public function auth_user_can_create_marker() {
        $this->generic_create();
    }
    
    /**
     * @test
     */
    public function auth_user_can_update_marker() {
        $this->generic_update($this->attributes);
    }
    
     /**
     * @test
     */
    public function auth_user_can_destroy_marker() {
        $this->generic_destroy($this->attributes)->assertStatus(200);
    }

}
