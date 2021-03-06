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
        
        $this->listing_attributes = [
            'user_id' => $user->id,
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'unique_url' => 'ASdfgH',
            'public_listed' => 1
        ];
                
        $listing = create('App\Listing', $this->listing_attributes);
        
        $this->attributes = [
            'user_id' => $user->id,
            'listing_id' => $listing->id,
            'lgt' => -8.10471335,
            'lat' => 39.02606758,
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'is_approved' => 1
        ];
    }
    
    /**
     * @test
     */
    public function auth_user_can_create_marker() {
        $this->generic_create($this->attributes);
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
