<?php

namespace Tests\Feature\AuthenticatedUser;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{           
    use RefreshDatabase;
    
    protected function setUp(): void {
        parent::setUp();
        
        $this->act_as_auth_user();
    }
    
    /** @test */
    public function can_show_the_authenticated_dashboard_page()
    {       
        $this
            ->get(route('home'))
            ->assertStatus(200)
            ->assertSeeText('Dashboard')
            ->assertSee('list-create');
    }
}
