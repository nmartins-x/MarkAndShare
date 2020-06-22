<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;

class ListingTest extends TestCase {

    use \Illuminate\Foundation\Testing\WithFaker;

    private $attributes = [];

    protected function setUp(): void {
        parent::setUp();

        $user = $this->act_as_auth_user();

        $this->setBaseModel('App\Listing');
        $this->setBaseRoute('listing');

        $this->attributes = [
            'user_id' => $user->id,
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'unique_url' => 'ASdfgH',
            'public_listed' => 1
        ];
    }
    
     /**
     * @test
     */
    public function auth_user_can_see_index_of_public_listings() {
        create($this->base_model, $this->attributes);
         
        $response = $this->get(route($this->base_route . '.index'));
        
        $response->assertSuccessful();
        
        $this->assertNotEmpty($response->json());
    }
        
    /**
    * @test
    */
    public function auth_user_cannot_see_index_of_other_users_private_listings() {
        $auth_user = $this->attributes['user_id'];
       
        $other_user = factory(User::class)->create();

        $attributes = $this->attributes;
        $attributes['user_id'] = $other_user->id;
        $attributes['public_listed'] = 0;
        
        create($this->base_model, $attributes);
        
        $response = $this->get(
                        route($this->base_route . '.index', $this->attributes)
                )->assertSuccessful();
        
        $model = new $this->base_model;

        $this->assertEmpty($response->json());
    }
    
    /**
    * @test
    */
    public function auth_user_can_view_own_listing() {      
        create($this->base_model, $this->attributes);
        
        $response = $this->get(
                        route($this->base_route . '.show', $this->attributes['unique_url'])
                )->assertSuccessful();

        $model = new $this->base_model;

        $this->assertEquals($response->json()[0]['user_id'], $this->attributes['user_id']);
    }
    
    /**
    * @test
    */   
    public function auth_user_can_view_own_private_listing() { 
        $attributes = $this->attributes;
        $attributes['public_listed'] = 0;
        
        create($this->base_model, $attributes);
        
        $response = $this->get(
                        route($this->base_route . '.show', $this->attributes['unique_url'])
                )->assertSuccessful();

        $model = new $this->base_model;

        $this->assertEquals($response->json()[0]['user_id'], $attributes['user_id']);
    }
    
    /**
    * @test
    */
    public function auth_user_can_view_other_users_listings() {
        $auth_user = $this->attributes['user_id'];
       
        $other_user = factory(User::class)->create();

        $attributes = $this->attributes;
        $attributes['user_id'] = $other_user->id;
        
        create($this->base_model, $attributes);
        
        $response = $this->get(
                        route($this->base_route . '.show', $this->attributes['unique_url'])
                )->assertSuccessful();
                
        $model = new $this->base_model;
        
        $this->assertNotEmpty($response->json());
                
        if (! empty($response->json())) {
            $this->assertEquals($response->json()[0]['user_id'], $other_user->id);
        }
    }

    /**
     * @test
     */
    public function auth_user_can_create_listing() {
        $this->generic_create();
    }
    
    /**
     * @test
     */
    public function auth_user_can_update_listing() {
        $this->generic_update($this->attributes);
    }
    
     /**
     * @test
     */
    public function auth_user_can_destroy_listing() {
        $this->generic_destroy($this->attributes)->assertStatus(200);
    }

}
